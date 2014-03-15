<h3>Квитанция на оплату для физических лиц</h3>

<span class="print" onclick="window.print();">Печатать</span>				

<style type="text/css">
hr { height: 1px; margin: 0px; padding: 0px; color: #000000; background-color: #000000; line-height: 0; }
* html hr {margin:-7px 0; display: block; padding: 0; border: 0; /* для IE6 */}
*+html hr {margin:-7px 0; display: block; padding: 0; border: 0; /* для IE7 */}
hr { border: 0\9 /* для IE8 */ }

.main_div
{
	margin-left: 0.5em;
	margin-right: 0.5em;
	margin-top: 2em;
	margin-bottom: 1em;
}
.content .main_div td {
	padding: 5px;
}
.content .main_div table table td {
	padding: 0;
}
.content .main_div hr {
	border-color: black;
	margin: 0;
}
</style>

<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">

<div class="main_div">
  <table xmlns="" rules="all" border="1" bordercolor="#000000" cellpadding="5" cellspacing="0" width="680">
	<tbody><tr valign="top">
	  <td height="275" width="190">
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td align="center">
			  <font size="2">
				<b>Извещение</b>
			  </font>
			</td>
		  </tr>
		  <tr>
			<td align="center" height="240" valign="bottom">
			  <font size="2">
				<b>Кассир</b>
			  </font>
			</td>
		  </tr>
		</tbody></table>
	  </td>
	  <td>
		<div align="right">
		  <font size="1">
			<i>Форма №ПД-4</i>
		  </font>
		</div>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td>
			  <font size="2">
				<b><?=$rec_company?></b>
			  </font>
			</td>
		  </tr>
		  <tr>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">
			  <font size="1">(наименование получателя платежа)</font>
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="150">
			  <font size="2"><?=$rec_inn?>/<?=$rec_kpp?></font>
			</td>
			<td rowspan="3" width="20"></td>
			<td>
			  <font size="2"><?=$rec_num?></font>
			</td>
		  </tr>
		  <tr>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">
			  <font size="1">(ИНН/КПП получателя платежа)</font>
			</td>
			<td align="center" valign="top">
			  <font size="1">(номер счета получателя платежа)</font>
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="5">
			  <font size="2">в</font>
			</td>
			<td width="5"></td>
			<td width="320">
			  <font size="2"><?=$rec_bank_address?></font>
			</td>
			<td rowspan="3" width="10"></td>
			<td width="20">
			  <font size="2">БИК</font>
			</td>
			<td rowspan="3" width="5"></td>
			<td>
			  <font size="2"><?=$rec_bik?></font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td colspan="3" align="center" valign="top">
			  <font size="1">(наименование банка получателя платежа)</font>
			</td>
			<td align="center" valign="top"></td>
			<td align="center" valign="top"></td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="280">
			  <font size="2">Номер кор./сч. банка получателя платежа</font>
			</td>
			<td width="10"></td>
			<td>
			  <font size="2"><?=$rec_kor_sch?></font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="225">
			  <font size="2">Оплата по счету № <?=$id?></font>
			</td>
			<td width="10"></td>
			<td></td>
		  </tr>
		  <tr>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">
			  <font size="1">(наименование платежа)</font>
			</td>
			<td></td>
			<td align="center" valign="top">
			  <font size="1">(номер лицевого счета (код) плательщика)</font>
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="120">
			  <font size="2">Ф.И.О. плательщика</font>
			</td>
			<td rowspan="4" width="10"></td>
			<td>
			  <font size="1">12312 rostber </font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td align="left">
			  <font size="2">Адрес плательщика</font>
			</td>
			<td>
			  <font size="1">123123,	Россия, Москва и Московская обл., Абрамцево, 123123123</font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td align="left" width="70">
			  <font size="1">
				<bobr>Сумма платежа</bobr>
			  </font>
			</td>
			<td width="45">
			  <font size="2">11675</font>
			</td>
			<td width="20">
			  <font size="1"> руб. </font>
			</td>
			<td align="center" width="20">
			  <font size="2">0</font>
			</td>
			<td width="20">
			  <font size="1"> коп.</font>
			</td>
			<td> </td>
			<td width="105">
			  <font size="1">
				<bobr>Сумма платы за услуги </bobr>
			  </font>
			</td>
			<td width="45"> </td>
			<td width="20">
			  <font size="1"> руб. </font>
			</td>
			<td class="bottom_border" align="center" width="20"> </td>
			<td width="20">
			  <font size="1">&nbsp;коп.</font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td align="left" width="30">
			  <font size="1">Итого</font>
			</td>
			<td width="50"> </td>
			<td width="20">
			  <font size="1">&nbsp;руб.&nbsp;</font>
			</td>
			<td class="bottom_border" align="center" width="20"> </td>
			<td>
			  <font size="1">&nbsp;коп.</font>
			</td>
			<td align="right">
			  <table class="default" rules="none" border="0" cellpadding="0" cellspacing="0">
				<tbody><tr>
				  <td width="2">
					<font size="1">«</font>
				  </td>
				  <td width="30"></td>
				  <td width="2">
					<font size="1">»</font>
				  </td>
				  <td width="90"></td>
				  <td width="10">
					<font size="1">20</font>
				  </td>
				  <td width="15"></td>
				  <td width="2">
					<font size="1">г.</font>
				  </td>
				</tr>
				<tr>
				  <td></td>
				  <td height="1">
					<hr color="#000000" noshade="noshade" size="1">
				  </td>
				  <td></td>
				  <td height="1">
					<hr color="#000000" noshade="noshade" size="1">
				  </td>
				  <td></td>
				  <td height="1">
					<hr color="#000000" noshade="noshade" size="1">
				  </td>
				  <td></td>
				</tr>
			  </tbody></table>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td></td>
		  </tr>
		</tbody></table>
		<font size="1">С условиями приема указанной в платежном документе
					суммы, в т.ч. с суммой взимаемой платы за услуги банка,
				ознакомлен и согласен.</font>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td align="right">
			  <font size="1">
				<b>Подпись плательщика</b>
			  </font>
			</td>
			<td width="150"></td>
		  </tr>
		  <tr>
			<td></td>
			<td width="150">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		</tbody></table>
	  </td>
	</tr>
  </tbody></table>
  <table xmlns="" rules="all" border="1" bordercolor="#000000" cellpadding="5" cellspacing="0" width="680">
	<tbody><tr valign="top">
	  <td height="275" width="190">
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td align="center">
			  <font size="2">
				<b>Квитанция</b>
			  </font>
			</td>
		  </tr>
		  <tr>
			<td align="center" height="240" valign="bottom">
			  <font size="2">
				<b>Кассир</b>
			  </font>
			</td>
		  </tr>
		</tbody></table>
	  </td>
	  <td>
		<div align="right">
		  <font size="1">
			<i>Форма №ПД-4</i>
		  </font>
		</div>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td>
			  <font size="2">
				<b>ООО "Инфинити"</b>
			  </font>
			</td>
		  </tr>
		  <tr>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">
			  <font size="1">(наименование получателя платежа)</font>
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="150">
			  <font size="2">1234567897/123456789</font>
			</td>
			<td rowspan="3" width="20"></td>
			<td>
			  <font size="2">40500000000000001</font>
			</td>
		  </tr>
		  <tr>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">
			  <font size="1">(ИНН/КПП получателя платежа)</font>
			</td>
			<td align="center" valign="top">
			  <font size="1">(номер счета получателя платежа)</font>
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="5">
			  <font size="2">в</font>
			</td>
			<td width="5"></td>
			<td width="320">
			  <font size="2">Сбербанк России ОАО г. Москва</font>
			</td>
			<td rowspan="3" width="10"></td>
			<td width="20">
			  <font size="2">БИК</font>
			</td>
			<td rowspan="3" width="5"></td>
			<td>
			  <font size="2">024040</font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td colspan="3" align="center" valign="top">
			  <font size="1">(наименование банка получателя платежа)</font>
			</td>
			<td align="center" valign="top"></td>
			<td align="center" valign="top"></td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="280">
			  <font size="2">Номер кор./сч. банка получателя платежа</font>
			</td>
			<td width="10"></td>
			<td>
			  <font size="2">30700000000000001</font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="225">
			  <font size="2">Оплата по счету № 246</font>
			</td>
			<td width="10"></td>
			<td></td>
		  </tr>
		  <tr>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">
			  <font size="1">(наименование платежа)</font>
			</td>
			<td></td>
			<td align="center" valign="top">
			  <font size="1">(номер лицевого счета (код) плательщика)</font>
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td width="120">
			  <font size="2">Ф.И.О. плательщика</font>
			</td>
			<td rowspan="4" width="10"></td>
			<td>
			  <font size="1">12312 rostber </font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		  <tr>
			<td align="left">
			  <font size="2">Адрес плательщика</font>
			</td>
			<td>
			  <font size="1">123123,	Россия, Москва и Московская обл., Абрамцево, 123123123</font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td align="left" width="70">
			  <font size="1">
				<bobr>Сумма платежа</bobr>
			  </font>
			</td>
			<td width="45">
			  <font size="2">11675</font>
			</td>
			<td width="20">
			  <font size="1"> руб. </font>
			</td>
			<td align="center" width="20">
			  <font size="2">0</font>
			</td>
			<td width="20">
			  <font size="1"> коп.</font>
			</td>
			<td> </td>
			<td width="105">
			  <font size="1">
				<bobr>Сумма платы за услуги </bobr>
			  </font>
			</td>
			<td width="45"> </td>
			<td width="20">
			  <font size="1"> руб. </font>
			</td>
			<td class="bottom_border" align="center" width="20"> </td>
			<td width="20">
			  <font size="1">&nbsp;коп.</font>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
		  </tr>
		</tbody></table>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td align="left" width="30">
			  <font size="1">Итого</font>
			</td>
			<td width="50"> </td>
			<td width="20">
			  <font size="1">&nbsp;руб.&nbsp;</font>
			</td>
			<td class="bottom_border" align="center" width="20"> </td>
			<td>
			  <font size="1">&nbsp;коп.</font>
			</td>
			<td align="right">
			  <table class="default" rules="none" border="0" cellpadding="0" cellspacing="0">
				<tbody><tr>
				  <td width="2">
					<font size="1">«</font>
				  </td>
				  <td width="30"></td>
				  <td width="2">
					<font size="1">»</font>
				  </td>
				  <td width="90"></td>
				  <td width="10">
					<font size="1">20</font>
				  </td>
				  <td width="15"></td>
				  <td width="2">
					<font size="1">г.</font>
				  </td>
				</tr>
				<tr>
				  <td></td>
				  <td height="1">
					<hr color="#000000" noshade="noshade" size="1">
				  </td>
				  <td></td>
				  <td height="1">
					<hr color="#000000" noshade="noshade" size="1">
				  </td>
				  <td></td>
				  <td height="1">
					<hr color="#000000" noshade="noshade" size="1">
				  </td>
				  <td></td>
				</tr>
			  </tbody></table>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td height="1">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
			<td></td>
			<td></td>
		  </tr>
		</tbody></table>
		<font size="1">С условиями приема указанной в платежном документе
					суммы, в т.ч. с суммой взимаемой платы за услуги банка,
				ознакомлен и согласен.</font>
		<table class="default" rules="none" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
			<td align="right">
			  <font size="1">
				<b>Подпись плательщика</b>
			  </font>
			</td>
			<td width="150"></td>
		  </tr>
		  <tr>
			<td></td>
			<td width="150">
			  <hr color="#000000" noshade="noshade" size="1">
			</td>
		  </tr>
		</tbody></table>
	  </td>
	</tr>
  </tbody></table>
</div>
