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
    public $gameDetails = [];
    public $blackjackRounds = [];

    public function __construct()
    {
        $this->players["Player"]["bank"] = 1000;
        $this->deck = $this->create_random_deck();
        $this->gameDetails["BalanceHalf"] = 'NA';
    }

    public function game_logic ()
    {
        //main game logic - continue player rounds as long as player has money and cards are still left
        while($this->players["Player"]["bank"] > 0 && count($this->deck) > 0)
        {
            if(count($this->deck) <=3)
            {
                $this->update_winner("Player");
                break;
            }else{
                $this->play_round();

                if($this->players["Player"]["bank"] <= 0)
                {
                    $this->update_winner("Dealer");
                }elseif (count($this->deck) == 0)
                {
                    $this->update_winner("Player");
                }
            }

        }
    }

    private function update_winner($winner){
        $this->gameDetails["GameWinner"] = $winner;
        $this->gameDetails["GamesPlayed"] = count($this->rounds);
        $this->gameDetails["HandsBlackjack"] = count($this->blackjackRounds);
    }

    private function create_random_deck (){
        $suits = array ("clubs", "diamonds", "hearts", "spades");
        $faces = array (
            "Ace" => 1, "2" => 2,"3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7,
            "8" => 8, "9" => 9, "10" => 10, "Jack" => 10, "Queen" => 10, "King" => 10);
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
        // step loop to get the first key=>value from the deck array and immediately break
        foreach ($this->deck as $key => $value)
        {
            $card[$key] = $value;
            break;
        }
        array_shift($this->deck); //remove the first element from the deck array

        return $card;
    }
    public function deal_hands()
    {
        if(count($this->deck) >= 4)
        {
            $round = [];
            for($i=0;$i<2;$i++){

                foreach($this->deal_card() as $key => $value)
                {
                    $round["Player"][$key] = $value;
                }
                foreach ($this->deal_card() as $key=> $value)
                {
                    $round["Dealer"][$key] = $value;
                }

            }
            return $round;
        }else
        {
            return false;
        }

    }

    public function play_round()
    {

        $round = $this->deal_hands();

//        if($round)
//        {
            $playerValues = [];
            $dealerValues = [];
            foreach ($round["Player"] as $card => $value)
            {
                $playerValues[] = $value;
            }
            foreach ($round["Dealer"] as $card => $value)
            {
                $dealerValues[] = $value;
            }
            $playerSum = array_sum($playerValues);
            $dealerSum = array_sum($dealerValues);
            while($playerSum <= $dealerSum)
            {
                //deal a card to player
                $newCard = $this->deal_card();
                //continue if we get a card back from deck
                if($newCard)
                {
                    $playerValues[] = reset($newCard);
                    foreach($newCard as $key => $value)
                    {
                        $round["Player"][$key] = $value;
                    }
                    $playerSum = array_sum($playerValues);

                    //check if player or dealer went over
                    if($playerSum >= 21){

                        $round["Winner"] = "dealer";
                        $this->players["Player"]["bank"] -= 100;
                        break;
                    }else if($playerSum > $dealerSum)
                    {
                        break;
                    }
                }else{ //if no card comes back - dealer is round winner
                    $round["Winner"] = "dealer";
                    $this->players["Player"]["bank"] -= 100;
                    break;
                }



            }
            while($dealerSum < $playerSum && $round["Winner"] != "dealer")
            {
                //deal a card to dealer
                $newCard = $this->deal_card();
                $dealerValues[] = reset($newCard);
                foreach($newCard as $key => $value)
                {
                    $round["Dealer"][$key] = $value;
                }
                $dealerSum = array_sum($dealerValues);
                //check if player or dealer went over
                if($dealerSum > 21){
                    $round["Winner"] = "player";
                    $this->players["Player"]["bank"] += 200;
                    break;
                }else
                {
                    $round["Winner"] = "dealer";
                    $this->players["Player"]["bank"] -= 100;
                }
            }

            $round["BankBalance"] = $this->players["Player"]["bank"]; //update player balance after round is over
            $roundIndex = count($this->rounds);
            if($this->players["Player"]["bank"] == 500)
            {
                $this->gameDetails["BalanceHalf"] = "Round " . ($roundIndex + 1);
            }
            if($playerSum == 21)
            {
                $this->blackjackRounds[] = "Round " . ($roundIndex + 1); //if blackjack - push into global array
            }
            $this->rounds["Round " . ($roundIndex + 1)] = $round; //store the round into global rounds array
        //}

    }


}

$game = new Blackjack();
$game->game_logic();

print_r($game->gameDetails);
