<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
	"beono:yandexfotki.album",
	".default",
	Array(
		"AUTHOR" => $arParams["AUTHOR"],
		"ALBUM_ID" => $arResult["VARIABLES"]["album_id"],
		"ITEMS_LIMIT" => $arParams["ITEMS_LIMIT"],
		"PHOTOS_SORT" => $arParams["PHOTOS_SORT"],
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