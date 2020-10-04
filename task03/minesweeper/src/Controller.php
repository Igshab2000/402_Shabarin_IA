<?php

namespace Igshab2000\minesweeper\Controller;

use function Igshab2000\minesweeper\View\showGame;
use function Igshab2000\minesweeper\Model\create;
use function Igshab2000\minesweeper\Model\createCells;
use function Igshab2000\minesweeper\Model\isBomb;
use function Igshab2000\minesweeper\Model\openArea;
use function Igshab2000\minesweeper\Model\setFlag;

function gameLoop() {
    global $cells, $lostGame, $openedCellsCount;

    $turnCount = 1;

    while (true) {
        showGame($turnCount);
        $turnCount++;
        
        $inputString = \cli\prompt(
            "Введите координаты x, y через запятую "
            . "без пробела.\n"
            . "Для установки флага введите A после координат"
        );

        $inputArray = explode(',', $inputString);
        if (
            !isset($inputArray[0]) || !isset($inputArray[1])
            || preg_match('/^[0-9]{1}$/', $inputArray[0]) == 0
            || preg_match('/^[0-9]{1}$/', $inputArray[1]) == 0
        ) {
            \cli\line("Неверно введены данные! Попробуйте еще раз");
            $turnCount--;
        } else {
            if (isset($inputArray[2]) && ($inputArray[2] == 'A' || $inputArray[2] == 'a')) {
                setFlag($inputArray[0], $inputArray[1]);
            } else {
                if (isBomb($inputArray[0], $inputArray[1])) {
                    showGame($turnCount);
                    \cli\line("GAME OVER");
                    break;
                } else {
                    openArea($inputArray[0], $inputArray[1]);
                    if ($openedCellsCount == count($cells) * count($cells[0])) {
                        showGame($turnCount);
                        \cli\line("CONGRATULATIONS! YOU WON");
                        break;
                    }
                }
            }
        }
    }
}

function startGame() {
    create();
    createCells();
    gameLoop();
}
