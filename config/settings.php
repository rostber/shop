<?php defined('BASEPATH') OR exit('No direct script access allowed');

// [высота], [ширина], [вписать в область], [водяной знак]
$config['shop.gallery_sizes'] = array(
		''=>array(480, 480, false, false),
		'middle'=>array(240, 240, true, false),
		'small'=>array(160, 220, false, false)
	);

$config['shop.group_sizes'] = array(
		''=>array(60, 60, false, false)
	);

$config['shop.quality'] = 80;
$config['shop.upload_dir'] = 'shop_items/';
$config['shop.upload_groups_dir'] = 'shop_groups/';

$config['shop.correlation_cost'] = 1; // изменение стоимости

$config['shop.import_temp_dir'] = 'shop_import/'; // директория для загрузки импортируемого каталога
$config['shop.import_step_items'] = 500; // разбить файл на N записей

$config['shop.nds'] = 18/118; // ндс
$config['shop.rec_inn'] = '6950069033'; // инн
$config['shop.rec_kpp'] = '771645001'; // кпп
$config['shop.rec_num'] = '40702810610000005030'; // счет
$config['shop.rec_bank_address'] = 'Филиал ОАО "ГУТА-БАНК" в г.Твери г.Тверь'; // адрес банка
$config['shop.rec_bik'] = '042809995'; // бик
$config['shop.rec_kor_sch'] = '30101810400000000995'; // кор. счет
$config['shop.rec_kor_ogrn'] = '1076952027239'; // ОГРН
$config['shop.rec_title'] = 'Покупка в магазине stk-food.ru'; // наименование платежа
$config['shop.rec_name1'] = 'Москвин А.П.'; // ФИО руководителя 1
$config['shop.rec_name2'] = 'Трофимова Л.Н.'; // ФИО руководителя 2
$config['shop.rec_dol1'] = 'Руководитель предприятия'; // Должность руководителя 1
$config['shop.rec_dol2'] = 'Главный бухгалтер'; // Должность руководителя 2
$config['shop.rec_company'] = 'ООО "СТК"'; // Организация
$config['shop.rec_shtamp'] = 'uploads/shtamp.png'; // Организация
