<?php

require('../../lib/tumblr/client.php');

$consumerKey="vZTileX2WXiuYD7264NquyeMk1aRhJ62jgksnKoM95ZrYE4jlQ";
$secretKey="aa0MmgepgObZe7neeLnw7pGtrkKiZt6FaCu0a03X5P2juiALpr";

//$client = new Tumblr\API\Client($consumerKey, $consumerSecret);

//$client->setToken($token, $tokenSecret);

// Authenticate via OAuth
$client = new Client($consumerKey,$secretKey,'O3GUEXPDfVmIRWCV7q0TDvgaaBwEqHjq6Y60jkXByyXiCanHsZ','Y0NEG6rCwaeR8cFXcdd5Nlg4GBK9yTgGzPcUhNPpVJqc1Iqo0U');
$arrMessage = array(
              'type' => 'regular', 
              'title' => 'Testing ', 
              'body' => 'Details', 
              'format' =>'html'
              );

// Make the request
//createPost($blogName, $data)
$client->createPost('milongabenews.tumblr.com', $arrMessage);

?>