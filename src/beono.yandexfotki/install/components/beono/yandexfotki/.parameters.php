<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"AUTHOR" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_AUTHOR'),
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "BASE"
		),
		"ITEMS_LIMIT" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_ITEMSLIMIT'),
			"TYPE" => "STRING",
			"DEFAULT" => "10",
			"PARENT" => "VISUAL"
		),
		"PHOTOS_SORT" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_PHOTOS_SORT'),
			"TYPE" => "LIST",
			"VALUES" => array(
				'rpublished' => GetMessage('BEONO_YAFOTKI_PARAMS_PHOTOS_SORT_PUBASC'), 
				'published' => GetMessage('BEONO_YAFOTKI_PARAMS_PHOTOS_SORT_PUBDESC')
			),
			"DEFAULT" => "rpublished",
			"PARENT" => "VISUAL"
		),
		"PAGER_TEMPLATE" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_PAGER'),
			"TYPE" => "STRING",
			"DEFAULT" => "modern",
			"PARENT" => "VISUAL"
		),
		"PHOTO_SIZE" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_PHOTOSIZE'),
			"TYPE" => "LIST",
			"VALUES" => array('L' => '500px', 'XL' => '800px', 'XXL' => '1024px'),
			"DEFAULT" => "L",
			"PARENT" => "VISUAL"
		),
		"DISPLAY_DATE" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_DISPLAYDATE'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"PARENT" => "VISUAL"
		),
		"DISPLAY_ORIGINAL" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_DISPLAYORIGINAL'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"PARENT" => "VISUAL"
		),
		"DISPLAY_SHARE" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_DISPLAYSHARE'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"PARENT" => "VISUAL"
		),
		"AJAX_MODE" => array(),
		"VARIABLE_ALIASES" => Array(
			"album_id" => Array(
				"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_ALBUM_URL'),
				"DEFAULT" => "album_id",
			),
			"photo_id" => Array(
				"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_PHOTO_URL'),
				"DEFAULT" => "photo_id",
			),
		),
		"SEF_MODE" => 
			Array(
				"albums" => array(
					"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_ALBUMS_URL'),
					"DEFAULT" => "",
					"VARIABLES" => "",
				),
				"album" => array(
					"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_ALBUM_URL'),
					"DEFAULT" => "#album_id#/",
					"VARIABLES" => array("album_id"),
				),
				"photo" => array(
					"NAME" => GetMessage('BEONO_YAFOTKI_PARAMS_PHOTO_URL'),
					"DEFAULT" => "#album_id#/#photo_id#/",
					"VARIABLES" => array("album_id", "photo_id"),
				),
			), 
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);
?>
