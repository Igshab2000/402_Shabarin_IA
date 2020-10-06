<?php

namespace Igshab2000\minesweeper\View;

function showGame($turnCount) {
    global $cells;
    \cli\line(sprintf('%20s', "ХОД №" . $turnCount));
    $line = sprintf('%2s', ' ');

    for ($i = 0; $i < MAX_X; $i++) {
        $line .= sprintf('%2s', $i);
    }
    
    \cli\line($line);
    $line = '';

    for ($i = 0; $i < MAX_Y; $i++) {
        $line .= sprintf('%2s', $i);

        for ($j = 0; $j < MAX_X; $j++) {
            if ($cells[$i][$j]['opened'] == true) {
                if ($cells[$i][$j]['marked'] == true) {
                    $line .= sprintf('%2s', 'F');
                } else {
                    if ($cells[$i][$j]['isBomb'] == true) {
                        $line .= sprintf('%2s', '*');
                    } else {
                        if ($cells[$i][$j]['besidecount'] == 0) {
                            $line .= sprintf('%2s', '-');
                        } else {
                            $line .= sprintf(
                                '%2s',
                                $cells[$i][$j]['besidecount']
                            );
                        }
                    }
                }
            } else {
                $line .= sprintf('%2s', '.');
            }
        }

        \cli\line($line);
        $line = '';
    }
}
