<?php 
/**
 * fsAdmin - Admin section for Flickr-stream
 *
 * @package Flickr-stream
 * @author Dustin Scarberry
 *
 * @since 1.1.5
 */
class fsAdmin
{
	
	private $_options;
	
	public function __construct()
	{
		
		//get plugin options
		$this->_options = get_option('flickrstream_main_opts');
	
		//add hooks
		add_action('admin_init', array(&$this, 'processor'));
		add_action('admin_enqueue_scripts', array(&$this, 'addScripts'));
		add_action('admin_menu', array(&$this, 'addMenus'));
		
	}
		
	public function addMenus()
	{
			
		add_menu_page('Flickr-stream', 'Flickr-stream', 'manage_options', 'flickr-stream_settings', array($this, 'option_panel'), plugins_url('flickr-stream/i/flickrstream_icon_16x16.png')); 
		add_submenu_page('flickr-stream_settings', 'Flickr-stream Shortcodes', __('Shortcodes', 'flickrstm'), 'manage_options', 'flickr-stream_settings_shortcodes', array($this, 'shortcode_panel'));
		
	}
		
	public function addScripts()
	{
		
		wp_enqueue_style('flickrstream_style', plugins_url('css/admin_style.css', __FILE__), false, null);
		wp_enqueue_script('jquery');
			
	}
	
	public function option_panel()
	{
	
		//reload options to be sure correct options are displayed
		$this->_options = get_option('flickrstream_main_opts');
		
	?>
		
		<div class="wrap" id="flickrstream_main_opts">
		
			<?php screen_icon('flickr-stream'); ?>
			
			<h2 id="fsMastHead">Flickr-stream Settings</h2>
			
			<script>
			
				jQuery(function(){
						
					jQuery('div.updated, div.e-message').delay(3000).queue(function(){jQuery(this).remove();});
					
					jQuery('#resetHighlightColor').click(function(){
						jQuery('#highlightColor').val('#397fdf');
						return false;
					});
						
				});
				
			</script>
			
			<div class="fsFormBox fsTopformBox">
				<form method="post">  
					<h3><?php _e('General Settings', 'flickrstm'); ?></h3>	
					<p>
						<label><?php _e('Flickr Api Key: ', 'flickrstm'); ?></label>
						<input type="text" name="apikey" value="<?php echo $this->_options['apikey']; ?>"/>
						<span class="fsHint"><?php _e('ex: your api key from Flickr', 'flickrstm'); ?></span>
					</p> 
					<p>
						<label><?php _e('Include Lightbox Scripts: ', 'flickrstm'); ?></label>
						<input type="checkbox" name="fancyboxInc" <?php echo ($this->_options['fancyboxInc'] == 'yes' ? 'checked' : ''); ?>/>
						<span class="fsHint"><?php _e('ex: check only if not using a Magnific Popup plugin', 'flickrstm'); ?></span>
					</p> 
					<p>
						<label><?php _e('Photo Highlight Color: ', 'flickrstm'); ?></label>
						<input type="color" name="highlightColor" id="highlightColor" value="<?php echo $this->_options['highlightColor']; ?>"/>
						<button id="resetHighlightColor" class="button-secondary">Reset</button>
						<span class="fsHint"><?php _e('ex: color value in hex format (#ffffff) to use for photo highlights', 'flickrstm'); ?></span>
					</p>
					<p>
						<label><?php _e('Use Mobile Photo Viewer: ', 'flickrstm'); ?></label>
						<input type="checkbox" name="useMobileView" <?php echo ($this->_options['useMobileView'] == 'yes' ? 'checked' : ''); ?>/>
						<span class="fsHint"><?php _e('ex: check to use mobile photo viewer for mobile devices (adds about 77kb of code)', 'flickrstm'); ?></span>
					</p> 
					<p class="submit">  
						<input type="submit" name="saveopts" value="<?php _e('Save Changes', 'flickrstm') ?>" class="button-primary"/> 
						<?php wp_nonce_field('flickrstream_update_options'); ?>							
					</p> 
				</form>	
			</div>
		</div>
			
	<?php
	}
	
	public function shortcode_panel()
	{
	
		//declare globals
		global $wpdb;
		
	?>
		
		<div class="wrap" id="flickrstream_main_opts">
		
			<?php screen_icon('flickr-stream'); ?>
			
			<h2 id="fsMastHead">Flickr-stream Shortcode Settings</h2>
			
			<script>
			
				jQuery(function(){
						
					jQuery('div.updated, div.e-message').delay(3000).queue(function(){jQuery(this).remove();});
						
				});
				
			</script>
			
			<script>
				
				jQuery(function(){
					
					jQuery('.fsConfirm').click(function(){
						
						if(!confirm('<?php _e('Are you sure you want to delete this item?', 'flickrstm'); ?>'))
							return false;
						
					});
					
				});
				
			</script>
			
			<?php
			
			if(isset($_POST['createShortcode']))
			{
				
			?>
				
				<div class="fsFormBox fsTopformBox">
					<form method="post">  
						<h3><?php _e('Create Shortcode', 'flickrstm'); ?></h3>
						<p>
							<label><?php _e('Name: ', 'flickrstm'); ?></label>
							<input type="text" name="vanityname"/>
							<span class="fsHint"><?php _e('ex: vanity name just for your reference', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Type: ', 'flickrstm'); ?></label>
							<select name="type">
								<option></option>
								<option value="Set"><?php _e('Set', 'flickrstm'); ?></option>
								<option value="Gallery"><?php _e('Gallery', 'flickrstm'); ?></option>
							</select>
							<span class="fsHint"><?php _e('ex: type of picture group', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('ID: ', 'flickrstm'); ?></label>
							<input type="text" name="id"/>
							<span class="fsHint"><?php _e('ex: id of set or gallery', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Number Of Photos: ', 'flickrstm'); ?></label> 
							<select name="photocnt">
								<option></option>
								
								<?php
						
								for($i = 1; $i < 101; $i++)			
								{				
	
									echo '<option>' . $i . '</option>';	
												
								}
								
								?>
								
							</select>
							<span class="fsHint"><?php _e('ex: number of photos to display', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Photo Selection: ', 'flickrstm'); ?></label> 
							<select name="photoselect">
								<option></option>
								<option value="Beginning"><?php _e('Beginning', 'flickrstm'); ?></option>
								<option value="Random"><?php _e('Random', 'flickrstm'); ?></option>
							</select>
							<span class="fsHint"><?php _e('ex: how to select photos', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Link Type: ', 'flickrstm'); ?></label> 
							<select name="linktype">
								<option></option>
								<option value="Image/Fancybox"><?php _e('Lightbox', 'flickrstm'); ?></option>
								<option value="Flickr"><?php _e('Flickr', 'flickrstm'); ?></option>
							</select>
							<span class="fsHint"><?php _e('ex: how to open photo links', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Thumbnail Size: ', 'flickrstm'); ?></label>
							<select name="thumbsize">
								<option></option>
								<option value="Small"><?php _e('Small', 'flickrstm'); ?></option>
								<option value="Medium"><?php _e('Medium', 'flickrstm'); ?></option>
							</select>
							<span class="fsHint"><?php _e('ex: thumbnail size to use', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Photo Alignment: ', 'flickrstm'); ?></label>	
							<select name="photoAlign">
								<option></option>
								<option value="Left"><?php _e('Left', 'flickrstm'); ?></option>
								<option value="Center"><?php _e('Center', 'flickrstm'); ?></option>
								<option value="Right"><?php _e('Right', 'flickrstm'); ?></option>		
							</select>
							<span class="fsHint"><?php _e('ex: alignment of photos in gallery/set', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Cache Data: ', 'flickrstm'); ?></label>
							<input type="checkbox" name="cachedata"/>
						</p>
						<p>
							<label><?php _e('Hide Set/Gallery Title: ', 'flickrstm'); ?></label>
							<input type="checkbox" name="hidetitle"/>
						</p>
						<p>
							<label><?php _e('Hide Captions: ', 'flickrstm'); ?></label>
							<input type="checkbox" name="hidecaption"/>
						</p>						
						<p class="submit">  
							<input type="submit" name="saveShortcode" value="<?php _e('Save New Shortcode', 'flickrstm') ?>" class="button-primary"/> 
							<?php wp_nonce_field('flickrstream_save_shortcode'); ?>
							<a href="?page=flickr-stream_settings_shortcodes" class="fsCancel"><?php _e('Go Back', 'flickrstm'); ?></a>							
						</p> 
					</form>
				</div>
					
				<?php
				
			}
			elseif(isset($_POST['editShortcode']))
			{

				$data = get_option('flickrstream_short_' . $_POST['key']);
						
			?>
						
				<div class="fsFormBox fsTopformBox">
					<form method="post">  
						<h3><?php _e('Edit Shortcode', 'flickrstm'); ?></h3>
						<p>
							<label><?php _e('Name: ', 'flickrstm'); ?></label>
							<input type="text" name="vanityname" value="<?php echo $data['vanityname']; ?>"/>
							<span class="fsHint"><?php _e('ex: vanity name just for your reference', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Type: ', 'flickrstm'); ?></label>
							<select name="type">				

								<?php					

								$opts = array(array('text' => __('Set', 'flickrstm'), 'value' => 'Set'), array('text' => __('Gallery', 'flickrstm'), 'value' => 'Gallery'));	

								foreach($opts as $val)
								{
									
									if($val['value'] == $data['type'])
										echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
									else
										echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';

								}
										
								?>	
								
							</select>
							<span class="fsHint"><?php _e('ex: type of picture group', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('ID: ', 'flickrstm'); ?></label>
							<input type="text" name="id" value="<?php echo $data['id']; ?>"/>
							<span class="fsHint"><?php _e(' ex: id of set or gallery', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Number Of Photos: ', 'flickrstm'); ?></label> 
							<select name="photocnt">
										
								<?php
						
								for($i = 1; $i < 101; $i++)			
								{				
										
									if($i == $data['photocnt'])
										echo '<option selected>' . $i . '</option>';
									else				
										echo '<option>' . $i . '</option>';	
												
								}
									
								?>
										
							</select>
							<span class="fsHint"><?php _e('ex: number of photos to display', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Photo Selection: ', 'flickrstm'); ?></label> 
							<select name="photoselect">
									
								<?php

								$opts = array(array('text' => __('Beginning', 'flickrstm'), 'value' => 'Beginning'), array('text' => __('Random', 'flickrstm'), 'value' => 'Random'));	

								foreach($opts as $val)
								{
									
									if($val['value'] == $data['photoselect'])
										echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
									else
										echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';

								}
		
								?>
						
							</select>
							<span class="fsHint"><?php _e('ex: how to select photos from Flickr', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Link Type: ', 'flickrstm'); ?></label> 
							<select name="linktype">
										
								<?php					

								$opts = array(array('text' => __('Lightbox', 'flickrstm'), 'value' => 'Image/Fancybox'), array('text' => __('Flickr', 'flickrstm'), 'value' => 'Flickr'));									
								foreach($opts as $val)
								{
									
									if($val['value'] == $data['linktype'])
										echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
									else
										echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';

								}
										
								?>
						
							</select>
							<span class="fsHint"><?php _e('ex: how to open photo links', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Thumbnail Size: ', 'flickrstm'); ?></label>
							<select name="thumbsize">
										
								<?php

								$opts = array(array('text' => __('Small', 'flickrstm'), 'value' => 'Small'), array('text' => __('Medium', 'flickrstm'), 'value' => 'Medium'));									

								foreach($opts as $val)
								{
									
									if($val['value'] == $data['thumbsize'])
										echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
									else
										echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';

								}
	
								?>
										
							</select>
							<span class="fsHint"><?php _e('ex: thumbnail size to use', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Photo Alignment: ', 'flickrstm'); ?></label>	
							<select name="photoAlign">
										
								<?php
								
								$opts = array(array('text' => __('Left', 'flickrstm'), 'value' => 'Left'), array('text' => __('Center', 'flickrstm'), 'value' => 'Center'), array('text' => __('Right', 'flickrstm'), 'value' => 'Right'));							

								foreach($opts as $val)
								{
									
									if($val['value'] == $data['photoAlign'])
										echo '<option value="' . $val['value'] . '" selected>' . $val['text'] . '</option>';
									else
										echo '<option value="' . $val['value'] . '">' . $val['text'] . '</option>';

								}
	
								?>
										
							</select>
							<span class="fsHint"><?php _e('ex: alignment of photos in gallery/set', 'flickrstm'); ?></span>
						</p>
						<p>
							<label><?php _e('Cache Data: ', 'flickrstm'); ?></label>
									
							<?php
									
							if($data['cachedata'] == 'on')			
								echo '<input type="checkbox" name="cachedata" checked/>';	
							else			
								echo '<input type="checkbox" name="cachedata"/>';					
									
							?>	

						</p>
						<p>
							<label><?php _e('Hide Set/Gallery Title: ', 'flickrstm'); ?></label>
									
							<?php
									
							if($data['hidetitle'] == 'on')			
								echo '<input type="checkbox" name="hidetitle" checked/>';	
							else			
								echo '<input type="checkbox" name="hidetitle"/>';					

							?>	
									
						</p>
						<p>
							<label><?php _e('Hide Captions: ', 'flickrstm'); ?></label>
								
							<?php
								
							if($data['hidecaption'] == 'on')			
								echo '<input type="checkbox" name="hidecaption" checked/>';	
							else			
								echo '<input type="checkbox" name="hidecaption"/>';					
								
							?>
								
						</p>
						<p class="submit">  
							<input type="submit" name="updateShortcode" value="<?php _e('Save Changes', 'flickrstm') ?>" class="button-primary"/>
							<input type="hidden" name="shortid" value="<?php echo $data['shortid']; ?>"/>
							<?php wp_nonce_field('flickrstream_update_shortcode'); ?>
							<a href="?page=flickr-stream_settings_shortcodes" class="fsCancel"><?php _e('Go Back', 'flickrstm'); ?></a>
						</p> 
					</form>
						
					<h3><?php _e('Preview: ', 'flickrstm'); ?></h3>
						
					<?php
						
					require_once 'class/fsWorkhorse.class.php';
						
					if(!empty($data))
					{

						$content = '<div class="flickrstream-embed">';
							
						$workhorse = new fsWorkhorse();
						$data = $workhorse->returnPhotos('shortcode', $data, null);
						
						if($data)
						{
						
							$content .= $data;
							$content .= '</div>';
						
						}
						else
							$content = '<div class="fs-errorbar">' . __('ERROR: BAD API KEY OR FLICKR API CALL', 'flickrstm') . '</div>';

						echo $content;
								
					}

					?>					
							
				</div>
					
			<?php	
					
			}
			else
			{
						
			?>

				<div class="fsFormBox">
					<h3><?php _e('Shortcodes', 'flickrstm'); ?></h3>
					
					<?php
					
					require_once(plugin_dir_path(__FILE__) . 'class/fsShortcodeListTable.class.php');
					
					$rows = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_name LIKE "flickrstream_short_%" ORDER BY option_name', ARRAY_A);
					
					$cells = array();
					
					foreach($rows as $val)
					{
					
						$data = unserialize($val['option_value']);
						
						array_push($cells, array(
							'ID' => $data['shortid'],
							'name' => stripslashes($data['vanityname']),
							'shortcode' => '[flickrstream id="' . $data['shortid'] . '"]',
										
							'lastupdated' => date('M j, Y @ g:ia', $data['updated']),
							'type' => $data['type'],
							'cached' => ($data['cachedata'] == 'on' ? 'Yes' : 'No'),
							'actions' => '<form method="post">
											<input class="fsLinkButton" type="submit" name="editShortcode" value="' . __('Edit', 'flickrstm') . '"/>
											<input class="fsLinkButton fsConfirm" type="submit" name="delShortcode" value="' . __('Delete', 'flickrstm') . '"/>
											<input type="hidden" name="key" value="' . $data['shortid'] . '"/>' . wp_nonce_field('flickrstream_actions') . '</form>'
						));
						
					}

					$shortcodes = new fsShortcodeListTable($cells);
					$shortcodes->prepare_items(); 
					$shortcodes->display(); 
					
					?>
					
					<form method="post">
						<p class="submit">
							<input class="button-secondary" type="submit" name="createShortcode" value="<?php _e('Create Shortcode', 'flickrstm'); ?>"/>
						</p>
					</form>
				</div>
				<div class="postbox">
					<h3 class="hndle fsPostBox"><span><?php _e("FAQ's", 'flickrstm'); ?></span></h3>
					<div class="inside">
						<div class="fsFormBox">
							<ul>
								<li>You must provide a <a href="http://www.flickr.com/services/apps/create/apply" target="_blank">valid Flickr Api key</a> in order for the plugin to work.</li>
								<li>When adding a set your must give its set id for the ID field (ie 72157632734875425). For a gallery, you should pass the entire url of the gallery (ie http://www.flickr.com/photos/davedunne/galleries/72157622248195017/).</li>
								<li>Un-installing the plugin will remove all data associated with it, including your api key, shortcodes and widget settings.</li>
								<li>To refresh the images of a cached widget or shortcode, simply click edit and then click on save changes.</li>
								<li>Only check the box to include Magnific Popup scripts if not using another Magnific Popup plugin.</li>
								<li>The hide captions option only affects Lightbox images, not Flickr links.</li>
								<li>Check the mobile viewer option to use Photoswipe for mobile devices</li>
							</ul>
						</div>
					</div>
				</div>	
					
			<?php
				
			}
				
			?>

		</div>
		
	<?php
		
	}
		
	public function processor()
	{

		if(!empty($_POST))
		{
	
			//SAVE MAIN OPTIONS//
			if(isset($_POST['saveopts']))
			{
			
				if(check_admin_referer('flickrstream_update_options'))
				{
				
					$opts['apikey'] = sanitize_text_field($_POST['apikey']);
					$opts['marker'] = $this->_options['marker'];	
					$opts['fancyboxInc'] = (isset($_POST['fancyboxInc']) ? 'yes' : 'no');
					$opts['useMobileView'] = (isset($_POST['useMobileView']) ? 'yes' : 'no');
					$opts['highlightColor'] = $_POST['highlightColor'];
					
					if(update_option('flickrstream_main_opts', $opts))
						echo '<div class="updated"><p>' . __('Settings saved', 'flickrstm') . '</p></div>'; 
					else
						echo '<div class="error"><p>' . __('Oops... something went wrong or there were no changes needed', 'flickrstm') . '</p></div>';
						
				}
						
			}
			//SAVE NEW SHORTCODE//
			elseif(isset($_POST['saveShortcode']))
			{
				
				if(check_admin_referer('flickrstream_save_shortcode'))
				{
										
					$optname = 'flickrstream_short_' . $this->_options['marker'];
							
					$ins['vanityname'] = sanitize_text_field($_POST['vanityname']);
					$ins['type'] = sanitize_text_field($_POST['type']);
					$ins['id'] = sanitize_text_field($_POST['id']);
					$ins['photocnt'] = sanitize_text_field($_POST['photocnt']);
					$ins['photoselect'] = sanitize_text_field($_POST['photoselect']);
					$ins['linktype'] = sanitize_text_field($_POST['linktype']);
					$ins['thumbsize'] = sanitize_text_field($_POST['thumbsize']);
					$ins['photoAlign'] = sanitize_text_field($_POST['photoAlign']);	
					$ins['cachedata'] = (isset($_POST['cachedata']) ? 'on' : 'off');	
					$ins['hidetitle'] = (isset($_POST['hidetitle']) ? 'on' : 'off');
					$ins['hidecaption'] = (isset($_POST['hidecaption']) ? 'on' : 'off');	
					$ins['shortid'] = $this->_options['marker'];
					$ins['updated'] = current_time('timestamp');

					if(empty($ins['vanityname']) || empty($ins['type']) || empty($ins['id']) || empty($ins['photocnt']) || empty($ins['photoselect']) || empty($ins['linktype']) || empty($ins['thumbsize']) || empty($ins['photoAlign']))
					{
					
						echo '<div class="error e-message"><p>' . __('Oops... all form fields must have a value', 'flickrstm') . '</p></div>';
						return;
						
					}
					
					if(empty($ins['shortid']))
					{
					
						echo '<div class="error e-message"><p>' . __('Oops... Some unknown error has occurred. If this persists, please contact the developer', 'flickrstm') . '</p></div>';
						return;
						
					}
					
					if(empty($this->_options['apikey']))
					{
					
						echo '<div class="error"><p>' . __('Oops... You have not provided a valid API Key in the settings menu.', 'flickrstm') . '<a href="?page=flickr-stream_settings">' . __('Enter your key', 'flickrstm') . '</a></p></div>';
						return;
					
					}
							
					if($ins['cachedata'] == 'on')
					{
							
						require 'class/fsWorkhorse.class.php';
						$fs = new fsWorkhorse();
						$ins['cache'] = $fs->returnCache($ins);
						
						if(!$ins['cache'])
						{
						
							echo '<div class="error"><p>' . __('Oops... Either your API key is invalid or there has been an issue contacting the Flickr Api.', 'flickrstm') . '</p></div>';
							return;
						
						}
												
					}
							
					$this->_options['marker']++;	
					update_option('flickrstream_main_opts', $this->_options);		
					
					if(update_option($optname, $ins))
						echo '<div class="updated"><p>' . __('Shortcode created', 'flickrstm') . '</p></div>';
					else
						echo '<div class="error e-message"><p>' . __('Oops... something went wrong', 'flickrstm') . '</p></div>';
					
				}
							
			}
			//UPDATE A SHORTCODE//
			elseif(isset($_POST['updateShortcode']))
			{
			
				if(check_admin_referer('flickrstream_update_shortcode'))
				{
			
					$ins['vanityname'] = sanitize_text_field($_POST['vanityname']);
					$ins['type'] = sanitize_text_field($_POST['type']);
					$ins['id'] = sanitize_text_field($_POST['id']);
					$ins['photocnt'] = sanitize_text_field($_POST['photocnt']);
					$ins['photoselect'] = sanitize_text_field($_POST['photoselect']);
					$ins['linktype'] = sanitize_text_field($_POST['linktype']);
					$ins['thumbsize'] = sanitize_text_field($_POST['thumbsize']);
					$ins['photoAlign'] = sanitize_text_field($_POST['photoAlign']);
					$ins['cachedata'] = (isset($_POST['cachedata']) ? 'on' : 'off');	
					$ins['hidetitle'] = (isset($_POST['hidetitle']) ? 'on' : 'off');
					$ins['hidecaption'] = (isset($_POST['hidecaption']) ? 'on' : 'off');	
					$ins['shortid'] = sanitize_text_field($_POST['shortid']);
					$ins['updated'] = current_time('timestamp');
					$optname = 'flickrstream_short_' . $ins['shortid'];
					
					if(empty($ins['vanityname']) || empty($ins['type']) || empty($ins['id']) || empty($ins['photocnt']) || empty($ins['photoselect']) || empty($ins['linktype']) || empty($ins['thumbsize']) || empty($ins['photoAlign']))
					{
					
						echo '<div class="error e-message"><p>' . __('Oops... all form fields must have a value', 'flickrstm') . '</p></div>';
						return;
						
					}
					
					if(empty($ins['shortid'])) 
					{
					
						echo '<div class="error e-message"><p>' . __('Oops... Some unknown error has occurred. If this persists, please contact the developer', 'flickrstm') . '</p></div>';
						return;
						
					}
					
					if(empty($this->_options['apikey']))
					{
					
						echo '<div class="error"><p>' . __('Oops... You have not provided a valid API Key in the settings menu.', 'flickrstm') . '<a href="?page=flickr-stream_settings">' . __('Enter your key', 'flickrstm') . '</a></p></div>';
						return;
					
					}
							
					if($ins['cachedata'] == 'on')
					{
							
						require 'class/fsWorkhorse.class.php';
						$fs = new fsWorkhorse();
						$ins['cache'] = $fs->returnCache($ins);
						
						if(!$ins['cache'])
						{
						
							echo '<div class="error"><p>' . __('Oops... Either your API key is invalid or there has been an issue contacting the Flickr Api.', 'flickrstm') . '</p></div>';
							return;
						
						}
								
					}
							
					if(update_option($optname, $ins))
						echo '<div class="updated"><p>' . __('Shortcode updated', 'flickrstm') . '</p></div>';
					else
						echo '<div class="error e-message"><p>' . __('Oops... something went wrong', 'flickrstm') . '</p></div>';
					
				}
				
			}
			//DELETE A SHORTCODE//
			elseif(isset($_POST['delShortcode']))
			{
				
				if(check_admin_referer('flickrstream_actions'))
				{
			
					if(delete_option('flickrstream_short_' . $_POST['key']))
						echo '<div class="updated"><p>' . __('Shortcode deleted', 'flickrstm') . '</p></div>';
					
				}
				
			}
			
		}
			
	}
}
?>