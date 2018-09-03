<?php
/*
Template Name: Packshot
*/

if($_GET['preview'] == true || isset($_GET['page_id'])) {
	get_header();
    $args = array('page_id' => $_GET['preview_id']);
    $package = getPackagePreview($package_id);
} else {
    $args = array(
        'wpse18703_title' => $package_id,
        'post_type' => 'page'
    );
}

$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();





if(isset($package->error)){
	if($package->error->message == 'Function ("getPackagePreview") is not a valid method for this service'){
		print "Preview Function not available";
	}else{
		print "Preview not available";
	}
	exit();
}
if(!isset($package_id)){
	$package_id = $the_query->posts[0]->post_title;
}

$custom_fields = get_post_custom(); 
$artist = unserialize($custom_fields['artist'][0]);

?>

<section>
    <main>
        <div class="title">
            <h1><?php echo $artist['name'];?></h1>
            <h1><?php echo $artist['album'];?></h1>
            <h4><?php echo $artist['company'];?></h4>
        </div>
        <p>
            <?php 
            global $more;    // Declare global $more (before the loop).
            $more = 0;       // Set (inside the loop) to display content above the more tag.
            the_content('');
            ?>
        </p>
        <div class="more_button btn">Read more</div>
        <div class="more_content">
            <?php 
                global $more;    // Declare global $more (before the loop).
                $more = 1;       // Set (inside the loop) to display content above the more tag.
                the_content('', true);
            ?>
        </div>
        <div class="social">
<?php
if($artist['twitter'] != '') {
?>
            <a href="http://www.twitter.com/<?php echo $artist['twitter'];?>" class="social_icons"><i class="twitter"></i></a>
<?php
}
if($artist['facebook'] != '') {
?>
            <a href="<?php echo $artist['facebook'];?>" class="social_icons"><i class="facebook"></i></a>
<?php
}
if($artist['music'] != '') {
?>
            <a href="<?php echo $artist['music'];?>" class="social_icons"><i class="music_note"></i></a>
<?
}
?>
        </div>
    </main>
    
    <aside>
        <?php the_post_thumbnail('full');?>
        <?php
       // if($_GET['preview'] == true) {
        //    echo '<p>The player is only visible from an email link.</p>';
       // } else {
        ?>
        <div class="player">
            <?php
                $tracks = $package->tracks;
         
            ?>
            <audio id="player" controls="controls">
                <source id="mp3_src" src="<?php echo $package->preview_links->B2GWO8JXX9XBJHGX;?>" type="audio/mp3" />
                Your browser does not support the audio element.
            </audio>
        </div>

        <div class="tracks">
<?php
$i = 1;
if(is_array($tracks)){
	foreach($tracks as $track) {
	    $track_det = getTrack($track->uid);
	    echo '<div>';
	    echo '<span class="track_number">';
	    echo $i;
	    echo '</span>';
	    echo '<span class="download_btns">';
	    echo '<a href="#" class="play_btn" data-link="'.$package->preview_links->{$track->uid}.'"></a>';
	    echo '<a href="#" class="dl_btn" data-div="'.$track->uid.'_dl"></a>';
	    echo '</span>';
	    echo $track_det->track->artist.'<br />';
	    echo $track_det->track->track_name;
	    if($track_det->track->mix_name != '') {
	        echo '<br />';    
	        echo '('.$track_det->track->mix_name.')';
	    }
	    echo '</div>';
	    echo '<div id="'.$track->uid.'_dl" class="dl_area">';
	    $formats = $package->formats;
	    foreach($formats as $format) {
	        echo '<a href="'.$package->download_links->tracks->{$track->uid}->{$format->format}->link.'">'.$format->name.'</a><br />';
	    }
	    echo '</div>';
	    $i++;
	}
}
?>
        </div>
        <a href="#" class="btn download_all_btn">Download All</a>
        <a href="mailto:<?php echo $artist['comment_email'];?>?subject=Package <?php echo $package_id;?>" class="btn comment_btn">Comment <i class="icon"></i></a>
        <div class="download_all dl_area">
            <?php
$formats = $package->formats;
if(is_array($formats)){
	foreach($formats as $format) {
	    echo '<a href="'.$package->download_links->all->{$format->format}->link.'">'.$format->name.'</a><br />';
	}
}
?>
        </div>
        <?php // } ?>
    </aside>
</section>

<?php endwhile; else : ?>
    <section><?php _e( 'Sorry, no posts matched your criteria.' ); ?></section>
<?php endif; ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.more_button').click(function() {
            jQuery('.more_content').slideToggle();
            var text = jQuery('.more_button').text();
            jQuery('.more_button').text(text == "Read more" ? "Read less" : "Read more");
        });
        
        jQuery('.dl_btn').click(function(e) {
            e.preventDefault();
            div = jQuery(this).attr('data-div');
            jQuery('#'+div).slideToggle();
        });
        
        jQuery('.download_all_btn').click(function(e) {
            e.preventDefault();
            jQuery('.download_all').slideToggle();
        });
        
        jQuery('.play_btn').click(function(e) {
            e.preventDefault();
            load_track = jQuery(this).attr('data-link');
            change_track(load_track);
        }); 
        function change_track(sourceUrl) {
            var audio = jQuery("#player");      
            jQuery("#mp3_src").attr("src", sourceUrl);
            /****************/
            audio[0].pause();
            audio[0].load();//suspends and restores all audio element
            audio[0].play();
            /****************/
        }
    });
</script>

<footer>
    <div class="logo">
        <img src="<?php echo get_template_directory_uri();?>/img/logo.png" />
    </div>
    <div class="social">
        <a href="#" class="social_icons small"><i class="twitter"></i></a>
        <a href="#" class="social_icons small"><i class="facebook"></i></a>
        <a href="#" class="social_icons small"><i class="music_note"></i></a>
    </div>
</footer>
<?php if($_GET['preview'] == true) { get_footer(); } ?>