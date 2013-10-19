<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arResult['PAGE_NUMBER'] <= 1 && $arResult['SUMMARY']):?>
	<div class="beono-yandexfotki-album-summary"><?=$arResult['SUMMARY'];?></div>
<?endif;?>
<?if(is_array($arResult['ITEMS'])):?>
<div class="beono-yandexfotki-albums beono-yandexfotki-size_<?=strtolower($arParams['SIZE'])?>"><!--
	<?foreach($arResult['ITEMS'] as $arPhoto):?>
		--><div class="beono-yandexfotki-photo">		
			<div class="beono-yandexfotki-photo-image">
				<a title="<?=$arPhoto['TITLE']?>" href="<?=$arPhoto['URL']?>"><img alt="<?=$arPhoto['TITLE']?>" src="<?=$arPhoto['SRC'][$arParams['SIZE']]['HREF']?>" width="<?=$arPhoto['SRC'][$arParams['SIZE']]['WIDTH']?>" height="<?=$arPhoto['SRC'][$arParams['SIZE']]['HEIGHT']?>" />&nbsp;</a>
			</div>
		</div><!--
	<?endforeach;?>
	--></div>
	<?if ($arResult['NAV_STRING']) echo $arResult['NAV_STRING'];?>
<?endif;?>