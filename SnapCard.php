<?php

Class SnapCard extends CardGame {

    public $snapOnce = false; // flag to check whether once there was a match

    // this comparision belongs to game of snaps only. So we can hide this game detail from others
    private function snapIt($i) {
        $comparePrev = explode(' ', $this->prevCard);
        $compareCurr = explode(' ', $this->currCard);
        if (isset($comparePrev[1]) && $comparePrev[1] == $compareCurr[1]) {
            $this->playersSet[$i] = $this->deck;
            $this->emptyDeck();
            $this->prevCard = '';
            $this->snapOnce = true;
            return true;
        }
        else return false;
    }

    public function playerOutOfCards(CardPlayers $plyrObj) {
        if (count($plyrObj->myCards) === 0 && $this->snapOnce === true) {
            General::printLines([
                "Player $plyrObj->name is out of cards. Player $plyrObj->name wins.",
                'Game Over :). See you soon'
            ]);
            return true;
        }
        else return false;
    }

    public function roundOver($i) {
        if ($i == $this->noOfPlyrs -1 && count($this->deck) != 52) return true;
        else return false;
    }

    public function deckOver() {
        if (count($this->deck) === 52 && $this->snapOnce === false) {
            General::printLines(['Cards Over :(. See you soon!']);
            return true;
        }
        else return false;
    }

    public function startGame() {
        General::printLines(["Welcome to 'Game of Snap'"]);

        // set player objects and thier cards
        for ($i = 0; $i<$this->noOfPlyrs; ++$i) {
            $no = $i + 1; // to define player name or number
            $playerObjName = 'player'. $no;

            // Create player objects
            $$playerObjName = new CardPlayers($no);
            $$playerObjName->takeCards($this); // give players their cards
        }
        $this->emptyDeck();

        // play game
        for ($i = 0; $i < $this->noOfPlyrs; ++$i) {
            $no = $i + 1;
            $playerObjName = 'player'. $no;
            General::printLines([
                "Player $no you have ". count($$playerObjName->myCards) ." cards.",
                "Press enter to play your card OR Type 's' and enter to shuffle and play a card:"
            ]);

            // Allow Player to play card
            $line = General::takeInput();

            switch (trim($line)) {
                case 'exit':
                    $this->endGame();
                    break;
                case 's': // Player shuffles his cards
                    $$playerObjName->shuffleCards();
                    break;
            }

            $this->currCard = $$playerObjName->drawMyCard();
            if (!($this->currCard)) {
                General::printLines([
                    "But Player $no is out of cards. Player $no wins.",
                    'Game Over :). See you soon'
                ]);
                break;  
            }
            $this->deck[] = $this->currCard; // add card to the pile
            General::printLines(["Player $no card: " . $this->currCard]);
            echo "\n";

            if ($this->snapIt($i))
            {
                General::printLines(["Theres a match: Player $no you get all the played cards"]);
                $$playerObjName->takeCards($this); // player gets the card in the pile
                --$i; // to make the same player (who collected the cards in pile) to play again
            }
            elseif ($this->playerOutOfCards($$playerObjName)) break;
            else $this->prevCard = $this->currCard;

            if ($this->roundOver($i)) $i = -1;

            if ($this->deckOver()) exit;
        }
    }

}