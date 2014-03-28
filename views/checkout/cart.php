
<h1>Моя корзина</h1>

<div class="js-cart__show">

	<?php if (count ($items)): ?>

		<table class="cart-list">
			<tbody>
			
				<tr>
					<th width="110" class="cart-list__col-1">Фото</th>
					<th class="cart-list__col-2">Наименование</th>
					<th class="cart-list__col-3">Кол-во</th>
					<th class="cart-list__col-4">Цена, руб.</th>
					<th class="cart-list__col-4">Сумма, руб.</th>
					<th class="cart-list__col-5"></th>
				</tr>

				<?php foreach ($items as $item): ?>

					<tr>
						<td class="cart-list__col-1">
							<?php if (!empty($item->photos[0]->file)): ?>	
								<?=anchor(site_url().'shop/product/'.$item->id, '<img src="'.$upload_dir.$item->photos[0]->id.'/small'.$item->photos[0]->file.'" alt="" width="100" class="preview" />', array('class'=>'cart_list_image', 'title' => $item->title))?>
							<?php endif; ?>
						</td>
						<td class="cart-list__col-2">
							<p><?=anchor('shop/product/'.$item->id, $item->title)?></p>
							<p>Артикул: <?=$item->code?></p>
						</td>
						<td class="cart-list__col-3">
							<input type="text" name="num" class="js-cart__list-num" data-id="<?=$item->id?>" value="<?=$item->num?>" />
						</td>
						<td class="cart-list__col-4">
							<span class="cart_list_price"><?=number_format($item->price, 2, '.', ' ')?></span>
						</td>
						<td class="cart-list__col-6">
							<span class="cart_list_price js-cart__summ-<?=$item->id?>"><?=number_format($item->price*$item->num, 2, '.', ' ')?></span>
						</td>
						<td class="cart-list__col-5">
							<span class="js-cart__delete" data-id="<?=$item->id?>" data-price="<?=$item->price?>" data-title="<?=$item->title?>" data-num="1" data-code="<?=$item->code?>" title="Удалить">X</span>
						</td>
					</tr>

				<?php endforeach; ?>

				<tr>
					<td colspan="3"></td>
					<td class="cart_list_summ_label">
						<b>Всего сумма:</b>
					</td>
					<td>
						<b><span class="js-cart__summ">0</span>&nbsp;р.</b>
					</td>
					<td>&nbsp;</td>
				</tr>

			</tbody>
		</table>

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


	<?php endif; ?>
	
</div>
<div class="js-cart__hide">

	<div class="notice-box">Корзина пуста</div>

</div>
