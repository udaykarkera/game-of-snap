<?php

Class CardGame extends Game implements CardsPlay {

    public $deck = [];

    public $playersSet = []; // this defines cards to be given for specific player

    public $prevCard;

    public $currCard;

    public function __construct() {
        $this->prepareDeck(); // Prepare deck
    }

    public function prepareDeck() {
        $cards = new Cards;
        foreach ($cards->type as $cardType) {
            foreach ($cards->value as $cardValue) {
                array_push($this->deck, $cardType . ' ' . $cardValue);
            }
        }
    }

    public function shuffleCards() {
        shuffle($this->deck); // shuffle the deck
        General::printLines(['Deck has been shuffled']);
    }

    // Here the game decides which card set to be given to specific player
    public function divDeckCards(Int $noPlayers) {
        $this->shuffleCards();
        $this->playersSet = array_chunk($this->deck,floor(count($this->deck)/$noPlayers));
    }

    public function emptyDeck() {
        $this->deck=[];
    }

    public function exitGame() {
        $this->endGame();
    }

    protected function startGame() {
        General::printLines(['Welcome to Card Games']);
    }

    protected function endGame() {
        General::printLines(['You have stopped the game. Goodbye!']);
        exit;
    }

}