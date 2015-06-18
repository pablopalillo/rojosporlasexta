<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
HOLA HOLA HOLA
<?php if ( is_single() ) : ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="entry-title"><?php the_title(); ?></h1>
	<div class="meta">
		<?php echo get_post_meta( get_the_ID(), 'genero', true ); ?> 
		<?php if( $tarima = get_post_meta( get_the_ID(), 'tarima', true ) ) echo ' / ' . $tarima; ?>
		<?php if( $fecha = get_post_meta( get_the_ID(), 'fecha', true ) ) echo ' / ' . $fecha; ?>
		<?php if( $hora = get_post_meta( get_the_ID(), 'hora', true ) ) echo ', ' . $hora; ?>
	</div>
	<div class="content">
		<?php the_content(); ?>
		<div class="row enlaces">
			<h2 class="col-sm-12">Enlaces</h2>
		<?php
		  $cfs = get_post_custom(get_the_ID());
		  foreach($cfs as $k => $v){
		  	if($k != '_edit_last' && $k != '_edit_lock' && $k != 'genero' && $k != 'tarima' && 
		  	   $k != 'fecha' && $k != 'hora' && $k != 'presentacion' && $k != '_thumbnail_id' ): ?>
		  	<a href="<?php echo $v[0] ?>" class="<?php echo $k ?> col-sm-6" target="_blank" rel="nofollow"><?php echo $v[0] ?></a>
		  	<?php endif;
		  }
		?>
		</div>
		<?php if($presentacion = get_post_meta( get_the_ID(), 'presentacion', true )): ?>
		<div class="row">
			<h2>Presentación en Altavoz 2013</h2>
			<?php echo $presentacion ?> 
		</div>
		<?php endif; ?>
	</div>
</article><!-- #post -->
<?php else: ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-3 col-xs-4 col-xxs-6'); ?>>
	<a href="<?php the_permalink(); ?>" rel="bookmark">
	<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail('thumbnail'); ?>
		</div>
	<?php endif; ?>
	<?php $tarima = get_post_meta( get_the_ID(), 'tarima', true );
		if($tarima): ?>
			<p><?php echo $tarima ?></p>
		<?php endif; ?>
	</a>
</article><!-- #post -->
<?php endif; // is_single() ?>
