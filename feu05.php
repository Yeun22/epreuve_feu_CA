<?php

//Erreur
if (count($argv) !== 2) {
    echo "Il foit y avoir un paramètres dans ce script \n";
    return;
}


if (file_exists($argv[1])) {
    $labyrinthe = file($argv[1]);
} else {
    echo "Les fichiers passés en paramètres ne sont pas bon \n";
    return;
}

if (!is_array($labyrinthe)) {
    echo "Les fichiers passés en paramètres ne sont pas bon \n";
    return;
}




function findStartAndFinal(array $labyrinthe, string $first, string $two)
{
    //Y represente l'axe de la hauteur, X la position sur la ligne (l'ordonnee);
    $start = [];
    $end = [];
    foreach ($labyrinthe as $ligne => $value) {
        for ($i = 0; $i < strlen($value); $i++) {
            if ($value[$i] === $first) {
                $start = ['x' => $i, 'y' => $ligne];
            }
            if ($value[$i] === $two) {
                $end = ['x' => $i, 'y' => $ligne];
            }
        }
    }

    return [$start, $end];
}

//Render in nav 
function renderArrayInNav($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        for ($j = 0; $j < strlen($arr[$i]); $j++) {
            if ($arr[$i][$j] == ' ') {
                echo " ";
            } else {
                echo $arr[$i][$j];
            }
        }
        echo "\n";
    }
}

//Find the better way to get out
function resolveLabyrinthe(array $labyrinthe, $start, $charsEnd, $charsToRendPath)
{
    // DANS LE LABYRINTHE ON VA COMMENCER A LA LIGNE DE DEPART 
    $cursor = $start;
    // ON REGARDE SI AUTOUR DE 1 ON A DU VIDE
    $pointsWeWere = [];
    $cursor['weComeFromLeft'] = false;
    $cursor['weComeFromRight'] = false;
    $cursor['weComeFromDown'] = false;
    $cursor['weComeFromUp'] = false;
    deplace:
    $x = intval($cursor['x']);
    $y = intval($cursor['y']);

    //D'abord checker si on une sortie autour
    if (
        isset($labyrinthe[$y][$x - 1]) && $labyrinthe[$y][$x - 1] === $charsEnd ||
        isset($labyrinthe[$y][$x + 1]) && $labyrinthe[$y][$x + 1] === $charsEnd ||
        isset($labyrinthe[$y + 1]) && $labyrinthe[$y + 1][$x] === $charsEnd ||
        isset($labyrinthe[$y - 1]) && $labyrinthe[$y - 1][$x] === $charsEnd

    ) {
        renderPath($labyrinthe, $pointsWeWere, $charsToRendPath);
        return;
    }

    if (isset($labyrinthe[$y][$x + 1]) && $labyrinthe[$y][$x + 1]  === ' ' && $cursor['weComeFromRight'] == false) {
        $cursor['weComeFromLeft'] = true;
        $cursor['x'] = $cursor['x'] + 1;
        $pointsWeWere[] = $cursor;
        goto deplace;

        // die("we got empty chars to right");
    } else if (isset($labyrinthe[$y + 1]) && $labyrinthe[$y + 1][$x] === ' ' && $cursor['weComeFromDown'] == false) {
        $cursor['weComeFromUp'] = true;
        $cursor['y'] = $cursor['y'] + 1;
        $pointsWeWere[] = $cursor;

        goto deplace;
        // die("we got empty chars to down");

    } else if (isset($labyrinthe[$y - 1]) && $labyrinthe[$y - 1][$x] === ' ' && $cursor['weComeFromUp'] == false) {
        $cursor['weComeFromDown'] = true;
        $cursor['y'] = $cursor['y'] - 1;
        $pointsWeWere[] = $cursor;

        goto deplace;
        // die("we got empty chars to up");

    } else if (isset($labyrinthe[$y][$x - 1]) && $labyrinthe[$y][$x - 1] === ' ' && $cursor['weComeFromLeft'] == false) {
        $cursor['weComeFromRight'] = true;
        $cursor['x'] = $cursor['x'] - 1;
        $pointsWeWere[] = $cursor;

        goto deplace;
        // die("we got empty chars to left");

    } else {
        // SI NON ON ENVOIE UNE ERREUR 
        //Si on arrive dans un mur, on reprends la liste de points et pour chacun on regarde si on peut se deplacer à un autre endroit que celui fait
        for ($p = (count($pointsWeWere) - 1); $p >= 0; $p--) {
            //If number of possibilities >1
            //If we come from left, we search at top, right and down but we also verified if the new point is no already existing ion our repertorie
            $pointToTest = $pointsWeWere[$p];
            $y = $pointToTest['y'];
            $x = $pointToTest['x'];
            //Check if we already try some path
            $right = false;
            $left = false;
            $up = false;
            $down = false;
            foreach ($pointsWeWere as $value) {
                if ($value['x'] === ($x + 1) && $value['y'] === $y) {
                    $right = true;
                }
                if ($value['x'] === ($x - 1) && $value['y'] === $y) {
                    $left = true;
                }
                if ($value['x'] == $x && $value['y'] === ($y + 1)) {
                    $down = true;
                }
                if ($value['x'] == $x && $value['y'] === ($y - 1)) {
                    $up = true;
                }
            }
            //End check if already try this path

            if (isset($labyrinthe[$y][$x + 1]) && $labyrinthe[$y][$x + 1]  === ' ' && $right === false) {
                $pointToTest['weComeFromLeft'] = true;
                $pointToTest['weComeFromRight'] = false;
                $pointToTest['weComeFromDown'] = false;
                $pointToTest['weComeFromUp'] = false;
                $cursor = $pointToTest;
                array_pop($pointsWeWere);
                $cursor['x'] = $cursor['x'] + 1;
                $pointsWeWere[] = $cursor;
                goto deplace;
                die('right exist and we never go in it');
            }
            if (isset($labyrinthe[$y][$x - 1]) && $labyrinthe[$y][$x - 1]  === ' ' && $left === false) {
                $pointToTest['weComeFromLeft'] = false;
                $pointToTest['weComeFromRight'] = true;
                $pointToTest['weComeFromDown'] = false;
                $pointToTest['weComeFromUp'] = false;
                $cursor = $pointToTest;
                array_pop($pointsWeWere);
                $cursor['x'] = $cursor['x'] - 1;
                $pointsWeWere[] = $cursor;
                goto deplace;
                die('left exist and we never go in it');
            }
            if (isset($labyrinthe[$y + 1]) && $labyrinthe[$y + 1][$x]  === ' ' && $down === false) {
                $pointToTest['weComeFromLeft'] = false;
                $pointToTest['weComeFromRight'] = false;
                $pointToTest['weComeFromDown'] = false;
                $pointToTest['weComeFromUp'] = true;
                $cursor = $pointToTest;
                array_pop($pointsWeWere);
                $cursor['y'] = $cursor['y'] + 1;
                $pointsWeWere[] = $cursor;
                goto deplace;

                die('down exist and we never go in it');
            }
            if (isset($labyrinthe[$y - 1]) && $labyrinthe[$y - 1][$x]  === ' ' && $up === false) {
                $pointToTest['weComeFromLeft'] = false;
                $pointToTest['weComeFromRight'] = false;
                $pointToTest['weComeFromDown'] = true;
                $pointToTest['weComeFromUp'] = false;
                $cursor = $pointToTest;
                array_pop($pointsWeWere);
                $cursor['y'] = $cursor['y'] - 1;
                $pointsWeWere[] = $cursor;
                goto deplace;
                die('up exist and we never go in it');
            }
        }
        echo "Sorry something got wrong, try again \n";
        return;
    }
    // SI OUI ON SE DEPLACE ET ON MET LE NOUVEAU POINT EN VALEUR DE DEPART PUIS ON RELANCE 
    // SI JAMAIS ON A ATTEINT 2 ON RETOURNE TROUVE
}


//Show path of labyrinthe
function renderPath(array $labyrinthe, array $points, string $charsToRendPath)
{
    for ($i = 0; $i < count($labyrinthe); $i++) {
        for ($j = 0; $j < strlen($labyrinthe[$i]); $j++) {
            if ($labyrinthe[$i][$j] == ' ') {
                $draw = false;
                foreach ($points as $point) {
                    if ($point['y'] === $i && $point['x'] === $j) {
                        echo $charsToRendPath;
                        $draw = true;
                    }
                }
                if (!$draw) {
                    echo " ";
                }
            } else {
                echo $labyrinthe[$i][$j];
            }
        }
        echo "\n";
    }
    $nbrCoups =  count($points);

    echo "Sortie Atteinte en $nbrCoups ! coups \n";
}


//Traitement

//First Select Start and End 

//Delete end spaces 
for ($i = 0; $i < count($labyrinthe); $i++) {
    $labyrinthe[$i] = substr($labyrinthe[$i], 0, strlen($labyrinthe[$i]) - 1);
}

//delete first occurence
$utilities = array_shift($labyrinthe);

$lengthFirstLine = strlen($utilities) - 1;

$charsOfEnd = $utilities[$lengthFirstLine - 1];
$charsOfStart =  $utilities[$lengthFirstLine - 2];
$charsToRendPath = $utilities[$lengthFirstLine - 3];

[$start, $end] = findStartAndFinal($labyrinthe, $charsOfStart, $charsOfEnd);

echo "\n Plateau de départ : \n";
renderArrayInNav($labyrinthe);
echo "\n Ma solution : \n";
resolveLabyrinthe($labyrinthe, $start, $charsOfEnd, $charsToRendPath);

