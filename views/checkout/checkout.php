<h1>Оформление заказа</h1>

<p>Для завершения покупки, выберите способ оплаты и доставки.</p>

<form action="" method="post" class="form">
	<input type="hidden" name="checkout" value="1" />
	<fieldset>
		<legend>Способ оплаты:</legend>
		<ol>
		<?php foreach ($type_payment as $k=>$item): ?>
			<li>
				<label><input type="radio" value="<?=$item->id?>" name="type_payment"<?=(!$k ? ' checked="checked"' : false)?> /> <?=$item->title?></label>
				<?=$item->text?>
			</li>
		<?php endforeach; ?>
		</ol>
	</fieldset>
	<fieldset>
		<legend>Способ доставки:</legend>
		<ol>
		<?php foreach ($type_delavery as $k=>$item): ?>
			<li>
				<label><input type="radio" value="<?=$item->id?>" name="type_delavery"<?=(!$k ? ' checked="checked"' : false)?> /> <?=$item->title?></label>
				<?=$item->text?>
			</li>
		<?php endforeach; ?>
		</ol>
	</fieldset>
	<input type="submit" value="Оформить заказ" />
</form>
