<?php

/**
 * @param array $arr array to transform
 * this function take an array and transform col in line
 * same number of arguments by index needed
 */
function reverseColArray(array $arr)
{
    $lengthArr = count($arr);
    $outputArray = [];
    $i = 0;
    do {
        $string = "";
        foreach ($arr as $value) {
            $string .= $value[$i];
        }
        $outputArray[] = $string;
        $i++;
    } while ($i < $lengthArr);
    return $outputArray;
}


//Algortihme:
function resolveSudoku(array $arrLine, array $arrCol, string $emptyChars)
{
    $passages = 0;
    //Initialisation de la résolution à faux : 
    //Choose an array wher we search
    $searchArray = $arrLine;
    $nameSearchArray = "arrayLine";

    do {
        $finish = true;
        foreach ($searchArray as $key => $value) {
            $passages++;
            //On prends mtn chaque ligne : 
            $line = str_split($value, 1);
            $missingNumber = 0;
            foreach ($line as $id => $number) {
                if ($number === $emptyChars) {
                    $missingNumber++;
                }
            }

            if ($missingNumber > 1) {
                //On a encore des trous
                $finish = false;
            }
            if ($missingNumber >= 2) {
                $numbersPossibles = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
                $idFind = false;
                foreach ($line as $id => $number) {
                    for ($i = 0; $i < count($numbersPossibles); $i++) {
                        if ($number == $numbersPossibles[$i]) {
                            array_splice($numbersPossibles, $i, 1);
                        }
                    }
                    if ($number === $emptyChars) {
                        $idChange = $id;
                        $idFind = true;
                    }
                    if ($idFind) {
                        if ($nameSearchArray === 'arrayLine') {
                            for ($j = 0; $j < strlen($arrCol[$idChange]); $j++) {
                                for ($i = 0; $i < count($numbersPossibles); $i++) {
                                    if ($arrCol[$idChange][$j] == $numbersPossibles[$i]) {
                                        array_splice($numbersPossibles, $i, 1);
                                    }
                                }
                            }
                            $restNumber = count($numbersPossibles);
                            if ($restNumber == 1) {
                                //alors on peut remplacer
                                $arrLine[$key][$idChange] = str_replace($emptyChars, $numbersPossibles[0], $searchArray[$key][$idChange]);
                                $arrCol[$idChange][$key] = str_replace($emptyChars, $numbersPossibles[0], $searchArray[$key][$idChange]);
                            } else {
                                continue;
                            }
                        } elseif ($nameSearchArray === 'arrayCol') {
                            for ($j = 0; $j < strlen($arrLine[$idChange]); $j++) {
                                for ($i = 0; $i < count($numbersPossibles); $i++) {
                                    if ($arrLine[$idChange][$j] == $numbersPossibles[$i]) {
                                        array_splice($numbersPossibles, $i, 1);
                                    }
                                }
                            }
                            $restNumber = count($numbersPossibles);
                            if ($restNumber == 1) {
                                //alors on peut remplacer
                                $arrCol[$key][$idChange] = str_replace($emptyChars, $numbersPossibles[0], $searchArray[$key][$idChange]);
                                $arrLine[$idChange][$key] = str_replace($emptyChars, $numbersPossibles[0], $searchArray[$key][$idChange]);
                            } else {
                                continue;
                            }
                        }
                    }
                }
            }
            //If missingNumber = 1 On traite, sinon on continue
            if ($missingNumber === 1) {
                $idFind = false;
                //Search good answer
                $numbersPossibles = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
                foreach ($line as $id => $number) {
                    for ($i = 0; $i < count($numbersPossibles); $i++) {
                        if ($number == $numbersPossibles[$i]) {
                            array_splice($numbersPossibles, $i, 1);
                        }
                    }
                    if ($number === $emptyChars) {
                        $idChange = $id;
                        $idFind = true;
                    }
                }
                if ($idFind) {
                    //On remplace dans le tableau actuel l'élément manquant par l'élément restant
                    //On remplace aussi dans l'autre array
                    if ($nameSearchArray === 'arrayLine') {
                        $arrLine[$key] = str_replace($emptyChars, $numbersPossibles[0], $searchArray[$key]);
                        $arrCol[$idChange][$key] = str_replace($emptyChars, $numbersPossibles[0], $searchArray[$key][$idChange]);
                    } elseif ($nameSearchArray === 'arrayCol') {
                        $arrCol[$key] = str_replace($emptyChars, $numbersPossibles[0], $searchArray[$key]);
                        $arrLine[$idChange][$key] = str_replace($emptyChars, $numbersPossibles[0], $searchArray[$key][$idChange]);
                    }
                }
            }
        }
        //Si c'est le cas on change de tableau
        if ($nameSearchArray === 'arrayLine') {
            $searchArray = $arrCol;
            $nameSearchArray = 'arrayCol';
        } else {
            $searchArray = $arrLine;
            $nameSearchArray = 'arrayLine';
        }
    } while ($finish === false);


    return $arrLine;
}

function verifValidity(array $arr)
{
    foreach ($arr as $key => $line) {
        $numbersPossibles = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $line = str_split($line, 1);

        foreach ($line as $id => $number) {
            for ($i = 0; $i < count($numbersPossibles); $i++) {
                if ($number == $numbersPossibles[$i]) {
                    array_splice($numbersPossibles, $i, 1);
                }
            }
        }
        if (count($numbersPossibles) > 0) {
            return false;
        }
    }
    return true;
}

function renderArrayInNav($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        echo $arr[$i];
        echo "\n";
    }
}

function deleteEmptySpacesInArray(array $arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        $arr[$i] = substr($arr[$i], 0, strlen($arr[$i]) - 1);
    }
    return $arr;
}

// Traitement des erreurs : 

if (count($argv) !== 2) {
    echo "Il foit y avoir un fichier en paramètre de ce script \n";
    return;
}


$arraySudoku = file($argv[1]);


if (!is_array($arraySudoku)) {
    echo "Le fichier passé en paramètres n'est pas bon \n";
    return;
}


//Execution :

//Traitement des espaces
$arraySudoku = deleteEmptySpacesInArray($arraySudoku);
//$arraySudoku = deleteEmptySpacesInArray($arraySudoku);
/**
 * [
 * "1957842.."
 * "3.6529147"
 * "4721.3985"
 * "637852419"
 * "8596.1732"
 * "214397658"
 * "92.418576"
 * "5.8976321"
 * "7612358.4"
 * ]
 */

//Création d'un array pour les colonnes
$colArray = reverseColArray($arraySudoku);

$resolution = resolveSudoku($arraySudoku,  $colArray,  '.');

if (
    verifValidity($resolution) &&
    verifValidity(reverseColArray($resolution))
) {
    echo "Notre algortihme à trouver la solution à votre sudoku \n";
    renderArrayInNav($resolution);
} else {
    echo "Notre algortihme n'a malheuresement pas bien résolut votre sudoku";
}

