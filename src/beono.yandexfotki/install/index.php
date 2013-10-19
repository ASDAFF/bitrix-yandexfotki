<?
global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

Class beono_yandexfotki extends CModule
{
	var $MODULE_ID = "beono.yandexfotki";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "N";

	function beono_yandexfotki()
	{
		$arModuleVersion = array();
		include("version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("BEONO_MODULE_YANDEXFOTKI_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("BEONO_MODULE_YANDEXFOTKI_INSTALL_DESCRIPTION");

		$this->PARTNER_NAME = "beono";
		$this->PARTNER_URI = "http://mp.1c-bitrix.ru/solutions/beono.yandexfotki/";
	}


	function InstallDB($install_wizard = true)
	{
		global $DB, $DBType, $APPLICATION;
		RegisterModule($this->MODULE_ID);
		return true;
	}

	function UnInstallDB($arParams = Array())
	{
		global $DB, $DBType, $APPLICATION;
		UnRegisterModule($this->MODULE_ID);
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles()
	{
		$res = CopyDirFiles(dirname(__FILE__)."/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		$res = CopyDirFiles(dirname(__FILE__)."/templates", $_SERVER["DOCUMENT_ROOT"]."/bitrix/templates", true, true);
		
		if(!is_writable($_SERVER["DOCUMENT_ROOT"]."/bitrix/components") || !is_writable($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates")) {
			$GLOBALS['beono_error'] = 'Catalog /bitrix/ must be writable';
		}

		return $res;
	}

	function InstallPublic()
	{
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/bitrix/components/beono/yandexfotki");
		DeleteDirFilesEx("/bitrix/components/beono/yandexfotki.album");
		DeleteDirFilesEx("/bitrix/components/beono/yandexfotki.albums");
		DeleteDirFilesEx("/bitrix/components/beono/yandexfotki.photo");
		DeleteDirFilesEx("/bitrix/templates/.default/page_templates/beono.yandexfotki");
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION, $step;
		$this->InstallFiles();			
		$this->InstallDB(false);
		$this->InstallEvents();
		$this->InstallPublic();

		$APPLICATION->IncludeAdminFile(GetMessage("BEONO_MODULE_YANDEXFOTKI_INSTALL_TITLE"), dirname(__FILE__)."/step.php");

	}

	function DoUninstall()
	{
		global $APPLICATION, $step;

		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallEvents();
		$APPLICATION->IncludeAdminFile(GetMessage("BEONO_MODULE_YANDEXFOTKI_UNINSTALL_TITLE"), dirname(__FILE__)."/unstep.php");
	}
}
?>