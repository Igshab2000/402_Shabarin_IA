<?php

namespace Igshab2000\minesweeper\View;

use function Igshab2000\minesweeper\Model\findSymbol;

function showGamesInfo($row) {
    \cli\line(
        "ID: $row[id] \nДата: $row[dategame] $row[gametime]\nИмя игрока: $row[playername]\nРазмерность: "
        . "$row[dimension]\nКол-во бомб: $row[bombscount]\nСтатус игры: $row[gameresult]"
    );
}

function showTurnInfo($row) {
    \cli\line("Номер хода: $row[gameturn]; координаты: $row[coordinates]; статус: $row[result]");
}

function showGame($turnCount) {
    \cli\line(sprintf('%20s', "ХОД №" . $turnCount));
    $line = sprintf('%2s', ' ');
    for ($i = 0; $i < DIMENSION; $i++) {
        $line .= sprintf('%2s', $i);
    }
    \cli\line($line);
    $line = '';

    for ($i = 0; $i < DIMENSION; $i++) {
        $line .= sprintf('%2s', $i);
        for ($j = 0; $j < DIMENSION; $j++) {
            $line .= findSymbol($i, $j);
        }
        \cli\line($line);
        $line = '';
    }
}
?>