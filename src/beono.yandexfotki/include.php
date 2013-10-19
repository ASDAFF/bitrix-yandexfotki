<?
IncludeModuleLangFile(__FILE__);

class BeonoYandexFotki {

	protected static $_yandex_users_url = 'http://api-fotki.yandex.ru/api/users/%s/';
	protected $_author = null;
	protected $_service_doc = null;
	protected $_albums_url = null;
	protected $_cache_time = 86400;

	public function __construct($author, $cache_time=0) {		
		
		if (!function_exists('json_decode')) {
			throw new Exception('Functions json_decode does not exist in your php installation');
		}

		$this->_cache_time = $cache_time;
		
		if(!$this->_service_doc = $this->getDataFromYandex(sprintf(self::$_yandex_users_url.'?format=json', $author))) {
			throw new Exception('Author not found');
		} else {
			$this->_author = $author;
			$this->_albums_url = self::formatUri($this->_service_doc['collections']['album-list']['href']);
		}
	}
	
	public static function formatUri($uri, $add_str='') {
		return str_replace(array('?', '&', 'format=json', 'limit=100'), '', $uri).$add_str;
	}

	public static function dateFormat($date, $date_format = false) {
		$arDate = ParseDateTime(ConvertTimeStamp(strtotime($date)), $date_format);
		$result = ltrim($arDate["DD"], "0")." ".strtolower(GetMessage("MONTH_".intval($arDate["MM"])."_S"))." ".$arDate["YYYY"];
		return $result;

	}
	
	static function jsonDecode($data) {
		$data = json_decode($data, true);
		if (!defined('BX_UTF') || defined('BX_UTF') && constant('BX_UTF') != true) {
			array_walk_recursive($data, array('BeonoYandexFotki', 'arrayTo1251'));
		}
		return $data;
	}
	
	public static function arrayTo1251(&$value, $key) {
		$value = iconv('utf-8', 'cp1251', $value);	
	}

	public function getAlbums($params=array()) {
		if($this->_albums_url) {
			$limit = 100;
			$next = $this->_albums_url."published/?format=json&limit=".$limit;
			$page_number=0;
			$image_count=0;
			while($next) {
				if ($arAlbums_xml = $this->getDataFromYandex($next)) {
					if (is_array($arAlbums_xml)) {
						foreach ($arAlbums_xml['entries'] as $album) {
							
							// if protected or has 0 photos 
							if ($album['protected'] || ($album['imageCount']==0 && $album['title'] == 'Неразобранное')) {
								continue;
							}	

							if ($arAlbums_xml['links']['next']) {
								$next = self::formatUri($arAlbums_xml['links']['next'], "?format=json&limit=".$limit);
							} else {
								$next = false;
							}
							
							if(preg_match('/album:([\d]+)/', (string) $album['id'], $matches)) {
							
								// filtering by parent album 
								if ($params['parent_id'] && $params['parent_id'] != self::formatUri($album['links']['album'])) {
									continue;
								}
								
								// if no filtering then escape child albums
								if (!$params['parent_id'] && $album['links']['album']) {
									continue;
								}
								
								
								$image_count++;									
																
								if ($params['limit'] && $params['page']) {
									$page_number = ceil($image_count/$params['limit']);
									if ($page_number == $params['page'] && $image_count >= ($params['page']*$params['limit'] - $params['limit']) && ($image_count <= $params['page']*$params['limit'])) {
										
									}	elseif ($params['page'])  {
										continue;
									}
								}
								
								$arAlbums['ITEMS'][] = array (
									'ID' => $matches[1],
									'TITLE' => htmlspecialchars($album['title']),
									'SUMMARY' => htmlspecialchars($album['summary']),
									'IMAGE_COUNT' => $album['imageCount'],
									'LINK' => self::formatUri($album['links']['photos']),
									'SELF_LINK' => self::formatUri($album['links']['self']),
									'COVER' => $this->getAlbumCover($album),
									'DATE_PUBLISHED' => self::dateFormat($album['published'])
								);
							}
						}
					}
				}
			}
			$arAlbums['TOTAL'] = $image_count;
			return $arAlbums;
		}
	}
	
	public function getAlbumPhotos ($album_id, $params=array()) {
		$limit = 100;
		
		if (!$params['sort'])  {
			$params['sort'] = 'rpublished';
		}
		
		if($this->_albums_url) {
			
			$next_albums_page = $this->_albums_url."/?format=json&limit=".$limit;
			
			while($next_albums_page) {
				
				if ($albums_xml = $this->getDataFromYandex($next_albums_page)) {
					
					if ($albums_xml['links']['next']) {
						$next_albums_page = self::formatUri($albums_xml['links']['next'], "?format=json&limit=".$limit);						
					} else {
						$next_albums_page = false;
					}
					
					if (is_array($albums_xml['entries'])) {
						
						foreach ($albums_xml['entries'] as $arAlbum) {	
									
							if ($arAlbum['id'] == 'urn:yandex:fotki:'.$this->_author.':album:'.$album_id) {	
								$next = self::formatUri($arAlbum['links']['photos'], $params['sort']."/?format=json&limit=".$limit);
								$self = self::formatUri($arAlbum['links']['self']);
								$next_albums_page = false;
								break;
							}
						}					
					}
					
				}
			}
			$page_number=0;
			$image_count=0;
			unset($arAlbum);
			while($next) {
				if ($album_xml = $this->getDataFromYandex($next)) {

					if (!isset($arAlbum)) {
						$arAlbum = array (
							'ID' => $album_id,
							'TITLE' => htmlspecialchars($album_xml['title']),
							'SUMMARY' => htmlspecialchars($album_xml['summary']),
							'DATE_PUBLISHED' => self::dateFormat($album_xml['published']),
							'SELF_LINK' => $self,
						);	
					}
					
					if(empty($album_xml['entries'])) {
						$next = false;
					} else {			
						
						if ($album_xml['links']['next']) {
							$next = self::formatUri($album_xml['links']['next'], "?format=json&limit=".$limit);
						} else {
							$next = false;
						}
						
						foreach ($album_xml['entries'] as $photo) {
							
							if(preg_match('/photo:([\d]+)/', $photo['id'], $matches)) {
								
								if ($photo['access'] != 'public') {
									continue;
								}
								
								$image_count++;

								$arNewPhoto = array (
									'ID' => $matches[1],
									'TITLE' => htmlspecialchars($photo['title']),
									'DATE_PUBLISHED' => self::dateFormat($photo['published'])
								);
								
								if (is_array($photo['img'])) {						
									foreach($photo['img'] as $size=>$image) {	
										$arNewPhoto['SRC'][$size]['HREF'] = $image['href'];
										$arNewPhoto['SRC'][$size]['WIDTH'] = $image['width'];
										$arNewPhoto['SRC'][$size]['HEIGHT'] = $image['height'];								
									}
								}
								
								$arAlbum['ITEMS'][] = $arNewPhoto;						
							}													
						}
					}
				}
			}
			
			$arAlbum['TOTAL'] = $image_count;

			return $arAlbum;
		}
	}

	public function getAlbumCover($album) {
		
		/*
		 * if($album['links']['cover'] && $arImage = $this->getDataFromYandex($album['links']['cover'])) {
					
			if (is_array($arImage)) {	
				foreach($arImage['img'] as $size=>$image) {	
					$arNewPhoto['SRC'][$size]['HREF'] = $image['href'];
					$arNewPhoto['SRC'][$size]['WIDTH'] = $image['width'];
					$arNewPhoto['SRC'][$size]['HEIGHT'] = $image['height'];								
				}
			}
			
			return $arNewPhoto;
		}
		 */

		if($arImages = $this->getDataFromYandex(self::formatUri($album['links']['photos'], "?format=json&limit=1"))) {	
			if (is_array($arImages['entries'][0]['img'])) {						
				foreach($arImages['entries'][0]['img'] as $size=>$image) {	
					$arNewPhoto['SRC'][$size]['HREF'] = $image['href'];
					$arNewPhoto['SRC'][$size]['WIDTH'] = $image['width'];
					$arNewPhoto['SRC'][$size]['HEIGHT'] = $image['height'];								
				}
			}
			
			if (empty($arNewPhoto) && $album['links']['self']) {
				
				$arChildAlbums = $this->getAlbums(array("parent_id" => self::formatUri($album['links']['self']), "page" => 1, 'limit' => 1));
				if (is_array($arChildAlbums['ITEMS'])) {
					return $arChildAlbums['ITEMS'][0]['COVER'];
				}
			}
			
			return $arNewPhoto;
		}
	}
	
	protected function getDataFromYandex($uri) {
		$obCache = new CPHPCache;
		if($obCache->InitCache($this->_cache_time, md5($uri), SITE_ID."/beono/yandexfotki_api/")) {
			$vars = $obCache->GetVars();
			$data = $vars['data'];
		} else {
			$data = @file_get_contents($uri);
			$data = self::jsonDecode($data);
			$obCache->StartDataCache();
			$obCache->EndDataCache(array("data" => $data)); 
		}
		return $data;	
	}

}
?>