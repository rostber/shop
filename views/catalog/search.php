<h3>Результаты поиска:</h3>

<?php if ($items): ?>

	<table class="products-table" width="100%">
	
		<tr>
			<th colspan="2">Модель</th>
			<th>Габариты</th>
			<th>Напряжение</th>
			<th>Мощность</th>
			<th>Наличие</th>
			<th>Цена</th>
		</tr>

	<?php 
	foreach ($items as $k=>$item):
	?>

		<tr>
			<td>
				<?php
				$image = '/uploads/default/shop/no_photo.jpg';
				$image_big = false;
				if (!empty($item->photos[0]->file)) 
				{
					$image = $upload_dir.$item->photos[0]->id.'/small'.$item->photos[0]->file;
					$image_big = $upload_dir.$item->photos[0]->id.'/'.$item->photos[0]->file;
				}
				?>
				<?php if ($image_big): ?>
					<?=anchor($image_big, '<img src="'.$image.'" alt="" />', array('class'=>'products-table__img', 'title'=>$item->title))?>
				<?php else: ?>
					<span class="shop_product_list_image"><?='<img src="'.$image.'" alt="" />'?></span>
				<?php endif; ?>
			</td>
			<td width="50%">
				<div><?=$item->title?></div>
				<div>Модель: <?=$item->model?></div>
				<div>Производитель: <?=$item->manufacturer?></div>
				<div>Код: <?=$item->code?></div>
				<span class="button" onclick="show_detail(this, '#item_<?=$k?>');">Подробнее</span>
			</td>
			<td class="shop_product_list_col_center">
				<?php if (!empty ($item->depth_packaging)): ?>
					<?=(1*$item->depth_packaging)?>/<?=(1*$item->width_packaging)?>/<?=(1*$item->height_packaging)?>&nbsp;см
				<?php else: ?>
					-
				<?php endif; ?>
			</td>
			<td class="shop_product_list_col_center">
				<?php if (!empty ($item->voltage)): ?>
					<?=$item->voltage?>
				<?php else: ?>
					-
				<?php endif; ?>
			</td>
			<td class="shop_product_list_col_center">
				<?php if (!empty ($item->power)): ?>
					<?=$item->power?>&nbsp;кВт
				<?php else: ?>
					-
				<?php endif; ?>
			</td>
			<td class="shop_product_list_col_center">
				<?=($item->availability) ? '<span class="green">В наличии</span>' : '<span class="red">Под заказ</span>' ?>
			</td>
			<td class="shop_product_list_col_center shop_product_list_item_6">
				<span class="shop_product_list_price"><?=number_format($item->price, 2, '.', ' ')?>&nbsp;руб</span><br />
				<span class="shop_product_list_add_cart button js_add_cart js_add_cart_<?=$item->id?>" data-id="<?=$item->id?>" data-price="<?=$item->price?>" data-title="<?=$item->title?>" data-num="1" data-code="<?=$item->code?>" data-image="<?=$image?>" title="Добавить в заказ">купить</span>
			</td>
		</tr>
		<tr><td colspan="7" style="display: none;">&nbsp;</td></tr>
		<tr style="display: none;">
			<td colspan="7">
				<div class="shop_product_list_item_detail" id="item_<?=$k?>">
					<div>Страна: <?=$item->country?></div>
					<p>
						<?=$item->text?>
					</p>
					<? /*<?=anchor('shop/product/'.$item->id, 'Полное описание', array('class'=>'button'))?> */ ?>
				</div>
			</td>
		</tr>

	<?php endforeach; ?>

	</table>

<?php else: ?>

	<div class="mess">Список пуст</div>

<?php endif; ?>

<?php $this->load->view('shop/catalog/pagination'); ?>


