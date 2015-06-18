<?php
/*
* Pagina
*/
?>
<?php get_header(); ?>


<header class="page-header">
	<div class="row">
		<?php get_template_part('menu'); ?>
		<div class="col-sm-9" id="main-content">
		<?php if(function_exists('kc_add_social_share')): ?>
			<div id="share"><?php kc_add_social_share(); ?></div>
		<?php endif ?>
		</div>
	</div>
	<h1 class="titulo-principal">

		<?php if (is_page())
		{
			single_cat_title() ;
		} elseif (is_tag()) 
		{
			single_tag_title();
		} 
		elseif (is_author()) 
		{
			get_the_author_meta('display_name');

		} elseif (is_day()) 
		{
			the_time('l, F j, Y');
		} elseif (is_month()) 
		{
			the_time('F Y');
		} elseif (is_year()) 
		{
			the_time('Y');
		}
		?>
	</h1>
</header><!-- .page-header -->

<div id="primary" role="main">
	

	<div >
			<!-- Contenido de la pagina -->
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>

			<?php the_content(); ?>

			<?php endwhile; ?>
			<?php endif; ?>
	</div>

</div><!-- #primary -->

<?php
get_footer();