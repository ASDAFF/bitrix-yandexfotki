<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult = array();

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if (!CModule::IncludeModule('beono.yandexfotki')) {
	ShowError('Module beono.yandexfotki is not installed');
	return;
}

if (!isset($arParams['SIZE'])) {
	$arParams['SIZE'] = "L";
}

if (!isset($arParams['ALBUM_ID'])) {
	ShowError('Album id is not defined');
	return;
}

if (!isset($arParams['PHOTO_ID'])) {
	ShowError('Photo id is not defined');
	return;
}

$arParams["ALBUM_ID"] = intval($arParams["ALBUM_ID"]);
$arParams["PHOTO_ID"] = intval($arParams["PHOTO_ID"]);

try { 
	$obAuthor = new BeonoYandexFotki($arParams["AUTHOR"], $arParams['CACHE_TIME']);
	$arResult = $obAuthor->getAlbumPhotos($arParams["ALBUM_ID"]);
	$arResult['URL'] = str_replace(array('#album_id#'), array($arParams["ALBUM_ID"]), $arParams['ALBUM_URL']);
	if(is_array($arResult['ITEMS'])) {			
		foreach ($arResult['ITEMS'] as $key=>$arPhoto) {		
			$arPhoto['URL'] = str_replace(array('#album_id#', '#photo_id#'), array($arParams["ALBUM_ID"], $arPhoto['ID']), $arParams['PHOTO_URL']);
			$arResult['ITEMS'][$key]['URL'] = $arPhoto['URL'];
			
			if ($arResult['ITEMS'][($key+1)]['ID'] == $arParams['PHOTO_ID']) {
				$arResult['PREV'] = $arPhoto;
			} elseif ($arResult['ITEMS'][($key-1)]['ID'] == $arParams['PHOTO_ID']) {
				$arResult['NEXT'] = $arPhoto;
			} elseif ($arPhoto['ID'] == $arParams['PHOTO_ID']) {
				$arResult['PHOTO'] = $arPhoto;		
			}
		}		
	} 
	if (empty($arResult['PHOTO'])) {
		throw new Exception(GetMessage('BEONO_YAFOTKI_COMP_ERROR_PHOTO404'));
	}
} catch (Exception $e) {
	ShowError($e->getMessage());
	CHTTP::SetStatus("404 Not Found");
}

$this->IncludeComponentTemplate();


$APPLICATION->SetTitle($arResult['PHOTO']['TITLE']);
$APPLICATION->SetPageProperty('title', $arResult['TITLE']." / ".$arResult['PHOTO']['TITLE']);
$APPLICATION->SetPageProperty("description", $arResult['SUMMARY']);
$APPLICATION->AddHeadString('<link rel="image_src" href="'.$arResult['PHOTO']['SRC'][$arParams['SIZE']]['HREF'].'"/> 
<meta property="og:image" content="'.$arResult['PHOTO']['SRC'][$arParams['SIZE']]['HREF'].'"/>');
$APPLICATION->AddChainItem($arResult['TITLE'], $arResult['URL']);

?>