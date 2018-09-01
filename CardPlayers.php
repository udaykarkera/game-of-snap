<?php

Class CardPlayers extends Player implements CardsPlay {

    public $myCards = [];

    public $myCurrCard;

    public $playersSetIndex; // this derives the name or identity of the player to take cards from the game

    public function __construct($nameOfPlyr) {
        $this->name = $nameOfPlyr;
        $this->playersSetIndex = $this->name - 1;
    }

    public function drawMyCard() {
        $myCardCount = count($this->myCards);
        if ($myCardCount == 0) return false;
        else {
            $keyToDraw = $myCardCount - 1;
            $this->myCurrCard = $this->myCards[$keyToDraw];
            unset($this->myCards[$keyToDraw]);
            return $this->myCurrCard;
        }
    }

    public function takeCards(CardGame $gameObj) {
        $this->myCards = array_merge($this->myCards, $gameObj->playersSet[$this->playersSetIndex]);
        $this->shuffleCards();
    }

    public function shuffleCards() {
        shuffle($this->myCards); // shuffle my cards
        General::printLines(["Player $this->name cards has been shuffled"]);
    }

}