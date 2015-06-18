<?php get_header(); ?>
	<div class="row">
		<?php get_template_part('menu'); ?>
		<div class="col-sm-9" id="main-content">
		<?php if(function_exists('kc_add_social_share')): ?>
			<div id="share"><?php kc_add_social_share(); ?></div>
		<?php endif ?>
		<?php if(is_home()): ?>
			<div class="row">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar2') ) : ?><?php endif; ?>
			</div>
			<div class="row sociales-home">
				<div class="col-md-6 col-sm-12">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar3') ) : ?><?php endif; ?>
				</div>
				<div class="col-md-6 col-sm-12">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar4') ) : ?><?php endif; ?>
				</div>
			</div>
		<?php else: //is_home?>
			
			<?php if(is_single() || is_page()): ?>
				<div id="single">

				<div class="row-fluid">
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) :?>
							<?php 
								the_post();
								 get_template_part( 'content', get_post_format() );
							 ?>
						<?php endwhile; ?>
					<?php endif; //have_posts?>	
					</div>
				<?php endif; ?>
			</div>

		<?php endif; //is_home?>
		</div>
	</div>
<?php get_footer(); ?>