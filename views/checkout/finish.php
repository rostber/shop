<div class="no_print">
	<h1><?=lang('shop.finish')?></h1>

	<div class="mess"><b>Ваш заказ оформлен.</b><br />Данные отправлены нашему менеджеру. В ближайшее время он с Вами свяжется.</div>
</div>

<?php if ($blank): ?>
	<span class="print no_print" onclick="window.print();">Печатать</span>
	<?=$blank?>
<?php endif; ?>