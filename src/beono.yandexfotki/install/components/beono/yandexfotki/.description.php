<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage('BEONO_YAFOTKI_COMP_NAME'),
	"DESCRIPTION" => GetMessage('BEONO_YAFOTKI_COMP_DESCR'),
	"ICON" => "/images/icon.png",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "Beono",
		"CHILD" => array(
			"ID" => "beono:yandexfotki",	
			"NAME" => GetMessage('BEONO_YAFOTKI_COMP_NAME'),
		)	
	),
	"COMPLEX" => "Y"
);
?>