<?php

$tofind = file($argv[1]);

$board =file($argv[2]);


for($i=0;$i<count($tofind);$i++)
{
	$findme = $tofind[$i];
	for($j=0;$j<count($board);$j++){
		$mystring = $board[$j];

		$pos = strpos($mystring, $findme);

		// Notez notre utilisation de !==.  != ne fonctionnerait pas comme attendu
		// car la position de 'a' est la 0-ième (premier) caractère.
		if ($pos !== false) {
    			echo "La chaine '$findme' a été trouvée dans la chaîne '$mystring'";
    			echo " et débute à la position $pos";
		} else {
    			echo "La chaîne '$findme' ne se trouve pas dans la chaîne '$mystring'";
		}
	}
}


var_dump($tofind); var_dump($board);