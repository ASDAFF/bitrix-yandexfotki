<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult = array();

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if (method_exists("CModule", "IncludeModuleEx") && CModule::IncludeModuleEx("beono.yandexfotki") == MODULE_DEMO_EXPIRED) {
	ShowError('Demo expired');
	echo '<p><a href="http://mp.1c-bitrix.ru/solutions/beono.yandexfotki/">Buy full version</a></p>';
	return;
}

if (!CModule::IncludeModule('beono.yandexfotki')) {
	ShowError('Module beono.yandexfotki is not installed or demo expired');
	return;
}

if (!trim($arParams['AUTHOR'])) {
	ShowError(GetMessage('BEONO_YAFOTKI_ERROR_AUTHOR'));
	return;
}

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
	$arRawResult = $obAuthor->getAlbums(array("parent_id" => $arParams['ALBUM_ID']));

	$dbresult = new CDBResult;
	$dbresult->InitFromArray($arRawResult['ITEMS']);
	$dbresult->NavStart($arParams['ITEMS_LIMIT'], false);
	
	$arResult = $arRawResult;
	$arResult['ITEMS'] = array();
	
	while ($arItem = $dbresult->GetNext()) {
		$arItem['URL'] = str_replace(array('#album_id#'), array($arItem["ID"]), $arParams['ALBUM_URL']);
		$arResult['ITEMS'][] = $arItem;
	}
	
	$arResult["NAV_STRING"] = $dbresult->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], $arParams["PAGER_SHOW_ALWAYS"]);
	
} catch (Exception $e) {
	ShowError($e->getMessage());
	CHTTP::SetStatus("404 Not Found");
}

$this->IncludeComponentTemplate();

?>
