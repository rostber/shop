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
	
	function num2str($num) {
		$nul='ноль';
		$ten=array(
			array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
			array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
		);
		$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
		$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
		$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
		$unit=array( // Units
			array('копейка' ,'копейки' ,'копеек',	 1),
			array('рубль'   ,'рубля'   ,'рублей'    ,0),
			array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
			array('миллион' ,'миллиона','миллионов' ,0),
			array('миллиард','милиарда','миллиардов',0),
		);
		//
		list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
		$out = array();
		if (intval($rub)>0) {
			foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
				if (!intval($v)) continue;
				$uk = sizeof($unit)-$uk-1; // unit key
				$gender = $unit[$uk][3];
				list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
				// mega-logic
				$out[] = $hundred[$i1]; # 1xx-9xx
				if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
				else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
				// units without rub & kop
				if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
			} //foreach
		}
		else $out[] = $nul;
		$out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
		$out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
		return $this->mb_ucfirst( trim(preg_replace('/ {2,}/', ' ', join(' ',$out))) );
	}

	/**
	 * Склоняем словоформу
	 * @ author runcore
	 */
	function morph($n, $f1, $f2, $f5) {
		$n = abs(intval($n)) % 100;
		if ($n>10 && $n<20) return $f5;
		$n = $n % 10;
		if ($n>1 && $n<5) return $f2;
		if ($n==1) return $f1;
		return $f5;
	}
	/* первая буква заглавная */
    function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
               mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
	
}