// menulis.js - Dotted-letter tracing (mask-based) for children
// Features:
// - Render large dashed-outline text and interior dots (guide)
// - Build pixel mask from rendered text (offscreen canvas)
// - Constrain drawing to mask (no visible strokes outside letters)
// - Snap/hit detection for guide dots and progress bar
// - Pointer/touch support, responsive resizing

(function(){
	'use strict';

	// Config
	const WORD = 'baju'; // default word for now
	const FONT_FRACTION = 0.55; // fraction of canvas height for font size
	const DOT_SPACING_DESKTOP = 28;
	const DOT_SPACING_MOBILE = 20;
	const DOT_RADIUS = 6;
	const HIT_RADIUS = 22; // tolerance to mark dot as hit
	const STROKE_COLOR = '#42a5f5';
	const STROKE_WIDTH = 16;

	// DOM elements
	let container, drawCanvas, drawCtx, guideCanvas, guideCtx;
	let tempCanvas, tempCtx, tempImageData;
	let guideDots = []; // {x,y,hit}
	let dpr = Math.max(1, window.devicePixelRatio || 1);

	// state
	let pointerDown = false;
	let lastX = 0, lastY = 0;
	let progress = 0;

	function $(sel){ return document.querySelector(sel); }

	function init(){
		container = document.querySelector('.canvas-container');
		drawCanvas = document.getElementById('drawingCanvas');
		if (!container || !drawCanvas) return console.error('Canvas or container not found');

		// create guide canvas behind drawCanvas
		guideCanvas = document.createElement('canvas');
		guideCanvas.id = 'guideCanvas';
		guideCanvas.style.position = 'absolute';
		guideCanvas.style.left = '0';
		guideCanvas.style.top = '0';
		guideCanvas.style.width = '100%';
		guideCanvas.style.height = '100%';
		guideCanvas.style.zIndex = 1;

		// make sure drawCanvas is positioned above
		drawCanvas.style.position = 'absolute';
		drawCanvas.style.left = '0';
		drawCanvas.style.top = '0';
		drawCanvas.style.width = '100%';
		drawCanvas.style.height = '100%';
		drawCanvas.style.zIndex = 2;

		// append guide canvas inside container
		container.appendChild(guideCanvas);

		guideCtx = guideCanvas.getContext('2d');
		drawCtx = drawCanvas.getContext('2d');

		// temp canvas for mask generation
		tempCanvas = document.createElement('canvas');
		tempCtx = tempCanvas.getContext('2d');

		// wire buttons (support both id and older class names)
		const eraser = document.getElementById('eraser-button') || document.querySelector('.btn-erase') || document.querySelector('.tool-button');
		const refresh = document.getElementById('refresh-button') || document.querySelector('.btn-refresh');
		const next = document.getElementById('next-word-button') || document.querySelector('#next-button') || document.querySelector('.btn-arrow[title="Berikutnya"]');
		const prev = document.getElementById('prev-button') || document.querySelector('#prev-button') || document.querySelector('.btn-arrow[title="Sebelumnya"]');
		if (eraser) eraser.addEventListener('click', eraseStrokes);
		if (refresh) refresh.addEventListener('click', resetAll);
		if (next) next.addEventListener('click', resetAll);
		if (prev) prev.addEventListener('click', resetAll);

		// pointer events
		drawCanvas.addEventListener('pointerdown', onPointerDown);
		window.addEventListener('pointermove', onPointerMove);
		window.addEventListener('pointerup', onPointerUp);

		// touch passive prevent default handled by pointer events

		window.addEventListener('resize', resizeAll);
		resizeAll();
	}

	function resizeAll(){
		const rect = container.getBoundingClientRect();
		const w = Math.max(300, Math.floor(rect.width));
		const h = Math.max(200, Math.floor(rect.height));

		// size guide canvas
		guideCanvas.width = Math.floor(w * dpr);
		guideCanvas.height = Math.floor(h * dpr);
		guideCanvas.style.width = w + 'px';
		guideCanvas.style.height = h + 'px';
		guideCtx.setTransform(dpr,0,0,dpr,0,0);

		// size draw canvas
		drawCanvas.width = Math.floor(w * dpr);
		drawCanvas.height = Math.floor(h * dpr);
		drawCanvas.style.width = w + 'px';
		drawCanvas.style.height = h + 'px';
		drawCtx.setTransform(dpr,0,0,dpr,0,0);

		// temp canvas to same pixel size
		tempCanvas.width = Math.floor(w * dpr);
		tempCanvas.height = Math.floor(h * dpr);
		tempCtx.setTransform(dpr,0,0,dpr,0,0);

		// build guides and mask
		buildMaskAndGuides(w, h);
		drawGuides();
		// clear user strokes
		drawCtx.clearRect(0,0,w,h);
		guideDots.forEach(d => d.hit = false);
		updateProgressBar(0);
	}

	function buildMaskAndGuides(w,h){
		// draw the filled text into temp canvas to produce mask pixels
		tempCtx.clearRect(0,0,w,h);
		// choose font size responsive to canvas
		const fontSize = Math.floor(h * FONT_FRACTION);
		tempCtx.fillStyle = '#000';
		tempCtx.textAlign = 'center';
		tempCtx.textBaseline = 'middle';
		tempCtx.font = `bold ${fontSize}px Arial`;
		// center
		tempCtx.fillText(WORD, w/2, h/2);

		// get image data
		try {
			tempImageData = tempCtx.getImageData(0,0,w,h);
		} catch(e){
			tempImageData = null; console.error('getImageData failed', e); return;
		}

		// sample grid for dots
		guideDots = [];
		const spacing = isMobile() ? DOT_SPACING_MOBILE : DOT_SPACING_DESKTOP;
		const margin = 6;
		for (let y = margin; y < h - margin; y += spacing){
			for (let x = margin; x < w - margin; x += spacing){
				if (isPixelFilled(Math.floor(x), Math.floor(y))){
					// ensure dot not too close to other dots
					guideDots.push({x,y,hit:false});
				}
			}
		}

		// optionally reduce density: keep every Nth dot by simple thinning (to get spaced dots along strokes)
		// We'll prune clusters by only keeping dots that have few neighbors nearby
		guideDots = pruneDots(guideDots, spacing * 0.8);
	}

	function pruneDots(dots, minDist){
		const kept = [];
		for (let i=0;i<dots.length;i++){
			const p = dots[i];
			let ok = true;
			for (let q of kept){
				const dx = p.x - q.x, dy = p.y - q.y;
				if (dx*dx + dy*dy < minDist*minDist){ ok = false; break; }
			}
			if (ok) kept.push(p);
		}
		return kept;
	}

	function isPixelFilled(x,y){
		if (!tempImageData) return false;
		const w = tempImageData.width;
		const idx = (y * w + x) * 4;
		return tempImageData.data[idx+3] > 50 || tempImageData.data[idx] > 20; // alpha or non-black
	}

	function drawGuides(){
		const w = guideCanvas.width / dpr, h = guideCanvas.height / dpr;
		guideCtx.clearRect(0,0,w,h);

		// dashed outline from text
		guideCtx.save();
		guideCtx.lineWidth = 6;
		guideCtx.strokeStyle = '#333';
		guideCtx.setLineDash([12,10]);
		guideCtx.font = `bold ${Math.floor(h * FONT_FRACTION)}px Arial`;
		guideCtx.textAlign = 'center';
		guideCtx.textBaseline = 'middle';
		guideCtx.strokeText(WORD, w/2, h/2);
		guideCtx.restore();

		// interior dots
		guideCtx.fillStyle = '#333';
		guideCtx.strokeStyle = '#fff';
		for (let d of guideDots){
			guideCtx.beginPath();
			guideCtx.arc(d.x, d.y, DOT_RADIUS, 0, Math.PI*2);
			guideCtx.fill();
			guideCtx.lineWidth = 2;
			guideCtx.stroke();
		}
	}

	// Drawing handlers
	function onPointerDown(e){
		if (e.pointerType === 'mouse' && e.button !== 0) return; // only left click
		pointerDown = true;
		const rect = drawCanvas.getBoundingClientRect();
		lastX = e.clientX - rect.left;
		lastY = e.clientY - rect.top;
		drawCtx.beginPath();
		drawCtx.lineCap = 'round';
		drawCtx.lineJoin = 'round';
		drawCtx.strokeStyle = STROKE_COLOR;
		drawCtx.lineWidth = STROKE_WIDTH;
		drawCtx.moveTo(lastX, lastY);
		checkNearbyHits(lastX, lastY);
	}

	function onPointerMove(e){
		if (!pointerDown) return;
		const rect = drawCanvas.getBoundingClientRect();
		const x = e.clientX - rect.left;
		const y = e.clientY - rect.top;

		// only draw if either last or current point is within mask
		const inLast = isPixelFilled(Math.floor(lastX), Math.floor(lastY));
		const inCur = isPixelFilled(Math.floor(x), Math.floor(y));
		if (!inLast && !inCur){
			// move pen silently
			drawCtx.beginPath();
			drawCtx.moveTo(x,y);
			lastX = x; lastY = y;
			checkNearbyHits(x,y);
			return;
		}

		drawCtx.lineTo(x,y);
		drawCtx.stroke();
		drawCtx.beginPath();
		drawCtx.moveTo(x,y);
		lastX = x; lastY = y;
		checkNearbyHits(x,y);
	}

	function onPointerUp(e){
		if (!pointerDown) return;
		pointerDown = false;
		drawCtx.closePath();
		evaluateCompletion();
	}

	function checkNearbyHits(x,y){
		let anyNew = false;
		for (let d of guideDots){
			if (!d.hit){
				const dx = x - d.x, dy = y - d.y;
				const dist = Math.sqrt(dx*dx + dy*dy);
				if (dist <= HIT_RADIUS){
					d.hit = true; anyNew = true;
					// draw filled small circle on draw canvas
					drawCtx.beginPath();
					drawCtx.fillStyle = STROKE_COLOR;
					drawCtx.arc(d.x, d.y, DOT_RADIUS+2, 0, Math.PI*2);
					drawCtx.fill();
					drawCtx.beginPath();
					drawCtx.moveTo(x,y);
				}
			}
		}
		if (anyNew) updateProgress();
	}

	function updateProgress(){
		const hit = guideDots.filter(d=>d.hit).length;
		progress = Math.round((hit / (guideDots.length || 1)) * 100);
		const bar = document.getElementById('progress-bar') || document.querySelector('.progress-bar');
		if (bar) bar.style.width = progress + '%';
	}

	function evaluateCompletion(){
		if (progress >= 95){
			showSuccess();
		} else if (progress >= 50){
			showEncouragement();
		}
	}

	function showSuccess(){
		const box = document.getElementById('message-box') || document.querySelector('.message-box');
		const text = document.getElementById('message-text') || document.querySelector('.message-text');
		if (text) text.textContent = '🎉 Hebat! Kamu berhasil!';
		if (box) { box.classList.remove('hidden'); box.style.animation = 'bounce 0.9s'; }
		const snd = document.getElementById('success-sound');
		if (snd && typeof snd.play === 'function') snd.play();
		createConfetti();
		setTimeout(()=>{ if (box) box.classList.add('hidden'); }, 3000);
	}

	function showEncouragement(){
		const box = document.getElementById('message-box') || document.querySelector('.message-box');
		const text = document.getElementById('message-text') || document.querySelector('.message-text');
		if (text) text.textContent = 'Ayo coba lagi, ikuti titik-titiknya!';
		if (box) box.classList.remove('hidden');
		setTimeout(()=>{ if (box) box.classList.add('hidden'); }, 2000);
	}

	function createConfetti(){
		const colors = ['#FFC107','#FF9800','#4CAF50','#8BC34A','#AEE2FF','#B8F1B0'];
		for (let i=0;i<30;i++){
			const e = document.createElement('div');
			e.className = 'confetti';
			e.style.left = (Math.random()*100)+'%';
			e.style.background = colors[Math.floor(Math.random()*colors.length)];
			e.style.width = (6+Math.random()*8)+'px';
			e.style.height = e.style.width;
			document.body.appendChild(e);
			setTimeout(()=>e.remove(), 3500);
		}
	}

	function eraseStrokes(){
		const w = drawCanvas.width / dpr, h = drawCanvas.height / dpr;
		drawCtx.clearRect(0,0,w,h);
		guideDots.forEach(d=>d.hit=false);
		updateProgress();
		const box = document.getElementById('message-box') || document.querySelector('.message-box');
		if (box) box.classList.add('hidden');
	}

	function resetAll(){
		eraseStrokes();
		drawGuides();
	}

	function updateWord(newWord){
		// placeholder to support switching words later
		// currently uses constant WORD
	}

	function isMobile(){
		return /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
	}

	// expose for debugging
	window.menulis = { init, rebuild: resizeAll };

	// start
	document.addEventListener('DOMContentLoaded', init);

})();

