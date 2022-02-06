<?php

if (count($argv)) {
    echo "Parals needed : x y density";
    return;
}

$x = $argv[0];
$y = $argv[1];
$density = $argv[2];
echo "$y.xo";
for ($i = 0; $i < $y; $i++) {
    for ($j = 0; $j < $x; $j++) {
        $chars = (rand($y) * 2) < $density ? 'x' : '.';
        echo $chars;
    }
    echo "\n";
}

