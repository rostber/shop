<?php defined('BASEPATH') or exit('No direct script access allowed');

class shop_admin_m extends MY_Model {

	public function get_items_lonely($pagination)
	{
		$ret = $this->db->query("SELECT i.* FROM `".$this->db->dbprefix('shop_items')."` i WHERE i.`id` NOT IN (SELECT gi.`item_id` FROM `".$this->db->dbprefix('shop_group_items')."` `gi`) LIMIT {$pagination['offset']}, {$pagination['limit']}");
		return $ret->result();
	}
	
	public function count_items_lonely()
	{
		$ret = $this->db->query("SELECT i.* FROM `".$this->db->dbprefix('shop_items')."` i WHERE i.`id` NOT IN (SELECT gi.`item_id` FROM `".$this->db->dbprefix('shop_group_items')."` `gi`)");
		return count($ret->result());
	}
	
	public function get_items($pagination)
	{
		$this->db
			->select('*')
			->from('shop_items')
			->order_by('`order`', 'ASC')
			->limit($pagination['limit'], $pagination['offset']);
		return $this->db->get()->result();		
	}
	
	public function count_items()
	{
		return $this->db->count_all_results('shop_items');
	}
	
	public function orders()
	{
		$this->db
			->select('o.*, p.display_name, p.last_name, p.first_name')
			->from('shop_orders o')
			->join('profiles p', 'p.user_id = o.user_id', 'left')
			->order_by('o.created_on', 'DESC');
		return $this->db->get()->result();		
	}
	
	public function get_gallery($id)
	{
		$this->db->select('*')->from('shop_gallery')->where('item_id', $id)->order_by('`order`', 'ASC')->order_by('id', 'ASC');
		return $this->db->get()->result();		
	}
	
	function delete_gallery($id)
	{
		if ($this->db->where('id', $id)->delete('shop_gallery'))
		{
			delete_directory(UPLOAD_PATH.$this->config->item('shop.upload_dir').$id.'/');
			return true;
		}
	}
	
	public $bk_arr = array();
	
	function bk($group_id)
	{
		$this->bk_rec($group_id);
		return array_reverse($this->bk_arr);
	}
	
	function bk_rec($group_id)
	{
		if ($group_id != 0) 
		{
			$ret = $this->get_group($group_id);
			$this->bk_arr[] = $ret;
			if ($ret->parent_group_id) $this->bk_rec($ret->parent_group_id);
		}
	}
	
	public function get_group($id)
	{
    	$result = $this->db
			->select('*')
			->from('shop_groups')
			->where('id', $id)
			->order_by('`order`', 'ASC')
			->get()->result();
		return (count($result) > 0) ? $result[0] : $result;
	}

	public function get_all_groups($id)
	{
		$this->db
			->select('*')
			->from('shop_groups')
			->where('parent_group_id', $id)
			->order_by('`order`', 'ASC');
		return $this->db->get()->result();
	}
	
	public function get_all_items($id_group)
	{
		$this->db
			->select('i.*, gi.id AS `group_item_id`')
			->from('shop_items i')
			->join('shop_group_items gi', 'gi.item_id = i.id', 'inner')
			->where('gi.group_id', $id_group)
			->order_by('gi.`order`', 'ASC')
			->order_by('i.`title`', 'ASC');
		return $this->db->get()->result();
	}
	
	public function get($id)
	{
    	$result = $this->db->select('*')->from('shop_items')->where('id', $id)->get()->result();
		return (!empty ($result[0])) ? $result[0] : false;
	}
	
	public function get_order($id)
	{
    	$result = $this->db
			->select('o.*, p.display_name, p.first_name, p.last_name, tp.title AS payment, td.title AS delavery')
			->from('shop_orders o')
			->join('profiles p', 'p.user_id = o.user_id', 'left')
			->join('shop_type_payments tp', 'tp.id = o.type_payment_id', 'innder')
			->join('shop_type_delavery td', 'td.id = o.type_delavery_id', 'innder')
			->where('o.id', $id)
			->get()
			->result();
		return (!empty ($result[0])) ? $result[0] : false;
	}
	
	public function get_all_items_options()
	{
		$ret = array();
    	$result = $this->db->select('*')->from('shop_items')->order_by('code', 'ASC')->get()->result();
		foreach($result as $v)
		{
			$ret[$v->id] = $v->code.' '.$v->title;
		}
		return $ret;
	}
	
	public function get_order_items($id)
	{
    	$result = $this->db->select('*')->from('shop_order_items')->where('order_id', $id)->get()->result();
		return $result;
	}
	
	public function get_all_group($id)
	{
    	$result = $this->db->select('*')->from('shop_groups')->where('id', $id)->get()->result();
		return (!empty ($result[0])) ? $result[0] : false;
	}
	
	public function get_all_group_item($id)
	{
    	$result = $this->db->select('*')->from('shop_group_items')->where('id', $id)->get()->result();
		return (!empty ($result[0])) ? $result[0] : false;
	}

	public function insert($post, $id = 0)
	{
		$post['price'] = str_replace(',', '.', $post['price']);
		$post['price'] = preg_replace('[^0-9\.]', '', $post['price']);
		
		$res = array(
			'updated_on' => time()
					);
		
		// trim integer
		$rows = array('title', 'published', 'order', 'text', 'code', 'brand', 'manufacturer', 'price', 'balance', 'delivery', 'depth', 'width', 'height', 'site', 'weight', 'country', 'model');		
		foreach ($rows as $v)
		{
			$res['`'.$v.'`'] = $post[$v];
		}
		
		// boolean
		$rows = array('show_home');		
		foreach ($rows as $v)
		{
			if (!empty($post[$v])) $res['`'.$v.'`'] = $post[$v];
			else $res['`'.$v.'`'] = 0;
		}
		
		if ($id)
		{
			if ($this->db->where('id', $id)->update('shop_items', $res)) 
			{
				$this->copy_files($id);
				$this->pyrocache->delete_all('shop_m');
				return true;
			}
			else return false;
		}
		else
		{
			$res['created_on'] = time();
			if ($this->db->insert('shop_items', $res)) 
			{
				$this->copy_files( $this->next_insert_id('shop_items')-1 );
				$this->pyrocache->delete_all('shop_m');
				return true;
			}
			else return false;
		}
	}
	
	public function insert_group_item($post, $id = 0)
	{
		$res = array(
			'updated_on' => time()
					);
		
		// trim integer
		$rows = array('group_id', 'item_id');		
		foreach ($rows as $v)
		{
			$res['`'.$v.'`'] = $post[$v];
		}
		
		if ($id)
		{
			if ($this->db->where('id', $id)->update('shop_group_items', $res)) 
			{
				$_SESSION['group_id'] = $post['group_id'];
				$this->pyrocache->delete_all('shop_m');
				return true;
			}
			else return false;
		}
		else
		{
			$res['created_on'] = time();
			if ($this->db->insert('shop_group_items', $res)) 
			{
				$_SESSION['group_id'] = $post['group_id'];
				return true;
			}
			else return false;
		}
	}
	
	public function get_order_item($id)
	{
    	$result = $this->db
			->select('*')
			->from('shop_order_items')
			->where('id', $id)
			->limit(1)
			->get()->result();
		return (count($result) > 0) ? $result[0] : $result;
	}
	
	public function update_order($id, $post)
	{
		$res = array( 'created_on' => time() );
		$not_deleted_a = array();
		if (!empty($post['item_id']))
		{
			foreach ($post['item_id'] as $k=>$v)
			{
				// обновление кол-во товара на складе
				$res_order_item = $this->get_order_item($v);
				$this->update_item_balance($res_order_item->item_id, $res_order_item->num - $post['item_num'][$k]);
				
				$this->db
					->where('id', $v)
					->update('shop_order_items', array('num'=>1*$post['item_num'][$k]));
				$this->pyrocache->delete_all('shop_m');
				$not_deleted_a[] = $v;
			}
		}
		
		// обновление кол-во товара на складе
		if (count($not_deleted_a)) $this->db->where_not_in('id', $not_deleted_a);
		$res_order_items = $this->db->where('order_id', $id)->from('shop_order_items')->get()->result();
		foreach ($res_order_items as $v)
		{
			$res_order_item = $this->get_order_item($v->id);
			if ($res_order_item) $this->update_item_balance($v->item_id, $res_order_item->num);
		}
		
		if (count($not_deleted_a)) $this->db->where_not_in('id', $not_deleted_a);
		$this->db->where('order_id', $id)->delete('shop_order_items');

		if (!empty($post['item_new_id']))
		{
			foreach ($post['item_new_id'] as $k=>$v)
			{
				$res = $this->get($v);
				if ($res)
				{
					$this->db->insert('shop_order_items', 
						array(
							'item_id'=>$v,
							'order_id'=>$id,
							'title'=>$res->title,
							'code'=>$res->code,
							'price'=>$res->price,
							'num'=>$post['item_new_num'][$k]
						)
					);

					// обновление кол-во товара на складе
					$this->update_item_balance($v, -$post['item_new_num'][$k]);
				}
			}
		}
		return true;
	}
	
	function update_item_balance($item_id, $add_balance)
	{
		$res = $this->get($item_id);
		if ($res)
		{
			$balance = $res->balance + $add_balance;
			if ($balance > 0) return $this->db->where('id', $item_id)->update('shop_items', array('balance'=>$balance));
		}
		return false;
	}
	
	function copy_files($item_id)
	{
		if (!empty ($_POST['file_id']))
		{
			$res_files = $this->db
				->select('*')
				->from('shop_gallery')
				->where_not_in('id', $_POST['file_id'])
				->where('item_id', $item_id)->get()->result();
			if ($res_files) 
			{
				foreach ($res_files as $v) $this->delete_gallery($v->id);
			}
		}
		if (!empty ($_FILES['file']['size']))
		{
			$dir = UPLOAD_PATH.$this->config->item('shop.upload_dir');
			check_dir($dir);
			foreach ($_FILES['file']['name'] as $k=>$name)
			{
				if ($_FILES['file']['size'][$k])
				{
					if (!empty($_POST['file_id'][$k])) $id = $_POST['file_id'][$k];
					else $id = $this->next_insert_id('shop_gallery');
					
					$dir_item = $dir.$id.'/';
				
					$nameN = translit_str($name);
					
					delete_directory($dir_item);
					check_dir($dir_item);
					
					edit_image_settings( $_FILES['file']['tmp_name'][$k], $dir_item, $nameN, false, $this->config->item('shop.gallery_sizes'), $this->config->item('shop.quality') );
					
					if (!empty($_POST['file_id'][$k])) 
					{
						$this->db->where('id', $_POST['file_id'][$k])->update('shop_gallery', array('file'=>$nameN));
					}
					else
					{
						$this->db->insert('shop_gallery', array('item_id'=>$item_id, 'file'=>$nameN));
					}
				}
			}
		}
	}
	
	function copy_group_file($group_id, $file, $dir, $size)
	{
		if (!empty ($_FILES[$file]['size']))
		{
			$dir = UPLOAD_PATH.$dir;
			check_dir($dir);
			$name = $_FILES[$file]['name'];				
			$dir_group = $dir.$group_id.'/';
		
			$nameN = translit_str($name);
			
			delete_directory($dir_group);
			check_dir($dir_group);
			
			edit_image_settings( $_FILES[$file]['tmp_name'], $dir_group, $nameN, false, $size, $this->config->item('shop.quality') );
			
			$this->db->where('id', $group_id)->update('shop_groups', array($file=>$nameN));
		}
		if (!empty($_POST['delete_image']) and $_POST['delete_image'] == $file)
		{
			$dir_group = UPLOAD_PATH.$dir.$group_id.'/';
			delete_directory($dir_group);
			$this->db->where('id', $group_id)->update('shop_groups', array($_POST['delete_image']=>null));
		}
	}
	
	public function insert_group($post, $id = 0)
	{
		$res = array(
				'title' => $post['title'], 
				'published' => $post['published'], 
				'order' => $post['order'], 
				'text' => $post['text'], 
				'updated_on' => time()
			);
										
		if (isset ($post['order']) and !is_numeric($post['order'])) $res['`order`'] = 0;
		if (!empty ($post['parent_group_id'])) $res['parent_group_id'] = $post['parent_group_id']; else $res['parent_group_id'] = 0;
		
		if ($id)
		{
			if ($this->db->where('id', $id)->update('shop_groups', $res)) 
			{
				$this->copy_group_file($id, 'file', $this->config->item('shop.upload_groups_dir'), $this->config->item('shop.group_sizes'));
				$_SESSION['parent_group_id'] = $res['parent_group_id'];
				$this->pyrocache->delete_all('shop_m');
				return true;
			}
			else return false;
		}
		else
		{
			$res['created_on'] = time();
			$id = $this->next_insert_id('shop_groups');
			if ($this->db->insert('shop_groups', $res)) 
			{
				$this->copy_group_file($id, 'file', $this->config->item('shop.upload_groups_dir'), $this->config->item('shop.group_sizes'));
				$_SESSION['parent_group_id'] = $res['parent_group_id'];
				$this->pyrocache->delete_all('shop_m');
				return true;
			}
			else return false;
		}
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
	
	public function toggle_published($id)
	{
		$res = $this->get($id);
		if (count ($res) != 0)
		{
			if ($res->published) $res->published = 0;
			else $res->published = 1;
			if ($this->db->where('id', $id)->update('shop_items', array ('published' => $res->published))) 
			{
				$this->pyrocache->delete_all('shop_m');
				return true;
			}
			else return false;
		}
		else return false;
	}
	
	public function toggle_published_group($id)
	{
		$res = $this->db->get_where('shop_groups', array('id'=>$id))->row();
		if (count ($res) != 0)
		{
			if ($res->published) $res->published = 0;
			else $res->published = 1;
			if ($this->db->where('id', $id)->update('shop_groups', array ('published' => $res->published))) 
			{
				$this->pyrocache->delete_all('shop_m');
				return true;
			}
			else return false;
		}
		else return false;
	}
	
	public function delete_order($id)
	{
		if ($this->db->where('id', $id)->delete('shop_orders')) 
		{
			$this->db->where('order_id', $id)->delete('default_shop_order_items');
			return true;
		}
		else return false;
	}
	
	public function delete_item($id)
	{
		if ($this->db->where('id', $id)->delete('shop_items'))
		{
			$this->db->where('item_id', $id)->delete('shop_group_items');
			$res = $this->db
					->select('*')
					->from('shop_gallery')
					->where('item_id', $id)
					->get()->result();
			foreach ($res as $k=>$v)
			{
				$this->db->where('id', $v->id)->delete('shop_gallery');
				delete_directory(UPLOAD_PATH.$this->config->item('shop.upload_dir').$v->id.'/');
			}
			$this->pyrocache->delete_all('shop_m');
			return true;
		}
		else return false;
	}
	
	public function delete($id)
	{
		if ($this->db->where('id', $id)->delete('shop_group_items')) 
		{
			$this->pyrocache->delete_all('shop_m');
			return true;
		}
		else return false;
	}
	
	public function delete_group($id)
	{
		$res = $this->db->select('*')->from('shop_groups')->where('parent_group_id', $id)->get()->result();
		foreach ($res as $v) $this->delete_group($v->id);
		
		if ($this->db->where('id', $id)->delete('shop_groups')) 
		{
			$dir_group = UPLOAD_PATH.$this->config->item('shop.upload_groups_dir').$id.'/';
			delete_directory($dir_group);
			
			$dir_group = UPLOAD_PATH.$this->config->item('shop.upload_groups_gallery_dir').$id.'/';
			delete_directory($dir_group);
		
			$this->db->where('group_id', $id)->delete('shop_group_items');
			$this->pyrocache->delete_all('shop_m');
			return true;
		}
		else return false;
	}
	
	var $group_parents_id = array('0'=>'-');
	
	public function group_parents_id_rec($none_id = 0, $id = 0, $level = 0)
	{
		$pad = '';
		for ($i=0; $i <= $level; $i++) $pad .= '- ';
		
		$res = $this->db->query("SELECT * FROM `".$this->db->dbprefix('shop_groups')."` WHERE `parent_group_id` = ".$id." AND `id` <> ".$none_id." ORDER BY `order` ASC, `id` ASC")->result();
		
		foreach ($res as $v)
		{
			$this->group_parents_id[$v->id] = $pad.$v->title;
			$this->group_parents_id_rec($none_id, $v->id, $level + 1);
		}
	}
	
	public function group_parents_id($none_id = 0)
	{
		$this->group_parents_id_rec($none_id);
		return $this->group_parents_id;
	}
	
	public function items_id()
	{
		$this->db
			->select('*')
			->from('shop_items')
			->order_by('title', 'ASC');
		$res = $this->db->get()->result();
		$arr = array();
		foreach ($res as $v) $arr[$v->id] = $v->title.' - '.$v->id;
		return $arr;
	}

}