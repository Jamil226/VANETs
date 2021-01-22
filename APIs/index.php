<?php
	include("lib/DatabaseHelper.php");
// echo rand() . "\n";
// echo rand() . "\n";

// echo rand(5, 15);

$string = 'ABCDEFG';
 
//Get the length of the string.
$stringLength = strlen($string);
 
//Generate a random index based on the string in question.
$randomIndex = mt_rand(0, $stringLength - 1);
 
//Print out the random character.
echo $string[$randomIndex];
?>