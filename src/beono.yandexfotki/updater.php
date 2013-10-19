<?php

DeleteDirFilesEx("/bitrix/components/beono/yandexfotki");
DeleteDirFilesEx("/bitrix/components/beono/yandexfotki.album");
DeleteDirFilesEx("/bitrix/components/beono/yandexfotki.albums");
DeleteDirFilesEx("/bitrix/components/beono/yandexfotki.photo");
DeleteDirFilesEx("/bitrix/templates/.default/page_templates/beono.yandexfotki");

CopyDirFiles(dirname(__FILE__)."/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
CopyDirFiles(dirname(__FILE__)."/install/templates", $_SERVER["DOCUMENT_ROOT"]."/bitrix/templates", true, true);		

?>