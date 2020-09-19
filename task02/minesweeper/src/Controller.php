<?php namespace Igshab2000\minesweeper\Controller;
    use function Igshab2000\minesweeper\View\showGame;
    
    function startGame() {
        echo "Game started".PHP_EOL;
        showGame();
    }
?>