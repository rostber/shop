<div style="text-align: center; height: 234px; font-size: 14px; font-style: italic; position: relative;">
	<img src="/addons/shared_addons/themes/stk/img/blank.jpg" alt="" style="position: absolute; left: 0; top: 0; display: block; z-index: 1;" />
	<div style="position: absolute; left: 0; top: 30px; padding-left: 467px; width: 450px; z-index: 10;">
		<?=$rec_company?>, г. Москва, Анадырский пр-д, д. 63<br />
		Представительство  в г. Тверь, пл. Гагарина, д. 1<br />
		Тел. 8 (4822) 68-02-20,  8 (980) 642-67-48 МТС<br />
		{{ settings:contact_email }}, {{ url:site }}<br />
		ИНН <?=$rec_inn?>  КПП <?=$rec_kpp?><br />
		ОГРН <?=$rec_kor_ogrn?>
	</div>
</div>

<p><b>Образец заполнения платежного поручения</b></p>

<table width="100%" border="1">
	<tbody>
		<tr>
			<td colspan="2">ИНН: <?=$rec_inn?></td>
		</tr>
		<tr>
			<td colspan="2">Получатель:</td>
		</tr>
		<tr>
			<td><?=$rec_company?></td>
			<td>Кор. сч.: <?=$rec_kor_sch?></td>
		</tr>
		<tr>
			<td>Банк получателя:</td>
			<td>БИК: <?=$rec_bik?></td>
		</tr>
		<tr>
			<td><?=$rec_bank_address?></td>
			<td>Расч.сч.: <?=$rec_num?></td>
		</tr>
	</tbody>
</table>

<p><b>СЧЕТ № <?=$id?>-СТК от <?=date("d.m.Y")?> г.</b></p>

<p>
	Плательщик: <?=$name?><br />
	Грузополучатель: <?=$name?>
</p>

<table width="100%" border="1">
	<tbody>
		<tr>
			<th>№</th>
			<th>Наименование товара</th>
			<th>Единица измерения</th>
			<th>Количество</th>
			<th>Цена</th>
			<th>Сумма</th>
		</tr>
		
		<?php foreach ($items as $k=>$v): ?>
		<tr>
			<td><?=$k+1?></td>
			<td><?=$v->title?> <?=$v->model?>, <?=$v->manufacturer?> - код <?=$v->code?></td>
			<td align="center">шт.</td>
			<td align="center"><?=$v->num?></td>
			<td align="center"><?=number_format($v->price, 2, '.', ' ')?></td>
			<td align="center"><?=number_format($v->price*$v->num, 2, '.', ' ')?></td>
		</tr>
		<?php 
		endforeach; 
		?>
		
	</tbody>
</table>

<p style="text-align: right;">
Итого: <?=number_format($total, 2, '.', ' ')?> руб.<br />
В т.ч. НДС: <?=number_format($nds, 2, '.', ' ')?> руб.<br />
Всего к оплате:	<b><?=number_format($total_nds, 2, '.', ' ')?> руб.</b>
</p>
<p>
Всего наименований <?=count($items)?>, на сумму <?=number_format($total_nds, 2, '.', ' ')?><br />
<?=$total_prop?><br />
Счет подлежит оплате в течение 3-х банковских дней!				
</p>
<div style="position: relative;">
	<div style="position: relative;">
		<?=$rec_dol1?>:
		<div style="position: absolute; right: 0; top: 0;">(<?=$rec_name1?>)</div>
	</div>
	<div style="margin-top: 130px; position: relative;">
		<?=$rec_dol2?>:
		<div style="position: absolute; right: 0; top: 0;">(<?=$rec_name2?>)</div>
	</div>
	<img src="<?=site_url().$rec_shtamp?>" alt="" style="position: absolute;left: 50%;top:0;margin-left: -70px;" />
</div>
