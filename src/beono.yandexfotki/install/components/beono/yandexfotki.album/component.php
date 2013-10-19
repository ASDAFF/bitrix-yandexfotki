<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult = array();

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if (!CModule::IncludeModule('beono.yandexfotki')) {
	ShowError('Module beono.yandexfotki is not installed');
	return;
}

if (!$arParams["ALBUM_ID"]) {
	return;
}

$arParams["ALBUM_ID"] = intval($arParams["ALBUM_ID"]);

if (!isset($arParams['SIZE'])) {
	$arParams['SIZE'] = "M";
}

if(!isset($arParams['ITEMS_LIMIT'])) {	
	$arParams['ITEMS_LIMIT'] = 9;
}

$arNavParams = array(
	"nPageSize" => $arParams['ITEMS_LIMIT'],
	"bShowAll" => $arParams["PAGER_SHOW_ALL"],
);
$arNavigation = CDBResult::GetNavParams($arNavParams);
	
try {
	$obAuthor = new BeonoYandexFotki($arParams["AUTHOR"], $arParams['CACHE_TIME']);
	$arRawResult = $obAuthor->getAlbumPhotos($arParams["ALBUM_ID"], array('sort' => $arParams['PHOTOS_SORT']));
	$arResult = $arRawResult;
	$arResult['ITEMS'] = array();
	
	if (is_array($arRawResult['ITEMS'])) {
		$dbresult = new CDBResult;
		$dbresult->InitFromArray($arRawResult['ITEMS']);
		$dbresult->NavStart($arParams['ITEMS_LIMIT'], false);	
		
		while ($arItem = $dbresult->GetNext()) {
			$arItem['URL'] = str_replace(array('#album_id#', '#photo_id#'), array($arParams["ALBUM_ID"], $arItem["ID"]), $arParams['PHOTO_URL']);
			$arResult['ITEMS'][] = $arItem;
		}			
				
		$arResult['PAGE_NUMBER'] = $dbresult->NavPageNomer;
		$arResult["NAV_STRING"] = $dbresult->GetPageNavStringEx($navComponentObject, false, $arParams["PAGER_TEMPLATE"], $arParams["PAGER_SHOW_ALWAYS"]);
	}
	
	if (!$arRawResult['ID']) {
		throw new Exception(GetMessage('BEONO_YAFOTKI_COMP_ERROR_ALBUM404'));
	}	
	
} catch (Exception $e) {
	ShowError($e->getMessage());
	$this->AbortResultCache();
	CHTTP::SetStatus("404 Not Found");
}	

// if there are sub-albums
if (!$arResult['TOTAL'] && $arResult['SELF_LINK']) {

	$APPLICATION->IncludeComponent(
		"beono:yandexfotki.albums",
		".default",
		Array(
			"AUTHOR" => $arParams["AUTHOR"],
			"ALBUM_ID" => $arResult['SELF_LINK'],
			"LIST_URL" => $arParams["SEF_FOLDER"],		
			"ALBUM_URL" => $arParams["ALBUM_URL"],
			"PHOTO_URL" => $arParams["PHOTO_URL"],
			"CACHE_TYPE" => "N",
			"ITEMS_LIMIT" => $arParams["ITEMS_LIMIT"],
			"CACHE_TYPE" => $arParams['CACHE_TYPE'],
			"CACHE_TIME" => $arParams['CACHE_TIME'],
			"PAGER_TEMPLATE" => $arParams['PAGER_TEMPLATE']
		),
		$component,
		array("HIDE_ICONS" => "Y")
	);
}


$this->IncludeComponentTemplate();


$APPLICATION->SetTitle($arResult['TITLE']);
$APPLICATION->SetPageProperty("description", $arResult['SUMMARY']);
$APPLICATION->AddChainItem($arResult['TITLE'], $arResult['URL']);
$this->SetTemplateCachedData($arResult["NAV_CACHED_DATA"]);
?>