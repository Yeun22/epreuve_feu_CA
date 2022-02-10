<?php


function renderArrayInNav($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        echo $arr[$i];
        echo "\n";
    }
}


function renderSquare($plateau, $cote, $startPosX, $startPosY, $formeSquare)
{
    for ($j = 0; $j < count($plateau); $j++) {
        if ($j >= $startPosY && $j <= $cote) {
            for ($x = 0; $x < strlen($plateau[$j]); $x++) {
                if ($x >= $startPosX && $x <= $startPosX + $cote) {
                    echo $formeSquare;
                } else {
                    echo $plateau[$j][$x];
                }
            }
        } else {
            echo $plateau[$j];
        }
        echo "\n";
    }
}

function findBiggestSquare(array $plateau, string $point, string $formeSquare)
{
    //Chopper le plus grand carré faisable :
    $hauteurMax = count($plateau);
    $largeurMax = strlen($plateau[0]);

    $hauteurMax < $largeurMax ? $cote = $hauteurMax : $largeurMax;
    $cote = $cote;
    $startPosX = 0;
    $startPosY = 0;
    startResearch:
    //EST CE QUE ON PEUT METTRE X EN LARGEUR ET Y EN HAUTEUR ? 
    if (strlen($plateau[$startPosY]) >= ($startPosX + $cote) && count($plateau) >= ($startPosY + $cote)) {
        // SI OUI EST CE QUON A DES CROIS DEDANS ? 
        for ($i = $startPosY; $i <= (count($plateau) - (count($plateau) - $cote)); $i++) {
            $pos = strpos($plateau[$i], $point, $startPosX);
            if ($pos !== false && $pos < ($cote + $startPosX)) {
                // echo "<br> CA MARCHE PAS : LE carré fait $cote x $cote et demarre à x = $startPosX et y = $startPosY il y a une croix en $pos de la ligne $i<br>";
                // SI OUI ALORS ON DECALE LA POSITION DE 1x SI POSSIBLE SINON ON REMET LA POSITION A y++ et x = 0;
                if (strlen($plateau[$startPosY]) > ($startPosX + 1 + $cote)) {
                    $startPosX++;
                    goto startResearch;
                } elseif ((count($plateau) - 1) > ($startPosY + $cote + 1)) {
                    $startPosX = 0;
                    $startPosY++;
                    goto startResearch;
                } else {
                    //on n'a rien
                    $cote--;
                    $startPosX = 0;
                    $startPosY = 0;
                    goto startResearch;
                }
            }
        }
        // echo "\n CA MARCHE : LE carré fait $cote x $cote et demarre à x = $startPosX et y = $startPosY \n";
    }

    renderSquare($plateau, $cote, $startPosX, $startPosY,$formeSquare);
}


//Erreur
if (count($argv) !== 2) {
    echo "Il foit y avoir un paramètre dans ce script \n";
    return;
}


if (file_exists($argv[1])) {
    $plateau = file($argv[1]);
} else {
    echo "Les fichiers passés en paramètres ne sont pas bon \n";
    return;
}

if (!is_array($plateau)) {
    echo "Les fichiers passés en paramètres ne sont pas bon \n";
    return;
}


//Traitement
//Delete First Line :
$params = array_shift($plateau);
//$params = 9.xo
//select points and chars to create square
$squareChars = $params[3];
$pointChars = $params[2];

//Delete end spaces 
for ($i = 0; $i < count($plateau); $i++) {
    $plateau[$i] = substr($plateau[$i], 0, strlen($plateau[$i]) - 1);
}

echo "Plateau \n";
renderArrayInNav($plateau);
echo "\n";

echo "Response \n";
findBiggestSquare($plateau, $pointChars, $squareChars);

