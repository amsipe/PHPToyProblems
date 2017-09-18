<?php
/**
 * Created by PhpStorm.
 * User: asipe
 * Date: 9/10/17
 * Time: 1:11 PM
 */

//NORMAL:
//Use two foreach loops to create a master array of all 52 cards in the array $deck, each represented as a key value pair in the format ‘face of suit’, use the print_r function to print out the contents of the $deck to make sure it is correct.
//EX: “King of Spades” should be one of the elements of the array and it should have a value of 13.

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

print_r($deck);