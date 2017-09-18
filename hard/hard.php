<?php
/**
 * Created by PhpStorm.
 * User: asipe
 * Date: 9/10/17
 * Time: 3:02 PM
 */

//HARD:
//Bring in your createDeck and dealCards function from the previous challenges. For the specified number of players below, assign each player an even set of cards.
//We will do this by counting out how many players there are, counting how many cards are in the deck and then dividing them so we know how many cards each player should get.
//
//  $deck =
//  $num_players = 4;
//  $num_cards_in_deck = //find a function to count the # of elements in an array
//  $num_cards_to_give_each_player =
//
//Use a for loop to add the "dealt hands" to the $players array
//Let’s create a simple game. Each player will play a card and whoever has the highest value wins. If there are 2 cards played that have the same value, everyone loses and that round is a draw. Store the results of each game and also who won that round as the value.
//If the round is a draw, store the value as DRAW. Use a loop to play each game until all opponents are out of cards. Print out the array of all the rounds. If there was a draw, the round should say DRAW.
//If a player has won, it should displayer “Player X” where X is the index of the player.

function create_random_deck (){
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

function deal_cards ($count){

    if (is_int($count)){
        $shuffledDeck = create_random_deck();
        $handKeys = array_rand($shuffledDeck,$count);
        $hand =[];
        foreach($handKeys as $key=>$card){
            $hand[$card] = $shuffledDeck[$card];
        }
        foreach ($hand as $card=>$value){

            unset($shuffledDeck[$card]);
        }
        return $hand;
    }
}
$newDeck = create_random_deck();
$num_players = 4;
$num_cards = count($newDeck);
$num_cards_player = (int)floor($num_cards/$num_players);

$game = [];
$players = [];
for ($i=0; $i<$num_players;$i++){
    $players[$i] = deal_cards($num_cards_player);
}


for($i=0; $i<$num_cards_player; $i++){
    $round = [];
    foreach($players as $player=>$hand){
        $hand = array_values($hand);
        $round[] = $hand[$i];
    }

    if(count($round) != count(array_unique($round))){
        $game["Round ".$i] = "Draw";
    }else {
        $game["Round ".$i] = "Player ".
            (array_search(max($round),$round)+1);
    }
}
print_r($players);
print_r($game);


