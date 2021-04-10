import Fraction from "../src/index";

test('getNumer', () => {
    const fraction = new Fraction(3, 5);

    expect(fraction.numer).toBe(3);
});

test('getDenom', () => {
    const fraction = new Fraction(3, 5);

    expect(fraction.denom).toBe(5);
});

test('add', () => {
    const firstFraction = new Fraction(3, 5);
    const secondFraction = new Fraction(1, 2);

    expect(firstFraction.add(secondFraction).toString()).toBe("1'1/10");
});

test('sub', () => {
    const firstFraction = new Fraction(3, 5);
    const secondFraction = new Fraction(1, 2);

    expect(firstFraction.sub(secondFraction).toString()).toBe("1/10");
});

test('toString', () => {
    const fraction = new Fraction(-6, 5);
    
    expect(fraction.toString()).toBe("-1'1/5");
})