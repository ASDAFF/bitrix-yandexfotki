<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<?if(is_array($arResult['ITEMS'])):?>
<div class="beono-yandexfotki-albums beono-yandexfotki-size_<?=strtolower($arParams['SIZE'])?>"><!-- 
	<?foreach($arResult['ITEMS'] as $arAlbum):?>
	 --><div class="beono-yandexfotki-photo">
			<div class="beono-yandexfotki-photo-image">
				<a href="<?=$arAlbum['URL']?>" title="<?=$arAlbum['TITLE']?>"><?if($arAlbum['COVER']['SRC'][$arParams['SIZE']]['HREF']):?><img alt="<?=$arAlbum['TITLE']?>" src="<?=$arAlbum['COVER']['SRC'][$arParams['SIZE']]['HREF']?>" width="<?=$arAlbum['COVER']['SRC'][$arParams['SIZE']]['WIDTH']?>" height="<?=$arAlbum['COVER']['SRC'][$arParams['SIZE']]['HEIGHT']?>" /><?else:?><img alt="<?=$arAlbum['TITLE']?>" src="<?=$this->GetFolder();?>/images/photos.png" width="16" height="16" /><?endif;?>&nsbp;</a>
			</div>
			<div class="beono-yandexfotki-photo-title"><a target="_self" href="<?=$arAlbum['URL']?>" title="<?=$arAlbum['TITLE']?>"><?=$arAlbum['TITLE']?></a></div>
			<div class="beono-yandexfotki-photo-summary"><?=$arAlbum['SUMMARY']?></div>
		<?if($arParams['SIZE'] != 'S'):?>
			<?if($arParams['DISPLAY_DATE'] == 'Y' && $arAlbum['DATE_PUBLISHED']):?>
			<div class="beono-yandexfotki-photo-date">
				<img class="beono-yandexfotki-icon" src="<?=$this->GetFolder();?>/images/date.png"/><?=$arAlbum['DATE_PUBLISHED']?>
			</div>
			<?endif;?>
			<?if($arAlbum['IMAGE_COUNT']):?>
			<div class="beono-yandexfotki-photo-count">
				<img class="beono-yandexfotki-icon" src="<?=$this->GetFolder();?>/images/photos.png"/><?=$arAlbum['IMAGE_COUNT']?>	
			</div>
			<?endif;?>
		<?endif;?>
		</div><!-- 
	<?endforeach;?>
	--></div>
<?if ($arResult['NAV_STRING']) echo $arResult['NAV_STRING'];?>
<?endif;?>