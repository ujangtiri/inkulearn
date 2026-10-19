// Star Meteor Cursor JavaScript
// Pastikan DOM sudah loaded sebelum menjalankan script ini

class StarMeteorCursor {
    constructor() {
        this.mouseX = 0;
        this.mouseY = 0;
        this.cursorX = 0;
        this.cursorY = 0;
        this.starCursor = null;
        this.glowEffect = null;
        
        this.init();
    }

    init() {
        // Buat elemen cursor
        this.createCursorElements();
        
        // Tambahkan class ke body untuk hide cursor default
        document.body.classList.add('custom-cursor-active');
        
        // Event listeners
        this.addEventListeners();
        
        // Mulai animasi
        this.animate();
    }

    createCursorElements() {
        // Buat star cursor
        this.starCursor = document.createElement('div');
        this.starCursor.className = 'star-cursor';
        this.starCursor.id = 'starCursor';
        
        const star = document.createElement('div');
        star.className = 'star';
        this.starCursor.appendChild(star);
        
        // Buat glow effect
        this.glowEffect = document.createElement('div');
        this.glowEffect.className = 'glow-effect';
        this.glowEffect.id = 'glowEffect';
        
        // Tambahkan ke body
        document.body.appendChild(this.starCursor);
        document.body.appendChild(this.glowEffect);
    }

    addEventListeners() {
        // Update posisi mouse
        document.addEventListener('mousemove', (e) => {
            this.mouseX = e.clientX;
            this.mouseY = e.clientY;
        });

        // Hide cursor saat mouse leave
        document.addEventListener('mouseleave', () => {
            this.starCursor.style.opacity = '0';
            this.glowEffect.style.opacity = '0';
        });

        // Show cursor saat mouse enter
        document.addEventListener('mouseenter', () => {
            this.starCursor.style.opacity = '1';
            this.glowEffect.style.opacity = '1';
        });

        // Efek klik
        document.addEventListener('click', () => {
            this.handleClick();
        });
    }

    createMeteorTrail(x, y) {
        const trail = document.createElement('div');
        trail.className = 'meteor-trail';
        trail.style.left = x + 'px';
        trail.style.top = y + 'px';
        document.body.appendChild(trail);

        // Hapus trail setelah animasi selesai
        setTimeout(() => {
            if (trail.parentElement) {
                trail.parentElement.removeChild(trail);
            }
        }, 800);
    }

    createSparkle(x, y) {
        if (Math.random() > 0.7) { // 30% chance untuk sparkle
            const sparkle = document.createElement('div');
            sparkle.className = 'sparkle';
            sparkle.style.left = (x + Math.random() * 20 - 10) + 'px';
            sparkle.style.top = (y + Math.random() * 20 - 10) + 'px';
            document.body.appendChild(sparkle);

            setTimeout(() => {
                if (sparkle.parentElement) {
                    sparkle.parentElement.removeChild(sparkle);
                }
            }, 1000);
        }
    }

    handleClick() {
        this.starCursor.style.transform = 'scale(1.5)';
        
        // Buat banyak sparkle saat klik
        for (let i = 0; i < 8; i++) {
            setTimeout(() => {
                this.createSparkle(this.cursorX, this.cursorY);
            }, i * 50);
        }
        
        setTimeout(() => {
            this.starCursor.style.transform = 'scale(1)';
        }, 150);
    }

    animate() {
        // Smooth following effect
        this.cursorX += (this.mouseX - this.cursorX) * 0.15;
        this.cursorY += (this.mouseY - this.cursorY) * 0.15;

        // Update posisi cursor
        this.starCursor.style.left = (this.cursorX - 15) + 'px';
        this.starCursor.style.top = (this.cursorY - 15) + 'px';

        // Update glow effect
        this.glowEffect.style.left = (this.cursorX - 50) + 'px';
        this.glowEffect.style.top = (this.cursorY - 50) + 'px';

        // Buat meteor trail dan sparkle
        if (Math.abs(this.mouseX - this.cursorX) > 1 || Math.abs(this.mouseY - this.cursorY) > 1) {
            this.createMeteorTrail(this.cursorX, this.cursorY);
            this.createSparkle(this.cursorX, this.cursorY);
        }

        requestAnimationFrame(() => this.animate());
    }

    // Method untuk destroy cursor (jika diperlukan)
    destroy() {
        if (this.starCursor) {
            this.starCursor.remove();
        }
        if (this.glowEffect) {
            this.glowEffect.remove();
        }
        document.body.classList.remove('custom-cursor-active');
    }
}

// Inisialisasi cursor setelah DOM ready
document.addEventListener('DOMContentLoaded', function() {
    window.starMeteorCursor = new StarMeteorCursor();
});

// Jika DOM sudah ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        window.starMeteorCursor = new StarMeteorCursor();
    });
} else {
    window.starMeteorCursor = new StarMeteorCursor();
}