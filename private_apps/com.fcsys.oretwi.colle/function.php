<?php
require_once 'config.php';

// Get Myself Timeline
function getTimeline($access_token, $access_token_secret, $count) {
	$options = array(
		'count' => $count
	);
	return getTwitter($access_token, $access_token_secret, 'GET', 'home_timeline', $options);
}

// Get Follower List
function getFollower($access_token, $access_token_secret, $count) {
	$options = array(
		'count' => $count
	);
	return getTwitter($access_token, $access_token_secret, 'GET', 'followers_list', $options);
}

// Search Tweet
function getSearch($access_token, $access_token_secret, $keyword, $count) {
	$options = array (
		'q' => $keyword, 
		'count' => $count
	);
	return getTwitter($access_token, $access_token_secret, 'GET', 'search_tweet', $options);
}

// Post new Tweet
function postTweet($access_token, $access_token_secret, $message) {
	$options = array (
		'status' => $message
	);
	return getTwitter($access_token, $access_token_secret, 'POST', 'statuses_update', $options);
}

// Retweet
function postRetweet($access_token, $access_token_secret, $tweetid) {
	$options = array (
		'id' => $tweetid
	);
	return getTwitter($access_token, $access_token_secret, 'POST', 'statuses_retweet', $options);
}

// Favorite
function postFavorite($access_token, $access_token_secret, $tweetid) {
	$options = array (
		'id' => $tweetid
	);
	return getTwitter($access_token, $access_token_secret, 'POST', 'favorites_create', $options);
}

// Follow
function postFollow($access_token, $access_token_secret, $userid) {
	$options = array (
		'user_id' => $userid,
		'follow' => 'true'
	);
	return getTwitter($access_token, $access_token_secret, 'POST', 'friendships_create', $options);
}


//print_r(getTimeline($access_token, $access_token_secret, 20));
//print_r(getSearch($access_token, $access_token_secret, 'テイルレッド', 20));
//print_r(postTweet($access_token, $access_token_secret, 'テストツイート'));
//print_r(postRetweet($access_token, $access_token_secret, '549952057830936576'));
//print_r(postFollow($access_token, $access_token_secret, '598539444'));
//print_r(getFollower($access_token, $access_token_secret, 5));
?>