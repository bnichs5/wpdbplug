<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.2.3
*
*/
// All Postmeta
$postmeta = doo_postmeta_episodes($post->ID);
$adsingle = doo_compose_ad('_dooplay_adsingle');
$tmdbids  = doo_isset($postmeta,'ids');
$temporad = doo_isset($postmeta,'temporada');
$episode  = doo_isset($postmeta,'episodio');
$pviews   = doo_isset($postmeta,'dt_views_count');
$images   = doo_isset($postmeta, 'imagenes');
$player   = doo_isset($postmeta,'players');
$player   = maybe_unserialize($player);
$tviews   = ($pviews) ? sprintf( __d('%s Views'), $pviews) : __d('0 Views');
$dynamicbg = esc_url(doo_rand_images($images,'original',true,true));
$tvshow    = doo_get_tvpermalink($tmdbids);
// Options
$player_ads = doo_compose_ad('_dooplay_adplayer');
$player_wht = dooplay_get_option('playsize','regular');
$title_opti = dooplay_get_option('dbmvstitleepisodes','{name}: S{season} E{episode}');
// Sidebar
$sidebar = dooplay_get_option('sidebar_position_single','right');
$tvshownav = DDbmoviesHelpers::EpisodeNav($tmdbids,$temporad,$episode);
$title_data = array(
    'name'    => get_the_title($tvshow),
    'season'  => doo_isset($postmeta,'temporada'),
    'episode' => doo_isset($postmeta,'episodio')
);
// End PHP
?>
<style>#seasons .se-c .se-a ul.episodios li.mark-<?php echo $episode; ?> {opacity: 0.2;}</style>
<!-- Big Player -->
<?php DooPlayer::viewer_big($player_wht, $player_ads, $dynamicbg); ?>
<!-- Start Single -->
<div id="single" class="dtsingle">
    <!-- Edit link response Ajax -->
    <div id="edit_link"></div>
    <!-- Start Post -->
    <?php if(have_posts()) :while (have_posts()) : the_post(); ?>

    <!-- Views Counter -->
    <?php DooPlayViews::Meta($post->ID); ?>

	<div class="sbox <?php echo $sidebar; ?>">
		<!-- Episode Links -->
		<h1><center>To Play any videos from this app you will need to install VLC.</center></h1><?php if(DOO_THEME_DOWNLOAD_MOD) get_template_part('inc/parts/single/links'); ?>
	</div>
	<div class="sbox <?php echo $sidebar; ?>">
        
        <!-- Episodes paginator -->
		<?php require_once( DOO_DIR.'/inc/parts/single/listas/episode_navigator.php'); ?>
        <!-- Episode Info -->
		<div id="info" class="sbox">
			<h1 class="epih1"><?php echo dbmovies_title_tags($title_opti,$title_data); ?></h1>
			<div itemprop="description" class="wp-content">
				<h3 class="epid3"><?php echo doo_isset($postmeta,'episode_name'); ?></h3>
				<?php the_content(); dbmovies_get_images($images); ?>
			</div>
			<?php if($d = doo_isset($postmeta, 'air_date')) echo '<span class="date">'.doo_date_compose($d,false).'</span>'; ?>
		</div>
       <!-- Single Post Ad -->
        <?php if($adsingle) echo '<div class="module_single_ads">'.$adsingle.'</div>'; ?>
    </div>
	<div class="sbox <?php echo $sidebar; ?>">
        <!-- Season Episodes List -->
		<div class="sbox">
			<?php get_template_part('inc/parts/single/listas/seasons'); ?>
		</div>
        <!-- Episode comments -->
		<?php get_template_part('inc/parts/comments'); ?>
	</div>
    <!-- End Post-->
	<?php endwhile; endif; ?>
    <!-- Episode Sidebar -->
    <div class="sidebar <?php echo $sidebar; ?> scrolling">
		<?php dynamic_sidebar('sidebar-tvshows'); ?>
	</div>
    <!-- End Sidebar -->
</div>
<!-- End Single -->
