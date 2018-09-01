<?php

abstract Class Game {

    public $noOfPlyrs = 0;

    abstract protected function startGame();
    abstract protected function endGame();

}