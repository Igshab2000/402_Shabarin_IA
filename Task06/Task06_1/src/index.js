export function gcd(numerator, denominator) {
    const modulo =  numerator % denominator;

    return modulo ? gcd(denominator, numerator % denominator) : Math.abs(denominator);
}

export function createFraction(numerator, denominator) {
    if(denominator > 0) {
        let numeratorFraction, denominatorFraction;
        const greatestCommonFactor = gcd(numerator, denominator);

        if(greatestCommonFactor === 1) {
            numeratorFraction = numerator;
            denominatorFraction = denominator;
        } else {
            numeratorFraction = numerator / greatestCommonFactor;
            denominatorFraction = denominator / greatestCommonFactor;
        }

        return {
            numerator: numeratorFraction,
            denominator: denominatorFraction,

            getNumer() {
                return this.numerator;
            },

            getDenom() {
                return this.denominator;
            },

            add(frac) {
                if(this.denominator === frac.denominator) {
                    const numerator = this.numerator + frac.numerator;

                    return createFraction(numerator, frac.denominator);
                } else {
                    const numerator = this.numerator * frac.denominator + this.denominator * frac.numerator;
                    const denominator = this.denominator * frac.denominator;

                    return createFraction(numerator, denominator);
                }
            },

            sub(frac) {
                if(this.denominator === frac.denominator) {
                    const numerator = this.numerator - frac.numerator;

                    return createFraction(numerator, frac.denominator);
                } else {
                    const numerator = this.numerator * frac.denominator - this.denominator * frac.numerator;
                    const denominator = this.denominator * frac.denominator;

                    return createFraction(numerator, denominator);
                }
            },

            convert() {
                const integerValue = Math.floor(this.numerator / this.denominator);
                const numerator  = Math.abs(this.numerator % this.denominator);

                return `${integerValue > 0 ? integerValue : integerValue + 1}'${numerator}/${this.denominator}`;
            },

            toString() {
                if(Math.abs(this.numerator) > this.denominator) {
                    return this.convert();
                }

                return `${this.numerator}/${this.denominator}`;
            }
    
        }
    } else {
        return "Введите знаменатель больше 0";
    }
}