<?php 
/**
 * fsFrontend - Frontend section for Flickr-Stream
 *
 * @package Flickr-Stream
 * @author Dustin Scarberry
 *
 * @since 1.1.5
 */
class fsFrontend
{
	
	private $_options;
		
	public function __construct()
	{
		
		//get plugin options
		$this->_options = get_option('flickrstream_main_opts');
		
		//add hooks
		add_shortcode('flickrstream', array(&$this, 'shortcode'));
		add_action('wp_print_footer_scripts', array(&$this, 'setupViewer'));
		add_action('wp_enqueue_scripts', array(&$this, 'addStyles'));
		
		//check for extra fancybox script inclusion
		if($this->_options['fancyboxInc'] == 'yes')
			add_action('wp_enqueue_scripts', array(&$this, 'addScripts'));
		
	}
		
	public function addStyles()
	{
		
		//load frontend styles
		wp_enqueue_style('flickrstream_style', plugins_url('css/front_style.css', __FILE__), false, null);
		
		if($this->_options['highlightColor'] != '#397fdf')
		{
		
			$css = '.flickrstream-widgetbox a img:hover, .flickrstream-embed img:hover{background-color:' . $this->_options['highlightColor'] . '!important;}';
			wp_add_inline_style('flickrstream_style', $css);
		
		}
			
	}
		
	//setup fancybox call for video galleries
	public function setupViewer()
	{
	
		if($this->_options['useMobileView'] == 'yes')
		{
	
		?>
	
		<script>
		
			jQuery(function(){

				(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
				
				var photoswipeCustomJS = '<?php echo plugins_url('photoswipe/photoswipe-custom.js', __FILE__); ?>';
				var photoswipeCSS = '<?php echo plugins_url('photoswipe/photoswipe.css', __FILE__); ?>';
				
				//if user is on mobile
				if(jQuery.browser.mobile)
				{
					var headNode = jQuery('head');
					var scriptNode_0 = document.createElement('script');
					var scriptNode_1 = document.createElement('link');
					
					scriptNode_0.src = photoswipeCustomJS;
					scriptNode_1.href = photoswipeCSS;
					scriptNode_1.rel = 'stylesheet';
					
					headNode[0].appendChild(scriptNode_0);
					headNode[0].appendChild(scriptNode_1);
	
				}
				//if user is on desktop
				else
				{

					jQuery('.flickrstream-embed, .flickrstream-widgetbox').each(function(){ 
						jQuery(this).magnificPopup({
							delegate: 'a.fsLightbox', 
							type: 'image',
							closeOnContentClick: true,
							closeMarkup: '<button title="<?php _e('Close (Esc)', 'flickrstm'); ?>" type="button" class="flickrstm-close mfp-close">×</button>',
							gallery: {
							  enabled:true,
							  navigateByImgClick: false,
							  arrowMarkup: '<button title="%title%" type="button" class="flickrstm-arrow mfp-arrow mfp-arrow-%dir%"></button>'
							 
							}
						});
					}); 
					
				}
	
			});
			
		</script>
		
		<?php
	
		}
		else
		{
		
		?>
		
		<script>
		
			jQuery(function(){
			
				jQuery('.flickrstream-embed, .flickrstream-widgetbox').each(function(){ 
					jQuery(this).magnificPopup({
						delegate: 'a.fsLightbox', 
						type: 'image',
						closeOnContentClick: true,
						closeMarkup: '<button title="<?php _e('Close (Esc)', 'flickrstm'); ?>" type="button" class="flickrstm-close mfp-close">×</button>',
						gallery: {
						  enabled:true,
						  navigateByImgClick: false,
						  arrowMarkup: '<button title="%title%" type="button" class="flickrstm-arrow mfp-arrow mfp-arrow-%dir%"></button>'
						 
						}
					});
				}); 
								
				

			});
		
		</script>
		
		<?php
		
		}
		
	}
		
	public function addScripts()
	{
		
		//load jquery and lightbox js / css
		wp_enqueue_script('jquery');	
		wp_enqueue_script('js', '//cdn.jsdelivr.net/jquery.magnific-popup/0.9.3/jquery.magnific-popup.min.js', array('jquery'), null, true);
		wp_enqueue_style('css', '//cdn.jsdelivr.net/jquery.magnific-popup/0.9.3/magnific-popup.css', false, null);
	
	}
		
	public function shortcode($atts)
	{
	
		extract($atts);
		$opts = get_option('flickrstream_short_' . $id);
		require_once 'class/fsWorkhorse.class.php';
		
		if(!empty($opts))
		{

			$content = '<div id="flickrstream-embed-' . $id . '" class="flickrstream-embed fsAlign' . $opts['photoAlign'] . '">';
			
			$workhorse = new fsWorkhorse();
			$data = $workhorse->returnPhotos('shortcode', $opts, $atts);
						
			if($data)
			{
			
				$content .= $data;
				$content .= '</div>';
			
			}
			else
				$content = '<div class="fs-errorbar">' . __('ERROR: BAD API KEY OR FLICKR API CALL', 'flickrstm') . '</div>';
			
		}
		else
			$content = '<div class="fs-errorbar">' . __('ERROR: INVALID SHORTCODE ID', 'flickrstm') . '</div>';
		
		return $content;
		
	}
			
}
?>