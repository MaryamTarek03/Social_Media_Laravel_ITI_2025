@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'fixed inset-0 pointer-events-none z-0 ' . $class]) }}>
    <canvas id="particle-canvas" class="w-full h-full"></canvas>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('particle-canvas');
    const ctx = canvas.getContext('2d');

    // Set canvas size
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // Particle class
    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.vx = (Math.random() - 0.5) * 0.5;
            this.vy = (Math.random() - 0.5) * 0.5;
            this.size = Math.random() * 2 + 0.5;
            this.opacity = Math.random() * 0.5 + 0.2;
            this.color = this.getRandomColor();
        }

        getRandomColor() {
            const colors = [
                'rgba(59, 130, 246, 0.6)', // blue
                'rgba(147, 51, 234, 0.6)', // purple
                'rgba(16, 185, 129, 0.6)', // emerald
                'rgba(245, 158, 11, 0.6)', // amber
                'rgba(239, 68, 68, 0.6)',  // red
                'rgba(236, 72, 153, 0.6)'  // pink
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;

            // Wrap around edges
            if (this.x < 0) this.x = canvas.width;
            if (this.x > canvas.width) this.x = 0;
            if (this.y < 0) this.y = canvas.height;
            if (this.y > canvas.height) this.y = 0;

            // Subtle pulsing effect
            this.opacity += Math.sin(Date.now() * 0.001 + this.x * 0.01) * 0.01;
            this.opacity = Math.max(0.1, Math.min(0.8, this.opacity));
        }

        draw() {
            ctx.save();
            ctx.globalAlpha = this.opacity;
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();

            // Add glow effect
            ctx.shadowBlur = 10;
            ctx.shadowColor = this.color;
            ctx.fill();
            ctx.restore();
        }
    }

    // Connection lines between nearby particles
    class Connection {
        constructor(p1, p2) {
            this.p1 = p1;
            this.p2 = p2;
            this.distance = this.getDistance();
            this.maxDistance = 150;
            this.opacity = 0;
        }

        getDistance() {
            const dx = this.p1.x - this.p2.x;
            const dy = this.p1.y - this.p2.y;
            return Math.sqrt(dx * dx + dy * dy);
        }

        update() {
            this.distance = this.getDistance();
            this.opacity = Math.max(0, 1 - this.distance / this.maxDistance) * 0.3;
        }

        draw() {
            if (this.distance < this.maxDistance) {
                ctx.save();
                ctx.globalAlpha = this.opacity;
                ctx.strokeStyle = 'rgba(147, 51, 234, 0.3)';
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(this.p1.x, this.p1.y);
                ctx.lineTo(this.p2.x, this.p2.y);
                ctx.stroke();
                ctx.restore();
            }
        }
    }

    // Create particles
    const particles = [];
    const connections = [];
    const particleCount = Math.min(100, Math.floor((canvas.width * canvas.height) / 15000));

    for (let i = 0; i < particleCount; i++) {
        particles.push(new Particle());
    }

    // Create connections
    for (let i = 0; i < particles.length; i++) {
        for (let j = i + 1; j < particles.length; j++) {
            connections.push(new Connection(particles[i], particles[j]));
        }
    }

    // Animation loop
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Update and draw connections
        connections.forEach(connection => {
            connection.update();
            connection.draw();
        });

        // Update and draw particles
        particles.forEach(particle => {
            particle.update();
            particle.draw();
        });

        requestAnimationFrame(animate);
    }

    animate();

    // Mouse interaction
    let mouse = { x: null, y: null };
    canvas.addEventListener('mousemove', (e) => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });

    canvas.addEventListener('mouseleave', () => {
        mouse.x = null;
        mouse.y = null;
    });

    // Add mouse attraction effect
    particles.forEach(particle => {
        const originalUpdate = particle.update.bind(particle);
        particle.update = function() {
            if (mouse.x !== null && mouse.y !== null) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < 200) {
                    const force = (200 - distance) / 200;
                    this.vx += (dx / distance) * force * 0.01;
                    this.vy += (dy / distance) * force * 0.01;
                }
            }

            // Apply friction
            this.vx *= 0.99;
            this.vy *= 0.99;

            originalUpdate();
        };
    });
});
</script>
