<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

	<input type="hidden" value="1" name="blank" />
	<ol>
		<?php
		$fields = array(
			'inn'=>'ИНН',
			'kpp'=>'КПП',
			'platelshik'=>'Плательщик',
			'bank'=>'Банк получателя',
			'schot'=>'Счет',
			'bik'=>'Бик',
			'kor'=>'Кор. счет',
			'poluchatel'=>'Грузополучатель',
		);
		?>
		<?php foreach ($fields as $k=>$v): ?>
		<li>
			<label for="<?=$k?>"><?=$v?> <span>*</span></label>
			<div class="input"><?php echo form_input($k, false, 'maxlength="255" class="required" id="'.$k.'"'); ?></div>
		</li>
		<?php endforeach; ?>
	</ol>

<?php echo form_close(); ?>
