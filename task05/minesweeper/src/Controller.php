<?php

namespace Igshab2000\minesweeper\Controller;

use function Igshab2000\minesweeper\View\showGame;
use function Igshab2000\minesweeper\View\showTurnInfo;
use function Igshab2000\minesweeper\View\showGamesInfo;
use function Igshab2000\minesweeper\Model\createVars;
use function Igshab2000\minesweeper\Model\createCellsArray;
use function Igshab2000\minesweeper\Model\isBomb;
use function Igshab2000\minesweeper\Model\openArea;
use function Igshab2000\minesweeper\Model\setFlag;
use function Igshab2000\minesweeper\Model\insertInfo;
use function Igshab2000\minesweeper\Model\getGameId;
use function Igshab2000\minesweeper\Model\insertTurnInfo;
use function Igshab2000\minesweeper\Model\updateDatabase;
use function Igshab2000\minesweeper\Model\idExists;
use function Igshab2000\minesweeper\Model\getGamesInfo;
use function Igshab2000\minesweeper\Model\getTurnsInfo;

function isCorrect($x, $y) {
    if (is_numeric($x) && is_numeric($y)) {
        $temp = DIMENSION - 1;
        if ($x >= 0 && $x <= $temp && $y >= 0 && $y <= $temp) {
            return true;
        }
    }
    return false;
}

function gameLoop() {
    global $cellsArray, $openedCellsCount;
    $flag = "-";
    $turnCount = 1;
    while (true) {
        showGame($turnCount);
        
        $inputString = \cli\prompt(
            "Введите координаты x, y ячейки через "
            . "запятую без пробела.\nЕсли хотите "
            . "установить флаг в ячейку, то введите "
            . "F или f после ввода координат (через запятую, "
            . "без пробела). Для выхода из игры используйте "
            . "команду --exit"
        );

        if ($inputString == "--exit") {
            exit();
        }

        $inputArray = explode(',', $inputString);

        $coordX = $inputArray[0];
        $coordY = $inputArray[1];

        if (!isCorrect($coordX, $coordY)) {
            \cli\line("Неверно введены данные! Попробуйте еще раз");
            continue;
        }

        if (isset($inputArray[2])) {
            if ($inputArray[2] == "F" || $inputArray[2] == "f") {
                $flag = $inputArray[2];
                setFlag($coordX, $coordY);
                insertTurnInfo($turnCount, "Установлен флаг", $coordX, $coordY);
                $turnCount++;
                continue;
            } else {
                \cli\line("Неверно введены данные! Попробуйте еще раз");
                continue;
            }
        }

        if (isBomb($coordX, $coordY)) {
            showGame($turnCount);
            \cli\line("GAME OVER");
            insertTurnInfo($turnCount, "Игра проиграна", $coordX, $coordY);
            updateDatabase("Игра проиграна");
            break;
        } else {
            openArea($coordX, $coordY);
            insertTurnInfo($turnCount, "Открыта область", $coordX, $coordY);
            if ($openedCellsCount == count($cellsArray) * count($cellsArray[0])) {
                showGame($turnCount);
                \cli\line("CONGRATULATIONS! YOU WON");
                insertTurnInfo($turnCount, "Игра выиграна", $coordX, $coordY);
                updateDatabase("Игра выиграна");
                break;
            }
        }
        $turnCount++;
    }
}

function newGame() {
    createVars();
    $playerName = \cli\prompt("Введите имя игрока. Для выхода из игры используйте команду --exit");

    if ($playerName == "--exit") {
        exit();
    }

    insertInfo($playerName);
    getGameId();
    createCellsArray();
    gameLoop();
    exit();
}

function listGames() {
    if (!file_exists("gamedb.db")) {
        \cli\line("База данных не обнаружена!");
        return;
    }

    $gamesArray = getGamesInfo();
    for ($i = 0; $i < count($gamesArray); $i++) {
        showGamesInfo($gamesArray[$i]);
    }
}

function replayGame($id) {
    if (!file_exists("gamedb.db")) {
        \cli\line("База данных не обнаружена!");
        return;
    }

    if (!idExists($id)) {
        \cli\line("Выбранной игры не существует");
        return;
    } else {
        $turnsArray = getTurnsInfo($id);
        for ($i = 0; $i < count($turnsArray); $i++) {
            showTurnInfo($turnsArray[$i]);
        }
    }
}

function startGame($command) {
    if (!isset($command[1])) {
        exit("Ключ не был введен!");
    }

    if ($command[1] == "--new") {
        newGame();
    } elseif ($command[1] == "--list") {
        listGames();
    } elseif (isset($command[2]) && is_numeric($command[2]) &&  $command[1] == "--replay") {
        replayGame($command[2]);
    } else {
        \cli\line("Неверный ключ!");
    }
}
?>