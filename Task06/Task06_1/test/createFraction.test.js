import { createFraction } from "../src/index";

test('getNumer', () => {
    const fraction = createFraction(3, 5);

    expect(fraction.getNumer()).toBe(3);
});

test('getDenom', () => {
    const fraction = createFraction(3, 5);

    expect(fraction.getDenom()).toBe(5);
});

test('add', () => {
    const firstFraction = createFraction(3, 5);
    const secondFraction = createFraction(1, 2);

    expect(firstFraction.add(secondFraction).toString()).toBe("1'1/10");
});

test('sub', () => {
    const firstFraction = createFraction(3, 5);
    const secondFraction = createFraction(1, 2);

    expect(firstFraction.sub(secondFraction).toString()).toBe("1/10");
});

test('toString', () => {
    const fraction = createFraction(-6, 5);
    
    expect(fraction.toString()).toBe("-1'1/5");
})