<?if(!check_bitrix_sessid()) return;?>
<?

if ($GLOBALS['beono_error']) {
	CAdminMessage::ShowMessage($GLOBALS['beono_error']);
}

echo CAdminMessage::ShowNote(GetMessage("MOD_INST_OK"));
?>
<p><?=GetMessage('BEONO_MODULE_YANDEXFOTKI_INSTALL_FINISHED');?></p>
<form action="<?echo $APPLICATION->GetCurPage()?>">
    <input type="hidden" name="lang" value="<?echo LANG?>">
    <input type="submit" name="" value="<?echo GetMessage("MOD_BACK")?>">
<form>