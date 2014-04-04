<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_shop extends Module {

	public $version = '2.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Shop',
				'ru' => 'Магазин'
			),
			'description' => array(
				'en' => 'Web shop',
				'ru' => 'Интернет магазин'
			),
			'frontend' => true,
			'backend' => true,
			'skip_xss' => true,
			'menu' => 'content',
			
			'sections' => array(
			    'posts' => array(
				    'name' => 'shop.list_label',
				    'uri' => 'admin/shop',

				),
				'items' => array(
				    'name' => 'shop.items_list_label',
				    'uri' => 'admin/shop/items',

				),
				'items_lonely' => array(
				    'name' => 'shop.items_lonely_list_label',
				    'uri' => 'admin/shop/items_lonely',

				),
				'orders' => array(
				    'name' => 'shop.orders_list_label',
				    'uri' => 'admin/shop/orders',

				)
		    ),
			'shortcuts' => array(
				array(
				   'name' => 'shop.new_item_label',
					'uri' => 'admin/shop/create_item',
					'class' => 'add'
				),
				array(
				   'name' => 'shop.new_group_label',
					'uri' => 'admin/shop/create_group',
					'class' => 'add'
				),
				array(
				   'name' => 'shop.new_group_item_label',
					'uri' => 'admin/shop/create_group_item',
					'class' => 'add'
				),
				array(
				   'name' => 'shop.import_label',
					'uri' => 'admin/shop/import',
					'class' => 'import'
				)
			)
		);
	}

	public function install()
	{
		$this->db->query("
			CREATE TABLE `".$this->db->dbprefix('shop_groups')."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `main_1c_id` varchar(64) NULL default NULL,
			  `title` varchar(255) NOT NULL,
			  `text` text,
			  `parent_group_id` int(11) NOT NULL default 0,
			  `file` varchar(255) NULL default NULL,
			  `order` int(11) NOT NULL default 0,
			  `created_on` int(11) NOT NULL default 0,
			  `updated_on` int(11) NOT NULL default 0,
			  `published` INT(1) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("
			CREATE TABLE `".$this->db->dbprefix('shop_items')."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL,
			  
			  `code` varchar(255) NULL default NULL,
			  `brand` varchar(255) NULL default NULL,
			  `manufacturer` varchar(255) NULL default NULL,
			  `price` DECIMAL (11,2) NOT NULL default 0,
			  `balance` int(11) NOT NULL default 0,
			  `delivery` varchar(255) NULL default NULL,
			  `main_1c_id` varchar(64) NULL default NULL,
			  `measurement` varchar(32) NULL default NULL,
			  `depth` varchar(128) NULL default NULL,
			  `width` varchar(128) NULL default NULL,
			  `height` varchar(128) NULL default NULL,
			  `site` varchar(255) NULL default NULL,
			  `weight` varchar(255) NULL default NULL,
			  `country` varchar(255) NULL default NULL,
			  `model` varchar(255) NULL default NULL,
			  
			  `show_home` int(11) NOT NULL default 0,
			  `group_id` int(11) NOT NULL default 0,
			  `text` text,
			  `order` int(11) NOT NULL default 0,
			  `created_on` int(11) NOT NULL default 0,
			  `updated_on` int(11) NOT NULL default 0,
			  `published` INT(1) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("
			CREATE TABLE `".$this->db->dbprefix('shop_group_items')."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `item_id` int(11) NOT NULL default 0,
			  `group_id` int(11) NOT NULL default 0,
			  `order` int(11) NOT NULL default 0,
			  `created_on` int(11) NOT NULL default 0,
			  `updated_on` int(11) NOT NULL default 0,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("
			CREATE TABLE `".$this->db->dbprefix('shop_gallery')."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `item_id` int(11) NOT NULL default 0,
			  `title` varchar(255) NULL default NULL,
			  `order` int(11) NOT NULL default 0,
			  `file` varchar(255) NULL default NULL,
			  `url` varchar(255) NULL default NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("
			CREATE TABLE `".$this->db->dbprefix('shop_orders')."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL default 0,
			  `name` varchar(255) NULL default NULL,
			  `email` varchar(255) NULL default NULL,
			  `phone` varchar(255) NULL default NULL,
			  `address` varchar(255) NULL default NULL,
			  `text` text NULL default NULL,
			  `blank` longtext NULL default NULL,
			  `type_payment_id` int(11) NOT NULL default 0,
			  `type_delavery_id` int(11) NOT NULL default 0,
			  `created_on` int(11) NOT NULL default 0,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("
			CREATE TABLE `".$this->db->dbprefix('shop_order_items')."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `item_id` int(11) NOT NULL default 0,
			  `order_id` int(11) NOT NULL default 0,
			  `num` int(11) NOT NULL default 0,
			  `title` varchar(255) NULL default NULL,
			  `code` varchar(255) NULL default NULL,
			  `price` DECIMAL (11,2) NOT NULL default 0,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("
			CREATE TABLE `".$this->db->dbprefix('shop_type_payments')."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL,
			  `text` text,
			  `redirect` varchar(255) NULL default NULL,
			  `order` int(11) NOT NULL default 0,
			  `created_on` int(11) NOT NULL default 0,
			  `updated_on` int(11) NOT NULL default 0,
			  `published` INT(1) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("
			INSERT INTO `".$this->db->dbprefix('shop_type_payments')."` (
			  `id`,
			  `title`,
			  `redirect`,
			  `published`
			)
			VALUES (
			  1,
			  'Наличными',
			  NULL,
			  1
			),
			(
			  2,
			  'Банковская квитанция',
			  'blank',
			  1
			),
			(
			  3,
			  'Безналичный расчет',
			  'pay',
			  0
			);
		");
		
		$this->db->query("
			CREATE TABLE `".$this->db->dbprefix('shop_type_delavery')."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL,
			  `text` text,
			  `price` DECIMAL (11,2) NOT NULL default 0,
			  `order` int(11) NOT NULL default 0,
			  `created_on` int(11) NOT NULL default 0,
			  `updated_on` int(11) NOT NULL default 0,
			  `published` INT(1) DEFAULT 0,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("
			INSERT INTO `".$this->db->dbprefix('shop_type_delavery')."` (
			  `id`,
			  `title`,
			  `price`,
			  `published`
			)
			VALUES (
			  1,
			  'Самовывоз',
			  0,
			  1
			),
			(
			  2,
			  'Доставка по почте',
			  200,
			  1
			);
		");

		return TRUE;
	}

	public function uninstall()
	{
		$this->db->query("DROP TABLE `".$this->db->dbprefix('shop_items')."`");
		$this->db->query("DROP TABLE `".$this->db->dbprefix('shop_group_items')."`");
		$this->db->query("DROP TABLE `".$this->db->dbprefix('shop_gallery')."`");
		$this->db->query("DROP TABLE `".$this->db->dbprefix('shop_groups')."`");
		$this->db->query("DROP TABLE `".$this->db->dbprefix('shop_orders')."`");
		$this->db->query("DROP TABLE `".$this->db->dbprefix('shop_type_payments')."`");
		$this->db->query("DROP TABLE `".$this->db->dbprefix('shop_order_items')."`");
		$this->db->query("DROP TABLE `".$this->db->dbprefix('shop_type_delavery')."`");
		return TRUE;
	}

	public function upgrade($old_version)
	{
		return TRUE;
	}

	public function help()
	{
		// You could include a file and return it here.
		return "The shop module.";
	}
}
/* End of file details.php */