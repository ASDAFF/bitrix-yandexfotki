<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult['PHOTO']):?>
	<div class="beono-yandexfotki-album_photo">
		<div class="beono-yandexfotki-photo">
			<div class="beono-yandexfotki-photo-image">
				<img alt="<?=$arResult['PHOTO']['TITLE']?>" src="<?=$arResult['PHOTO']['SRC'][$arParams['SIZE']]['HREF']?>" width="<?=$arResult['PHOTO']['SRC'][$arParams['SIZE']]['WIDTH']?>" height="<?=$arResult['PHOTO']['SRC'][$arParams['SIZE']]['HEIGHT']?>" />
				<?if($arResult['PREV']['URL']):?>
				<div class="beono-yandexfotki-album-prev_photo">
					<a rel="<?if($arParams['AJAX_MODE']=='Y') echo 'ajax';?>" id="beono_yandexfotki_prev_photo" href="<?=$arResult['PREV']['URL']?>">&nbsp</a>
				</div>
				<?endif;?>
				<?if($arResult['NEXT']['URL']):?>
				<div class="beono-yandexfotki-album-next_photo">
					<a rel="<?if($arParams['AJAX_MODE']=='Y') echo 'ajax';?>" id="beono_yandexfotki_next_photo" href="<?=$arResult['NEXT']['URL']?>">&nbsp</a>			
				</div>
				<?endif;?>
			</div>
			<?if($arParams['DISPLAY_DATE'] == 'Y' && $arResult['PHOTO']['DATE_PUBLISHED']):?>
			<div class="beono-yandexfotki-photo-date">
				<img class="beono-yandexfotki-icon" src="<?=$this->GetFolder();?>/images/date.png"/><?=$arResult['PHOTO']['DATE_PUBLISHED']?>				
			</div>
			<?endif;?>
			<?if($arParams['DISPLAY_ORIGINAL'] == 'Y' && $arResult['PHOTO']['SRC']['orig']['HREF']):?>
			<div class="beono-yandexfotki-photo-original">
				<a target="_blank" href="<?=$arResult['PHOTO']['SRC']['orig']['HREF']?>"><?=GetMessage('BEONO_YAFOTKI_PHOTO_ORIGINAL');?></a>			
			</div>	
			<?endif;?>
			<?if($arParams['DISPLAY_SHARE'] == 'Y'):?>
			<div class="beono-yandexfotki-photo-share">
				<?if(!$_GET['bxajaxid']):?>
				<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
				<?endif;?>
				<script type="text/javascript">
				 var YaShareInstance = new Ya.share({element:'ya_share',
					link: '<?=$arResult['PHOTO']['URL'];?>',
					elementStyle: {
						type: 'button',
						quickServices: ['']
					}
				 });
				 YaShareInstance.updateShareLink('http://api.yandex.ru', 'API');
				</script>
				<div id="ya_share" ></div>	
			</div>		
			<?endif;?>	 
		</div>
	</div>
<?endif;?>

