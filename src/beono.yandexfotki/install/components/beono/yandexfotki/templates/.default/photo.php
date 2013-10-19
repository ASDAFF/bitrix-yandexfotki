<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
	"beono:yandexfotki.photo",
	".default",
	Array(
		"AUTHOR" => $arParams["AUTHOR"],
		"ALBUM_ID" => $arResult["VARIABLES"]["album_id"],
		"PHOTO_ID" => $arResult["VARIABLES"]["photo_id"],
		"SIZE" => $arParams["PHOTO_SIZE"],	
		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_ORIGINAL" => $arParams["DISPLAY_ORIGINAL"],	
		"DISPLAY_SHARE" => $arParams["DISPLAY_SHARE"],	
		"LIST_URL" => $arParams["SEF_FOLDER"],		
		"ALBUM_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]['album'],
		"PHOTO_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]['photo'],
		"AJAX_MODE" => $arParams['~AJAX_MODE'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
	),
	$component
);
?>