<?php
require_once 'function.php';

// Check all the follower list
echo "Listing all the followers and refollowing ...\n";
$followers = getFollower($access_token, $access_token_secret, $follower_count);
// Follow new followers
if($follower_count != 0) {
    foreach($followers["users"] as $key => $value) {
		if($value["lang"] == $follower_lang || 'all' == $follower_lang) {
			echo "Following [".$value["name"]."] ...\n";
			postFollow($access_token, $access_token_secret, $value["id_str"]);
		}
    }
} else {
    echo "Skipped.\n";
}
echo "\n\n";


// reTweet
echo "Retweeting tweets from twitter ...\n";
$result = getSearch($access_token, $access_token_secret, $search_keyword, $retweet_count);
// ReTweet tweets from result
foreach($result["statuses"] as $key => $value) {
	$user = (object)$value["user"];
	echo "Retweeting tweet from [".$user->name."] ...\n";
	postRetweet($access_token, $access_token_secret, $value["id_str"]);
	echo "Following [".$user->name."] ...\n";
	postFollow($access_token, $access_token_secret, $user->id_str);
}
echo "\n\n";

// favTweet
echo "Favoriting tweets from twitter ...\n";
$result = getSearch($access_token, $access_token_secret, $search_keyword, $favorite_count);
// Favorite tweets from result
foreach($result["statuses"] as $key => $value) {
	$user = (object)$value["user"];
	echo "Favoriting tweet from [".$user->name."] ...\n";
	postFavorite($access_token, $access_token_secret, $value["id_str"]);
}
echo "\n\n";
?>
