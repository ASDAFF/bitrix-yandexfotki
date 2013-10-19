<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arDefaultVariableAliases = Array(
	"album_id" => "album_id", 
	"photo_id" => "photo_id", 
);

if($arParams["SEF_MODE"] == "Y")
{
	$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(array(), $arParams["SEF_URL_TEMPLATES"]);
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases(array(), $arParams["VARIABLE_ALIASES"]);
	$componentPage = CComponentEngine::ParseComponentPath($arParams["SEF_FOLDER"], $arUrlTemplates, $arVariables);
	CComponentEngine::InitComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);
	$arResult = array(
		"FOLDER" => $arParams["SEF_FOLDER"],
		"URL_TEMPLATES" => $arUrlTemplates, 
		"VARIABLES" => $arVariables, 
		"ALIASES" => $arVariableAliases
	);

}
else
{
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
	CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

	$componentPage = "";

	if(isset($arVariables["album_id"]) && intval($arVariables["album_id"]) > 0) {
		$componentPage = "album";
	}
	if($componentPage == "album" && isset($arVariables["photo_id"]) && strlen($arVariables["photo_id"]) > 0) {
		$componentPage = "photo";
	}

	$arResult = array(
		"FOLDER" => "",
		"URL_TEMPLATES" => Array(
			"almbums" => htmlspecialchars($APPLICATION->GetCurPage()),
			"album" => htmlspecialchars($APPLICATION->GetCurPage()."?".$arVariableAliases["album_id"]."=#album_id#"),
			"photo" => $APPLICATION->GetCurPage()."?".$arVariableAliases["album_id"]."=#album_id#&".$arVariableAliases["photo_id"]."=#photo_id#",
	),
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases
	);
}

if (!$componentPage) {
	$componentPage = "albums";
}

if(!isset($arParams['DISPLAY_DATE'])) {	
	$arParams['DISPLAY_DATE'] = 'Y';
}
if(!isset($arParams['DISPLAY_ORIGINAL'])) {	
	$arParams['DISPLAY_ORIGINAL'] = 'Y';
}
if(!isset($arParams['DISPLAY_SHARE'])) {	
	$arParams['DISPLAY_SHARE'] = 'Y';
}

$this->IncludeComponentTemplate($componentPage);
?>