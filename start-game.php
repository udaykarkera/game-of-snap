<?php
// Autoload Classes
spl_autoload_register('myAutoloader');
function myAutoloader($className)
{
    require_once $className.'.php';
}

General::printLines([
    "Enter to play and type 'exit' to leave: "
]);

$line = General::takeInput();

$gameObj = new SnapCard;
if(trim($line) != 'exit'){

    General::printLines(['Game Starts']);

    // You can increase the number of players here
    // $handle = fopen ("php://stdin","r");
    // $gameObj->noOfPlyrs = (int) trim(fgets($handle));
    $gameObj->noOfPlyrs = 2;
    General::printLines(['Number of Players: ' . $gameObj->noOfPlyrs]);

    // this makes cards set for the given number of players
    $gameObj->divDeckCards($gameObj->noOfPlyrs);
    // start game
    $gameObj->startGame();
}
else {
    $gameObj->exitGame();
}