<?php

namespace Igshab2000\minesweeper\Model;

function dbCreate() {
    $db = new \SQLite3('gamedb.db');

    $gamesInfoTable = "CREATE TABLE gamesInfo(
        idGame INTEGER PRIMARY KEY,
        dateGame DATE,
        timeGame TIME,
        playerName TEXT,
        metering INTEGER,
        bombsCount INTEGER,
        gameResult TEXT
    )";
    $db->exec($gamesInfoTable);

    $concreteGameTable = "CREATE TABLE concreteGame(
        idGame INTEGER,
        gameTurn INTEGER,
        coordinates TEXT,
        result TEXT
    )";
    $db->exec($concreteGameTable);

    $bombsInfoTable = "CREATE TABLE bombsInfo(
        idGame INTEGER,
        bombCoordinates TEXT
    )";
    $db->exec($bombsInfoTable);
}

function openDatabase() {
    if (!file_exists("gamedb.db")) {
        dbCreate();
    } else {
        $db = new \SQLite3('gamedb.db');
    }
}

function readCfgFile() {
    if (!file_exists("config.cfg")) {
        exit("Config файл не обнаружен!\n");
    }
    $configFile = file("config.cfg");
    $fieldNames = array(0 => "METERING", 1 => "BOMBS_COUNT");
    $checker = 0;
    for ($i = 0; $i < count($configFile); $i++) {
        $tempArray = explode(' ', $configFile[$i]);
        $name = $tempArray[0];
        $value = $tempArray[1];

        if (in_array($name, $fieldNames)) {
            define($name, (int)$value);
            $checker++;
        } else {
            exit("Неверный config файл!\n");
        }
    }

    if ($checker != 2) {
        exit("Неверный config файл!\n");
    }
}

function readFromDb($id) {
    $gameDatabase = new \SQLite3('gamedb.db');
    $query = "SELECT metering, bombsCount FROM gamesInfo";
    $result = $gameDatabase->query($query);
    $row = $result->fetchArray();
    $metering = $row[0];
    $bombsCount = $row[1];
    define("METERING", (int)$metering);
    define("BOMBS_COUNT", (int)$bombsCount);
}

function getVars($id) {
    readFromDb($id);
    openDatabase();

    $cellsArray = array();
    $bombsArray = array();
    $openedCellsCount = 0;
}

function makeVars() {
    readCfgFile();
    openDatabase();

    $cellsArray = array();
    $bombsArray = array();
    $openedCellsCount = 0;
}

function contains($array, $x, $y) {
    if (isset($array)) {
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i]['x'] == $x && $array[$i]['y'] == $y) {
                return true;
            }
        }
    }
    return false;
}

function createBombsArray($position) {
    global $bombsArray;
    for ($i = 0; $i < BOMBS_COUNT; $i++) {
        $randX = rand(0, METERING - 1);
        $randY = rand(0, METERING - 1);
        if (!contains($bombsArray, $randX, $randY)) {
            $bombsArray[$i] = array('x' => $randX, 'y' => $randY);
        } else {
            createBombsArray($i);
            break;
        }
    }
    if (count($bombsArray) == BOMBS_COUNT) {
        return;
    }
}

function createBombsArrayFromDb($id) {
    global $bombsArray;
    $gameDatabase = new \SQLite3('gamedb.db');
    $query = "SELECT * FROM bombsInfo WHERE idGame = '$id'";
    $result = $gameDatabase->query($query);
    $i = 0;
    while ($row = $result->fetchArray()) {
        $temp = explode(',', $row[1]);
        $x = $temp[0];
        $y = $temp[1];
        $bombsArray[$i] = array('x' => $x, 'y' => $y);
        $i++;
    }
}

function deployBombs() {
    global $cellsArray, $bombsArray;
    for ($i = 0; $i < BOMBS_COUNT; $i++) {
        $x = $bombsArray[$i]['x'];
        $y = $bombsArray[$i]['y'];
        $cellsArray[$y][$x]['itsBombs'] = true;
        for ($j = $x - 1; $j <= $x + 1; $j++) {
            for ($k = $y - 1; $k <= $y + 1; $k++) {
                if (isset($cellsArray[$j]) && isset($cellsArray[$k][$j])) {
                    $cellsArray[$k][$j]['nearbycount'] += 1;
                }
            }
        }
    }
}

function createMakeArr($identifier, $id) {
    global $cellsArray, $bombsArray;
    for ($i = 0; $i < METERING; $i++) {
        for ($j = 0; $j < METERING; $j++) {
            $cellsArray[$i][$j] = array('open' => false, 'registered' => false,
                                        'itsBombs' => false, 'nearbycount' => 0);
        }
    }

    if ($identifier == "new") {
        createBombsArray(0);
    } elseif ($identifier == "replay") {
        createBombsArrayFromDb($id);
    }
    insertBombsToDb($bombsArray);
    deployBombs();
}

function itsBombs($x, $y) {
    global $cellsArray, $lostGame;
    if (
        $cellsArray[$x][$y]['itsBombs'] == true
        && $cellsArray[$x][$y]['registered'] == false
    ) {
        $cellsArray[$x][$y]['open'] = true;
        return true;
    }
    return false;
}

function openSurroundedCells($x, $y) {
    global $cellsArray;
    if (
        isset($cellsArray[$x])
        && isset($cellsArray[$x][$y])
    ) {
        openArea($x, $y);
    }
}

function openArea($x, $y) {
    global $openedCellsCount, $cellsArray;
    if (
        $cellsArray[$x][$y]['open'] == false
        && $cellsArray[$x][$y]['registered'] == false
    ) {
        $cellsArray[$x][$y]['open'] = true;
        $openedCellsCount += 1;
        if ($cellsArray[$x][$y]['nearbycount'] != 0) {
            return;
        }
    } else {
        return;
    }
    for ($i = $x - 1; $i <= $x + 1; $i++) {
        for ($j = $y - 1; $j <= $y + 1; $j++) {
            openSurroundedCells($i, $j);
        }
    }
}

function setFlag($x, $y) {
    global $openedCellsCount, $cellsArray;
    if ($cellsArray[$x][$y]['registered'] == false) {
        if ($cellsArray[$x][$y]['open'] == false) {
            $cellsArray[$x][$y]['registered'] = true;
            $cellsArray[$x][$y]['open'] = true;
            $openedCellsCount++;
        }
    } else {
            $cellsArray[$x][$y]['registered'] = false;
            $cellsArray[$x][$y]['open'] = false;
            $openedCellsCount--;
    }
}

function seeSymbol($x, $y) {
    global $cellsArray;
    if ($cellsArray[$y][$x]['open'] == true) {
        if ($cellsArray[$y][$x]['registered'] == true) {
            return sprintf('%2s', 'F');
        }

        if ($cellsArray[$y][$x]['itsBombs'] == true) {
            return sprintf('%2s', '*');
        }

        if ($cellsArray[$y][$x]['nearbycount'] == 0) {
            return sprintf('%2s', '-');
        } else {
            return sprintf(
                '%2s',
                $cellsArray[$y][$x]['nearbycount']
            );
        }
    } else {
        return sprintf('%2s', '.');
    }
}

function insertInfo() {
    $gameDatabase = new \SQLite3('gamedb.db');

    date_default_timezone_set("Europe/Moscow");

    $dateGame = date("d") . "." . date("m") . "." . date("Y");
    $timeGame = date("H") . ":" . date("i") . ":" . date("s");
    $playerName = getenv("username");
    $metering= METERING;
    $bombsCount = BOMBS_COUNT;
    $gameResult = "Не окончена";

    $query = "INSERT INTO gamesInfo(
        dateGame,
        timeGame, 
        playerName,
        metering,
        bombsCount,
        gameResult
    ) VALUES (
        '$dateGame',
        '$timeGame', 
        '$playerName',
        '$metering',
        '$bombsCount',
        '$gameResult' 
    )";

    $gameDatabase->exec($query);
}

function postGameId() {
    $gameDatabase = new \SQLite3('gamedb.db');
    $query = "SELECT idGame 
    FROM gamesInfo 
    ORDER BY idGame DESC LIMIT 1";
    $result = $gameDatabase->querySingle($query);
    define("GAME_ID", $result);
}

function insertBombsToDb() {
    global $bombsArray;
    $gameDatabase = new \SQLite3('gamedb.db');
    $gameId = GAME_ID;
    for ($i = 0; $i < BOMBS_COUNT; $i++) {
        $coordinates = $bombsArray[$i]['x'] . "," . $bombsArray[$i]['y'];
        $query = "INSERT INTO bombsInfo(
            idGame,
            bombCoordinates
        ) VALUES(
            '$gameId',
            '$coordinates'
        )";
        $gameDatabase->exec($query);
    }
}

function insertTurnInfo($turn, $turnResult, $x, $y) {
    $gameDatabase = new \SQLite3('gamedb.db');
    $gameId = GAME_ID;
    $coordinates = $x . "," . $y;
    $query = "INSERT INTO concreteGame(
        idGame,
        gameTurn,
        coordinates,
        result
    ) VALUES (
        '$gameId',
        '$turn',
        '$coordinates',
        '$turnResult'
    )";
    $gameDatabase->exec($query);
}