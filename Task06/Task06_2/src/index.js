export function gcd(numerator, denominator) {
    const modulo =  numerator % denominator;

    return modulo ? gcd(denominator, numerator % denominator) : Math.abs(denominator);
}

export function Fraction(numerator, denominator) {
    if(denominator < 0) {
        return "Введите знаменатель больше 0";
    }

    let numeratorFraction, denominatorFraction;
    const greatestCommonFactor = gcd(numerator, denominator);

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

Fraction.prototype.getNumer = function() {
    return this.numerator;
}

Fraction.prototype.getDenom = function() {
    return this.denominator;
}

Fraction.prototype.add = function(frac) {
    if(this.denominator === frac.denominator) {
        const numerator = this.numerator + frac.numerator;

        return new Fraction(numerator, frac.denominator);
    } else {
        const numerator = this.numerator * frac.denominator + this.denominator * frac.numerator;
        const denominator = this.denominator * frac.denominator;

        return new Fraction(numerator, denominator);
    }
}

Fraction.prototype.sub = function(frac) {
    if(this.denominator === frac.denominator) {
        const numerator = this.numerator - frac.numerator;

        return new Fraction(numerator, frac.denominator);
    } else {
        const numerator = this.numerator * frac.denominator - this.denominator * frac.numerator;
        const denominator = this.denominator * frac.denominator;

        return new Fraction(numerator, denominator);
    }
}

Fraction.prototype.convert = function() {
    const integerValue = Math.floor(this.numerator / this.denominator);
    const numerator  = Math.abs(this.numerator % this.denominator);

    return `${integerValue > 0 ? integerValue : integerValue + 1}'${numerator}/${this.denominator}`;
}

Fraction.prototype.toString = function() {
    if(Math.abs(this.numerator) > this.denominator) {
        return this.convert();
    }

    return `${this.numerator}/${this.denominator}`;
}