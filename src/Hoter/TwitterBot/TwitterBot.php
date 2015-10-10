<?php

namespace Hoter\TwitterBot;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterBot {
  private $connection;

  public function __construct($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret) {
    $this->connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
  }

  public function retweet($since = -1, $count = 1) {
   if ($since === -1) {
     $since = $this->findLastTweet();
   }

   
  }

  public function findLastTweet() {
    $message = $this->connection->get("statuses/user_timeline", array('count' => 1));
    print_r($message);
  }
}
