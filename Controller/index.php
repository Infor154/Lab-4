<?php

/*<!--===============================================
   Name   : index.php
   Purpose: Authenticates,creates database and insert tweets into database
   Author : Omotola and Shaun
 ================================================-->*/
// requires library 
       require_once('../twitter-api-php-master/TwitterAPIExchange.php');
   //includes necessary files     
include '../Model/functions.php';
include('../Model/database.php');
       //sets authentication data
       $settings = array(
   'oauth_access_token' => "259392968-UU5tUvlpCijzwp8Q9xea7jXegvAEozvsbKx44nl6",
    'oauth_access_token_secret' => "xbgVKObz9NZr6Pzlmqu8pEZh3C1yI3VCmmqs22QadRLmp",
    'consumer_key' => "5Mxg8hTW6bXmi7AXlbmBIXHg1",
    'consumer_secret' => "HevfmignG9EksUAg5IqSvVKdzBBoB4LTA1FBn7lnTsmXcn5ECx"
);
       //gets text field from html file
       
$keyword = $_POST['keyword'];
$keyword2 = $_POST['keyword2'];

echo "<h2> CORRELATION BETWEEN  <br/> keyword 1 : ".$keyword." <br/> keyword 2 : ". $keyword2;
//makes the keyword compatible with the url
$plus = '%20';
$keywords = explode(" ",$keyword);
$query = implode($plus,$keywords);
$q = str_replace('','%3A',$query);


//sets the url and the request method
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q='. $q;
$requestMethod = 'GET';

// creates a new TwitterAPIExchange object with the authetication data and calls the function that gets the results form twitter
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
$tweets = json_decode($response)->statuses;
$objects=tweets2array($tweets);
echo '<br/> <br/> Total tweets '.count($objects);
//prints out the query string, and url
//echo'<h3>'.$query.'</h3>';
//echo'<h3>URL for the Query</h3>';
////echo'<a href='.$url.'>' .$url.'</a>';
//echo'<a href='.$url.'?q='.$query.'>' .$url.'?q='.$query.'</a>';
//echo'<hr>';
$database = new Database('twitter',"$keyword");
$database->insertTweets($objects,"$keyword");
 
//makes the keyword compatible with the url

$keywords2 = explode(" ",$keyword2);
$query2 = implode($plus,$keywords2);
$q2 = str_replace('','%3A',$query2);


//sets the url and the request method
$getfield = '?q='. $q2;


// creates a new TwitterAPIExchange object with the authetication data and calls the function that gets the results form twitter
$twitter2 = new TwitterAPIExchange($settings);
$response2 = $twitter2->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
//prints out the results in json format
$tweets2 = json_decode($response2)->statuses;
$objects2=tweets2array($tweets2);
echo '<br/> <br/> Total tweets '.count($objects2);

$database2 = new Database('twitter',"$keyword2");

$database2->insertTweets($objects2,"$keyword2");
$database2->relationships($keyword,$keyword2);
//include ('../View/view.php');

$database->close();
