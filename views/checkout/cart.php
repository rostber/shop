
<h1>Моя корзина</h1>

<?php if (count ($items)): ?>

<div class="block">

<table class="cart_list">
	<tbody>
	
		<tr>
			<th width="110" class="cart_list_col_1">Фото</th>
			<th class="cart_list_col_2">Наименование</th>
			<th class="cart_list_col_3">Кол-во</th>
			<th class="cart_list_col_4">Цена, руб.</th>
			<th class="cart_list_col_4">Сумма, руб.</th>
			<th class="cart_list_col_5">Удаление</th>
		</tr>

<?php 
foreach ($items as $item):
?>

		<tr>
			<td class="cart_list_col_1">
				<?php
				$image = '/uploads/default/shop/no_photo.jpg';
				if (!empty($item->photos[0]->file)) $image = $upload_dir.$item->photos[0]->id.'/small'.$item->photos[0]->file;
				?>	
				<?=anchor(site_url().'shop/product/'.$item->id, '<img src="'.$image.'" alt="" width="100" class="preview" />', array('class'=>'cart_list_image', 'title' => $item->title))?>
			</td>
			<td class="cart_list_col_2">
				<p><?=anchor('shop/product/'.$item->id, $item->title)?></p>
				<p>Артикул: <?=$item->code?></p>
			</td>
			<td class="cart_list_col_3">
				<input type="text" name="num" class="js_cart_list_num cart_list_num" data-id="<?=$item->id?>" value="<?=$item->num?>" />
			</td>
			<td class="cart_list_col_4">
				<span class="cart_list_price"><?=number_format($item->price, 2, '.', ' ')?></span>
			</td>
			<td class="cart_list_col_6">
				<span class="cart_list_price js_cart_summ_<?=$item->id?>"><?=number_format($item->price*$item->num, 2, '.', ' ')?></span>
			</td>
			<td class="cart_list_col_5">
				<span class="cart_list_delete js_delete_cart" data-id="<?=$item->id?>" data-price="<?=$item->price?>" data-title="<?=$item->title?>" data-num="1" data-code="<?=$item->code?>" data-image="<?=$image?>" title="Удалить">&nbsp;</span>
			</td>
		</tr>

<?php endforeach; ?>

		<tr>
			<td colspan="3"></td>
			<td class="cart_list_summ_label">
				<b>Всего сумма:</b>
			</td>
			<td>
				<b><span class="js_cart_summ">0</span>&nbsp;р.</b>
			</td>
			<td>&nbsp;</td>
		</tr>

	</tbody>
</table>

</div>

<div class="block block_cart">

	<h3 class="block_cart_title">Оформление заказа</h3>

	<?php echo form_open_multipart(site_url().'shop/checkout', 'class="form"'); ?>
		<ol>	
		
<?php if ( !empty ($this->_ci_cached_vars['current_user']->id) ): ?>

			<?php
			$fields = array(
				'name'=>array('Ф.И.О.(ИП или ООО)', 'username'),
				'address'=>array('Адрес', false),
				'email'=>array('E-mail', 'email'),
				'phone'=>array('Телефон', 'phone')
			);
			?>
			<?php foreach ($fields as $k=>$v): ?>
			<li>
				<label for="<?=$k?>"><?=$v[0]?> <span>*</span></label>
				<div class="input"><?php echo form_input($k, ($v[1] ? $this->_ci_cached_vars['current_user']->$v[1] : false), 'maxlength="255" class="required" id="'.$k.'"'); ?></div>
			</li>
			<?php endforeach; ?>

<?php else: ?>	

			<?php
			$fields = array(
				'name'=>'Ф.И.О.(ИП или ООО)',
				'address'=>'Адрес',
				'email'=>'E-mail',
				'phone'=>'Телефон'
			);
			?>
			<?php foreach ($fields as $k=>$v): ?>
			<li>
				<label for="<?=$k?>"><?=$v?> <span>*</span></label>
				<div class="input"><?php echo form_input($k, false, 'maxlength="255" class="required" id="'.$k.'"'); ?></div>
			</li>
			<?php endforeach; ?>

<?php endif; ?>

			<li>
				<label for="text">Вопросы и пожелания</label>
				<div class="input"><?php echo form_textarea(array('id'=>'text', 'name'=>'text', 'value' => '', 'rows' => 10, 'class' => 'wysiwyg-advanced')); ?></div>
			</li>

			<li>
				<button class="button_flash">Оформить заказ</button>
			</li>

		</ol>
	<?php echo form_close(); ?>
	
</div>

<?php else: ?>

<div class="notice-box">Список пуст</div>

<?php endif; ?>
