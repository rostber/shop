<?php defined('BASEPATH') or exit('No direct script access allowed');

class shop_m extends MY_Model {

	public $group_current_id = 0;
	
	public $bk_arr = array();
	
	function bk($group_id)
	{
		$this->bk_rec($group_id);
		return array_reverse($this->bk_arr);
	}
	
	function bk_rec($group_id)
	{
		if ($group_id) 
		{
			$ret = $this->get_group($group_id);
			$this->bk_arr[] = $ret;
			if ($ret->parent_group_id) $this->bk_rec($ret->parent_group_id);
		}
	}
	
	function set_prices($data)
	{
		foreach ($data as $k=>$v)
		{
			$data[$k]->price = $this->set_price($data[$k]->price);
		}
		
		return $data;
	}
	function set_price($price)
	{
		
		$price = $price * $this->config->item('shop.correlation_cost'); 
		
		$price = round($price, 2);
		
		return $price;
	}
	
	public function get_search_list($search, $limit = 10)
	{
		if (empty ($search)) return array();
		return $this->db->query("
		SELECT `title`
			FROM {$this->db->dbprefix('shop_items')}
			WHERE `published`=1 AND `title` LIKE '%{$search}%'
		UNION
			SELECT `code` AS `title`
			FROM {$this->db->dbprefix('shop_items')}
			WHERE `published`=1 AND `code` LIKE '{$search}%'
		UNION
			SELECT `manufacturer` AS `title`
			FROM {$this->db->dbprefix('shop_items')}
			WHERE `published`=1 AND `manufacturer` LIKE '{$search}%'
		GROUP BY `title`
		LIMIT {$limit}
		")->result();
	}
	
	public function get_search_items($search, $limit_1 = 50)
	{
		if (empty ($search)) return array();
		$this->db
			->select('*')
			->from('shop_items')
			->where('published', 1)
			->like('title', $search)
			->or_like('code', $search, 'none')
			->or_like('manufacturer', $search)
			->order_by('title', 'ASC')
			->limit($limit_1);
		$res = $this->db->get()->result();
		return $this->get_photos($res);	
	}

	public function group_rec($id, $level_depth = false, $level = 0, $photo_item = array())
	{
		$groups = $this->shop_m->get_groups($id);
		foreach ($groups as $k=>$group)
		{
			if (!count($photo_item)) $photo_item = $this->shop_m->get_first_photo($group->id);
			if ($level_depth === false or $level < $level_depth)
			{
				$groups[$k]->childs = $this->group_rec($group->id, $level_depth, $level + 1, &$photo_item);
			}
			$groups[$k]->photo = $photo_item;
			if (!$level) $photo_item = array();
		}
		return $groups;
	}
	

	public function get_item($id = 0)
	{
		$this->db
			->select('i.*, gi.group_id AS gi_group_id')
			->from('shop_items i')
			->join('shop_group_items gi', 'gi.item_id = i.id', 'inner')
			->where('i.published', 1)
			->limit(1);
		$this->db->where('i.id', $id);
		$res = $this->db->get()->result();
		$res = $this->get_photos($res);	
		return isset($res[0]) ? $res[0]: $res;
	}
	
	public function count_items($id = false)
	{
		if ($id) $groups_a = $this->get_array_childs_group($id);
		$this->db
			->select('COUNT( DISTINCT(i.id) ) AS `numrows`')
			->from('shop_items i')
			->join('shop_group_items gi', 'gi.item_id = i.id', 'inner')
			->where('i.published', 1);
		if ($id) $this->db->where_in('gi.group_id', $groups_a);
		$ret = $this->db->get()->result();
		return (!empty($ret[0])) ? $ret[0]->numrows : 0;
	}


	public function get_items($pagination, $id = 0)
	{
		if ($id) $groups_a = $this->get_array_childs_group($id);
		$this->db
			->select('i.*')
			->from('shop_items i')
			->join('shop_group_items gi', 'gi.item_id = i.id', 'inner')
			->where('i.published', 1)
			->order_by('gi.order', 'ASC')
			->order_by('i.title', 'ASC')
			->group_by('gi.id')
			->limit($pagination['limit'], $pagination['offset']);
		if ($id) $this->db->where_in('gi.group_id', $groups_a);
		$res = $this->db->get()->result();
		return $this->get_photos($res);	
	}
	
	var $childs_group = array();
	
	function get_array_childs_group($id)
	{
		if (count($this->childs_group)) return $this->childs_group;
		else return $this->get_array_childs_group_rec($id);
	}
	
	function get_array_childs_group_rec($id)
	{
		$ret = array();
		$ret[$id] = $id;
		$res = $this->db
			->select('*')
			->from('shop_groups')
			->where('parent_group_id', $id)
			->where('published', 1)
			->get()
			->result();
		foreach ($res as $v)
		{
			$ret[$v->id] = $v->id;
			$ret = $ret + $this->get_array_childs_group_rec($v->id);
		}
		return $ret;
	}
	
	public function get_home($limit_1 = 10)
	{
		$this->db
			->select('*')
			->from('shop_items')
			->where('show_home', 1)
			->where('published', 1)
			->order_by('RAND()')
			->limit($limit_1);
		$res = $this->db->get()->result();
		return $this->get_photos($res);	
	}
	
	function get_photos($res)
	{
		foreach ($res as $k=>$v)
		{
			$this->db
				->select('*')
				->from('shop_gallery')
				->where('item_id', $v->id)
				->order_by('`order`', 'ASC');
			$res[$k]->photos = $this->db->get()->result();
		}
		return $res;
	}

	public function get_group($id = 0)
	{
		$this->db
			->select('*')
			->from('shop_groups')
			->where('id', $id)
			->where('published', 1)
			->limit(1);
		$res = $this->db->get()->result();	
		return isset($res[0]) ? $res[0]: $res;
	}
	
	public function get_groups($id = 0)
	{
		$this->db
			->select('*')
			->from('shop_groups')
			->where('parent_group_id', $id)
			->where('published', 1)
			->order_by('`order`', 'ASC');
		return $this->db->get()->result();		
	}
	
	public function get_first_photo($id = 0)
	{
		$this->db
			->select('cg.*')
			->from('shop_items c')
			->join('shop_gallery cg', 'cg.item_id = c.id', 'inner')
			->join('shop_group_items gi', 'gi.item_id = c.id', 'inner')
			->where('gi.group_id', $id)
			->where('published', 1)
			->order_by('c.title', 'ASC')
			->limit(1);
		$res = $this->db->get()->result();	
		return !empty($res[0]->file) ? $res[0]: $res;
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

}