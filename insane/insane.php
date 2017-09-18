<?php
/**
 * Created by PhpStorm.
 * User: asipe
 * Date: 9/15/17
 * Time: 9:45 PM
 */
//
//INSANE CHALLENGE:
//Create a game of Blackjack.
//Rules:
//1. At any given time, there will only be two players. The dealer and player one.
//2. 4 cards will be dealt out each round, 2 to the dealer and 2 to the player.
//3. If the amount in the player’s hand is less than or equal to the amount in the dealer’s hand, you must draw a card.
//4. If the player draws a card and the amount they have goes over 21, the dealer has won that round.
//5. If the player ever reaches an amount greater than the dealer’s, they should stay then it will be the dealer’s turn.
//6. The dealer must draw until he reaches an amount greater than the player’s or until he loses.
//7. Subtract $100 from the player’s bank every time they lose
//8. Add $200 to the player’s bank every time they win
//9. Player starts with $1000 in the bank account
//10. Aces can either be an 11 or 1
//The game will continue as long as there are enough cards in the deck OR the player runs out of money.
//Output:
//1. How many games were played?
//    2. Who won the game?
//    3. Which round did the player’s bank reach half way?
//    4. How many times did the player get blackjack?
//
//    EXTRA CREDIT:
//Create a function called countCards and enable it for the player, NOT the dealer. This function must analyze the deck and determine if the player should draw again even if the amount in his hand is greater than the dealer.
//EX: If the dealer has a sum of 9 on the table, you might have two 6’s (12 total). Player should draw again because it is more likely the dealer can beat your 12.
//

class Blackjack {
    public $players = [];
    public $deck;
    public $rounds = [];
    public function __construct()
    {
        $this->players["Player"]["bank"] = 1000;
        $this->players["Dealer"]["bank"] = 1000;
        $this->deck = $this->create_random_deck();
    }

    private function create_random_deck (){
        $suits = array ("clubs", "diamonds", "hearts", "spades");
        $faces = array (
            "Ace" => 1, "2" => 2,"3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7,
            "8" => 8, "9" => 9, "10" => 10, "Jack" => 11, "Queen" => 12, "King" => 13);
        $deck = array();
        foreach ($faces as $face=>$value){
            foreach ($suits as $suit){
                $deck["$face of $suit"] = $value;
            }
        }
        $randKeys = array_keys($deck);
        shuffle($randKeys);
        $newDeck = [];
        foreach($randKeys as $key){
            $newDeck[$key] = $deck[$key];
        }
        return $newDeck;
    }

    public function deal_card()
    {
        $card = [];
        foreach ($this->deck as $key => $value)
        {
            $card[$key] = $value;
            break;
        }
        array_shift($this->deck);
        return $card;
    }
    public function deal_hands()
    {
        $round = [];
        for($i=1;$i<=2;$i++){
            $round["Player"][] = $this->deal_card();
            $round["Dealer"][] = $this->deal_card();

        }
        return $round;
    }

    public function play_round()
    {
        $round = $this->deal_hands();
        $playerValues = [];
        foreach ($round["Player"] as $card => $value)
        {
            $playerValues[] = array_values(array_values($value));
        }
        $playerSum = array_sum($playerValues);
        print_r($playerValues);
        return $round;
    }


}

$game = new Blackjack();
//print_r($game->deal_card());
print_r($game->play_round());
//print_r($game->rounds);