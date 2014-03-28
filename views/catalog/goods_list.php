<?php if (!empty($items)): ?>

	<table class="goods-table">
		<tbody>
		
			<tr>
				<th colspan="2">Модель</th>
				<th>Наличие</th>
				<th>Цена</th>
			</tr>

			<?php foreach ($items as $k=>$item): ?>

				<tr>
					<td>
						<?php if (!empty($item->photos[0]->file)): ?>
							<?=anchor($upload_dir.$item->photos[0]->id.'/'.$item->photos[0]->file, '<img src="'.$upload_dir.$item->photos[0]->id.'/small'.$item->photos[0]->file.'" alt="" class="preview" />', array('class'=>'shop_product_list_image modal', 'title'=>$item->title))?>
						<?php endif; ?>
					</td>
					<td width="50%">
						<div class="goods-table__info"><?=$item->title?></div>
						<div class="goods-table__info">Модель: <?=$item->model?></div>
						<div class="goods-table__info">Производитель: <?=$item->manufacturer?></div>
						<div class="goods-table__info">Код: <?=$item->code?></div>
						<div class="goods-table__info">Страна: <?=$item->country?></div>
						<div class="goods-table__info"><?=$item->text?></div>
						<div class="goods-table__info"><?=anchor('shop/product/'.$item->id, 'Полное описание', array('class'=>'button'))?></div>
					</td>
					<td>
						<?php if (!empty ($item->depth)): ?>
							<?=(1*$item->depth)?>/<?=(1*$item->width)?>/<?=(1*$item->height)?>&nbsp;см
						<?php else: ?>
							-
						<?php endif; ?>
					</td>
					<td>
						<?=($item->availability) ? 'В наличии' : 'Под заказ' ?>
					</td>
					<td>
						<?=number_format($item->price, 2, '.', ' ')?>&nbsp;руб<br />
						<span class="js-cart__add js-cart__add-<?=$item->id?>" data-id="<?=$item->id?>" data-price="<?=$item->price?>" data-title="<?=$item->title?>" data-num="1" data-code="<?=$item->code?>">купить</span>
					</td>
				</tr>

			<?php endforeach; ?>

		</tbody>
	</table>
	
	<?php $this->load->view('shop/catalog/pagination'); ?>

<?php else: ?>

	<div class="mess">Список пуст</div>

<?php endif; ?>
