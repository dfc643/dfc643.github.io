</section>
<footer class="footer">
    <div class="footer-inner">
        <div class="copyright pull-left">
         Copyright © 2011-<?php echo date("Y"); ?> FC-System Computer Inc All Rights Reserved.
        </div>
        <div class="trackcode pull-right">
            <?php if( dopt('d_track_b') ) echo dopt('d_track'); ?>
        </div>
    </div>
</footer>

<?php 
wp_footer(); 
global $dHasShare; 
if($dHasShare == true){ 
	echo'';
}  
if( dopt('d_footcode_b') ) echo dopt('d_footcode'); 
?>
</body>
</html>
