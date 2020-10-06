<?php

namespace Igshab2000\minesweeper\Model;

function create() {
    define("MAX_X", 10);
    define("MAX_Y", 10);
    define("BOMBS_COUNT", 10);

    $cells = array();
    $bombs = array();
    $openedCellsCount = 0;
}

function keep($array, $x, $y) {
    if (isset($array)) {
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i]['x'] == $x && $array[$i]['y'] == $y) {
                return true;
            }
        }
    }
    return false;
}

function createBombs($position) {
    global $bombs;
    
    for ($i = 0; $i < BOMBS_COUNT; $i++) {
        $randX = rand(0, MAX_X - 1);
        $randY = rand(0, MAX_Y - 1);

        if (!keep($bombs, $randX, $randY)) {
            $bombs[$i] = array('x' => $randX, 'y' => $randY);
        } else {
            createBombs($i);
            break;
        }
    }
    if (count($bombs) == BOMBS_COUNT) {
        return;
    }
}

function deployBombs() {
    global $cells, $bombs;

    for ($i = 0; $i < BOMBS_COUNT; $i++) {
        $x = $bombs[$i]['x'];
        $y = $bombs[$i]['y'];
        $cells[$y][$x]['isBomb'] = true;

        for ($j = $x - 1; $j <= $x + 1; $j++) {
            for ($k = $y - 1; $k <= $y + 1; $k++) {
                if (isset($cells[$j]) && isset($cells[$k][$j])) {
                    $cells[$k][$j]['besidecount'] += 1;
                }
            }
        }
    }
}

function createCells() {
    global $cells;
    for ($i = 0; $i < MAX_Y; $i++) {
        for ($j = 0; $j < MAX_X; $j++) {
            $cells[$i][$j] = array('opened' => false, 'marked' => false,
                                        'isBomb' => false, 'besidecount' => 0);
        }
    }
    createBombs(0);
    deployBombs();
}

function isBomb($x, $y) {
    global $cells, $lostGame;

    if ($cells[$y][$x]['isBomb'] == true && $cells[$y][$x]['marked'] == false) {
        $cells[$y][$x]['opened'] = true;
        
        return true;
    }
    return false;
}

function openCells($x, $y) {
    global $cells;
    if (isset($cells[$y]) && isset($cells[$y][$x])) {
        openArea($x, $y);
    }
}

function openArea($x, $y) {
    global $openedCellsCount, $cells;

    if ($cells[$y][$x]['opened'] == false && $cells[$y][$x]['marked'] == false) {

        $cells[$y][$x]['opened'] = true;
        $openedCellsCount += 1;

        if ($cells[$y][$x]['besidecount'] != 0) {
            return;
        }
    } else {
        return;
    }

    for ($i = $x - 1; $i <= $x + 1; $i++) {
        for ($j = $y - 1; $j <= $y + 1; $j++) {
            openCells($i, $j);
        }
    }
}

function setFlag($x, $y) {
    global $openedCellsCount, $cells;

    if ($cells[$y][$x]['marked'] == false) {
        if ($cells[$y][$x]['opened'] == false) {
            $cells[$y][$x]['marked'] = true;
            $cells[$y][$x]['opened'] = true;
            $openedCellsCount++;
        }
    } else {
            $cells[$y][$x]['marked'] = false;
            $cells[$y][$x]['opened'] = false;
            $openedCellsCount--;
    }
}
