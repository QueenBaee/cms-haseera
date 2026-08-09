import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.statCounter = function (finalValue, delay = 0) {
    return {
        display: String(finalValue),
        _done: false,

        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !this._done) {
                        this._done = true;
                        observer.disconnect();
                        setTimeout(() => this._start(), delay);
                    }
                });
            }, { threshold: 0.3 });

            observer.observe(this.$el);
        },

        _start() {
            const raw = String(finalValue);

            // Detect format: slash-separated (e.g. "24/7"), numeric with optional decimal/K/%
            const slashMatch = raw.match(/^(\d+)\/(\d+)$/);
            const numMatch   = raw.match(/^([\d.]+)([Kk%]?)$/);

            if (slashMatch) {
                this._scrambleSlash(slashMatch[1], slashMatch[2]);
            } else if (numMatch) {
                this._scrambleNum(numMatch[1], numMatch[2]);
            }
            // else: leave display as-is (unsupported format)
        },

        _scrambleNum(numStr, unit) {
            const target   = parseFloat(numStr);
            const isInt    = !numStr.includes('.');
            const duration = 1300;
            const interval = 55;
            const steps    = Math.floor(duration / interval);
            let   step     = 0;

            const timer = setInterval(() => {
                step++;
                const progress = step / steps;                       // 0 → 1
                const ease     = progress < 0.7
                    ? Math.random()                                   // early: fully random
                    : target * progress + (Math.random() - 0.5) * target * (1 - progress) * 2; // late: converge

                const val = step < steps
                    ? (isInt
                        ? Math.round(Math.abs(ease) % (target * 2 || 1))
                        : (Math.abs(ease) % (target * 2 || 1)).toFixed(1))
                    : numStr; // final frame = exact original string

                this.display = String(val) + (unit ? unit : '');

                if (step >= steps) clearInterval(timer);
            }, interval);
        },

        _scrambleSlash(a, b) {
            const tA      = parseInt(a, 10);
            const tB      = parseInt(b, 10);
            const duration = 1300;
            const interval = 55;
            const steps    = Math.floor(duration / interval);
            let   step     = 0;

            const rnd = (max) => Math.floor(Math.random() * (max * 2 || 9)) % (max * 2 || 9);

            const timer = setInterval(() => {
                step++;
                const progress = step / steps;

                const vA = step < steps
                    ? (progress > 0.7 ? tA + Math.round((Math.random() - 0.5) * tA * (1 - progress) * 3) : rnd(tA))
                    : tA;
                const vB = step < steps
                    ? (progress > 0.7 ? tB + Math.round((Math.random() - 0.5) * tB * (1 - progress) * 3) : rnd(tB))
                    : tB;

                const dA = step < steps ? Math.abs(vA) : tA;
                const dB = step < steps ? Math.abs(vB) : tB;

                this.display = `${dA}/${dB}`;

                if (step >= steps) clearInterval(timer);
            }, interval);
        },
    };
};

Alpine.start();
