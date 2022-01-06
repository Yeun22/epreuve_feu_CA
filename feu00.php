<?php

$x = $argv[1];
$y = $argv[2];

for ($i = 0; $i < $x; $i++) {
    if ($i == 0 || $i == $x - 1) {
        echo "o";
    } else {
        echo '-';
    }
}
for ($j = 0; $j < $y - 2; $j++) {
    echo "\n";

    for ($i = 0; $i < $x; $i++) {
        if ($i == 0 || $i == $x-1) {
            echo '|';
        } else {
            echo ' ';
        }
    }
}
echo "\n";
if ($y >= 2) {


    for ($i = 0; $i < $x; $i++) {
        if ($i == 0 || $i == $x - 1) {
            echo "o";
        } else {
            echo '-';
        }
    }
}
echo "\n";
