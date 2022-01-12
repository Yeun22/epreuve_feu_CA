<?php

function my_calculette_of_dead(array $calc)
{
    [$calc, $stilParenthese] = find_parentheses($calc);

    if (!$stilParenthese) {
        //Il n' ya pas de parenthèse
        $result = make_calcul($calc);
        if ($result === 'finish' || count($result) === 1) {
            //C'est finie : 
            echo "yolo le resultat c'est  " . $result[0] . "\n";
	   return;
        } else {
            my_calculette_of_dead($result);
        }
    } else {
        my_calculette_of_dead($calc);
    }
}


function find_parentheses(array $arr)
{
    // First Chercher les parenthèses
    $outputArray = [];

    $take = false;
    $finish = false;
    $stilParenthese = true;
    for ($i = 0; $i < count($arr); $i++) {
        //Si les parenthèses n'ont qu'une valeur on les dégages et on retourne le tableau
        if ($arr[$i] === '(' && $arr[$i + 2] === ')') {
            array_splice($arr, $i, 3, $arr[$i + 1]);
            return [$arr, $stilParenthese];
        }
        //Sinon on traite
        if ($arr[$i] === '(') {
            $take = true;
            $idDebut = $i;
        }
        if ($take) {
            $outputArray[] = $arr[$i];
        }
        if ($take && $arr[$i] === ')') {
            $take = false;
            $longueur = ($i) - $idDebut;
            $finish = true;
        }
        if ($finish) {

            $parenthesesCalcullee = make_calcul($outputArray);

            array_splice($arr, $idDebut, $longueur + 1, $parenthesesCalcullee);
            return [$arr, $stilParenthese];
        }
    }
    $stilParenthese = false;
    return [$arr, $stilParenthese];
}

function make_calcul(array $arr)
{
    if (count($arr) > 0) {
        //Resolve prioritaires
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i] === "*" || $arr[$i] === "/") {
                $result = make_a_calcul($arr[$i], $arr[$i - 1], $arr[$i + 1]);
                $arr = maj_array($arr, $i, $result);
                return $arr;
            }
        }
        //Calcul le reste
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i] === "+" || $arr[$i] === "-" || $arr[$i] === "%") {
                $result = make_a_calcul($arr[$i], $arr[$i - 1], $arr[$i + 1]);
                $arr = maj_array($arr, $i, $result);
                return $arr;
            }
        }
    } else {
        return "finish";
    }
}


function maj_array(array $arr, $index, $result): array
{

    if (isset($arr[$index - 1]) && isset($arr[$index + 1])) {
        array_splice($arr, ($index - 1), 3, $result);
    }
    return $arr;
}


function make_a_calcul($operator, $nbr1, $nbr2)
{
    switch ($operator) {
        case '*':
            return floatval($nbr1) * floatval($nbr2);
            break;
        case '/':
            return floatval($nbr1) / floatval($nbr2);
            break;
        case '%':
            return floatval($nbr1) % floatval($nbr2);
            break;
        case '+':
            return floatval($nbr1) + floatval($nbr2);
            break;
        case '-':
            return floatval($nbr1) - floatval($nbr2);
            break;
    }
}

array_shift($argv);

if ($argv === []) {
    echo "Vous devez spécifier un argument de type string \n";
    return;
}
if (count($argv) > 1) {
    echo "Vous devez spécifier un SEUL argument de type string \n";
    return;
}



$calc = explode(" ", $argv[0]);


$start = 0;
$end = 0;
for ($i = 0; $i < count($calc); $i++) {

    if (strlen($calc[$i]) >= 2) {
        $test = strval($calc[$i]);
        for ($j = 0; $j < strlen($test); $j++) {
            if ($test[$j] === '(') {
                $start++;
		$parenthese = substr($test, 0, 1);
                $value = substr($test, 1, strlen($test) - 1);
                array_splice($calc, $i, 1, [$parenthese, $value]);
            }
            if ($test[$j] === ')') {
                $end++;
		$parenthese = substr($test, strlen($test) - 1, 1);
                $value = substr($test, 0, strlen($test) - 1);
                array_splice($calc, $i, 1, [$value, $parenthese]);
            }
        }
    }
}

if ($start !== $end) {
    echo "Il ya une erreur dans les parenthèses ! \n";
    return;
}


my_calculette_of_dead($calc);
