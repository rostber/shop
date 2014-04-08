<?php echo form_open_multipart($this->uri->uri_string(), 'class="form"'); ?>

	<input type="hidden" value="1" name="blank" />
	<ol>
		<?php
		$fields = array(
			'rec_name'=>'ФИО плательщика',
			'rec_address'=>'Адрес плательщика'
		);
		?>
		<?php foreach ($fields as $k=>$v): ?>
		<li>
			<label for="<?=$k?>"><?=$v?> <span>*</span></label>
			<div class="input"><?php echo form_input($k, false, 'maxlength="255" class="required" id="'.$k.'"'); ?></div>
		</li>
		<?php endforeach; ?>
		<li>
			<input type="submit" name="sub" value="Оформить заказ" class="button" />
		</li>
	</ol>

<?php echo form_close(); ?>
