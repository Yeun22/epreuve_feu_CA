<?php


function isInteger($arg) 
{
	if(is_numeric($arg) && intval($arg)-$arg ===0)
	{
		return true;
	}
}

if(empty($argv[1]) || empty($argv[2]) )
{
        echo "Il doit y avoir deux paramètres \n";
        return;
}

if(!isInteger($argv[1]) || !isInteger($argv[2]) )
{
	echo "Les deux paramètres doivent être des entiers \n";
	return;
}

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

