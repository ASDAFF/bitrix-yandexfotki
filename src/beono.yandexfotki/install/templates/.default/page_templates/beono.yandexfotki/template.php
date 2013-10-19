<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CPageTemplate::IncludeLangFile(__FILE__);

class CBeonoYandexFotkiPageTemplate
{
	function GetDescription()
	{
		return array(
         "name"=>GetMessage("BEONO_WIZ_NAME"), 
         "description"=>GetMessage("BEONO_WIZ_DESC"),
		//"icon"=>"",
		);
	}
	 
	function GetFormHtml()
	{
		if(!CModule::IncludeModule('beono.yandexfotki')) {
			return false;
		}
		$s = '
<tr>
   <td class="bx-popup-label bx-width50"><label for="beono_fotki_author_input">'.GetMessage("BEONO_WIZ_AUTHOR").'</label>:</td>
   <td><input type="text" id="beono_fotki_author_input" name="AUTHOR" value="" size="20"></td>
<tr>
';      
		return $s;
	}

	function GetContent($arParams)
	{
		$s =
'<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?><?$APPLICATION->IncludeComponent("beono:yandexfotki", ".default", array(
	"AUTHOR" => "'.EscapePHPString($_POST['AUTHOR']).'",
	"PAGER_TEMPLATE" => "modern",
	"DISPLAY_DATE" => "Y",
	"DISPLAY_ORIGINAL" => "Y",
	"DISPLAY_SHARE" => "Y",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "'.EscapePHPString($arParams["path"]).'",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_SHADOW" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "Y",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "86400",
	"AJAX_OPTION_ADDITIONAL" => "",
	"SEF_URL_TEMPLATES" => array(
		"albums" => "",
		"album" => "#album_id#/",
		"photo" => "#album_id#/#photo_id#/",
	)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>';
		return $s;
	}
}

$pageTemplate = new CBeonoYandexFotkiPageTemplate;
?>