<?php



$adjectifsLongs = ['LONG','HASARDEUX', 'PAS DE TOUT REPOS', 'INCROYABLE', 'A FAIRE CHAUFFER LE CIBOULO','SO AMAZING'];
$id1 = rand(0, count($adjectifsLongs)-1);
$adjectifsChauds = ["GALERE", "CONTRAIGNANT SA MAMAN", "CHAUD DE OUF", "HYPER INSTRUCTIF", "DUUUUUUUUUUUUUUUUUR"];
$id2 = rand(0, count($adjectifsChauds)-1);

echo " J'ai terminé l'épreuve du Feu, jsuis on fire pour la suite !!! \n
 C'était ... \n Comment dire ... \n " .$adjectifsLongs[$id1]  . " pour commencer mais aussi ... 
\n ...\n Mega Interessant mais méga ". $adjectifsChauds[$id2] ." ! \n";

return;



