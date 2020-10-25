<?php

namespace Igshab2000\minesweeper\View;

use function Igshab2000\minesweeper\Model\seeSymbol;

function InformationOfGames($row) {
    \cli\line(
        "ID: $row[0]\nДата: $row[1] $row[2]\nИмя игрока: $row[3]\nРазмерность: "
        . "$row[4]\nКолличесвово бомб: $row[5]\nСтатус игры: $row[6]"
    );
}

function showTurnInfo($row) {
    \cli\line("Номер хода: $row[0]; координаты: $row[1]; статус игры: $row[2]");
}

function showGame($turnCount) {
    \cli\line(sprintf('%18s', "ХОД №" . $turnCount));
    $line = sprintf('%2s', ' ');
    for ($i = 0; $i < METERING; $i++) {
        $line .= sprintf('%2s', $i);
    }
    \cli\line($line);
    $line = '';

    for ($i = 0; $i < METERING; $i++) {
        $line .= sprintf('%2s', $i);
        for ($j = 0; $j < METERING; $j++) {
            $line .= seeSymbol($i, $j);
        }
        \cli\line($line);
        $line = '';
    }
}