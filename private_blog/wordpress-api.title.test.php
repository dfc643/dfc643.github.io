<?php
define('WP_USE_THEMES', false);
require('wp-blog-header.php'); 
query_posts('showposts=5');
get_archives('postbypost', 5); 
?>