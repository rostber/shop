<?php defined('BASEPATH') OR exit('No direct script access allowed');

// [высота], [ширина], [вписать в область], [водяной знак]

// фотографии продуктов
$config['shop.gallery_sizes'] = array(
		''=>array(1000, 1000, false, false),
		'middle'=>array(450, 600, false, false),
		'small'=>array(180, 240, false, false)
	);

// фотографии таксонов
$config['shop.group_sizes'] = array(
		''=>array(60, 60, false, false)
	);

$config['shop.quality'] = 80;
$config['shop.upload_dir'] = 'shop_items/';
$config['shop.upload_groups_dir'] = 'shop_groups/';

$config['shop.correlation_cost'] = 1; // коэффициент изменения стоимости

// импорт
$config['shop.import_temp_dir'] = 'shop_import/'; // директория для загрузки импортируемого каталога
$config['shop.import_step_items'] = 500; // разбить файл на N записей

// печать бланка для оплата в банке
$config['shop.rec_inn'] = '6950069433'; // инн
$config['shop.rec_kpp'] = '771643001'; // кпп
$config['shop.rec_num'] = '40702810612000005530'; // счет
$config['shop.rec_bank_address'] = 'Филиал ОАО "ГУТА-БАНК" в г.Твери г.Тверь'; // адрес банка
$config['shop.rec_bik'] = '042809995'; // бик
$config['shop.rec_kor_sch'] = '30101810400100000995'; // кор. счет
$config['shop.rec_company'] = 'ООО "СТК"'; // Организация

// данные yandex money
$config['shop.ya_m_id'] = '.....';
$config['shop.ya_m_redirect_path'] = '/shop/pay_complete';
$config['shop.ya_m_secret'] = '....';
