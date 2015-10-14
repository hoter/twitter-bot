<?php

namespace Aytpaev\TwitterBot;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterBot {
  private $connection;

  public function __construct($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret) {
    $this->connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
  }

  public function retweetByHashTag($hashtag, $since = -1, $count = 1) {
   if ($since < 0) {
     $since = $this->findLastTweet();
   }

   $tweets = $this->connection->get("search/tweets", array('q' => '#' . $hashtag, 'result_type' => 'mixed', 'since_id' => $since + 1, 'count' => $count));
   if (!empty($tweets->statuses)) {
     foreach ($tweets->statuses as $tweet) {
       $this->connection->post("statuses/retweet/" . $tweet->id);
     }

     return TRUE;
   }

   return FALSE;
  }

  public function favoriteByHashTag($hashtag, $since = -1, $count = 1) {
   if ($since < 0) {
     $since = $this->findLastTweet();
   }

   $tweets = $this->connection->get("search/tweets", array('q' => '#' . $hashtag, 'result_type' => 'mixed', 'since_id' => $since + 1, 'count' => $count));
   if (!empty($tweets->statuses)) {
     foreach ($tweets->statuses as $tweet) {
       print_r($this->connection->post("favorites/create", array('id' => $tweet->id)));
     }

     return TRUE;
   }

   return FALSE;
  }

  protected function findLastTweet() {
    $messages = $this->connection->get("statuses/user_timeline", array('count' => 1));
    if ($messages) {
      $message = reset($messages);
      return $message->id;
    }
  }
}
