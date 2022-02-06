<?php

if (count($argv) !== 3) {
    echo "Il foit y avoir deux paramètres dans ce script \n";
    return;
}


if (file_exists($argv[1]) && file_exists($argv[2])) {
    $arrToFind = file($argv[1]);
    $arrBoard = file($argv[2]);
} else {
    echo "Les fichiers passés en paramètres ne sont pas bon \n";
    return;
}

if (!is_array($arrToFind) || !is_array($arrBoard)) {
    echo "Les fichiers passés en paramètres ne sont pas bon \n";
    return;
}


function findArrayInOtherOne($arrBoard, $arrToFind)
{

    $counterBoard = 0;
    $counterFind = 0;
    $line = count($arrBoard);
    $reponses = 0;
    $outputArray = [];
    do {
        $mystring = $arrBoard[$counterBoard];
        $findme = $arrToFind[$counterFind];

        $pos = findStringInOtherOne($mystring, $findme);
        //Premier cas le + simple : Pas dedans : 
        if ($pos === "notfind") {
            $counterFind = 0;
        } else {
            do {
                if ($counterBoard < $line) {
                    $line = $counterBoard;
                }
                $counterFind++;
                $counterBoard++;
                $mystring = $arrBoard[$counterBoard];
                $findme = $arrToFind[$counterFind];
                $newPos = findStringInOtherOne($mystring, $findme, $pos);
                if ($pos == $newPos) {
                    if (!isset($arrToFind[$counterFind + 1])) {
                        //Alors on vérifie qu'on a trouvé la string complète !
                        $posFixe = $pos;
                        $isFind = true;
                        $s = $counterBoard;
                        $find = (count($arrToFind) - 1);
                        do {
                            $lastPos = findStringInOtherOne($arrBoard[$s], $arrToFind[$find], $posFixe);
                            $pos = findStringInOtherOne($arrBoard[$s], $arrToFind[$find], $posFixe);
                            if ($lastPos !== $pos) {
                                $isFind = false;
                            }
                            $find--;
                            $s--;
                        } while ($find >= 0);

                        if ($isFind) {
                            $reponses++;
                            $lineFinale = $counterBoard - $counterFind;
                            $outputArray[] =  [$newPos, $lineFinale];
                            $counterBoard = $lineFinale;
                            $counterFind = 0;
                            $pos++;
                        }
                    } elseif (!isset($arrBoard[$counterBoard + 1])) {
                        return "notfind";
                    }
                } elseif ($newPos !== $pos && $newPos !== 'notfind') {
                    //On doit péter le while et reprendre avec 
                    $counterBoard = $line;
                    $counterFind = 0;
                    $pos = $newPos;
                }
            } while ($newPos !== 'notfind' && $counterBoard < count($arrBoard));
        }
        $counterFind = 0;
        $counterBoard++;
    } while ($counterBoard < 3);
    if ($reponses > 0) {
        return $outputArray;
    }
    return "Forme introuvable";
}



function findStringInOtherOne($searchString, $findString, $pos = 0)
{
    $i = $pos;
    $j = 0;
    do {
        if ($findString[$j] === $searchString[$i]) {
            if (isset($findString[$j + 1]) && isset($searchString[$i + 1])) {
                $i++;
                $j++;
            } else {
                if (!isset($findString[$j + 1])) {
                    //Alors on vérifie qu'on a trouvé la string complète !
                    $isFind = true;
                    $s = $i;
                    $find = (strlen($findString) - 1);
                    do {
                        if ($searchString[$s] !== $findString[$find] && $findString[$find] !== " ") {
                            $isFind = false;
                        }
                        $s--;
                        $find--;
                    } while ($find >= 0);

                    if ($isFind) {
                        $pos = $i - (strlen($findString) - 1);
                        return $pos;
                    }
                } elseif (!isset($searchString[$i + 1])) {
                    return "notfind";
                }
            }
        } elseif ($findString[$j] === ' ') {
            if (isset($findString[$j + 1]) && isset($searchString[$i + 1])) {
                $i++;
                $j++;
            }
        } else {
            if (!isset($searchString[$i + 1])) {
                return "notfind";
            }
            $i++;
        }
    } while ($i < strlen($searchString));
}


function renderForme($arrayToFilter, $arrayToKeep, $posStart, $lineStart)
{


    $countArrayToKeep = count($arrayToKeep);
    $countArrayToFilter = count($arrayToFilter);
    $y = 0;
    //Si y'a des espâces on les remplaces pa '-'


    for ($i = 0; $i < $countArrayToFilter; $i++) {
        if ($i < $lineStart || $i >= $lineStart + $countArrayToKeep) {
            for ($l = 0; $l < strlen($arrayToFilter[$i]); $l++) {
                echo '-';
            }
        } else {
            $letter = 0;
            for ($l = 0; $l < $posStart; $l++) {
                echo '-';
            }
            for ($l = $posStart; $l < strlen($arrayToKeep[$y]) + ($posStart); $l++) {
                if ($arrayToKeep[$y][$letter] === ' ') {
                    echo  '-';
                } else {
                    echo $arrayToKeep[$y][$letter];
                }
                if (isset($arrayToKeep[$letter + 1])) {
                    $letter++;
                }
            }
            for ($l = strlen($arrayToKeep[$y]) + $posStart; $l < strlen($arrayToFilter[$i]); $l++) {
                echo '-';
            }
            if (isset($arrayToKeep[$y + 1])) {
                $y++;
            }
        }
        echo "\n";
    }
}

echo "\n\n Le Traitement : \n\n";

for ($i = 0; $i < count($arrToFind); $i++) {
    $arrToFind[$i] = substr($arrToFind[$i], 0, strlen($arrToFind[$i]) - 1);
}
for ($i = 0; $i < count($arrBoard); $i++) {
    $arrBoard[$i] = substr($arrBoard[$i], 0, strlen($arrBoard[$i]) - 1);
}

$result =  findArrayInOtherOne($arrBoard, $arrToFind);

//on nre récupère déjà que la premiere ligne ou l'on trouve la forme 
if (is_array($result)) {
    foreach ($result as $value) {
        $position = $value[0];
        $line = $value[1];
    }
    //on affiche que la dernière donc la plus à droite
    echo "\n Line = $line et position = $position  \n";
    renderForme($arrBoard, $arrToFind, $position, $line);
} else {
    echo $result . "\n";
}

