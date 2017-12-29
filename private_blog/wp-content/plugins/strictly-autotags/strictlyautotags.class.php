<?php

/**
 * Plugin Name: Strictly Auto Tags
 * Version: 3.0.2
 * Plugin URI: http://www.strictly-software.com/plugins/strictly-auto-tags/
 * Description: This plugin automatically detects tags to place against posts using existing tags as well as a simple formula that detects common tag formats such as Acronyms, names and countries. Whereas other smart tag plugins only detect a single occurance of a tag within a post this plugin will search for the most used tags within the content so that only the most relevant tags get added.
 * Author: Rob Reid
 * Author URI: http://www.strictly-software.com 
 * Text Domain: strictly-autotags
 * =======================================================================
 */

/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/

require_once(dirname(__FILE__) . "/strictlyautotagfuncs.php");

class StrictlyAutoTags{

	/**
	* The kind of version this is
	*
	* @access protected
	* @var string
	*/
	protected $version_type = "FREE";

	/**
	* current free version of plugin 
	*
	* @access protected
	* @var string
	*/
	protected $free_version = "3.0.2";

	/**
	* latest paid for version
	*
	* @access protected
	* @var string
	*/
	protected $paid_version = "3.0.3";

	/**
	* whether or not to remove all the saved options on uninstallation
	*
	* @access protected
	* @var bool
	*/
	protected $uninstall;

   /**
	* look for new tags by searching for Acronyms and names 
	*
	* @access protected
	* @var bool
	*/
	protected $autodiscover; 

   /**
	* treat tags found in the post title as important and automatically add them to the post
	*
	* @access protected
	* @var bool
	*/
	protected $ranktitle; 

	/**
	* treat tags found in certain html tags such as headers or links as important and increase their ranking
	*
	* @access protected
	* @var bool
	*/
	protected $rankhtml; 

   /**
	* The maxiumum number of tags to add to a post
	*
	* @access protected
	* @var integer
	*/
	protected $maxtags; 

	/**
	* The percentage of content that is allowed to be capitalised when auto discovering new tags
	*
	* @access protected
	* @var integer
	*/
	protected $ignorepercentage;

	/**
	* The list of case sensitive noise words to use
	*
	* @access protected
	* @var string
	*/
	protected $noisewords;

	/**
	* The list of case sensitive noise words to use
	*
	* @access protected
	* @var string
	*/
	protected $noisewords_case_sensitive;


	/**
	* This setting determines how nested tags are handled e.g New York, New York City, New York City Fire Department all contain "New York"
	* AUTOTAG_BOTH = all 3 terms will be tagged 
	* AUTOTAG_SHORT= the shortest version "New York" will be tagged and the others dicarded
	* AUTOTAG_LONG = the longest version "New York City Fire Department" will be tagged and the others dicarded
	*/
	protected $nestedtags;


	/**
	* The default list of case insensitive noise words to use
	*
	* @access protected
	* @var string
	*/
	protected $defaultnoisewords = "about|after|a|all|also|an|and|another|any|are|as|at|be|because|been|before|being|between|both|but|by|came|can|come|could|did|do|does|each|even|for|from|further|furthermore|get|gets|got|had|has|have|he|her|here|hi|him|himself|how|hows|however|i|if|in|indeed|into|is|its|just|like|made|many|may|me|might|more|moreover|most|much|must|my|never|no|not|now|of|on|only|or|other|our|out|over|put|puts|says|said|same|see|she|should|since|some|still|such|take|than|that|the|their|them|then|there|theres|therefore|these|they|this|those|through|thus|to|too|under|up|very|was|way|we|well|were|what|when|where|which|while|will|why|with|would|you|your"; 


	/**
	* The default list of case sensitive noise words to use
	*
	* @access protected
	* @var string
	*/
	protected $defaultnoisewords_case_sensitive = "it|who"; 

	/**
	* Holds a regular expression for checking whether a word is a noise word or phrase
	*
	* @access protected
	* @var string
	*/
	protected $isnoisewordregex_case_sensitive;

	/**
	* Holds a regular expression for checking whether a word is a case sensitive noise word or phrase
	*
	* @access protected
	* @var string
	*/
	protected $isnoisewordregex;

	/**
	* Holds a regular expression for removing noise words from a string of words
	*
	* @access protected
	* @var string
	*/
	protected $removenoisewordsregex;

	/**
	* Holds a regular expression for removing case sensitive noise words from a string of words
	*
	* @access protected
	* @var string
	*/
	protected $removenoisewordsregex_case_sensitive;

	/**
	* Max no of words to contain in each tag
	*
	* @access protected
	* @var int
	*/
	protected $maxtagwords;


	/**
	* Whether or not to bold the tagged words
	*
	* @access protected
	* @var bool
	*/
	protected $boldtaggedwords;


	/**
	* Whether or not to deeplink tags found in the article by linking them to the relevant tag pages
	*
	* @access protected
	* @var bool
	*/
	protected $taglinks;

	/**
	* Min no of posts a tag must have against it to deeplink it within the post if enabled
	*
	* @access protected
	* @var int
	*/
	protected $minpoststotaglink;

	/**
	* Max no of tags in a post to link
	*
	* @access protected
	* @var int
	*/
	protected $maxtagstolink;

	/**
	* The array holding all tags that have already have the specified amount of tags for deeplinking
	*
	* @access protected
	* @var int
	*/
	protected $deeplinkarray;

	/**
	* The title for any deeplinks including the placeholder for the tag
	*
	* @access protected
	* @var int
	*/
	protected $deeplinktitle;


	/**
	* Whether the post we are looking at has had tags added to it manually already and if any have been bolded/linked
	*
	* @access protected
	* @var bool
	*
	*/
	protected $already_strictly_tagged_and_linked;

	/**
	* Whether we should always remove any deeplinks or bolded tags when re-saving so that removed tags are de-linked and de-bolded and we re-do it
	*
	* @access protected
	* @var bool
	*
	*/
	protected $remove_strictly_tags_and_links;


	/**
	* Whether we should not bother AutoTagging any posts that already have tags
	*
	* @access protected
	* @var bool
	*
	*/
	protected $skip_tagged_posts;
	
	/**
	* Array of stored titles, src, alt, href that would cause issues with a nested link/bold tag inside it
	*
	* @access protected
	* @var array
	*/
	protected $storage;

	public function __construct(){

		ShowDebugAutoTag("IN StrictlyAutoTag INIT");

		// add/remove any new options for users upgrading the plugin who didn't de-activate/activate to install it e.g FTP only
		StrictlyAutoTagControl::UpgradedOptions();		

		// set up values for config options e.g autodiscover, ranktitle, maxtags
		$this->GetOptions();

		ShowDebugAutoTag("Got Options");


		// create some regular expressions required by the parser

		// case insensitive noise noise word regex
		
		// create regex to identify a noise word
		$this->isnoisewordregex							= "/^(?:" . str_replace("\|","|",preg_quote($this->noisewords,"/")) . ")$/i";

		// create regex to replace all noise words in a string
		$this->removenoisewordsregex					= "/\b(" . str_replace("\|","|",preg_quote($this->noisewords,"/")) . ")\b/i";

		// now for case sensitive noise word regex

		// create regex to identify a noise word
		$this->isnoisewordregex_case_sensitive			= "/^(?:" . str_replace("\|","|",preg_quote($this->noisewords_case_sensitive,"/")) . ")$/";

		// create regex to replace all noise words in a string
		$this->removenoisewordsregex_case_sensitive		= "/\b(" . str_replace("\|","|",preg_quote($this->noisewords_case_sensitive,"/")) . ")\b/";

		// load any language specific text
		load_textdomain('strictly-autotags'	, dirname(__FILE__).'/language/'.get_locale().'.mo');

		// add options to admin menu
		add_action('admin_menu'				, array(&$this, 'RegisterAdminPage'));
		
		ShowDebugAutoTag("Set a SavePost for the next article");

		// set a function to run whenever posts are saved that will call our AutoTag function
		add_action('save_post'				, array($this, 'SaveAutoTags'),1);
		//add_action('publish_post'			, array(&$this, 'PublishedArticle'),2);
		//add_action('post_syndicated_item'	, array(&$this, 'SaveAutoTags'),1);

		//ShowDebugAutoTag("END OF StrictlyAutoTag INIT");
	}
	
	

	/**
	 * Check post content for auto tags
	 *
	 * @param integer $post_id
	 * @param array $post_data
	 * @return boolean
	 */
	public function SaveAutoTags( $post_id = null, $post_data = null ) {
	
		set_time_limit(0);


		ShowDebugAutoTag("IN SaveAutoTags post id = " . $post_id);
		
		global $wpdb;
		

		$object = get_post($post_id);
		if ( $object == false || $object == null ) {
			return false;
		}


		// store orig content in-case we end up with blank articles for some reason - maybe reformatting removes the content etc
		// if that happens just revert to original content
		$orig_content = $object->post_content;

		ShowDebugAutoTag("Length of original content is " . strlen($orig_content));

		// if we skip posts with tags already then leave now
		if ( get_the_tags($object->ID) != false) {

			ShowDebugAutoTag("this post has tags already do we skip it skip_tagged_posts = " . intval($this->skip_tagged_posts));

			if($this->skip_tagged_posts){

				ShowDebugAutoTag("We ignore posts already with tags");

				ShowDebugAutoTag("fire actions on finished_doing_tagging with post ID of " . $object->ID);

				// fire in case tweetbot needs to tweet
				do_action('finished_doing_tagging', $object->ID);

				return false;
			}

		}

		
		// have we already got tags against this post and if so do they contain strictly links and bold tags
		
		// default content
		$newcontent = $object->post_content;

		ShowDebugAutoTag("Do we need to clean any Strictly Goodness?");

		$newcontent = $this->CheckAndCleanTags( $newcontent );

		ShowDebugAutoTag("do we deeplink = " . intval($this->taglinks));

		// if we are deep linking we only deep link on existing tags with the appropriate count
		if($this->taglinks){

			ShowDebugAutoTag("We are deep linking for tags that already have " . $this->minpoststotaglink . " posts associaed with them");

			$sql = $wpdb->prepare("SELECT	name,slug
									FROM	{$wpdb->terms} AS a
									JOIN	{$wpdb->term_taxonomy} AS c ON a.term_id = c.term_id				
									WHERE (
											c.taxonomy = 'post_tag'											
											AND  c.count >= %d
										);",$this->minpoststotaglink);
			

			ShowDebugAutoTag($sql);

			$this->deeplinkarray = $wpdb->get_results($sql);	

			
			ShowDebugAutoTag("there are " . count($this->deeplinkarray) . " tags with " .$this->minpoststotaglink . " or more posts against them");

		}
		

		ShowDebugAutoTag("now auto tag");

		// get the relevant tags for the post
		$posttags = $this->AutoTag( $object );

		
		// Append tags if tags to add
		if ( count($posttags) > 0) {


			ShowDebugAutoTag("do we bold auto tags? == " . $this->boldtaggedwords);
			
			ShowDebugAutoTag($posttags);

			if ( count($posttags) > 0) {

				ShowDebugAutoTag("do we bold tags? == " . intval($this->boldtaggedwords) . " or auto link tags = " . intval($this->taglinks));
				
				ShowDebugAutoTag($posttags);

				if($this->boldtaggedwords || $this->taglinks){


					// store href/alt/src/title attributes that would cause issues with nested tags
					$newcontent = $this->StoreContent($newcontent, "STORE");

					ShowDebugAutoTag("call bold or deeplink tags");

					if($this->boldtaggedwords){
						// help SEO by bolding our tags

						ShowDebugAutoTag("lets auto bold tags");

						$newcontent = $this->AutoBold($newcontent,$posttags);
					}
					
					ShowDebugAutoTag("auto link tags = " . intval($this->taglinks));
				
					
					if($this->taglinks){
						
						ShowDebugAutoTag("lets auto link");

						// help SEO by deeplinking our tags
						$newcontent = $this->AutoLink($newcontent,$posttags);

						ShowDebugAutoTag("after auto link content = $newcontent");
					}

					ShowDebugAutoTag("put stored content back in");

					$newcontent = $this->StoreContent($newcontent, "RETURN");

					ShowDebugAutoTag("our new content is === " . $newcontent);

					// ensure new content is at least 50 chars long otherwise we dont update it 
					if(empty($newcontent) || strlen($newcontent) < 50)
					{
						// don't update the content as something has happened to it!
						ShowDebugAutoTag("Dont update the content as its now a length of " . strlen($newcontent) . " whereas the original content was " . strlen($orig_content) . " characters long");
					}
					else
					{
						$sql = $wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = %s WHERE id = %d;", $newcontent,$object->ID);

						ShowDebugAutoTag("SQL is $sql");


						$r = $wpdb->query($sql);
						
						ShowDebugAutoTag("should have been updated rows = " . $r);
					}
				

				}
			}

			// Add tags to posts
			wp_set_object_terms( $object->ID, $posttags, 'post_tag', true );

			ShowDebugAutoTag("after set object terms");
			
			// Clean cache
			if ( 'page' == $object->post_type ) {
				clean_page_cache($object->ID);
			} else {
				clean_post_cache($object->ID);
			}			
		}

		ShowDebugAutoTag("fire actions on finished_doing_tagging with post ID of " . $object->ID);

		// fire in case tweetbot needs to tweet
		do_action('finished_doing_tagging', $object->ID);

		ShowDebugAutoTag("END OF AUTOTAG HOOK");

		return true;
	}

	/** Checks for existing bolded or linked tags and remove them if settings say so
	*
	* @param string $content;
	* @returns string;
	*/
	protected function CheckAndCleanTags($content){
		
		set_time_limit(0);


		ShowDebugAutoTag("IN CheckAndCleanTags");

		$newcontent = $content;

		ShowDebugAutoTag("we have " . strlen($newcontent) . " of content");


		if(preg_match("@<(strong|a) class=['\"]StrictlyAutoTag@i",$content)){			
				
			ShowDebugAutoTag("The content has signs of Strictly sprinkled in it do we remove = " . intval($this->remove_strictly_tags_and_links));

			// if we re-bold/re-link the article even if tags have been added manually then remove our ones first
			if($this->remove_strictly_tags_and_links)
			{

				ShowDebugAutoTag("Content does have StrictlyAutoTag classes on strong or A tags");

				// remove it all so we can link any new tags that have been added as well
				$newcontent = $this->RemoveBoldAndLinks($newcontent);

				// so we can re-tag it, re-bold and re-link it al
				$this->already_strictly_tagged_and_linked = false;
			}
			else
			{
				ShowDebugAutoTag("This content has Strictly Auto Tags/Links and we keep them there");

				$this->already_strictly_tagged_and_linked = true;
			}
		}else{

			ShowDebugAutoTag("no tags saved against post");

			// so we can re-tag it, re-bold and re-link it all
			$this->already_strictly_tagged_and_linked = false;
			
		}

		ShowDebugAutoTag("return " . strlen($newcontent) . " of content");

		return $newcontent;
	}

	/** Removes any existing bold or linked tags
	*
	* @param string $content;
	* @returns string 
	*/
	protected function RemoveBoldAndLinks($content){

		ShowDebugAutoTag("IN RemoveBoldAndLinks");

		// as we now put classes on the tags its easier to find and replace
		set_time_limit(200);

		ShowDebugAutoTag("b4 replace len is " . strlen($content));
		
		// match single AND double quotes as I switch bold for links sometimes
		$content = preg_replace("@(<strong class=[\"']StrictlyAutoTagBold[\"']>)([\s\S]+?)(</strong>)@","$2",$content);

		ShowDebugAutoTag("after first replace len is " . strlen($content));

		$content = preg_replace("@(<a class=\"StrictlyAutoTagAnchor\"[^>]+?>)([\s\S]+?)(</a>)@","$2",$content);

		ShowDebugAutoTag("after 2nd replace len is " . strlen($content));

		return $content;

	}


	/** Reformats the main article by highlighting the tagged words
	*
	* @param string $content;
	* @returns string 
	*/
	protected function AutoBold($content,$tags){

		set_time_limit(200);

		ShowDebugAutoTag("IN AutoBold $content we have " . count($tags) . " to bold");

		ShowDebugAutoTag($tags);

		if(!empty($content) && is_array($tags) && count($tags)>0){

			ShowDebugAutoTag("lets loop through our post tags");

			
			//loop and bold unless they are already inside a bold tag
			foreach($tags as $tag){

				

				// instead of doing negative lookaheads and entering a world of doom match and then clean	
				// easier to do a positive match than a negative especially with nested matches
				// might want to tag words with dots in e.g msnbc.com
				$regex = "@\b(" . preg_quote($tag) . ")(\s|\.(?:\s|<\/)|$)@";

				ShowDebugAutoTag("regex is $regex");

				// wrap tags in strong and keep the formatting e.g dont upper case if the tag is lowercase as it might be inside
				// an href or src which might screw it up
				$content = preg_replace($regex,"<strong class='StrictlyAutoTagBold'>$1</strong>$2",$content);
			

			}
			
		}

		

		ShowDebugAutoTag("look at how it would appear");
		

		ShowDebugAutoTag("BOLDED RETURNS $content");

		return $content;

	}

	

	/** Reformats the main article by highlighting the tagged words in <A> tags to deeplink to the relevant tag page
	*
	* @param string $content;
	* @returns string 
	*/
	protected function AutoLink($content,$tags){

		ShowDebugAutoTag("IN AutoLink");

		global $wp_rewrite;

	
		ShowDebugAutoTag("look at deeplink array");

		ShowDebugAutoTag($this->deeplinkarray);

		set_time_limit(0);

		$no =  count($this->deeplinkarray);

		ShowDebugAutoTag("IN AutoLink $content we have " .  $no . " to deeplink");

		if(!empty($content) && is_array($this->deeplinkarray) && $no>0){

			ShowDebugAutoTag("lets loop through our deep linked tags");

			// get tag permalink structure and remove trailing slash so it can be added on correcly if needs be
			$taglink = rtrim($wp_rewrite->get_tag_permastruct(),'/');

			ShowDebugAutoTag("tag link permastruct is " . $taglink);

			// store whether trailing slashes need to be added 
			$this->addtrailingslash = $wp_rewrite->use_trailing_slashes;

			ShowDebugAutoTag("tag permalink structure is $taglink do we add trailing slashes = " . intval($wp_rewrite->use_trailing_slashes));

			// ensure the start of the tag rewrite url has a / as for some reason 3.0+ stopped adding it
			if(!empty($taglink)){
				if(substr($taglink,0,1) != "/"){
					$taglink = "/" .  $taglink;
				}
			}


			// set tag placeholder			
			$tagplaceholder = ($this->addtrailingslash) ? ( $taglink ."/") : $taglink;

			ShowDebugAutoTag("tag placeholder is $tagplaceholder");

			$siteurl	= untrailingslashit(get_option('siteurl'));

			ShowDebugAutoTag("site url is $siteurl");

			//$tagurl = "<a href=\"##TAGURL##\" class=\"StrictlyAutoTagAnchor\" title=\"" . str_replace($this->deeplinktitle,"%tag%",$tag) . "\">$tag</a>";      

			ShowDebugAutoTag("loop through array and deeplink");

			$lasttag = $lastslug = "";

			
			//loop and bold unless they are already inside a bold tag
			foreach($this->deeplinkarray as $tag){

				$lasttag = $tag->name;
				$lastslug = $tag->slug;

				ShowDebugAutoTag("tag = " . $tag->name . " and slug = " . $tag->slug);

				// we skip any that are nested in tagged links already - shouldnt be anymore with storage!
				$testreg = "@<a class=\"StrictlyAutoTagAnchor\"[^>]+?>[^<]*?" . preg_quote($tag->name) . "[^<]*?</a>@";

				if(preg_match($testreg,$content)){

					ShowDebugAutoTag("ignore this tag " . $tag->name . " as its already within a linked tag regex was == " . $testreg);
						
				}else{

					ShowDebugAutoTag("this tag " . $tag->name . " is NOT already within a linked tag");

				
					// handle old and new
					$actualtitle = preg_replace("@%tag%@i",$tag->name,$this->deeplinktitle);
					$actualtitle = preg_replace("@%post_tag%@i",$tag->name,$actualtitle);

					ShowDebugAutoTag("replace %tag% with " . $tag->slug . " in " . $tagplaceholder);

					$actualurl   = $siteurl . preg_replace('@%tag%@i',$tag->slug,$tagplaceholder);
					$actualurl   = preg_replace('@%post_tag%@i',$tag->slug,$actualurl);

					ShowDebugAutoTag("actual url is now $actualurl");

					ShowDebugAutoTag("did we already bold = " . intval($this->boldtaggedwords));

					// as this runs after auto bold if thats enabled i can just use those markers as replacements
					if($this->boldtaggedwords){						

						$link = '<a class="StrictlyAutoTagAnchor" href="' . $actualurl . '" title="' . $actualtitle . '">' . $tag->name . '</a>';

						$regex = "@<strong class='StrictlyAutoTagBold'>" . preg_quote($tag->name) . "</strong>@i";						
						
						// wrap tags in anchors and keep the formatting e.g dont upper case if the tag is lowercase as it might be inside
						// an href or src which might screw it up
						$content = preg_replace($regex,$link,$content,$this->maxtagstolink);

					}else{

						ShowDebugAutoTag("no bolding so just link for first time");

						$origcontent = $content;

						// instead of doing negative lookaheads and entering a world of doom match and then clean	
						// easier to do a positive match than a negative especially with nested matches

						$link = '<a class="StrictlyAutoTagAnchor" href="' . $actualurl . '" title="' . $actualtitle . '">$1</a>';

						
						ShowDebugAutoTag("replace " . preg_quote($tag->name) . " in content");

						// wrap tags in anchors and keep the formatting e.g dont upper case if the tag is lowercase as it might be inside
						// an href or src which might screw it up
						$content = preg_replace("@\b(" . preg_quote($tag->name) . ")\b@",$link,$content,$this->maxtagstolink);

						ShowDebugAutoTag("1 len is now " . strlen($content));
						
					}					
				}
				
				
			}

			//ShowDebugAutoTag("after put ##Q## placeholders back len is now " . strlen($content));

		}

		ShowDebugAutoTag("return $content");

		return $content;

	}
	
	protected function StoreContent($content, $dir)
	{
		// works on my test page on my PC but not on Wordpress why? I have no idea?
		//return $content;
		
		ShowDebugAutoTag("IN StoreContent direction = $dir");
		
		if($dir == "STORE")
		{
			// kill any existing array contents which might be left around due to Wordpress keeping the class in memory
			// between page loads/imports/edits or whatever which "may" cause the values of a previous article stored in the 
			// content hash to be used for another article (not proven just guessing)
			
			unset($this->storage);
	
			// handle new data-title data-description tags
			preg_match_all('@((?:title|src|href|alt|data-\w+|data-\w+-\w+)\s?=\s?)(")([\s\S]*?)(")@i',$content,$matches,PREG_SET_ORDER);
		
			$x = 0;

			if($matches)
			{
				
				foreach($matches as $match)
				{
					$word = $match[0];


					ShowDebugAutoTag("store match $word");

					$this->storage[] = $word;

					$content = str_replace($word, "##M".$x."##", $content);
					$x++;
				}
			}

			preg_match_all("@((?:title|src|href|alt|data-\w+|data-\w+-\w+)\s?=\s?)(')([\s\S]*?)(')@i",$content,$matches,PREG_SET_ORDER);
			
			if($matches)
			{
				
				foreach($matches as $match)
				{
					$word = $match[0];

					ShowDebugAutoTag("store match $word");

					$this->storage[] = $word;

					$content = str_replace($word, "##M".$x."##", $content);
					$x++;
				}
			}

			ShowDebugAutoTag("store <strong><h4> etc");

			// store stuff already in <a> <strong> <h4> etc
			preg_match_all("@(<(h[1-6]|strong|a|b|i|em).*?>)([\s\S]*?)(<\/\\2>)@i",$content,$matches,PREG_SET_ORDER);
			
			if($matches)
			{
				ShowDebugAutoTag("got matches");

				foreach($matches as $match)
				{
					$word = $match[0];

					ShowDebugAutoTag("store TAG $word");

					$this->storage[] = $word;

					$content = str_replace($word, "##M".$x."##", $content);
					$x++;
				}
			}


			ShowDebugAutoTag("match [youtube video]");

			// store wordpress shortcodes [youtube=blah] as they are not be touched by any formatting or to be used for tagging
			// changed 9th Feb 2014 to handle non space shortcodes [shortcode=blah] as well as [youtube http://www.site.com]			
			preg_match_all("@(\[[\S\s]+?\])@",$content,$matches,PREG_SET_ORDER);
			
			if($matches)
			{
				ShowDebugAutoTag("got matches");

				foreach($matches as $match)
				{
					$word = $match[0];

					ShowDebugAutoTag("store TAG $word");

					$this->storage[] = $word;

					$content = str_replace($word, "##M".$x."##", $content);
					$x++;
				}
			}


			ShowDebugAutoTag($this->storage);

		}else{
			
			ShowDebugAutoTag("put them back in");

			if(count($this->storage) > 0)
			{
				ShowDebugAutoTag("we have " . count($this->storage) . " stored bits to put back");

				$x = 0;
				
				// we loop twice incase we stored a title/alt inside a bold/strong tag so we need to replace both
				foreach($this->storage as $match)
				{
					
					ShowDebugAutoTag("put $match back in ##M".$x."##");
			

					$content = str_replace( "##M".$x."##",$match, $content);
					$x++;

					//ShowDebugAutoTag("now content = $content");
				}

				$x = 0;
				foreach($this->storage as $match)
				{
					
					ShowDebugAutoTag("put $match back in ##M".$x."##");
			

					$content = str_replace( "##M".$x."##",$match, $content);
					$x++;

					//ShowDebugAutoTag("now content = $content");
				}
			}
			
			ShowDebugAutoTag("after put content back");

			// clean out array again just to be sure!
			unset($this->storage);
		}

		ShowDebugAutoTag("RETURN CONTENT == $content");

		return $content;
	}

				
	/**
	 * Removes any noise words from the system if they are already used as post tags
	 *
	 * @param string $noisewords
	 * @return bool
	 */
	protected function RemoveSavedNoiseWords($noisewords=""){

		ShowDebugAutoTag("IN RemoveSavedNoiseWords");

		set_time_limit(0);

		global $wpdb,$wp_object_cache;

		$deleted = 0;

		if(!empty($noisewords)){

			ShowDebugAutoTag("Format noise words = '$noisewords'");

			// ensure we don't have pipes at beginning or end
			if(substr($noisewords,0,1) == "|"){

				ShowDebugAutoTag("remove starting pipe");

				$noisewords = substr($noisewords,1,strlen($noisewords));
			}
			if(substr($noisewords,-1) == "|"){

				ShowDebugAutoTag("remove trailing pipe");

				$noisewords = substr($noisewords,0,strlen($noisewords)-1);
			}
			
			
			// wrap in quotes for IN statement and make sure each noise word values is escaped
			$sqlin = "'" . preg_replace("@\|@","','",addslashes($noisewords)) . "'";

			
			ShowDebugAutoTag("IN is now $sqlin");	
		

			// cannot use the prepare function as it will add extra slashes and quotes
			// need to first delete any records that are only used as post_tags and dont have shared taxonomies
			$sql = sprintf("DELETE a,c
							FROM {$wpdb->terms} AS a
							JOIN {$wpdb->term_taxonomy} AS c ON a.term_id = c.term_id			
							LEFT JOIN {$wpdb->term_taxonomy} as b ON a.term_id = b.term_id AND b.taxonomy != 'post_tag'
							WHERE (
									c.taxonomy = 'post_tag'
									AND b.term_id IS NULL
									AND  a.Name IN(%s)
								);",$sqlin);
		

			ShowDebugAutoTag($sql);

			$deleted = $wpdb->query($sql);	
		
			if($deleted >0){
				
				// divide by two as we are deleting 2 records at a time
				if($deleted % 2 == 0)
				{
					$deleted = $deleted / 2;
				}
			}

			// now do any records that DO have shared taxonomies and just delete the term_taxonomy record
			$sql = sprintf("DELETE c
							FROM {$wpdb->terms} AS a
							JOIN {$wpdb->term_taxonomy} AS c ON a.term_id = c.term_id			
							WHERE (
									c.taxonomy = 'post_tag'
									AND  a.Name IN(%s)
								);",$sqlin);
		

			ShowDebugAutoTag($sql);

			$deleted = $deleted + $wpdb->query($sql);	


			if($deleted >0){
				// clear object cache				
				unset($wp_object_cache->cache);
					
				$wp_object_cache->cache = array();
			}

			ShowDebugAutoTag("SQL Query deleted this no of rows == " . $deleted);


		}

		return $deleted;
	}


	/**
	 * Deletes unused posts or under used tags	 
	 * $notags is the number of posts a tag must be related to e.g 0 we remove all tags not associated with any post
	 *
	 * @param int  $notags
	 * @return int
	 */
	protected function CleanTags( $notags=1) {
		
		set_time_limit(0);

		global $wpdb,$wp_object_cache;

		$updated = 0;

		
		// we do 2 deletes one to remove both records where only post_tag taxonomies exist then one for shared
		$sql = $wpdb->prepare("DELETE   a,c
								FROM	{$wpdb->terms} AS a
								JOIN	{$wpdb->term_taxonomy} AS c ON a.term_id = c.term_id		
								LEFT JOIN {$wpdb->term_taxonomy} as b ON a.term_id = b.term_id AND b.taxonomy != 'post_tag'
								WHERE (
										c.taxonomy = 'post_tag'
										AND b.term_id IS NULL
										AND  c.count <= %d
									);",$notags);
		

		ShowDebugAutoTag($sql);

		$updated = $wpdb->query($sql);	
		
		if($updated >0){
			
			// divide by two as we are deleting 2 records!
			if($updated >0){

				// divide by two as we are deleting 2 records at a time
				if($updated % 2 == 0)
				{
					$updated = $updated / 2;
				}
			}
		}

		// now do the delete for shared taxonomies so we just delete the term_taxonomy record
		$sql = $wpdb->prepare( "DELETE  c
								FROM	{$wpdb->terms} AS a
								JOIN	{$wpdb->term_taxonomy} AS c ON a.term_id = c.term_id				
								WHERE (
										c.taxonomy = 'post_tag'
										AND  c.count <= %d
									);",$notags);

		
		ShowDebugAutoTag($sql);

		$updated = $updated + $wpdb->query($sql);	

		if($updated >0){
			// clear object cache
				
			unset($wp_object_cache->cache);
			
			$wp_object_cache->cache = array();
		}

		ShowDebugAutoTag("SQL Query returns " . $updated);

		return $updated;
	}

	/**
	 * Finds the number of under used tags in system
	 *
	 * @return int
	 */
	protected function GetUnderusedTags($notags=1)			
	{
		global $wpdb;

		$tags = 0;

		$sql =  $wpdb->prepare("SELECT	COUNT(*) as Tags
								FROM	{$wpdb->terms} wt
								INNER JOIN {$wpdb->term_taxonomy} wtt 
									ON	wt.term_id=wtt.term_id
								WHERE	wtt.taxonomy='post_tag' 
										AND wtt.count<=%d;",$notags);
		

		ShowDebugAutoTag($sql);

		$tags = $wpdb->get_var(($sql));		

		return $tags;
	}

	
	/**
	 * Updates existing posts by adding in deeplinks and new bold tags
	 * The $all_posts param specifies whether all posts are re-tagged or only those without tags
	 *
	 * @param bool  $all_posts
	 * @return int
	 */
	protected function ReLinkAndTagPosts( $all_posts=false ) {


		ShowDebugAutoTag("IN ReLinkAndTagPosts " . intval( $all_posts));

		set_time_limit(0);

		global $wpdb;

		$updated = 0;

		// in future rewrite this with a branch so that if we are looking at posts with no tags then
		// we only return from the DB those posts that have no tags

		// handle custom post types by allowing everything that isnt a page, attachment or revision
		$sql = "SELECT id 
				FROM {$wpdb->posts}
				WHERE post_password='' AND post_status='publish' AND post_type NOT IN('page', 'attachment', 'revision') 
				ORDER BY post_modified_gmt DESC;";


		ShowDebugAutoTag($sql);

		$posts = $wpdb->get_results($sql);
		
		foreach($posts as $post){

			// definitley a better way to do this but would involve a major rewrite!

			ShowDebugAutoTag("get post id " . $post->id);

			$object = get_post($post->id);
			if ( $object == false || $object == null ) {
				return false;
			}		

			
			
			// have we already got tags against this post and if so do they contain strictly links and bold tags and if they do - do we need to remove them?	

			ShowDebugAutoTag("Do we need to clean any Strictly Goodness?");

			$newcontent = $this->CheckAndCleanTags( $object->post_content );
			
			// find tags for this post
			$posttags = $this->AutoTag( $object,  $all_posts );

			

			ShowDebugAutoTag("do we bold / deeplink / convert text to links");

			if($this->boldtaggedwords || $this->taglinks ){	
				
				ShowDebugAutoTag("yes so store content");

				// store href/alt/src/title attributes that would cause issues with nested tags
				$newcontent = $this->StoreContent($newcontent, "STORE");

				

				ShowDebugAutoTag("call bold or deeplink tags");

				if($this->boldtaggedwords && count($posttags) > 0){

					ShowDebugAutoTag("Auto Bold this content");

					// help SEO by bolding our tags
					$newcontent = $this->AutoBold($newcontent,$posttags);

				}

				if($this->taglinks && count($posttags) > 0){

					ShowDebugAutoTag("Auto Link this content");

					// help SEO by deeplinking our tags
					$newcontent = $this->AutoLink($newcontent,$posttags);

				}
						
				// put stored placeholders back in to content and clear cache
				$newcontent = $this->StoreContent($newcontent, "RETURN");

				// now save the new deeplinked bolded content

				ShowDebugAutoTag("our new content is === " . $newcontent);

				$sql = $wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = %s WHERE id = %d;", $newcontent,$object->ID);

				ShowDebugAutoTag("SQL is $sql");

				$r = $wpdb->query($sql);
					
				ShowDebugAutoTag("should have been updated rows = " . $r);				
			
			}

			ShowDebugAutoTag("did we find new tags to save?");

			if($posttags !== false){
			
				$updated++;
				
				ShowDebugAutoTag("we have " .  count($posttags) . " tags to add to this post");

				// add tags to post
				// Append tags if tags to add
				if ( count($posttags) > 0) {
					
					// Add tags to posts
					wp_set_object_terms( $object->ID, $posttags, 'post_tag', true );
					
					// Clean cache
					if ( 'page' == $object->post_type ) {
						clean_page_cache($object->ID);
					} else {
						clean_post_cache($object->ID);
					}			
				}
			}

			unset($object,$posttags);
		}

		unset($posts);		

		return $updated;
	}
	
	/**
	 * Updates existing posts with tags
	 * The $all_posts param specifies whether all posts are re-tagged or only those without tags
	 *
	 * @param bool  $all_posts
	 * @return int
	 */
	protected function ReTagPosts( $all_posts=false ) {
		
		set_time_limit(0);

		global $wpdb;

		$updated = 0;

		// in future rewrite this with a branch so that if we are looking at posts with no tags then
		// we only return from the DB those posts that have no tags

		$sql = "SELECT id 
				FROM {$wpdb->posts}
				WHERE post_password='' AND post_status='publish' AND post_type NOT IN('page', 'attachment', 'revision') 
				ORDER BY post_modified_gmt DESC;";


		ShowDebugAutoTag($sql);

		$posts = $wpdb->get_results($sql);
		
		foreach($posts as $post){

			// definitley a better way to do this but would involve a major rewrite!

			ShowDebugAutoTag("get post id " . $post->id);

			$object = get_post($post->id);
			if ( $object == false || $object == null ) {
				return false;
			}		
			
			// find tags for this post THATS all we do in this method
			$posttags = $this->AutoTag( $object,  $all_posts );
			

			if($posttags !== false){
			
				$updated++;
				
				ShowDebugAutoTag("we have " .  count($posttags) . " tags to add to this post");

				// add tags to post
				// Append tags if tags to add
				if ( count($posttags) > 0) {
					
					// Add tags to posts
					wp_set_object_terms( $object->ID, $posttags, 'post_tag', true );
					
					// Clean cache
					if ( 'page' == $object->post_type ) {
						clean_page_cache($object->ID);
					} else {
						clean_post_cache($object->ID);
					}			
				}
			}

			unset($object,$posttags);
		}

		unset($posts);		

		return $updated;
	}

	/**
	 * Format content to make searching for new tags easier
	 *
	 * @param string $content
	 * @return string
	 */
	protected function FormatContent($content=""){

		if(!empty($content)){

			// if we are auto discovering tags then we need to reformat words next to full stops so that we don't get false positives
			if($this->autodiscover){
				// ensure capitals next to full stops are decapitalised but only if the word is single e.g
				// change ". The world" to ". the" but not ". United States"
				$content = preg_replace("/(\.[”’\"]?\s*[A-Z][a-z]+\s[a-z])/e","strtolower('$1')",$content);
			}

			// remove plurals
			$content = preg_replace("/(\w)([‘'’]s )/i","$1 ",$content);

			// now remove anything not a letter or number
			$content = preg_replace("/[^-\w\d\s\.,\?]/"," ",$content);
			
			// replace new lines with a full stop so we don't get cases of two unrelated strings being matched
			$content = preg_replace("/\r\n/",". ",$content);

			// remove excess space
			$content = preg_replace("/\s{2,}/"," ",$content);			

		}

		return $content;

	}
	
	/**
	 * Checks a word to see if its a known noise word
	 * 
	 * @param string $word
	 * @return boolean
	 */
	protected function IsNoiseWord($word){
		
		//ShowDebugAutoTag("Is $word a noise word == " . $this->isnoisewordregex);

		$count = preg_match($this->isnoisewordregex,$word,$match);

		if(count($match)>0){
			return true;
		}else{			

			// check the case sensitive list
			$count = preg_match($this->isnoisewordregex_case_sensitive,$word,$match);

			if(count($match)>0){
				return true;
			}else{
				return false;
			}
		}
	}

	/**
	 * Format content to make searching for new tags easier
	 *
	 * @param string $content
	 * @return string
	 */
	protected function FormatTitle($content="")
	{
		ShowDebugAutoTag("IN FormatTitle = $content");

		if(!empty($content)){

			// remove plurals
			$content = preg_replace("/(\w)([‘'’]s )/i","$1 ",$content);
			$content = preg_replace("/(\ws)([‘'’] )/i","$1 ",$content);

			// now remove anything not a letter or number
			$content = preg_replace("/[^-\w\d\s\.,\?]/"," ",$content);		

			// remove excess space
			$content = preg_replace("/\s{2,}/"," ",$content);
		}

		ShowDebugAutoTag("RETURN = $content");

		return $content;

	}

	/**
	 * Checks whether a word is a roman numeral
	 *
	 * @param string $word
	 * @return boolean
	 */
	function IsRomanNumeral($word){

		if(preg_match("/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/",$word)){
			return true;
		}else{
			return false;
		}
	}

	/*
	 * removes noise words from a given string
	 *
	 * @param string
	 * @return string
	 */
	protected function RemoveNoiseWords($content){		

		$content = preg_replace($this->removenoisewordsregex," ",$content);

		// remove case sensitive noise words

		$content = preg_replace($this->removenoisewordsregex_case_sensitive," ",$content);

		return $content;
	}

	/*
	 * counts the number of words that capitalised in a string
	 *
	 * @param string
	 * @return integer
	 */
	protected function CountCapitals($words){
		
		$no_caps =	preg_match_all("/\b[A-Z][A-Za-z]*\b/",$words,$matches);			

		return $no_caps;
	}
	
	/*
	 * strips all non words from a string
	 *
	 * @param string
	 * @return string
	 */
	protected function StripNonWords($words){

		// strip everything not space or uppercase/lowercase
		$words = preg_replace("@[^-A-Za-z\s]@","",$words);
	
		return $words;
	}

	/**
	 * Searches the passed in content looking for Acronyms to add to the search tags array
	 * 
	 * @param string $content
	 * @param array $searchtags
	 */
	protected function MatchAcronyms($content,&$searchtags){
		
		// easiest way to look for keywords without some sort of list is to look for Acronyms like CIA, AIG, JAVA etc.
		// so use a regex to match all words that are pure capitals 2 chars or more to skip over I A etc
		preg_match_all("/\b([A-Z]{2,})\b/u",$content,$matches,PREG_SET_ORDER);
	
		if($matches){
		
			foreach($matches as $match){
				
				$pat = $match[1];

				// ignore noise words who someone has capitalised as well as roman numerals which may be part of something else e.g World War II
				if(!$this->IsNoiseWord($pat) && !$this->IsRomanNumeral($pat)){
					// add in the format key=value to make removing items easy and quick plus we don't waste overhead running
					// array_unique to remove duplicates!					
					$searchtags[$pat] = trim($pat);
				}
			}
		}

		unset($match,$matches);

	}

	/**
	 * Searches the passed in content looking for Countries to add to the search tags array
	 * 
	 * @param string $content
	 * @param array $searchtags
	 */
	protected function MatchCountries($content,&$searchtags){
		preg_match_all("/\s(Afghanistan|Albania|Algeria|American\sSamoa|Andorra|Angola|Anguilla|Antarctica|Antigua\sand\sBarbuda|Arctic\sOcean|Argentina|Armenia|Aruba|Ashmore\sand\sCartier\sIslands|Australia|Austria|Azerbaijan|Bahrain|Baker\sIsland|Bangladesh|Barbados|Bassas\sda\sIndia|Belarus|Belgium|Belize|Benin|Bermuda|Bhutan|Bolivia|Bosnia\sand\sHerzegovina|Botswana|Bouvet\sIsland|Brazil|British\sVirgin\sIslands|Brunei|Bulgaria|Burkina\sFaso|Burma|Burundi|Cambodia|Cameroon|Canada|Cape\sVerde|Cayman\sIslands|Central\sAfrican\sRepublic|Chad|Chile|China|Christmas\sIsland|Clipperton\sIsland|Cocos\s(Keeling)\sIslands|Colombia|Comoros|Congo|Cook\sIslands|Coral\sSea\sIslands|Costa\sRica|Croatia|Cuba|Cyprus|Czech\sRepublic|Denmark|Djibouti|Dominica|Dominican\sRepublic|Ecuador|Eire|Egypt|El\sSalvador|Equatorial\sGuinea|England|Eritrea|Estonia|Ethiopia|Europa\sIsland|Falkland\sIslands\s|Islas\sMalvinas|Faroe\sIslands|Fiji|Finland|France|French\sGuiana|French\sPolynesia|French\sSouthern\sand\sAntarctic\sLands|Gabon|Gaza\sStrip|Georgia|Germany|Ghana|Gibraltar|Glorioso\sIslands|Greece|Greenland|Grenada|Guadeloupe|Guam|Guatemala|Guernsey|Guinea|Guinea-Bissau|Guyana|Haiti|Heard\sIsland\sand\sMcDonald\sIslands|Holy\sSee\s(Vatican\sCity)|Honduras|Hong\sKong|Howland\sIsland|Hungary|Iceland|India|Indonesia|Iran|Iraq|Ireland|Israel|Italy|Ivory\sCoast|Jamaica|Jan\sMayen|Japan|Jarvis\sIsland|Jersey|Johnston\sAtoll|Jordan|Juan\sde\sNova\sIsland|Kazakstan|Kenya|Kingman\sReef|Kiribati|Korea|Korea|Kuwait|Kyrgyzstan|Laos|Latvia|Lebanon|Lesotho|Liberia|Libya|Liechtenstein|Lithuania|Luxembourg|Macau|Macedonia\sThe\sFormer\sYugoslav\sRepublic\sof|Madagascar|Malawi|Malaysia|Maldives|Mali|Malta|Man\sIsle\sof|Marshall\sIslands|Martinique|Mauritania|Mauritius|Mayotte|Mexico|Micronesia\sFederated\sStates\sof|Midway\sIslands|Moldova|Monaco|Mongolia|Montenegro|Montserrat|Morocco|Mozambique|Namibia|Nauru|Navassa\sIsland|Nepal|Netherlands|Netherlands\sAntilles|New\sCaledonia|New\sZealand|Nicaragua|Nigeria|Niue|Norfolk\sIsland|Northern\sIreland|Northern\sMariana\sIslands|Norway|Oman|Pakistan|Palau|Palmyra\sAtoll|Panama|Papua\sNew\sGuinea|Paracel\sIslands|Paraguay|Peru|Philippines|Pitcairn\sIslands|Poland|Portugal|Puerto\sRico|Qatar|Reunion|Romania|Russia|Rwanda|Saint\sHelena|Saint\sKitts\sand\sNevis|Saint\sLucia|Saint\sPierre\sand\sMiquelon|Saint\sVincent\sand\sthe\sGrenadines|San\sMarino|Sao\sTome\sand\sPrincipe|Saudi\sArabia|Scotland|Senegal|Serbia|Seychelles|Sierra\sLeone|Singapore|Slovakia|Slovenia|Solomon\sIslands|Somalia|South\sAfrica|South\sGeorgia\sand\sthe\sSouth\sSandwich\sIslands|Spain|Spratly\sIslands|Sri\sLanka|Sudan|Suriname|Svalbard|Swaziland|Sweden|Switzerland|Syria|Taiwan|Tajikistan|Tanzania|Thailand|The\sBahamas|The\sGambia|Togo|Tokelau|Tonga|Trinidad\sand\sTobago|Tromelin\sIsland|Tunisia|Turkey|Turkmenistan|Turks\sand\sCaicos\sIslands|Tuvalu|Uganda|Ukraine|United\sArab\sEmirates|UAE|United\sKingdom|UK|United\sStates\sof\sAmerica|USA|Uruguay|Uzbekistan|Vanuatu|Venezuela|Vietnam|Virgin\sIslands|Wake\sIsland|Wales|Wallis\sand\sFutuna|West\sBank|Western\sSahara|Western\sSamoa|Yemen|Zaire|Zambia|Zimbabwe|Europe|Western\sEurope|North\sAmerica|South\sAmerica|Asia|South\sEast\sAsia|Central\sAsia|The\sCaucasus|Middle\sEast|Far\sEast|Scandinavia|Africa|North\sAfrica|North\sPole|South\sPole|Central\sAmerica|Caribbean|London|New\sYork|Paris|Moscow|Beijing|Tokyo|Washington\sDC|Los\sAngeles|Miami|Rome|Sydney|Mumbai|Baghdad|Kabul|Islamabad|Berlin|Palestine|Dublin|Belfast|Tel\sAviv)\s/i",$content,$matches, PREG_SET_ORDER);


		if($matches){
		
			foreach($matches as $match){
				
				$pat = $match[1];

				$searchtags[$pat] = trim($pat);
			}
		}

		unset($match,$matches);

	}

	/**
	 * Searches the passed in content looking for Countries to add to the search tags array
	 * 
	 * @param string $content
	 * @param array $searchtags
	 */
	protected function MatchNames($content,&$searchtags){

		ShowDebugAutoTag("IN MatchNames");

		// look for names of people or important strings of 2+ words that start with capitals e.g Federal Reserve Bank or Barack Hussein Obama
		// this is not perfect and will not handle Irish type surnames O'Hara etc
		@preg_match_all("/((\b[A-Z][^A-Z\s\.,;:\?]+)(\s+[A-Z][^A-Z\s\.,;:\?]+)+\b)/u",$content,$matches,PREG_SET_ORDER);

		// found some results
		if($matches){
		
			foreach($matches as $match){
				
				$pat = $match[1];

				ShowDebugAutoTag("found possible name tag to our stack " . $pat);

				$searchtags[$pat] = trim($pat);
			}
		}
		
		unset($match,$matches);
	}


	/**
	 * check the content to see if the amount of content that is parsable is above the allowed threshold
	 *
	 * @param string
	 * @return boolean
	 */
	protected function ValidContent($content){

		// strip everything not space or uppercase/lowercase letters
		$content	= $this->StripNonWords($content);

		// count the total number of words
		$word_count = str_word_count($content);

		// no words? nothing to analyse
		if($word_count == 0){
			return false;
		}

		// count the number of capitalised words
		$capital_count = $this->CountCapitals($content);

		if($capital_count > 0){
			// check percentage - if its set to 0 then we can only skip the content if its all capitals
			if($this->ignorepercentage > 0){
				$per = round(($capital_count / $word_count) * 100);

				if($per > $this->ignorepercentage){
					return false;	
				}
			}else{
				if($word_count == $capital_count){
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * If post content to discover new tags and then rank matching tags so that only the most appropriate are added to a post
	 *
	 * @param string $content
	 * @return string
	 */
	public function RemoveBasicFormatting($content)
	{		
		ShowDebugAutoTag("IN RemoveBasicFormatting content = " . $content);
		
		// remove empty tags first to save on negative lookaheads or 0 or more chars later on
		
		$content = preg_replace("@(<(b|em|strong|i|font|span)(?:\s.*?>|>))\s*?(<\/\\2>)@i","",$content);	

		ShowDebugAutoTag("1 We return this content = " . $content);

		$content = preg_replace("@(<(b|em|strong|i|font|span)>)([\S\s]*?)(<\/?\\2>)@i","$3",$content);

		ShowDebugAutoTag("2 We return this content = " . $content);

		// remove all basic formatting this is done before we add our own bold/a tags
		$content = preg_replace("@(<(b|em|strong|i|font|span)(?:\s.*?>|>))([\S\s]+?)(<\/?\\2>)@i","$3",$content);	
		
		ShowDebugAutoTag("3 We return this content = " . $content);

		return $content;
		
	}

	/**
	 * Parse post content to discover new tags and then rank matching tags so that only the most appropriate are added to a post
	 *
	 * @param object $object
	 * @return array
	 */
	public function AutoTag($object,$all_posts=false){

		if(!$all_posts){

			// skip posts with tags already added
			if ( get_the_tags($object->ID) != false) {				
				
				if(($this->boldtaggedwords || $this->taglinks) && $this->already_strictly_tagged_and_linked){
				
					ShowDebugAutoTag("No need to re tag as this is already tagged and linked");

					return false;
				}
			}
		}

		// tags to add to post
		$addtags = array();

		// stack used for working out which tags to add
		$tagstack = array();

		// potential tags to add
		$searchtags = array();

		
		// ensure all html entities have been decoded
		$html		= $object->post_content;

		if($this->autodiscover){
			
			ShowDebugAutoTag("html B4 replace HTML with . is " . $html);

			// replace certain important HTML markers with . to prevent words that shouldnt be found
			$html = preg_replace("@</(?:p|div|table|tr|td|h[1-6])>@i",". ",$html);
			$html = preg_replace("@<[bh]r\s*/?>@i",". ",$html);

			ShowDebugAutoTag("html B4 replace HTML with . is " . $html);
		}


		$article	= html_entity_decode(strip_tags($html));
		$excerpt	= html_entity_decode($object->post_excerpt);
		$title		= html_entity_decode($object->post_title);

		ShowDebugAutoTag("our title is " . $title);

		// no need to trim as empty checks for space
		if(empty($article) && empty($excerpt) && empty($title)){		
			return $addtags;	
		}
		
		// remove anything in [] shortcodes with or without spaces so we don't leave the values as poosible NEW words e.g [shortcode] OR [youtube http://www.youtube.com/watch?v=FUpQ5jStLaA&w=500&h=300]		
		$article = preg_replace("@(\[[\S\s+?]+?\])@","",$article);

		// if we are looking for new tags then check the major sections to see what percentage of words are capitalised
		// as that makes it hard to look for important names and strings
		if($this->autodiscover){
			
			$discovercontent = "";

			ShowDebugAutoTag("do we add the title to our discover content == " . $title);

			// ensure title is not full of capitals
			if($this->ValidContent($title)){

				ShowDebugAutoTag("title is valid so add to discover content");

				// add a full stop to ensure words at the end of the title don't accidentally match those in the content during auto discovery
				$discovercontent .= " " . $title . " ";				
			}


			// ensure article is not full of capitals
			if($this->ValidContent($article)){
				$discovercontent .= ". " . $article . " ";					
			}

			// ensure excerpt  is not full of capitals
			if($this->ValidContent($excerpt)){
				$discovercontent .= ". " . $excerpt . " ";					
			}
			
		}else{			
			$discovercontent	= "";
		}

		ShowDebugAutoTag("do we rank the title = " . $this->ranktitle);

		// if we are doing a special parse of the title we don't need to add it to our content as well
		if($this->ranktitle){
			$content			= " " . $article . ". " . $excerpt . " ";
			$title				= $this->FormatTitle($title);
		}else{
			$content			= " " . $article . ". " . $excerpt . ". " . $title . " ";
		}

		// set working variable which will be decreased when tags have been found
		$maxtags			= $this->maxtags;


		// reformat content to remove plurals and punctuation
		$content			= $this->FormatContent($content);
		$discovercontent	= $this->FormatContent($discovercontent);

		// remove noise words from our auto discover content
		// they pose a problem for new tags and not tags that have already been saved as they might legitamitley exist
		// therefore we just want to prevent new tags containing noise words getting added

		ShowDebugAutoTag("Remove Noise words from == $discovercontent");

		$discovercontent	= $this->RemoveNoiseWords($discovercontent);

		ShowDebugAutoTag("our discover content is now == $discovercontent");

		// now if we are looking for new tags and we actually have some valid content to check
		if($this->autodiscover && !empty($discovercontent)){

			ShowDebugAutoTag("look for acronyms and names");
			
			// look for Acronyms in content
			// the searchtag array is passed by reference to prevent copies of arrays and merges later on
			$this->MatchAcronyms($discovercontent,$searchtags);		
			
			// look for countries as these are used as tags quite a lot
			$this->MatchCountries($discovercontent,$searchtags);

			// look for names and important sentences 2-4 words all capitalised
			$this->MatchNames($discovercontent,$searchtags);
		}
		
		//ShowDebugAutoTag("After auto discover our tags are");

		//ShowDebugAutoTag($searchtags);

		// get existing tags from the DB as we can use these as well as any new ones we just discovered
		global $wpdb;

		// just get all the terms from the DB in array format
	
		$dbterms = $wpdb->get_col("
				SELECT	DISTINCT name
				FROM	{$wpdb->terms} AS t
				JOIN	{$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id
				WHERE	tt.taxonomy = 'post_tag'
			");
		
		// if we have got some names and Acronyms then add them to our DB terms
		// as well as the search terms we found
		$c = count($searchtags);
		$d = count($dbterms);
		
		if($c > 0 && $d > 0){

			// join the db terms to those we found earlier
			$terms = array_merge($dbterms,$searchtags);
		
			// remove duplicates which come from discovering new tags that already match existing stored tags
			$terms = array_unique($terms);
			
		}elseif($c > 0){

			// just set terms to those we found through autodiscovery
			$terms = $searchtags;

		}elseif($d > 0){

			// just set terms to db results
			$terms = $dbterms;
		}

		// clean up		
		unset($searchtags,$dbterms);
		
		// if we have no terms to search with then quit now
		if(!isset($terms) || !is_array($terms)){
			// return empty array
			return $addtags;
		}
		                          
		
		// do we rank terms in the title higher?
		if($this->ranktitle){

			ShowDebugAutoTag("look inside our title for terms");

			// make it easier to match word boundaries
		//	$title = " " . $title . " ";

			ShowDebugAutoTag("our title is '" . $title . "'");

			// parse the title with our terms adding tags by reference into the tagstack
			// as we want to ensure tags in the title are always tagged we tweak the hitcount by adding 1000
			// in future expand this so we can add other content to search e.g anchors, headers each with their own ranking
			$this->SearchContent($title,$terms,$tagstack,1000);

		}

		ShowDebugAutoTag("so we just searched our title now check html");

		// do we rank terms in html tags such as headers or links higher?
		if($this->rankhtml){

			// get other important content
			@preg_match_all("@<(h[1-6])>([\S\s]+?)<\/?\\1>@i",$html,$matches,PREG_SET_ORDER);
			
			
			if($matches){
			
				foreach($matches as $match){
					
					ShowDebugAutoTag("HEADER MATCH == " . $match[2]);

					if($match[1] == "h1"){
						$score = 900;
					}elseif($match[1] == "h2"){
						$score = 650;
					}elseif($match[1] == "h3"){
						$score = 500;
					}elseif($match[1] == "h4"){
						$score = 350;
					}elseif($match[1] == "h5"){
						$score = 250;
					}elseif($match[1] == "h6"){
						$score = 200;
					}

					$important_content = html_entity_decode(strip_tags($match[2]));

					$this->SearchContent($important_content,$terms,$tagstack,$score);

				}

			}

			/*
			ShowDebugAutoTag("get links as they are important tags");

			// get other important content
			preg_match_all("@<a [^>]+?>([\S\s]+?)<\/?a>@i",$html,$matches,PREG_SET_ORDER);			
			

			if($matches){
			
				foreach($matches as $match){
					
					ShowDebugAutoTag("ANCHOR MATCH == " . $match[1]);

					$important_content = html_entity_decode(strip_tags($match[1]));

					$this->SearchContent($important_content,$terms,$tagstack,150);
				}

			}
			*/

			ShowDebugAutoTag("get other important tags");

			// get other important content
			preg_match_all("@<(b|i|em|strong)>([\S\s]+?)<\/?\\1>@i",$html,$matches,PREG_SET_ORDER);			
			

			if($matches){
			
				foreach($matches as $match){
					
					ShowDebugAutoTag("HEADER MATCH == " . $match[2]);

					$important_content = html_entity_decode(strip_tags($match[2]));

					$this->SearchContent($important_content,$terms,$tagstack,100);
				}

			}
		}

		ShowDebugAutoTag("now parse our main bit of content");
		
		// now parse the main piece of content
		$this->SearchContent($content,$terms,$tagstack,0);
		
		// cleanup
		unset($terms,$term);
	
		// take the top X items
		if($maxtags != -1 && count($tagstack) > $maxtags){

			ShowDebugAutoTag("take the top $maxtags from the " . count($tagstack) . " we have got for this article");

			// sort our results in decending order using our hitcount
			uasort($tagstack, array($this,'HitCount'));
			
			// return only the results we need
			$tagstack = array_slice($tagstack, 0, $maxtags);
		}

		ShowDebugAutoTag($tagstack);

		// add our results to the array we return which will be added to the post
		foreach($tagstack as $item=>$tag){
			$addtags[] = $tag['term'];
		}
		

		// we don't need to worry about dupes e.g tags added when the rank title check ran and then also added later
		// as Wordpress ensures duplicate taxonomies are not added to the DB
	
		//ShowDebugAutoTag("our full list of tags to add");
		
		//ShowDebugAutoTag($addtags);

		// update counter with the number of tags our plugin has added
		$newtags = count($addtags);

	
		//ShowDebugAutoTag("we are adding $newtags to the system");

		// add to existing tag count
		update_option('strictlyautotagcount',get_option('strictlyautotagcount') + $newtags);


		ShowDebugAutoTag("now order by longest first");
		ShowDebugAutoTag("before ordering we have");
		ShowDebugAutoTag($addtags);

		// now order by string so longest is first for bold/deeplinking 
		usort($addtags, 'StringLenSort');
		
		ShowDebugAutoTag("after sort by len we have");
		ShowDebugAutoTag($addtags) ;		
		

		// return array of post tags
		ShowDebugAutoTag("these are the tags we used");
		ShowDebugAutoTag($addtags);


		// return array of post tags
		return $addtags;

	}

	/**
	 * formats a search term to allow for ownwership tags we want to match
	 *
	 * @param string $term		
	 * @return string	 
	 */
	protected function FormatSearchTerm($term)
	{
		ShowDebugAutoTag("IN FormatSearchTerm $term");

		$words = explode(" ",$term);
		$newterm = "";

		foreach($words as $word)
		{
			if(!empty($word)){
				$newterm .= preg_quote($word) . "(['’]s)? ";
			}
		}

		$newterm = trim($newterm);

		ShowDebugAutoTag("RETURN " . $newterm);

		return $newterm;
	}

	/**
	 * parses content with a supplied array of terms looking for matches
	 *
	 * @param string content
	 * @param array $terms
	 * @param array $tagstack	
	 * @param integer $tweak	 
	 */
	protected function SearchContent($content,$terms,&$tagstack,$tweak){

		if(empty($content) || !is_array($terms) || !is_array($tagstack)){
			return;
		}

		// remove noise words now so that any tags that we discovered earlier will match
		//$content = $this->RemoveNoiseWords($content);

		// now loop through our content looking for the highest number of matching tags as we don't want to add a tag
		// just because it appears once as that single word would possibly be irrelevant to the posts context.
		foreach($terms as $term){

			ShowDebugAutoTag("Term = $term");

			// safety check in case some BS gets into the DB!
			if(strlen($term) > 1){

				// for an accurate search use preg_match_all with word boundaries
				// as substr_count doesn't always return the correct number from tests I did
				
				ShowDebugAutoTag("nestedtags = " . $this->nestedtags);


				// for exact matches we want to ensure that New York City Fire Department only matches that and not New York City
				if($this->nestedtags == AUTOTAG_LONG){

					ShowDebugAutoTag("longest word only");

					$regex = "@(^|[.,;:?]\s*|\s+[a-z0-9]+\s+)" . preg_quote( $term ) . "([.,;:?]|\s+[a-z0-9]+|$)@";

				}else{
				
					ShowDebugAutoTag("not longest word only");

					$regex = "@\b" . preg_quote( $term ) . "\b@";
				}

				ShowDebugAutoTag("regex = $regex");

				$addtag		= false;
				$addarray	= array();

				//ShowDebugAutoTag("look for $regex");

				$i = @preg_match_all($regex,$content,$matches);

				// if found then store it with the no of occurances it appeared e.g its hit count
				if($i > 0){
	
					ShowDebugAutoTag("found $i occurencces of $term");
					
					// if we are tweaking the hitcount e.g for ranking title tags higher
					if($tweak > 0){
						$i = $i + $tweak;
					}

					// do we add all tags whether or not they appear nested inside other matches
					if($this->nestedtags == AUTOTAG_BOTH ){
	
						ShowDebugAutoTag("ADD BOTH INCLUDING INSIDE OTHER MATCHES");

						// if we already have this term in our stack then update the counter
						if(isset($tagstack[$term])){
						
							$oldcount= $tagstack[$term]['count'];
							$newcount= $oldcount+$i;
							
							// ensure noise words are never added
							if(!$this->IsNoiseWord($term)){

								ShowDebugAutoTag("Add term = $term count = $newcount");

								$addarray	= array("term"=>$term,"count"=>$newcount);
								$addtag		= true;									
							}
						}else{
							
							ShowDebugAutoTag("make sure $term is not a noise word");

							// ensure noise words are never added
							if(!$this->IsNoiseWord($term)){

								ShowDebugAutoTag("Add term = $term count = $i");

								// add term and hit count to our array
								$addarray	= array("term"=>$term,"count"=>$i);
								$addtag		= true;	

							}
						}
					// only tag longest
					}else if($this->nestedtags == AUTOTAG_LONG){
						ShowDebugAutoTag("LONGEST TAG VERSION ONLY");

						$ignore = false;


						ShowDebugAutoTag("loop looking for existing shorter tags we remove to use the longer one");

						// loop through existing tags checking for nested matches e.g New York appears in New York City 						
						foreach($tagstack as $key=>$value){

							$oldterm = $value['term'];
							$oldcount= $value['count'];
			
							ShowDebugAutoTag("is $oldterm in new term $term");

							// check whether one of our old terms is in our new one
							if(stripos($term,$oldterm)!==false && $term != $oldterm){
								
								ShowDebugAutoTag("we found $oldterm inside $term so remove old term and use new one");

								// we found an old term inside our new longer one and as we are keeping the longest version we need to add
								// the other tags hit count before deletng it as if it was a ranked title we want this version to show
								$i = $i + (int)$oldcount;

								// remove our previously stored tag as we only want the longest version						
								unset($tagstack[$key]);
							
							// check whether our old term is in our new one as it means the new one we found is not the longest!
							}elseif(stripos($oldterm,$term)!==false && $term != $oldterm){
								
								ShowDebugAutoTag("our new term $term is in $oldterm so keep longest version and ignore new term as its not longest!");

								// yes it is so keep our longest version in the stack and ignore our new term								
								$ignore = true;
								break;
							}
						}			
						
						
						// do we add our new term
						if(!$ignore){		
							// ensure noise words are never added
							if(!$this->IsNoiseWord($term)){

								ShowDebugAutoTag("Add term = $term count = $i");

								// add term and hit count to our array
								$addarray	= array("term"=>$term,"count"=>$i);
								$addtag		= true;	
							}
						}
					
					// must be AUTOTAG_SHORT
					}else{

						ShowDebugAutoTag("SHORT TAG VERSION ONLY");

						$ignore = false;
						
						ShowDebugAutoTag("loop looking for existing longer tags we remove to use the shorter one");

						// loop through existing tags checking for nested matches e.g New York appears in New York City 						
						foreach($tagstack as $key=>$value){

							$oldterm = $value['term'];
							$oldcount= $value['count'];
			
							// check whether our new term is already in one of our old terms
							if(stripos($oldterm,$term)!==false && $term != $oldterm){
								
								ShowDebugAutoTag("we found $term inside $oldterm so remove old term and use new one");

								// we found our term inside a longer one and as we are keeping the shortest version we need to add
								// the other tags hit count before deletng it as if it was a ranked title we want this version to show
								$i = $i + (int)$oldcount;

								// remove our previously stored tag as we only want the smallest version						
								unset($tagstack[$key]);
							
							// check whether our old term is in our new one
							}elseif(stripos($term,$oldterm)!==false && $term != $oldterm){
								
								ShowDebugAutoTag("our old term $oldterm is in $term so keep short version and ignore new term as its not shortest!");

								// yes it is so keep our short version in the stack and ignore our new term								
								$ignore = true;
								break;
							}
						}
					
						
						
						// do we add our new term
						if(!$ignore){		
							// ensure noise words are never added
							if(!$this->IsNoiseWord($term)){

								ShowDebugAutoTag("Add term = $term count = $i");

								// add term and hit count to our array
								$addarray	= array("term"=>$term,"count"=>$i);
								$addtag		= true;	
							}
						}
					}

					if($addtag){

						if($this->maxtagwords > 0){

							ShowDebugAutoTag("make sure the tag = " .$addarray['term'] . " is less than or equal to " . $this->maxtagwords . " words long");

							$wordcount = str_word_count($addarray['term']);

							if($wordcount > $this->maxtagwords){

								ShowDebugAutoTag("this tag has TOO MANY words in it!");
								$addtag = false;
							}
						}
						
						if($addtag){
							$tagstack[$term] = $addarray;
						}							
					}

					unset($addarray);
				}
			}
		}

		// the $tagstack was passed by reference so no need to return it
	}


	/**
	 * used when sorting tag hit count to compare two array items hitcount
	 *
	 * @param array $a
	 * @param array $b
	 * @return integer
	 */
	protected function HitCount($a, $b) {
		return $b['count'] - $a['count'];
	}

	/**
	 * Register AdminOptions with Wordpress
	 *
	 */
	public function RegisterAdminPage() {	
		add_options_page('Strictly Auto Tags', 'Strictly Auto Tags', 'manage_options', basename(__FILE__), array(&$this,'AdminOptions'));	
	}

	/**
	 * get saved options otherwise use defaults
	 *	 
	 * @return array
	 */
	protected function GetOptions(){

		$this->uninstall = get_option('strictlyautotag_uninstall');

		// get saved options from wordpress DB
		$options = get_option('strictlyautotags');

		//ShowDebugAutoTag("IN GetOptions do we deeplink = " . intval($this->taglinks));

		// if there are no saved options then use defaults
		if ( !is_array($options) )
		{
			// This array sets the default options for the plugin when it is first activated.
			$options = array('autodiscover'=>true, 'ranktitle'=>true, 'maxtags'=>4, 'ignorepercentage'=>50, 'noisewords'=>$this->defaultnoisewords, 'nestedtags'=>AUTOTAG_LONG, 'rankhtml'=>true, 'maxtagwords'=>3, 'boldtaggedwords' => false, 'noisewords_case_sensitive'=>$this->defaultnoisewords_case_sensitive, 'taglinks'=>false, 'deeplinktitle'=>"View all articles about %post_tag% here", 'maxtagstolink'=>2, 'minpoststotaglink'=>4, 'removestrictlytagsandlinks'=>false, 'skiptaggedposts'=>true);

		}else{

			// check defaults in case of new functionality added to plugin after installation
			if(IsNothing($options['nestedtags'])){
				$options['nestedtags'] = AUTOTAG_LONG;
			}

			if(IsNothing($options['noisewords'])){
				$options['noisewords'] = $this->defaultnoisewords;
			}

			if(IsNothing($options['noisewords_case_sensitive'])){
				$options['noisewords_case_sensitive'] = $this->defaultnoisewords_case_sensitive;
			}

			if(IsNothing($options['ignorepercentage'])){
				$options['ignorepercentage'] = 50;
			}

			if(!isset($options['rankhtml'])){
				$options['rankhtml'] = true;
			}

			if(IsNothing($options['maxtagwords'])){
				$options['maxtagwords'] = 0;
			}

			if(!isset($options['boldtaggedwords'])){
				$options['boldtaggedwords'] = false;
			}

			//ShowDebugAutoTag("IN GetOptions do we deeplink = " . intval($this->taglinks));


			// paid for special options
			if(!isset($options['taglinks'])){

				ShowDebugAutoTag("options['taglinks'] is nothing set to false");

				$options['taglinks'] = false;
			}

		//	ShowDebugAutoTag("IN GetOptions do we deeplink = " . intval($options['taglinks']));

			if(!isset($options['removestrictlytagsandlinks'])){

				ShowDebugAutoTag("options['removestrictlytagsandlinks'] is nothing set to false");

				$options['removestrictlytagsandlinks'] = false;
			}
			
			if(!isset($options['skiptaggedposts'])){

				ShowDebugAutoTag("options['skiptaggedposts'] is nothing set to true");

				$options['skiptaggedposts'] = true;
			}

			
			if(IsNothing($options['deeplinktitle'])){
				$options['deeplinktitle'] = "View all articles about %post_tag% here";
			}

			if(IsNothing($options['maxtagstolink'])){
				$options['maxtagstolink'] = 2;
			}
			
			if(IsNothing($options['minpoststotaglink'])){
				$options['minpoststotaglink'] = 4;
			}

		}

		// set internal members		
		$this->SetValues($options);

		// return options
		return $options;
	}

	/**
	 * save new options to the DB and reset internal members
	 *
	 * @param object $object
	 */
	protected function SaveOptions($options){

		update_option('strictlyautotag_uninstall', $this->uninstall);

		update_option('strictlyautotags', $options);

		// set internal members
		$this->SetValues($options);
	}
	
	/**
	 * sets internal member properties with the values from the options array
	 *
	 * @param object $object
	 */
	protected function SetValues($options){
		
		$this->autodiscover					= $options['autodiscover'];

		$this->ranktitle					= $options['ranktitle'];

		$this->maxtags						= $options['maxtags'];

		$this->ignorepercentage				= $options['ignorepercentage'];

		$this->noisewords					= $options['noisewords'];

		$this->noisewords_case_sensitive	= $options['noisewords_case_sensitive'];

		$this->nestedtags					= $options['nestedtags'];

		$this->rankhtml						= $options['rankhtml'];

		$this->maxtagwords					= $options['maxtagwords'];

		$this->boldtaggedwords				= $options['boldtaggedwords'];

		//ShowDebugAutoTag("IN GetOptions do we deeplink = " . intval($options['taglinks']));


		$this->taglinks						= $options['taglinks'];

		//ShowDebugAutoTag("IN GetOptions do we deeplink = " . intval($this->taglinks));


		$this->deeplinktitle				= $options['deeplinktitle'];

		$this->maxtagstolink				= $options['maxtagstolink'];

		$this->minpoststotaglink			= $options['minpoststotaglink'];

		$this->remove_strictly_tags_and_links= $options['removestrictlytagsandlinks'];

		$this->skip_tagged_posts			= $options['skiptaggedposts'];
			

		
	}

	

	/**
	 * Admin page for backend management of plugin
	 *
	 */
	public function AdminOptions(){

		// ensure we are in admin area
		if(!is_admin()){
			die("You are not allowed to view this page");
		}

		ShowDebugAutoTag("IN AdminOptions");

		// get saved options
		$options		= $this->GetOptions();

		// get the no of under used tags
		$notags			= get_option('strictlyautotags_underused');

		if(empty($notags) || !is_numeric($notags)){
			$notags = 1;
		}
		

		// message to show to admin if input is invalid
		$noisemsg = $errmsg = $msg	= "";



		if ( $_POST['CleanSubmit'] )
		{

			ShowDebugAutoTag("Clean Tags");

			// check nonce
			check_admin_referer("cleanup","strictlycleanupnonce");

			// do we retag all posts?
			$notags	=  strip_tags(stripslashes($_POST['strictlyautotags-cleanupposts']));	

			ShowDebugAutoTag("notags = " . $notags);

			if(!is_numeric($notags)){
				$errmsg .= __('The value you entered for No of Tagged Posts was invalid.<br />','strictly-autotags');

				$notags = 1;
			}else{

				// save new values to the DB
				update_option('strictlyautotags_underused', $notags);

				ShowDebugAutoTag("Delete all tags related to " . $notags . " or less posts");

				$deleted = $this->CleanTags($notags);

				ShowDebugAutoTag("We deleted " . $deleted . " tags");

				if($deleted == 0){
					$msg = __('No Tags were removed','strictly-autotags');
				}else{
					$msg = sprintf(__('%d relevant Tags have been removed','strictly-autotags'),$deleted);
				}
			}
		}

		if ( $_POST['RepostSubmit'] )
		{

			ShowDebugAutoTag("ReTag Posts");

			// check nonce
			check_admin_referer("retag","strictlyretagnonce");

			// do we retag all posts?
			$allposts	= (bool) strip_tags(stripslashes($_POST['strictlyautotags-tagless']));	

			ShowDebugAutoTag("allposts = " . $allposts);

			$updated = $this->ReTagPosts($allposts);

			if($updated == 0){
				$msg = sprintf(__('No Posts were re-tagged - If you think this an error please try the test post in the Readme.txt file with AutoDiscovery on to check the tagging works','strictly-autotags'),$updated);
			}else if($updated == 1){
				$msg = sprintf(__('1 Post was re-tagged','strictly-autotags'),$updated);
			}else{
				$msg = sprintf(__('%d Posts have been re-tagged','strictly-autotags'),$updated);
			}
		}

		if ( $_POST['RelinkSubmit'] )
		{

			ShowDebugAutoTag("ReLink And ReTag Posts");

			// check nonce
			check_admin_referer("retag2","strictlyretagnonce");

			// do we retag all posts?
			$allposts	= (bool) strip_tags(stripslashes($_POST['strictlyautotags-tagless2']));	

			ShowDebugAutoTag("allposts = " . $allposts);

			$updated = $this->ReLinkAndTagPosts($allposts);

			if($updated == 0){
				$msg = sprintf(__('No Posts were re-tagged or deeplinked - If you think this an error please try the test post in the Readme.txt file with AutoDiscovery on to check the tagging works','strictly-autotags'),$updated);
			}else if($updated == 1){
				$msg = sprintf(__('1 Post was re-tagged and deeplinkedd','strictly-autotags'),$updated);
			}else{
				$msg = sprintf(__('%d Posts have been re-tagged and deeplinked','strictly-autotags'),$updated);
			}
		}
		


		// if our option form has been submitted then save new values
		if ( $_POST['SaveOptionsSubmit'] )
		{
			// check nonce
			check_admin_referer("tagoptions","strictlytagoptionsnonce");

			ShowDebugAutoTag("get saved values");

			$this->uninstall						= (bool) strip_tags(stripslashes($_POST['strictlyautotags-uninstall']));
			$options['autodiscover']				= strip_tags(stripslashes($_POST['strictlyautotags-autodiscover']));
			$options['skiptaggedposts']				= (bool)strip_tags(stripslashes($_POST['strictlyautotags-skip_tagged_posts']));				
			$options['ranktitle']					= strip_tags(stripslashes($_POST['strictlyautotags-ranktitle']));			
			$options['nestedtags']					= strip_tags(stripslashes($_POST['strictlyautotags-nestedtags']));
			$options['rankhtml']					= strip_tags(stripslashes($_POST['strictlyautotags-rankhtml']));
			$options['boldtaggedwords']				= strip_tags(stripslashes($_POST['strictlyautotags-boldtaggedwords']));	
			$options['taglinks']					= (bool)strip_tags(stripslashes($_POST['strictlyautotags-taglinks']));
			$options['deeplinktitle']				= strip_tags(stripslashes($_POST['strictlyautotags-deeplinktitle']));	
			$options['removestrictlytagsandlinks']	= (bool)strip_tags(stripslashes($_POST['strictlyautotags-remove_strictly_tags_and_links']));					

			$ignorepercentage						= trim(strip_tags(stripslashes($_POST['strictlyautotags-ignorepercentage'])));			
			$noisewords								= trim(strip_tags(stripslashes($_POST['strictlyautotags-noisewords'])));	
			$noisewords_case_sensitive				= trim(strip_tags(stripslashes($_POST['strictlyautotags-noisewords-case-sensitive'])));	
			$removenoise							= (bool) strip_tags(stripslashes($_POST['strictlyautotags-removenoise']));
				
			// check format is word|word|word
			if(empty($noisewords)){
				$noisewords = $this->defaultnoisewords;
			}else{
				$noisewords = strtolower($noisewords);

				// make sure the noise words don't start or end with pipes				
				if( preg_match("@^([-a-z'0-9. ]+\|[-a-z'0-9. ]*)+$@i",$noisewords)){

					$noisewords = preg_replace("@^\|@","",$noisewords);
					$noisewords = preg_replace("@\|$@","",$noisewords);

					$options['noisewords']	= $noisewords;

					ShowDebugAutoTag("do we remove any saved noise words = " . $removenoise);

					// do we try and remove any saved noise words?
					if($removenoise){

						ShowDebugAutoTag("Remove any saved noise words");

						if($this->RemoveSavedNoiseWords( $noisewords )){
							$noisemsg = __('The system has removed all saved noise words from your saved post tag list.<br />','strictly-autotags');
						}else{
							$errmsg .= __('The system couldn\'t find any saved post tags matching your current noise word list.<br />','strictly-autotags');
						}
					}
				}else{
					$errmsg .= __('The noise words you entered are in an invalid format.<br />','strictly-autotags');
				}
			}

			// handle case sensitive words			

			if(empty($noisewords_case_sensitive)){
				$noisewords_case_sensitive = $this->defaultnoisewords_case_sensitive;
			}else{
				$noisewords_case_sensitive = $noisewords_case_sensitive;

				// make sure the noise words don't start or end with pipes				
				if( preg_match("@^([-a-z'0-9. ]+\|[-a-z'0-9. ]*)+$@i",$noisewords_case_sensitive)){
					
					$noisewords_case_sensitive = preg_replace("@^\|@","",$noisewords_case_sensitive);
					$noisewords_case_sensitive = preg_replace("@\|$@","",$noisewords_case_sensitive);

					$options['noisewords_case_sensitive']	= $noisewords_case_sensitive;

					ShowDebugAutoTag("do we remove any saved noise words = " . $removenoise);

					// do we try and remove any saved noise words?
					if($removenoise){

						ShowDebugAutoTag("Remove any saved noise words");

						if($this->RemoveSavedNoiseWords( $noisewords_case_sensitive )){
							$noisemsg = __('The system has removed all saved case sensitive noise words from your saved post tag list.<br />','strictly-autotags');
						}else{
							$errmsg .= __('The system couldn\'t find any saved post tags matching your current case sensitive noise word list.<br />','strictly-autotags');
						}
					}
				}else{
					$errmsg .= __('The noise words you entered are in an invalid format.<br />','strictly-autotags');
				}
			}

			// only set if its numeric
			$maxtags = strip_tags(stripslashes($_POST['strictlyautotags-maxtags']));

			if(is_numeric($maxtags) && $maxtags > 0 && $maxtags <= 20){
				$options['maxtags']		= $maxtags;
			}else{
				$errmsg .= __('The value you entered for Max Tags was invalid: (1 - 20)<br />','strictly-autotags');
				$options['maxtags'] = 4;
			}
			$maxtagwords = strip_tags(stripslashes($_POST['strictlyautotags-maxtagwords']));

			if(is_numeric($maxtagwords) && $maxtagwords >= 0 ){
				$options['maxtagwords']		= $maxtagwords;
			}else{
				$errmsg .= __('The value you entered for Max Tag Words was invalid: (> 0)<br />','strictly-autotags');
				$options['maxtagwords']		= 0;
			}


			if(is_numeric($ignorepercentage) && ($ignorepercentage >= 0 || $ignorepercentage <= 100)){
				$options['ignorepercentage']		= $ignorepercentage;
			}else{
				$errmsg .= __('The value your entered for the Ignore Capitals Percentage was invalid: (0 - 100)<br />','strictly-autotags');
				$options['ignorepercentage']	= 50;
			}

			$maxtagstolink				= strip_tags(stripslashes($_POST['strictlyautotags-maxtagstolink']));
			if(is_numeric($maxtagstolink) && $maxtagstolink >= 0 ){
				$options['maxtagstolink']		= $maxtagstolink;
			}else{
				$errmsg .= __('The value you entered for Max Tags to Link was invalid: (> 0)<br />','strictly-autotags');
				$options['maxtagstolink']		= 0;
			}

			$minpoststotaglink				= strip_tags(stripslashes($_POST['strictlyautotags-minpoststotaglink']));
			if(is_numeric($minpoststotaglink) && $minpoststotaglink >= 0 ){
				$options['minpoststotaglink']		= $minpoststotaglink;
			}else{
				$errmsg .= __('The value you entered for Min no of Tagged Posts to Link was invalid: (> 0)<br />','strictly-autotags');
				$options['minpoststotaglink']		= 0;
			}
			

			if(!empty($errmsg)){
				$errmsg = substr($errmsg,0,strlen($errmsg)-6);
			}

			// save new values to the DB
			update_option('strictlyautotags', $options);

			$msg = __('Options Saved','strictly-autotags');

			if(!empty($noisemsg)){
				$msg .= "<br />" . $noisemsg;
			}
		}

		echo	'<style type="text/css">
				#StrictlyAutoTagsAdmin h3 {
					font-size:12px;
					font-weight:bold;
					line-height:1;
					margin:0;
					padding:7px 9px 4px;
				}
				div.inside{
					padding: 10px;
				}
				div.tagopt{
					margin-top:17px;
				}
				.donate{
					margin-top:30px;
				}					
				span.notes{
					display:		block;
					padding-left:	5px;
					font-size:		0.8em;	
					margin-top:		7px;
				}
				p.error{
					font-weight:bold;
					color:red;
				}
				p.msg{
					font-weight:bold;
					color:green;
				}
				#StrictlyAutoTagsAdmin ul{
					list-style-type:circle !important;
					padding-left:18px;
				}
				#StrictlyAutoTagsAdmin label{
					font-weight:bold;
				}
				#strictlyautotags-noisewords{
					width:600px;
					height:250px;
				}
				div label:first-child{					
					display:	inline-block;
					width:		275px;
				}
				#lblnoisewords{
					vertical-align:top;
				}
				#supportstrictly{
					margin-bottom: 15px;
				}
				#strictlyautotags-deeplinktitle{
					width: 350px !important;
				}
				</style>
				
				';

		echo	'<div class="wrap" id="StrictlyAutoTagsAdmin">';

		if($this->version_type == "FREE")
		{

			echo	'<div class="postbox">						
						<h3 class="hndle">'.sprintf(__('Strictly AutoTags - Free Version %s (Most Recent Version is %s)', 'strictly-autotags'),$this->free_version,$this->paid_version).'</h3>					
						<div class="inside">
							<p>' . __('You are using the free version of this software. I would like to keep just one version of this code running instead of two as it\'s a lot of work however as no-one donates I cannot afford to. If you find this plugin usefull just think - if you all had donated me a single &pound;1 how much time I could spend on this project with over 150,000 downloads to make it a much better plugin for everyone and give everybody the full range of options?') . '</p>
							<p>' . __('At the moment you are missing out on the following options.') . '</p>
							<ul><li>Being able to use tag equivalency e.g if certain words are found e.g NSA, Snowden, PRISM so add the tag Privacy.</li>
							<li>Being able to automatically turn text such as http://mysite.com or www.mysite.com into real clickable anchor tags.</li>
							<li>Being able to turn on &quot;Clean Edit Mode&quot; and edit a post to remove any HTML formatting the AutoTag plugin adds in if you need to.</li>
							<li>Being able to remove basic formatting tags from posts you may have imported such as &lt;I&gt;, &lt;B&gt;, &lt;SPAN&gt; and &lt;FONT&gt; tags.</li>
							<li>Being able to set a minimum word limit that a tag must have to be included during auto-discovery.</li>
							<li>Being able to override the value for siteurl in case you have an odd setup and need to hardcode your site URL in front of deeplinked tags.</li>
							<li>New functions specifically designed to match trickier words such as <strong>World War II</strong>, <strong>al-Nusra Front</strong>, <strong>1,000 Guineas</strong> or <strong>Pope John Paul II</strong>.</li>
							</ul>
							<p>Please could you "like" my Facebook page at <a target="_blank" rel="nofollow" href="https://www.facebook.com/strictlysoftware">Facebook/strictlysoftware</a> where you will find lots of information on the plugins.</p>
							<p><strong>If you need help setting up or configuring the plugin for your site you can purchase a <a target="_blank" rel="nofollow"  href="https://www.etsy.com/uk/listing/190480863/this-coupon-goes-with-the-strictly" rel="nofollow" title="Buy a coupon that will allow me to conigure the plugin on your site">configuration coupon on Etsy.com</a> which will allow you to get me to help you set-up this plugin for your site with the best options and test that it is working correctly.</p>
							<p>If you feel any of these options could be useful to you then you can purchase the latest edition of the plugin from my site for &pound;40 or you can start off the donation rally and hopefully others will follow you.<p>
							<p>To buy the latest edition of the plugin you can either go to <a href="http://www.strictly-software.com/plugins/strictly-auto-tags">www.strictly-software.com/plugins/strictly-auto-tags</a> and purchase it or visit my <a href="https://www.etsy.com/uk/shop/StrictlySoftware" rel="nofollow" title="My Etsy shop with Strictly-Software automation products and configuration coupons">Etsy.com shop</a> to buy more Strictly-Software products.</p>';		

		}else{
			
			echo	'<div class="postbox">						
						<h3 class="hndle">'.sprintf(__('Strictly AutoTags - Paid Version %s (Thank you!)', 'strictly-autotags'),$this->paid_version).'</h3>					
						<div class="inside">
							<p>Please could you "like" my Facebook page at <a target="_blank" rel="nofollow" href="https://www.facebook.com/strictlysoftware">Facebook/strictlysoftware</a> where you will find lots of information on the plugin including detailed help articles.</p>
							<p>If you need help setting up or configuring the plugin for your site you can purchase a <a target="_blank" rel="nofollow" href="https://www.etsy.com/uk/listing/190480863/this-coupon-goes-with-the-strictly" rel="nofollow" title="Buy a coupon that will allow me to conigure the plugin on your site">configuration coupon on Etsy.com</a> which will allow you to get me to help you set-up this plugin for your site with the best options and test that it is working correctly.</p>';		

		}


		// get no of underused tags
		$underused		= $this->GetUnderusedTags($notags);

		if(!empty($msg)){
			echo '<p class="msg">' . $msg . '</p>';
		}
		if(!empty($errmsg)){
			echo '<p class="error">' . $errmsg . '</p>';
		}

		
		$installdate = get_option('strictlyautotag_install_date');
		$now		 = date('Y-m-d\TH:i:s+00:00',time());		
		$diff		 = (int)((strtotime($now) - strtotime($installdate)) / 60);	
		$tagged		 = get_option('strictlyautotagcount');

		ShowDebugAutoTag("we have tagged $tagged tags so far in the $diff minutes since $installdate");

		echo '<p><strong>'.__('About Strictly AutoTags','strictly-autotags').'</strong></p>';

		echo	'<p>'.__('Strictly AutoTags is designed to do one thing and one thing only - automatically add relevant tags to your posts.', 'strictly-autotags').'</p>';


		if(($diff > 10080 && $tagged > 100) || get_option('strictlyautotagcount') > 250){
			
			// removed logic as not neccessary
			echo '<p>'. sprintf(__('Strictly AutoTags has automatically generated <strong>%s tags</strong> since %s.', 'strictly-autotags'),number_format($tagged),$installdate).'</p>';
				
		}		
		
		
		echo '<p>'.__('Please remember that this plugin has been developed for the <strong>English language</strong> and will only work with standard English characters e.g A-Z. If you have any problems with the plugin please check that it is not due to UTF-8 characters within the articles you are trying to auto tag.', 'strictly-autotags').'</p>
				<ul><li>'.__('Enable Auto Discovery to find new tags.', 'strictly-autotags').'</li>
				<li>'.__('Suitable words such as acronyms, names, countries and other important keywords will then be identified within the post.', 'strictly-autotags').'</li>
				<li>'.__('Existing tags will also be used to find relevant tags within the post.', 'strictly-autotags').'</li>
				<li>'.__('Set the maximum number of tags to append to a post to a suitable amount. Setting the number too high could mean that tags that only appear once might be added.', 'strictly-autotags').'</li>
				<li>'.__('Treat tags found in the post title, H1 or strong tags as especially important by enabling the Rank Title and Rank HTML options.', 'strictly-autotags').'</li>
				<li>'.__('Handle badly formatted content by setting the Ignore Capitals Percentage to an appropiate amount.', 'strictly-autotags').'</li>
				<li>'.__('Aid Search Engine Optimisation by bolding your matched tags to emphasis to search engines the important terms within your articles.', 'strictly-autotags').'</li>
				<li>'.__('Also help your internal SEO by deeplinking a certain number of tags per article to their related tag page.', 'strictly-autotags').'</li>
				<li>'.__('Set the Max Tag Words setting to an appropriate value to prevent long capitalised sentences from matching during auto discovery.', 'strictly-autotags').'</li>					
				<li>'.__('Only the most frequently occurring tags will be added against the post.', 'strictly-autotags').'</li>
				<li>'.__('Re-Tag all your existing posts in one go or just those currently without tags.','strictly-autotags').'</li>
				<li>'.__('Re-Tag and Re-Link all your existing posts in one go or just those currently without tags.','strictly-autotags').'</li>
				<li>'.__('Quickly clean up your system by removing under used saved tags or noise words that have already been tagged.','strictly-autotags').'</li></ul>
				</div>
				</div>';

				
		echo	'<div class="postbox">						
					<h3 class="hndle">'.__('Test Post For Tagging', 'strictly-autotags') .'</h3>					
					<div class="inside">
						<p>If you are having problems generating tags then please create a test post with the following text to see if the plugin is working. Ensure Auto Disovery is enabled when you do this test. A draft posting will be enough to see if tags are generated.</p><p>If no tags are generated then you have an issue. If tags are generated then the plugin works and if you still have problems then do the standard tests which are listed in the Readme.txt file and are on my <a href="http://facebook/strictlysoftware">Facebook/strictlysoftware</a> page at <a href="https://www.facebook.com/strictlysoftware/posts/364830366999257" title="Fixes for problems with Strictly AutoTags">Strictly AutoTag Debugging.</a></p>
						<p><strong>Post Title:</strong> The CIA now admits responsibility for torture at Guantanamo Bay</p>
						<p><strong>Article Content:</strong><pre>Today the CIA admitted it was responsible for the recent accusations of torture at Guantanamo Bay.<br />Billy Bob Johnson, the chief station manager at the Guantanamo Bay prison said that the USA had to hold its hands up and admit that it had allowed its CIA operatives to feed the prisoners nothing but<br />McDonalds and Kentucky Fried Chicken meals whilst forcing them to listen to Christian Rock Music for up to 20 hour periods at a time without any break. The CIA apologised for the allegations and promised<br />to review its policy of using fast food and Christian Rock Music as a method of torture.</pre></p><p>Save this as a draft post and see what tags appear. As long as they are not in the noise word lists and you have auto discovery on at least a few tags should be found.</p>
					</div>
				</div>';

		
		echo	'<form name="retag" id="retag" method="post">
				<div class="postbox">						
					<h3 class="hndle">'.__('Re-Tag Existing Posts', 'strictly-autotags').'</h3>					
					<div class="inside">
				'. wp_nonce_field("retag","strictlyretagnonce",false,false) .'
				<div class="tagopt">
				<label for="strictlyautotags-tagless">'.__('Re-Tag All Posts','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-tagless" id="strictlyautotags-tagless" value="true" ' . ((!IsNothing($allposts)) ? 'checked="checked"' : '') . '/>
				<span class="notes">'.__('Checking this will option will mean that all your posts will be re-tagged otherwise only posts without any current tags will be parsed for appropriate tags.', 'strictly-autotags').'</span>
				</div>
				<p class="submit"><input value="'.__('Re-Tag Posts', 'strictly-autotags').'" type="submit" name="RepostSubmit" id="RepostSubmit"></p>
				</div></div></form>';

		echo	'<form name="retag2" id="retag2" method="post">
				<div class="postbox">						
					<h3 class="hndle">'.__('Re-Tag and Re-Link Existing Posts', 'strictly-autotags').'</h3>					
					<div class="inside">
				'. wp_nonce_field("retag2","strictlyretagnonce",false,false) .'
				<div class="tagopt">
				<label for="strictlyautotags-tagless2">'.__('Re-Tag and Re-Link All Posts','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-tagless2" id="strictlyautotags-tagless2" value="true" ' . ((!IsNothing($allposts)) ? 'checked="checked"' : '') . '/>
				<span class="notes">'.__('Checking this will option will mean that all your posts will be re-tagged and deeplinked otherwise only posts without any current tags will be parsed for appropriate tags.', 'strictly-autotags').'</span>
				</div>
				<p class="submit"><input value="'.__('Re-Link and Re-Tag Posts', 'strictly-autotags').'" type="submit" name="RelinkSubmit" id="RelinkSubmit"></p>
				</div></div></form>';		

		echo	'<form name="cleantag2" id="cleantag2" method="post">
				<div class="postbox">						
					<h3 class="hndle">'.__('Remove Deeplinking and Bolded HTML from existing posts - Tags Will Remain', 'strictly-autotags').'</h3>					
					<div class="inside">
				'. wp_nonce_field("cleantag2","strictlycleantagsnonce",false,false) .'
				<div class="tagopt">
				<label for="strictlyautotags-cleanhtml">'.__('Remove AutoTagging HTML','strictly-autotags').'</label><span class="notes">'.__('Selecting this will mean that all your posts will be re-scanned and any HTML from the deeplinking or bolding will be removed. Tags against articles will remain though. On big systems this could take a very long time depending on the number of posts.', 'strictly-autotags').'</span>
				</div>
				<p class="submit"><input value="'.__('Clean Tag HTML From Posts', 'strictly-autotags').'" type="submit" name="CleanHTML" id="CleanHTML"></p>
				</div></div></form>';	

		echo	'<form name="cleanup" id="cleanup" method="post">
				<div class="postbox">						
				<h3 class="hndle">'.__('Clean Up Tag Database (Backup Database First!)', 'strictly-autotags').'</h3>					
				<div class="inside">
				'. wp_nonce_field("cleanup","strictlycleanupnonce",false,false) .'				
				<p>'.sprintf(__('You currently have %d tags that are only associated with %d or less posts.', 'strictly-autotags'), $underused,$notags).'</p>
				<div class="tagopt">
				<label for="strictlyautotags-cleanupposts">'.__('No of Tagged Posts','strictly-autotags').'</label>
				<input type="text" name="strictlyautotags-cleanupposts" id="strictlyautotags-cleanupposts" value="' . esc_attr($notags) . '" />		
				<span class="notes">'.__('Strictly AutoTags can add a lot of tags into your system very quickly and to keep things fast and your tag numbers down it is advisable to clean up your tags reguarly. You may find that you have lots of articles with only one post related to a tag or you may have deleted articles which will have created orphan tags not associated with any articles at all. You should consider deleting redudant or under used tags if you feel they are not providing any benefit to your site. Change the number to the amount of posts to delete tags for e.g selecting 1 means any tags that are associated with 0 or 1 posts will be removed. If you want to know which tags to delete you should use the standard Wordpress Post Tags admin option to manually check and remove tags one by one. You should always backup your database before removing any data from the system!', 'strictly-autotags').'</span>
				</div>
				<p class="submit"><input value="'.__('Clean Tags', 'strictly-autotags').'" type="submit" name="CleanSubmit" id="CleanSubmit" onclick="return confirm(\'Are you sure you want to remove these tags from your system?\');"></p>
				</div></div></form>';

		
		echo	'<form method="post">
				<div class="postbox">						
				<h3 class="hndle">'.__('AutoTag Options', 'strictly-autotags').'</h3>					
				<div class="inside">
				'. wp_nonce_field("tagoptions","strictlytagoptionsnonce",false,false) ;

		echo	'<div class="tagopt">
				<label for="strictlyautotags-uninstall">'.__('Uninstall Plugin when deactivated', 'strictly-autotags').'</label><input type="checkbox" name="strictlyautotags-uninstall" id="strictlyautotags-uninstall" value="true" ' . (($this->uninstall) ? 'checked="checked"' : '') . '/>
				<span class="notes">'.__('Remove all plugin related data and configuration options when the plugin is de-activated.', 'strictly-autotags').'</span>
				</div>';
	
		echo	'<div class="tagopt">
				<label for="strictlyautotags-autodiscover">'.__('Auto Discovery','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-autodiscover" id="strictlyautotags-autodiscover" value="true" ' . (($options['autodiscover']) ? 'checked="checked"' : '') . '/>				
				<span class="notes">'.__('Automatically discover new tags on each post.', 'strictly-autotags').'</span>
				</div>';

		echo	'<div class="tagopt">
				<label for="strictlyautotags-skip_tagged_posts">'.__('Skip Pre-Tagged Posts','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-skip_tagged_posts" id="strictlyautotags-skip_tagged_posts" value="true" ' . (($options['skiptaggedposts']) ? 'checked="checked"' : '') . '/>				
				<span class="notes">'.__('Don\'t AutoTag posts that already have been tagged. Ideally set this to true, then let the plugin tag your posts when you save a draft copy of your article before manually adding/removing any tags yourself and publishing. On the second save the post won\'t be scanned for tags or have any SEO work or reformatting carried out on it.', 'strictly-autotags').'</span>
				</div>';
		


		echo	'<div class="tagopt">
				<label for="strictlyautotags-ranktitle">'.__('Rank Title','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-ranktitle" id="strictlyautotags-ranktitle" value="true" ' . (($options['ranktitle']) ? 'checked="checked"' : '') . '/>				
				<span class="notes">'.__('Rank tags found within the post title over those found within the article content.', 'strictly-autotags').'</span>
				</div>';

		echo	'<div class="tagopt">
				<label for="strictlyautotags-rankhtml">'.__('Rank HTML','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-rankhtml" id="strictlyautotags-rankhtml" value="true" ' . (($options['rankhtml']) ? 'checked="checked"' : '') . '/>				
				<span class="notes">'.__('Rank tags found in H1,H2,H3,H4,H5,H6,STRONG,EM,A and B tags more importantly than those found in other content. The score given to each match is weighted so that a match found within an H1 tag is ranked higher than a match within an H6 or strong tag.', 'strictly-autotags').'</span>
				</div>';


		echo	'<div class="tagopt">
				<label for="strictlyautotags-maxtags">'.__('Max Tags','strictly-autotags').'</label>
				<input type="text" name="strictlyautotags-maxtags" id="strictlyautotags-maxtags" value="' . esc_attr($options['maxtags']) . '" />
				<span class="notes">'.__('Maximum no of tags to save (20 max).', 'strictly-autotags').'</span>
				</div>';

		
		echo	'<div class="tagopt">
				<label for="strictlyautotags-maxtagwords">'.__('Max Tag Words','strictly-autotags').'</label>
				<input type="text" name="strictlyautotags-maxtagwords" id="strictlyautotags-maxtagwords" value="' . esc_attr($options['maxtagwords']) . '" />
				<span class="notes">'.__('Set the maximum number of words a saved tag can have or set it to 0 to save tags of all sizes.', 'strictly-autotags').'</span>
				</div>';



		echo	'<div class="tagopt">
				<label for="strictlyautotags-boldtaggedwords">'.__('Bold Tagged Words','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-boldtaggedwords" id="strictlyautotags-boldtaggedwords" value="true" ' . (($options['boldtaggedwords']) ? 'checked="checked"' : '') . '/>				
				<span class="notes">'.__('Wrap matched tags found within the post article with &lt;strong&gt; tags to aid SEO and empahsis your tags to readers.', 'strictly-autotags').'</span>
				</div>';

		echo	'<div class="tagopt">
				<label for="strictlyautotags-taglinks">'.__('Deeplink Tagged Words','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-taglinks" id="strictlyautotags-taglinks" value="true" ' . (($options['taglinks']) ? 'checked="checked"' : '') . '/>				
				<span class="notes">'.__('Wrap matched tags found within the post article with links to the relevant tag page. This aids SEO by deeplinking your site.', 'strictly-autotags').'</span>
				</div>';



		echo	'<div class="tagopt">
				<label for="strictlyautotags-deeplinktitle">'.__('Deeplink Anchor Title','strictly-autotags').'</label>
				<input type="text" name="strictlyautotags-deeplinktitle" id="strictlyautotags-deeplinktitle" value="' . esc_attr($options['deeplinktitle']) . '" />
				<span class="notes">'.__('The title to use for deeplinked anchor tags. Use %post_tag% for the placeholder where the tag word will appear e.g <strong>&quot;View all posts for this %post_tag% here&quot;</strong>.', 'strictly-autotags').'</span>
				</div>';


		echo	'<div class="tagopt">
				<label for="strictlyautotags-maxtagstolink">'.__('Max Tags to Deeplink','strictly-autotags').'</label>
				<input type="text" name="strictlyautotags-maxtagstolink" id="strictlyautotags-maxtagstolink" value="' . esc_attr($options['maxtagstolink']) . '" />
				<span class="notes">'.__('Set the maximum number of tags within a post to deeplink.', 'strictly-autotags').'</span>
				</div>';

		echo	'<div class="tagopt">
				<label for="strictlyautotags-minpoststotaglink">'.__('Min no of Tags within a Post to deeplink to.','strictly-autotags').'</label>
				<input type="text" name="strictlyautotags-minpoststotaglink" id="strictlyautotags-minpoststotaglink" value="' . esc_attr($options['minpoststotaglink']) . '" />
				<span class="notes">'.__('Set the minimum number of tags that a post must have before deeplinking to their tag page.', 'strictly-autotags').'</span>
				</div>';


		echo	'<div class="tagopt">
				<label for="strictlyautotags-remove">'.__('Remove Basic Format Tags','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-taglinks" id="strictlyautotags-taglinks" value="true" ' . (($options['taglinks']) ? 'checked="checked"' : '') . '/>				
				<span class="notes">'.__('Wrap matched tags found within the post article with links to the relevant tag page. This aids SEO by deeplinking your site.', 'strictly-autotags').'</span>
				</div>';


		echo	'<div class="tagopt">
				<label for="strictlyautotags-remove_strictly_tags_and_links">'.__('Always Cleanup on Re-Save','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-remove_strictly_tags_and_links" id="strictlyautotags-remove_strictly_tags_and_links" value="true" ' . (($options['removestrictlytagsandlinks']) ? 'checked="checked"' : '') . '/>						
				<span class="notes">'.__('Whether to always remove any deeplinked or bolded tags on re-saving a post in case those tags have been removed. Will take longer to run and not always required.', 'strictly-autotags').'</span>
				</div>';

	
		echo	'<div class="tagopt">
				<label for="strictlyautotags-ignorepercentage">'.__('Ignore Capitals Percentage','strictly-autotags').'</label>
				<input type="text" name="strictlyautotags-ignorepercentage" id="strictlyautotags-ignorepercentage" value="' . $options['ignorepercentage'] . '" />				
				<span class="notes">'.__('Badly formatted content that contains too many capitalised words can cause false positives when discovering new tags. This option allows you to tell the system to ignore auto discovery if the percentage of capitalised words is greater than the specified threshold. Set to 0 to turn off this feature.', 'strictly-autotags').'</span>
				</div>';

		echo	'<div class="tagopt">
				<input type="radio" name="strictlyautotags-nestedtags" id="strictlyautotags-nestedtagslong" value="' . AUTOTAG_LONG . '" ' . (($options['nestedtags'] == AUTOTAG_LONG) ? 'checked="checked"' : '') . '/><label for="strictlyautotags-nestedtagslong">'.__('Tag Longest Version','strictly-autotags').'</label>
				<input type="radio" name="strictlyautotags-nestedtags" id="strictlyautotags-nestedtagsboth" value="' . AUTOTAG_BOTH . '" ' . ((IsNothing($options['nestedtags']) || $options['nestedtags']==AUTOTAG_BOTH  ) ? 'checked="checked"' : '') . '/><label for="strictlyautotags-nestedtagsboth">'.__('Tag All Versions','strictly-autotags').'</label>
				<input type="radio" name="strictlyautotags-nestedtags" id="strictlyautotags-nestedtagsshort" value="' . AUTOTAG_SHORT . '" ' . (($options['nestedtags'] == AUTOTAG_SHORT) ? 'checked="checked"' : '') . '/><label for="strictlyautotags-nestedtagsshort">'.__('Tag Shortest Version','strictly-autotags').'</label>				
				<span class="notes">'.__('This option determines how nested tags are handled e.g <strong><em>New York, New York City, New York City Fire Department</em></strong> all contain the words <strong><em>New York</em></strong>. Setting this option to <strong>Tag All</strong> will mean all 3 get tagged. Setting it to <strong>Tag shortest</strong> will mean the shortest match e.g <strong><em>New York</em></strong> gets tagged and setting it to <strong>Tag Longest</strong> means that only exact matches get tagged.', 'strictly-autotags').'</span>
				</div>';

		echo	'<div class="tagopt">
				<label id="lblnoisewords" for="strictlyautotags-noisewords">'.__('Noise Words','strictly-autotags').'</label>
				<textarea name="strictlyautotags-noisewords" id="strictlyautotags-noisewords" style="width:100%;">' . esc_attr($options['noisewords']) . '</textarea>
				</div>
				<div class="tagopt">
				<label id="lblnoisewords" for="strictlyautotags-noisewords-case-sensitive">'.__('Case Sensitive Noise Words','strictly-autotags').'</label>
				<textarea name="strictlyautotags-noisewords-case-sensitive" id="strictlyautotags-noisewords-case-sensitive" style="width:100%;" >' . esc_attr($options['noisewords_case_sensitive']) . '</textarea>
				</div>
				<div class="tagopt">
				<label for="strictlyautotags-removenoise">'.__('Remove Saved Noise Tags','strictly-autotags').'</label>
				<input type="checkbox" name="strictlyautotags-removenoise" id="strictlyautotags-removenoise" value="false" />				
				<span class="notes">'.__('Noise words or stop words, are commonly used English words like <strong><em>any, or, and</em></strong> that are stripped from the content before analysis as you wouldn\'t want these words being used as tags. Please ensure all words are separated by a pipe | character e.g <strong>a|and|at|as</strong>.) <strong>Whenever you add new noise words to the list you should make sure they are removed from the existing list of saved post tags otherwise they might still get matched. Ticking the Remove Saved Noise Tags option when saving will do this for you. </strong><br />If you want to treat particular words or phrases in a case sensitive manner then add them to the <strong>Case Sensitive Noise Words List.</strong>', 'strictly-autotags').'</span>
				</div>';

		echo	'<p class="submit"><input value="'.__('Save Options', 'strictly-autotags').'" type="submit" name="SaveOptionsSubmit" id="SaveOptionsSubmit"></p></div></div></form>';

		echo	'<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<div class="postbox">						
				<h3 class="hndle">'.__('Donate to Stictly Software', 'strictly-autotags').'</h3>					
				<div class="inside donate">';		

		echo	'<p>'.__('Please dontate to help me keep just one version of this plugin active and not keep all the best features for those who pay.', 'strictly-autotags').'</p>';
		
		echo	'<div style="text-align:center;"><br /><br />
				<input type="hidden" name="cmd" value="_s-xclick"><br />
				<input type="hidden" name="hosted_button_id" value="6427652"><br />
				<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
				<br /></div></div></div></form>
				
				<div class="postbox">						
				<h3 class="hndle">'.__('Stictly Software Recommendations', 'strictly-autotags').'</h3>					
				<div class="inside">				
					<p>'.__('If you enjoy using this Wordpress plugin you might be interested in some other websites, tools and plugins I have developed.', 'strictly-autotags').'</p>
					<ul>
						<li><a href="http://www.strictly-software.com/plugins/strictly-auto-tags">'.__('Strictly AutoTags','strictly-autotags').'</a>
							<p>' . sprintf(__('Strictly AutoTags %s is the latest pay only version of this plugin that you can buy for &pound;40. Due to the lack of donations I have received so far I am keeping this new version for people who really want it. Not only does it offer the ability to use equivalent words for tags e.g match <strong>Snowden,NSA,GCHQ</strong> and tag the word <strong>Internet Privacy</strong>, but it has new functions to match words like al-Qaeda or 1,000 Guineas, convert plain (strong and weak) text links into real anchors, set a minimum character length and a maximum word count a tag must have to be used and also a new cleanup mode that lets you edit individual articles and remove HTML the plugin adds to aid SEO if you need it to. There is also a new function to remove basic styling tags if you need to, great for auto-bloggers. You can buy this plugin direct from my site. However if everyone using this plugin who liked it donated me a single &pound; I wouldn\'t need to do this so please consider it if you like this plugins features.','strictly-autotags'), $this->paid_version) .'</p>
						</li>
						<li><a href="http://wordpress.org/extend/plugins/strictly-tweetbot/">'.__('Strictly Tweetbot','strictly-autotags').'</a>
							<p>'.__('Strictly Tweetbot is a Wordpress plugin that allows you to automatically post tweets to multiple accounts or multiple tweets to the same account whenever a post is added to your site. Features include: Content Analysis, Tweet formatting and the ability to use tags or categories as hash tags, OAuth PIN code authorisation and Tweet Reports.','strictly-autotags').'</p>
						</li>
						<li><a href="http://wordpress.org/extend/plugins/strictly-system-check/">'.__('Strictly System Check','strictly-autotags').'</a>
							<p>'.__('Strictly System Check is a Wordpress plugin that allows you to automatically check your sites status at scheduled intervals to ensure it\'s running smoothly and it will run some system checks and send you an email if anything doesn\'t meet your requirements.','strictly-autotags').'</p>
						</li>
						<li><a href="http://www.strictly-software.com/online-tools">'.__('Strictly Online Tools','strictly-autotags').'</a>
							<p>'.__('Strictly Online Tools is a suite of free online tools I have developed which include encoders, unpackers, translators, compressors, scanners and much more.','strictly-autotags').'</p>
						</li>
						<li><a href="http://www.ukhorseracingtipster.com">'.__('UK Horse Racing Tipster','strictly-autotags').'</a>
							<p>'.__('If you like Horse Racing and earning BIG profits from betting on it then this is the site for you. Get the latest racing news, free tips by email and cheap membership by week, month and year for premium high ROI tips that have been proven again and again!','strictly-autotags').'</p>
						</li>
						<li><a href="http://www.fromthestables.com">'.__('From The Stables','strictly-autotags').'</a>
							<p>'.__('If you like horse racing or betting and want that extra edge when using Betfair then this site is for you. It\'s a members only site that gives you inside information straight from the UK\'s top racing trainers every day. We reguarly post up to 5 winners a day and our members have won thousands since we started in 2010.','StrictlySystemCheck').'</p>
						</li>
						<li><a href="http://www.darkpolitricks.com">'.__('Dark Politricks  ','strictly-autotags').'</a>
							<p>'.__('Tired of being fed news from inside the box? Want to know the important news that the mainstream media doesn\'t want to report on? Then this site is for you. Alternative news, comment and analysis all in one place.','strictly-autotags').'</p>
						</li>						
					</ul>
				</div>			
				</div>';

	}
}


class StrictlyAutoTagControl{

	
	private static $StrictlyAutoTag;


	/**
	 * Init is called on every page not just when the plugin is activated and creates an instance of my strictly autotag class if it doesn't already exist
	 *
	 */
	public static function Init(){
		
		if(!isset(StrictlyAutoTagControl::$StrictlyAutoTag)){
			// create class and all the good stuff that comes with it
			StrictlyAutoTagControl::$StrictlyAutoTag = new StrictlyAutoTags(); 
		}

	}
	

	/**
	 * Called when plugin is deactivated and removes all the settings related to the plugin
	 *
	 */
	public static function Deactivate(){

		if(get_option('strictlyautotag_uninstall')){

			delete_option("strictlyautotags");
			delete_option("strictlyautotagcount");
			delete_option("strictlyautotag_uninstall");			
			delete_option("strictlyautotag_install_date");

			// no longer use this option so if it exists then delete it / might already have gone but this wont raise an error			
			delete_option("strictlyautotag_install_type");			
			
		}

	}

	/**
	 * Called when plugin is activated and adds new options or removes old ones
	 *
	 */
	public static function Activate(){

		StrictlyAutoTagControl::UpgradedOptions();		

	}

	/**
	 * Add and set any new options for upgraded plugins
	 *
	 */
	public static function UpgradedOptions(){

				
		// no longer use this so delete if it exists
		delete_option("strictlyautotag_install_type");					

		// log the install date if we haven't already got one
		if(!get_option('strictlyautotag_install_date')){
			update_option('strictlyautotag_install_date', current_time('mysql'));
		}

		// create and initialise counter
		if(!get_option('strictlyautotagcount')){
			update_option('strictlyautotagcount',0);
		}
	}
}

// register my activate hook to setup the plugin
register_activation_hook(__FILE__, 'StrictlyAutoTagControl::Activate');

// register my deactivate hook to ensure when the plugin is deactivated everything is cleaned up
register_deactivation_hook(__FILE__, 'StrictlyAutoTagControl::Deactivate');

add_action('init', 'StrictlyAutoTagControl::Init');


?>
