<?php
/**
 * Created by PhpStorm.
 * User: asipe
 * Date: 9/10/17
 * Time: 2:00 PM
 */

//MEDIUM:
//Let’s bring in the deck code from the past example (your normal challenge).
//Create a function that will create a deck of cards, randomize it and then return the deck.
//We will now create a function to deal these cards to each user. Modify this function so that it returns the number of cards specified for the user. Also, it must modify the deck so that those cards are no longer available to be distributed.
//

/**
 * @return array
 */
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

//print_r(create_random_deck());
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
print_r(deal_cards(2));