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
       //gets both text fields from html file
       
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
$getfield = '?q='. $q.'&result_type=mixed&count=100';
$requestMethod = 'GET';

// creates a new TwitterAPIExchange object with the authetication data and calls the function that gets the results form twitter
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
$tweets = json_decode($response)->statuses;
$objects=tweets2array($tweets);
//creates a new database table
$database = new Database('twitter',"$keyword");
//inserts tweets into the table
$database->insertTweets($objects,"$keyword");
 
//makes the sencond keyword compatible with the url and 

$keywords2 = explode(" ",$keyword2);
$query2 = implode($plus,$keywords2);
$q2 = str_replace('','%3A',$query2);


//sets the url and the request method
$getfield = '?q='. $q2.'&result_type=mixed&count=100';


// creates a new TwitterAPIExchange object with the authetication data and calls the function that gets the results form twitter
$twitter2 = new TwitterAPIExchange($settings);
$response2 = $twitter2->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
$tweets2 = json_decode($response2)->statuses;
$objects2=tweets2array($tweets2);
//creates new table for secind keyword
$database2 = new Database('twitter',"$keyword2");
//insert tweets into table
$database2->insertTweets($objects2,"$keyword2");

//calls file the prints result.
include ('../View/view.php');
//closes database connection
$database->close();
