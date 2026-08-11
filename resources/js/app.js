import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.statCounter = function (finalValue, delay = 0) {
    const rawValue = String(finalValue);
    const valueMatch = rawValue.match(/^(\d+(?:[.,]\d+)?)(.*)$/s);
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const suffix = valueMatch?.[2] ?? '';

    return {
        display: reducedMotion || !valueMatch ? rawValue : `0${suffix}`,
        _done: false,

        init() {
            if (reducedMotion || !valueMatch) {
                this.display = rawValue;

                return;
            }

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
            const numericText = valueMatch[1];
            const normalizedNumber = numericText.replace(',', '.');
            const target = Number.parseFloat(normalizedNumber);
            const hasDecimal = normalizedNumber.includes('.');
            const decimalPlaces = hasDecimal ? normalizedNumber.split('.')[1].length : 0;
            const duration = 1400;
            const interval = 50;
            const steps = Math.floor(duration / interval);
            const randomCeiling = Math.max(9, Math.ceil(target * 1.8));
            let step = 0;

            const timer = setInterval(() => {
                step++;

                const progress = step / steps;
                const isSettling = progress >= 0.65;
                const randomValue = Math.random() * randomCeiling;
                const settlingValue = target + (Math.random() - 0.5) * randomCeiling * (1 - progress);
                const nextValue = isSettling ? settlingValue : randomValue;
                const formattedValue = hasDecimal
                    ? Math.max(0, nextValue).toFixed(decimalPlaces)
                    : Math.round(Math.max(0, nextValue));

                this.display = step >= steps
                    ? rawValue
                    : `${formattedValue}${suffix}`;

                if (step >= steps) {
                    clearInterval(timer);
                }
            }, interval);
        },
    };
};

Alpine.start();
