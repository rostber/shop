<h1>
<?php if (!empty($admin)): ?>
	Заказ №<?=$order_id?>
<?php else: ?>
	Вы успешно оформили заказ №<?=$order_id?> от <?=date("d.m.Y")?> г.
<?php endif; ?>
</h1>

<?php if (!empty($admin)): ?>
	<p><b>Ф.И.О.(ИП или ООО:</b> <?=$name?></p>
	<p><b>E-mail:</b> <?=$email?></p>
	<p><b>Телефон:</b> <?=$phone?></p>
	<p><b>Адрес:</b> <?=$address?></p>
	<p><?=$text?></p>
<?php endif; ?>

<p><b>Заказ:</b></p>
<ul>
<?php foreach($items as $item): ?>
	<li>
		<?=$item->title?> <?=$item->model?>, <?=$item->manufacturer?> - код <?=$item->code?><br />
		Кол-во: <?=$item->num?> шт.<br />
		Цена: <?=number_format($item->price, 2, '.', ' ')?> руб./шт.
	</li>
<?php endforeach; ?>
</ul>

<p><b>Стоимость заказа: <?=number_format($total, 2, '.', ' ')?> руб.</b></p>

<p>
	<?=anchor(site_url().'shop/show_blank/'.$order_id, lang('shop.blank_label'), array('target'=>'_blank'))?>
</p>

<?php if (empty($admin)): ?>
	<p><i>В ближайшее время с Вами свяжется наш менеджер.</i></p>
<?php endif; ?>
