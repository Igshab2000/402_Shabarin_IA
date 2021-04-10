export default class Fraction {
    constructor(numerator, denominator) {
        if(denominator < 0) {
            return this;
        }
    
        let numeratorFraction, denominatorFraction;
        const greatestCommonFactor = this.gcd(numerator, denominator);
    
        if(greatestCommonFactor === 1) {
            numeratorFraction = numerator;
            denominatorFraction = denominator;
        } else {
            numeratorFraction = numerator / greatestCommonFactor;
            denominatorFraction = denominator / greatestCommonFactor;
        }
    
        this.numerator = numeratorFraction;
        this.denominator = denominatorFraction;
    }

    get numer() {
        return this.numerator;
    }

    get denom() {
        return this.denominator;
    }

    add(frac) {
        if(this.denominator === frac.denominator) {
            const numerator = this.numerator + frac.numerator;

            return new Fraction(numerator, frac.denominator);
        } else {
            const numerator = this.numerator * frac.denominator + this.denominator * frac.numerator;
            const denominator = this.denominator * frac.denominator;

            return new Fraction(numerator, denominator);
        }
    }

    sub(frac) {
        if(this.denominator === frac.denominator) {
            const numerator = this.numerator - frac.numerator;

            return new Fraction(numerator, frac.denominator);
        } else {
            const numerator = this.numerator * frac.denominator - this.denominator * frac.numerator;
            const denominator = this.denominator * frac.denominator;

            return new Fraction(numerator, denominator);
        }
    }

    convert() {
        const integerValue = Math.floor(this.numerator / this.denominator);
        const numerator  = Math.abs(this.numerator % this.denominator);

        return `${integerValue > 0 ? integerValue : integerValue + 1}'${numerator}/${this.denominator}`;
    }

    toString() {
        if(Math.abs(this.numerator) > this.denominator) {
            return this.convert();
        }

        return `${this.numerator}/${this.denominator}`;
    }

    gcd(numerator, denominator) {
        const modulo =  numerator % denominator;
    
        return modulo ? this.gcd(denominator, numerator % denominator) : Math.abs(denominator);
    }
}