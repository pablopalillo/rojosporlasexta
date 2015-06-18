<?php 
/**
 * fsWorkhorse - Workhorse for generating output for Flickr-Stream
 *
 * @package Flickr-Stream
 * @author Dustin Scarberry
 *
 * @since 1.1.5
 */
class fsWorkhorse
{

	private $_content, $_mainopts, $_opts, $_relgen;

	public function __construct()
	{
	
		$this->_mainopts = get_option('flickrstream_main_opts');
		
	}
	
	//return photos for a shortcode or widget//
	public function returnPhotos($type, $opts, $extra)
	{
	
		if(!empty($opts) && !empty($type))
		{
		
			$this->_opts = $opts;
			$this->_relgen = rand();
		
			if($extra != null)
				extract($extra);
			
			if(!isset($this->_opts['thumbsize']))
				$this->_opts['thumbsize'] = 'Small';
				
			if($this->_opts['cachedata'] == 'on')
			{
			
				if($this->_opts['hidetitle'] == 'off')
				{
				
					if($type == 'shortcode')
						$this->_content .= '<h3 class="fs-settitle">' . $this->_opts['cache']['name'] . '</h3>';
					else
						$this->_content .= $before_title . $this->_opts['cache']['name'] . $after_title;
				
				}
					
				for($i = 0; $i < $this->_opts['photocnt']; $i++)
				{
					
					$this->getCachedPhoto($this->_opts['cache']['photos'][$i]);
						
				}
			
			}
			else
			{
			
				if($this->_opts['type'] == 'Set')
				{

					$meta = $this->callAPI('https://api.flickr.com/services/rest/?method=flickr.photosets.getInfo&api_key=' . $this->_mainopts['apikey'] . '&photoset_id=' . $this->_opts['id'] . '&format=json&nojsoncallback=1');
					
					if(!$meta)
						return false;
					
					$data = $this->callAPI('https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' . $this->_mainopts['apikey'] . '&photoset_id=' . $this->_opts['id'] . '&extras=url_k,url_h,url_l,url_z&privacy_filter=1&format=json&nojsoncallback=1');
					
					if(!$data)
						return false;
					
					if($meta['photoset']['count_photos'] < $this->_opts['photocnt'])
						$this->_opts['photocnt'] = $meta['photoset']['count_photos'];
					
					if($this->_opts['hidetitle'] == 'off')
					{
					
						if($type == 'shortcode')
							$this->_content .= '<h3 class="fs-settitle">' . $meta['photoset']['title']['_content'] . '</h3>';
						else
							$this->_content .= $before_title . $meta['photoset']['title']['_content'] . $after_title;
					
					}
					
					if($this->_opts['photoselect'] == 'Random')
					{
					
						$range = ($data['photoset']['total'] - 1 < 500 ? $data['photoset']['total'] - 1 : 500);
						$gen = range(0, $range);
						shuffle($gen);
						
						for($i = 0; $i < $this->_opts['photocnt']; $i++)
						{
					
							$this->getLiveSetPhoto($data, $gen[$i]);
							
						}
				
					}
					else
					{
					
						for($i = 0; $i < $this->_opts['photocnt']; $i++)
						{

							$this->getLiveSetPhoto($data, $i);
							
						}
					
					}

				}
				else
				{
				
					$meta = $this->callAPI('https://api.flickr.com/services/rest/?method=flickr.urls.lookupGallery&api_key=' . $this->_mainopts['apikey'] . '&url=' . $this->_opts['id'] . '&format=json&nojsoncallback=1');
					
					if(!$meta)
						return false;
						
					$data = $this->callAPI('https://api.flickr.com/services/rest/?method=flickr.galleries.getPhotos&api_key=' . $this->_mainopts['apikey'] . '&gallery_id=' . $meta['gallery']['id'] . '&extras=url_k,url_h,url_l,url_z&privacy_filter=1&format=json&nojsoncallback=1');
					
					if(!$data)
						return false;
					
					if($meta['gallery']['count_photos'] < $this->_opts['photocnt'])
						$this->_opts['photocnt'] = $meta['gallery']['count_photos'];
						
					if($this->_opts['hidetitle'] == 'off')
					{
					
						if($type == 'shortcode')
							$this->_content .= '<h3 class="fs-settitle">' . $meta['gallery']['title']['_content'] . '</h3>';
						else
							$this->_content .= $before_title . $meta['gallery']['title']['_content'] . $after_title;
					
					}
				
					if($this->_opts['photoselect'] == 'Random')
					{
					
						$range = ($data['photos']['total'] - 1 < 500 ? $data['photos']['total'] - 1 : 500);
						$gen = range(0, $range);
						shuffle($gen);
							
						for($i = 0; $i < $this->_opts['photocnt']; $i++)
						{
				
							$this->getLiveGalleryPhoto($data, $gen[$i]);
							
						}

					}
					else
					{

						for($i = 0; $i < $this->_opts['photocnt']; $i++)
						{
				
							$this->getLiveGalleryPhoto($data, $i);	
							
						}
					
					}
					
				}

			}
		
			return $this->_content;
			
		}else
			return false;
	
	}
	
	//return cache data for photoset or gallery//
	public function returnCache(&$instance)
	{
	
		if(!empty($instance))
		{
	
			$store = array();
			
			if($instance['type'] == 'Set')
			{
				
				
				$meta = $this->callAPI('https://api.flickr.com/services/rest/?method=flickr.photosets.getInfo&api_key=' . $this->_mainopts['apikey'] . '&photoset_id=' . $instance['id'] . '&format=json&nojsoncallback=1');
				
				if(!$meta)
					return false;
				
				$store['name'] = $meta['photoset']['title']['_content'];
								
				$data = $this->callAPI('https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' . $this->_mainopts['apikey'] . '&photoset_id=' . $instance['id'] . '&extras=url_k,url_h,url_l,url_z&privacy_filter=1&format=json&nojsoncallback=1');

				if(!$data)
					return false;
				
				if($meta['photoset']['count_photos'] < $instance['photocnt'])
					$instance['photocnt'] = $meta['photoset']['count_photos'];
					
				if($instance['photoselect'] == 'Random')
				{
						
					$range = ($data['photoset']['total'] - 1 < 500 ? $data['photoset']['total'] - 1 : 500);
					$gen = range(0, $range);
					shuffle($gen);
						
					for($i = 0; $i < $instance['photocnt']; $i++){
				
						$rand = $gen[$i];
									
						$store['photos'][$i]['title'] = $data['photoset']['photo'][$rand]['title'];
						
						$store['photos'][$i]['url'] = $this->getLargestPhotoURL($data['photoset']['photo'][$rand]);
						
						$store['photos'][$i]['flickr'] = 'http://www.flickr.com/photos/' . $data['photoset']['owner'] . '/' . $data['photoset']['photo'][$rand]['id'];
								
					}
									
				}
				else
				{
							
					for($i = 0; $i < $instance['photocnt']; $i++)
					{
								
						$store['photos'][$i]['title'] = $data['photoset']['photo'][$i]['title'];
									
						$store['photos'][$i]['url'] = $this->getLargestPhotoURL($data['photoset']['photo'][$i]);
									
						$store['photos'][$i]['flickr'] = 'http://www.flickr.com/photos/' . $data['photoset']['owner'] . '/' . $data['photoset']['photo'][$i]['id'];
								
					}
							
				}

			}
			else
			{
					
				$meta = $this->callAPI('https://api.flickr.com/services/rest/?method=flickr.urls.lookupGallery&api_key=' . $this->_mainopts['apikey'] . '&url=' . $instance['id'] . '&format=json&nojsoncallback=1');
				
				if(!$meta)
					return false;
					
				$store['name'] = $meta['gallery']['title']['_content'];
							
				$data = $this->callAPI('https://api.flickr.com/services/rest/?method=flickr.galleries.getPhotos&api_key=' . $this->_mainopts['apikey'] . '&gallery_id=' . $meta['gallery']['id'] . '&extras=url_k,url_h,url_l,url_z&privacy_filter=1&format=json&nojsoncallback=1');
				
				if(!$data)
					return false;
					
				if($meta['gallery']['count_photos'] < $instance['photocnt'])
					$instance['photocnt'] = $meta['gallery']['count_photos'];
					
				if($instance['photoselect'] == 'Random')
				{
						
					$range = ($data['photos']['total'] - 1 < 500 ? $data['photos']['total'] - 1 : 500);
					$gen = range(0, $range);
					shuffle($gen);
							
					for($i = 0; $i < $instance['photocnt']; $i++)
					{
				
						$rand = $gen[$i];
		
						$store['photos'][$i]['title'] = $data['photos']['photo'][$rand]['title'];
							
						$store['photos'][$i]['url'] = $this->getLargestPhotoURL($data['photos']['photo'][$rand]);
										
						$store['photos'][$i]['flickr'] = 'http://www.flickr.com/photos/' . $data['photos']['photo'][$rand]['owner'] . '/' . $data['photos']['photo'][$rand]['id'];
									
					}
							
				}
				else
				{

					for($i = 0; $i < $instance['photocnt']; $i++)
					{
					
						$store['photos'][$i]['title'] = $data['photos']['photo'][$i]['title'];
										
						$store['photos'][$i]['url'] = $this->getLargestPhotoURL($data['photos']['photo'][$i]);
		
						$store['photos'][$i]['flickr'] = 'http://www.flickr.com/photos/' . $data['photos']['photo'][$i]['owner'] . '/' . $data['photos']['photo'][$i]['id'];
								
					}
						
				}
					
			}
			
			return $store;
			
		}else
			return false;
	
	}
	
	//get data from flickr api//
	private function callAPI($url) 
	{
			
		$response = wp_remote_get($url);
		
		if($response['response']['code'] != 200)
			return false;
		
		$response = json_decode($response['body'], true);
		
		if($response['stat'] == 'fail')
			return false;
		else
			return $response;

	}
	
	//get a live photo and link from a photoset//
	private function getLiveSetPhoto(&$data, $pointer)
	{
	
		if($this->_opts['linktype'] == 'Flickr')
		{
						
			$this->_content .= '<a href="http://www.flickr.com/photos/' . $data['photoset']['owner'] . '/' . $data['photoset']['photo'][$pointer]['id'] . '" target="_blank" title="' . $data['photoset']['photo'][$pointer]['title'] . '"><img src="' . $this->getLiveThumbnailURL($data['photoset']['photo'][$pointer], $this->_opts['thumbsize']) . '" class="' . ($this->_opts['thumbsize'] == 'Medium' ? 'medtbm' : 'smltbm') . '"/></a>';
						
		}
		else
		{
	
			$this->_content .= '<a href="' . $this->getLargestPhotoURL($data['photoset']['photo'][$pointer]) . '"' . ($this->_opts['hidecaption'] == 'off' ? 'title="' . $data['photoset']['photo'][$pointer]['title'] . '"' : '') . ' class="fsLightbox" rel="' . $this->_relgen . '"><img src="' . $this->getLiveThumbnailURL($data['photoset']['photo'][$pointer], $this->_opts['thumbsize']) . '" class="' . ($this->_opts['thumbsize'] == 'Medium' ? 'medtbm' : 'smltbm') . '"/></a>';
					
		}
	
	}
	
	//get a live photo and link from a gallery//
	private function getLiveGalleryPhoto(&$data, $pointer)
	{
	
		if($this->_opts['linktype'] == 'Flickr')
		{
						
			$this->_content .= '<a href="http://www.flickr.com/photos/' . $data['photos']['photo'][$pointer]['owner'] . '/' . $data['photos']['photo'][$pointer]['id'] . '" target="_blank" title="' . $data['photos']['photo'][$pointer]['title'] . '"><img src="' . $this->getLiveThumbnailURL($data['photos']['photo'][$pointer], $this->_opts['thumbsize']) . '" class="' . ($this->_opts['thumbsize'] == 'Medium' ? 'medtbm' : 'smltbm') . '"/></a>';
						
		}
		else
		{
				
			$this->_content .= '<a href="' . $this->getLargestPhotoURL($data['photos']['photo'][$pointer]) . '"' . ($this->_opts['hidecaption'] == 'off' ? 'title="' . $data['photos']['photo'][$pointer]['title'] . '"' : '') . ' class="fsLightbox" rel="' . $this->_relgen . '"><img src="' . $this->getLiveThumbnailURL($data['photos']['photo'][$pointer], $this->_opts['thumbsize']) . '" class="' . ($this->_opts['thumbsize'] == 'Medium' ? 'medtbm' : 'smltbm') . '"/></a>';
						
		}
	
	}
	
	//get a photo and link from cached data//
	private function getCachedPhoto(&$photo)
	{
	
		if($this->_opts['linktype'] == 'Flickr')
		{
			
			$this->_content .= '<a href="' . $photo['flickr'] . '" title="' . $photo['title'] . '" target="_blank"><img src="' . $this->getCachedThumbnailURL($photo['url'], $this->_opts['thumbsize']) . '"/></a>';

		}
		else
		{
			
			$this->_content .= '<a href="' . $photo['url'] . '"' . ($this->_opts['hidecaption'] == 'off' ? 'title="' . $photo['title'] . '"' : '') . ' class="fsLightbox" rel="' . $this->_relgen . '"><img src="' . $this->getCachedThumbnailURL($photo['url'], $this->_opts['thumbsize']) . '" class="' . ($this->_opts['thumbsize'] == 'Medium' ? 'medtbm' : 'smltbm') . '"/></a>';

		}
	
	}
	
	//get largest source image available for photo//
	private function getLargestPhotoURL(&$photo)
	{
	
		//sizes available are k:2048 and h:1600
		if(isset($this->_mainopts['useHigherRes']) && $this->_mainopts['useHigherRes'] == true && isset($photo['url_h']))
		{
			
			return $photo['url_h'];
			
		}
		elseif(isset($photo['url_l']))
		{
		
			return $photo['url_l'];
		
		}
		elseif(isset($photo['url_z']))
		{
		
			return str_replace('?zz=1', '', $photo['url_z']);
			
		}
		else
		{
		
			return 'https://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '.jpg';
			
		}

	}
	
	//get cached thumbnail url//
	private function getCachedThumbnailURL($base, &$size)
	{
	
		$char = substr($base, -6, 1);
		
		if($char == '_')
			$base = substr($base, 0, strlen($base) - 6);
		else
			$base = substr($base, 0, strlen($base) - 4);
	
		if($size == 'Medium')
			return $base . '_q.jpg';
		else
			return $base . '_s.jpg';
		
	}
	
	//get live api call thumbnail url//
	private function getLiveThumbnailURL(&$base, &$size)
	{
	
		return 'https://farm' . $base['farm'] . '.staticflickr.com/' . $base['server'] . '/' . $base['id'] . '_' . $base['secret'] . ($size == 'Medium' ? '_q.jpg' : '_s.jpg');
	
	}
		
}

?>