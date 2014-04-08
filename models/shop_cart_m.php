<?php defined('BASEPATH') or exit('No direct script access allowed');

class shop_cart_m extends MY_Model {


	public function update_order($blank, $id)
	{
		return $this->db->where('id', $id)->update('shop_orders', array('blank'=>$blank));
	}

	public function insert_order($type_payment, $type_delavery, $res_items, $name, $email, $phone, $address, $text)
	{
		$user_id = !empty($this->current_user->id) ? $this->current_user->id : 0;
		$order_id = $this->next_insert_id('shop_orders');
		$res = array(
			'id'=>$order_id,
			'user_id'=>$user_id,
			'name'=>$name,
			'email'=>$email,
			'phone'=>$phone,
			'address'=>$address,
			'text'=>$text,
			'type_payment_id'=>$type_payment,
			'type_delavery_id'=>$type_delavery,
			'created_on'=>time()
		);
		if ($this->db->insert('shop_orders', $res)) 
		{
			foreach ($res_items as $v)
			{
				$res = array(
					'item_id'=>$v->id,
					'order_id'=>$order_id,
					'num'=>$v->num,
					'title'=>$v->title,
					'code'=>$v->code,
					'price'=>$v->price
				);
				$this->db->where('id', $v->id)->update('shop_items', array('balance'=>($v->balance - $v->num)));
				$this->db->insert('shop_order_items', $res);
			}
			return $order_id;
		}
		return false;
	}
	
	public function get_type_delavery()
	{
		$this->db
			->select('*')
			->from('shop_type_delavery')
			->where('published', 1)
			->order_by('`order`', 'ASC');
		return $this->db->get()->result();
	}

	public function get_type_payments()
	{
		$this->db
			->select('*')
			->from('shop_type_payments')
			->where('published', 1)
			->order_by('`order`', 'ASC');
		return $this->db->get()->result();
	}

	public function get_cart_items()
	{
		if (!empty($_COOKIE['cart'])) $cart = json_decode( $_COOKIE['cart'] );
		else $cart = array();
		if ( !count($cart) ) return array();
		$id_array = array();
		foreach($cart as $v) $id_array[] = $v[0];
		
		$this->db
			->select('*')
			->from('shop_items')
			->where_in('id', $id_array)
			->where('published', 1);
		$res = $this->db->get()->result();
		
		foreach($res as $k=>$v)
		{
			foreach($cart as $vv)
			{
				if ($v->id == $vv[0]) $res[$k]->num = $vv[1];
			}
		}
		
		return $this->get_photos($res);
	}
	
	function get_photos($res)
	{
		foreach ($res as $k=>$v)
		{
			$this->db
				->select('*')
				->from('shop_gallery c')
				->where('item_id', $v->id)
				->order_by('`order`', 'ASC');
			$res[$k]->photos = $this->db->get()->result();
		}
		return $res;
	}
	
	public function next_insert_id($table) // определить следующий по порядку id для insert
	{
		$res = $this->db->query("SHOW TABLE STATUS LIKE '".$this->db->dbprefix($table)."'");
		if ($res->num_rows() == 1) 
		{
			$row = $res->row();
			return $row->Auto_increment;
		}
		else return false;
	}
	
	function get_summ()
	{
		$items = $this->shop_cart_m->get_cart_items();
		$summ = 0;
		foreach($items as $v)
		{
			$summ =+ $v->num*$v->price;
		}
		return $summ;
	}
	
}