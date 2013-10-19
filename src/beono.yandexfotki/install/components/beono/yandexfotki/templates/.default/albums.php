<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
	"beono:yandexfotki.albums",
	".default",
	Array(
		"AUTHOR" => $arParams["AUTHOR"],
		"ITEMS_LIMIT" => $arParams["ITEMS_LIMIT"],
		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"LIST_URL" => $arParams["SEF_FOLDER"],		
		"ALBUM_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]['album'],
		"PHOTO_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]['photo'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"PAGER_TEMPLATE" => $arParams['PAGER_TEMPLATE']
	),
	$component
);
?>