<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {
	
	private $item_validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:shop.title_label',
			'rules' => 'trim|max_length[255]|required'
		),
		array(
			'field' => 'order',
			'label' => 'lang:shop.order_label',
			'rules' => 'integer|max_length[11]|required'
		),
		array(
			'field' => 'published',
			'label' => 'lang:shop.published_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'text',
			'label' => 'lang:shop.text_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'show_home',
			'label' => 'lang:shop.show_home_label',
			'rules' => 'trim'
		)
	);
	
	private $group_validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:shop.title_label',
			'rules' => 'trim|max_length[255]|required'
		),
		array(
			'field' => 'order',
			'label' => 'lang:shop.order_label',
			'rules' => 'integer|max_length[11]'
		),
		array(
			'field' => 'parent_group_id',
			'label' => 'lang:shop.parent_id_label',
			'rules' => 'integer|max_length[11]'
		),
		array(
			'field' => 'published',
			'label' => 'lang:shop.published_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'text',
			'label' => 'lang:shop.text_label',
			'rules' => 'trim'
		)
	);
	
	private $validation_rules = array(
		array(
			'field' => 'item_id',
			'label' => 'lang:shop.item_id_label',
			'rules' => 'integer|max_length[11]'
		),
		array(
			'field' => 'order',
			'label' => 'lang:shop.order_label',
			'rules' => 'integer|max_length[11]'
		),
		array(
			'field' => 'group_id',
			'label' => 'lang:shop.group_id_label',
			'rules' => 'integer|max_length[11]'
		),
	);
	
	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('shop_admin_m');
		$this->load->library('form_validation');
		$this->lang->load('shop');
		$this->config->load('settings');
		$this->load->helper('html');
		$this->load->helper('edit_files');
		
		$this->data = new stdClass;
		
		$this->data->upload_dir = UPLOAD_PATH.$this->config->item('shop.upload_dir');
		$this->data->upload_groups_dir = UPLOAD_PATH.$this->config->item('shop.upload_groups_dir');
		$this->data->import_temp_dir = UPLOAD_PATH.$this->config->item('shop.import_temp_dir');
		
		check_dir($this->data->upload_dir);
		check_dir($this->data->upload_groups_dir);

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
		
		$this->data->rows_trim = array('code'=>1, 'brand'=>0, 'manufacturer'=>0, 'delivery'=>0, 'price'=>1, 'balance'=>1, 'depth'=>0, 'width'=>0, 'height'=>0, 'site'=>0, 'weight'=>0, 'country'=>0, 'model'=>0);
		
		foreach ($this->data->rows_trim as $k=>$v)
		{
			if ($v) $req = 'required';
			else $req = '';
			$this->item_validation_rules[] = array(
				'field' => $k,
				'label' => 'lang:shop.'.$k.'_label',
				'rules' => 'trim|max_length[255]|'.$req
			);
		}
	}

	function index()
	{
		$this->data->current_group = 0;
		$this->data->bk = array();
		$this->data->html = $this->list_rec();
		$this->template
			->append_css('module::admin.css')
			->append_js('module::published.js')
			->append_js('module::sortable.js')
			->build('admin/admin', $this->data);
	}
	
	function items()
	{
		$pagination = create_pagination('admin/shop/items', $this->shop_admin_m->count_items());
	
		$this->data->items = $this->shop_admin_m->get_items($pagination);
		
		$this->template
			->append_css('module::admin.css')
			->set('pagination', $pagination)
			->build('admin/admin_items', $this->data);
	}
	
	function items_lonely()
	{
		$pagination = create_pagination('admin/shop/items_lonely', $this->shop_admin_m->count_items_lonely());
	
		$this->data->items = $this->shop_admin_m->get_items_lonely($pagination);
		
		$this->template
			->append_css('module::admin.css')
			->set('pagination', $pagination)
			->build('admin/admin_items_lonely', $this->data);
	}
	
	function import($step = null)
	{
		ini_set("memory_limit", "512M");
		ini_set("upload_max_filesize", "128M");
		ini_set('max_execution_time', 300);
		
		$this->data->course = 45; // euro/rub
		$xml = json_decode(str_replace('@attributes', 'attributes', json_encode(simplexml_load_file('http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml'))));

		if ( isset($xml->Cube->Cube->Cube) )
		{
			foreach( $xml->Cube->Cube->Cube as $v )
			{
				if ($v->attributes->currency == 'RUB') $this->data->course = $v->attributes->rate;
			}
		}
		
		if ($step == null)
		{

			require_once 'addons/shared_addons/modules/shop/excel_reader2.php';
			if (isset($_FILES['file_xls']['size']))
			{
				if (!empty($_REQUEST['course'])) 
				{
					$course = $_REQUEST['course'];
					
					if ($_FILES['file_xls']['type'] == 'application/vnd.ms-excel' or $_FILES['file_xls']['type'] == 'application/octet-stream')
					{
						$res = array();
						$res_key = 0;
						$data = new Spreadsheet_Excel_Reader($_FILES['file_xls']['tmp_name']);
						$row = 2;
						while ( $code_1c = $data->val($row, 'A') )
						{
							$code_1c = $data->val($row,'A');
							$manufacturer = $data->val($row,'B');
							$title = $data->val($row,'C');
							$model = $data->val($row,'D');
							$text = $data->val($row,'E');
							$power = $data->val($row,'G');
							$voltage = $data->val($row,'H');
							$depth = $data->val($row,'I');
							$width = $data->val($row,'J');
							$height = $data->val($row,'K');
							$depth_packaging = $data->val($row,'O'); 
							$width_packaging = $data->val($row,'P'); 
							$height_packaging = $data->val($row,'Q');
							$price = $course*$data->val($row,'M');
							$site = $data->val($row,'R');
							$weight = $data->val($row,'S');
							$gross_weight = $data->val($row,'T');
							$image_url = $data->val($row,'U');
							$country = $data->val($row,'V');

							$res[$res_key][] = array($code_1c, $manufacturer, $title, $model, $text, $power,  $voltage, $depth, $width, $height, $depth_packaging, $width_packaging, $height_packaging, $price, $site, $weight, $gross_weight, $image_url, $country);
							
							if ($row / $this->config->item('shop.import_step_items') > ($res_key + 1)) $res_key++; // количество шагов при импорте
							
							$row++;
						}
						$this->session->set_flashdata('success', lang('shop.import_success').$row);
						delete_directory($this->data->import_temp_dir);
						check_dir($this->data->import_temp_dir);
						foreach($res as $res_key=>$res_item)
						{
							file_put_contents($this->data->import_temp_dir.$res_key.'.txt', serialize($res_item));
						}
						redirect('admin/shop/import/0');
					}
					else 
					{
						$this->session->set_flashdata('error', lang('shop.file_error'));
					}
				}
				else 
				{
					redirect('admin/shop/import');
				}
				redirect('admin/shop/import');
			}
			
			$this->template
				->build('admin/import', $this->data);
		}
		else
		{
			$this->data->step = $step;
			if (!empty($_POST['btnAction']))
			{
				if ( is_file($this->data->import_temp_dir.$step.'.txt') and $res = file_get_contents($this->data->import_temp_dir.$step.'.txt') )
				{
					$res = unserialize($res);
					foreach ($res as $res_i)
					{
						list($code_1c, $manufacturer, $title, $model, $text, $power,  $voltage, $depth, $width, $height, $depth_packaging, $width_packaging, $height_packaging, $price, $site, $weight, $gross_weight, $image_url, $country) = $res_i;
					
						$this->shop_admin_m->insert_item_and_gallery($code_1c, $manufacturer, $title, $model, $text, $power,  $voltage, $depth, $width, $height, $depth_packaging, $width_packaging, $height_packaging, $price, $site, $weight, $gross_weight, $image_url, $country);
					}
					$this->session->set_flashdata('success', lang('shop.import_step_finish').count($res));
					redirect('admin/shop/import/'.($step+1));
				}
				else
				{
					$this->pyrocache->delete_all('shop_m');
					$this->session->set_flashdata('success', lang('shop.import_finish'));
					redirect('admin/shop/import');
				}
			}
			$this->template
				->build('admin/import_step', $this->data);
		}
	}
	
	function orders()
	{
		$this->data->items = $this->shop_admin_m->orders();
		$this->template
			->append_css('module::admin.css')
			->append_js('module::sortable.js')
			->build('admin/orders', $this->data);
	}	
	
	function group($group = 0)
	{
		$this->data->current_group = $group;
		$this->data->bk = $this->shop_admin_m->bk($group);
		$this->data->html = $this->list_rec($group, count ($this->data->bk));
		$this->template
			->append_css('module::admin.css')
			->append_js('module::sortable.js')
			->append_js('module::published.js')
			->build('admin/admin', $this->data);
	}	
	
	public function list_rec($parent_group = 0, $level = 0)
	{
		$html = '';

		$groups = $this->shop_admin_m->get_all_groups($parent_group);
		if (!empty ($groups))
		{
			foreach ($groups as $v)
			{
				$data_t = array ('data_group' => $v, 'level'=>$level);
				$html .= $this->load->view('admin/admin_group', $data_t, true);
				//$html .= $this->list_rec($v->parent_group_id, $level + 1);
			}
		}

		$items = $this->shop_admin_m->get_all_items($parent_group);
		if (!empty ($items))
		{
			foreach ($items as $v)
			{
				$data_t = array ('data_item' => $v, 'level'=>$level);
				$html .= $this->load->view('admin/admin_item', $data_t, true);
			}
		}
		
		return $html;
	}
	
	public function published($id = NULL)
	{
		if (empty ($id))
		{
			show_404();
		}
		elseif (!$this->shop_admin_m->toggle_published($id))
		{
			show_404();
		}
		redirect('admin/shop');
	} 
	
	public function published_group($id = NULL)
	{
		if (empty ($id))
		{
			show_404();
		}
		elseif (!$this->shop_admin_m->toggle_published_group($id))
		{
			show_404();
		}
		redirect('admin/shop');
	}
	
	public function manage_order($id = null)
	{
		$post = $this->shop_admin_m->get_order($id);
		
		$this->data->items_options = $this->shop_admin_m->get_all_items_options();
		
		$this->data->orders = $this->shop_admin_m->get_order_items($id);

		if (empty ($id) or empty($post) )
		{
			$this->session->set_flashdata('error', lang('shop.exists_error'));
			redirect('admin/shop/orders');
		}

		if ( count($_POST) )
		{
			if ( $this->shop_admin_m->update_order($id, $_POST) === TRUE )
			{
				$this->session->set_flashdata('success', lang('shop.update_success'));
				if (!empty ($_POST['btnAction']) and $_POST['btnAction'] == 'save') redirect('admin/shop/manage_order/' . $id); 
				else redirect('admin/shop/orders');
			}
			else
			{
				$this->session->set_flashdata('error', lang('shop.update_error'));
				redirect('admin/shop/manage_order/' . $id);
			}
			
			$this->pyrocache->delete_all('shop_m');
		}

		foreach($this->item_validation_rules as $rule)
		{
			if ($this->input->post($rule['field'])) $post->{$rule['field']} = $this->input->post($rule['field']);
			if (!isset ($post->{$rule['field']})) $post->{$rule['field']} = false;
		}

		$this->template
			->title($this->module_details['name'], lang('shop.manage_order_label'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->set('post', $post)
			->append_css('module::admin.css')
			->build('admin/manage_order');
	}
	
	public function create_item()
	{
		$this->manage_item();
	}
	
	public function manage_item($id = null)
	{
		$this->form_validation->set_rules($this->item_validation_rules);

		// Get the shop
		$post = $this->shop_admin_m->get($id);
		
		$this->data->gallery = $this->shop_admin_m->get_gallery($id);

		if (!$id) 
		{
			$next_id = $this->shop_admin_m->next_insert_id('shop_items');
			$post->published = 1;
			$post->order = 0;
			$post->price = 0;
			$post->balance = 0;
			if (!empty ($_SESSION['group_id'])) $post->group_id = $_SESSION['group_id'];
		}
		else $next_id = $id;

		if (!empty ($id) and empty($post) )
		{
			$this->session->set_flashdata('error', lang('shop.exists_error'));
			redirect('admin/shop');
		}

		if ( $this->form_validation->run() )
		{
			if (!empty ($id))
			{
				if ( $this->shop_admin_m->insert($_POST, $id) )
				{
					$this->session->set_flashdata('success', lang('shop.update_success'));
					if (!empty ($_POST['btnAction']) and $_POST['btnAction'] == 'save') redirect('admin/shop/manage_item/' . $next_id); 
					else redirect('admin/shop');
				}
				else
				{
					$this->session->set_flashdata('error', lang('shop.update_error'));
					redirect('admin/shop/manage_item/' . $id);
				}
			}
			else
			{
				if ($this->shop_admin_m->insert($_POST))
				{
					$this->session->set_flashdata('success', lang('shop.create_success'));
					if (!empty ($_POST['btnAction']) and $_POST['btnAction'] == 'save') redirect('admin/shop/manage_item/' . $next_id); 
					else redirect('admin/shop/items');
				}
				else
				{
					$this->session->set_flashdata('error', lang('shop.create_error'));
					redirect('admin/shop/create');
				}
			}
		}

		foreach($this->item_validation_rules as $rule)
		{
			if ($this->input->post($rule['field'])) $post->{$rule['field']} = $this->input->post($rule['field']);
			if (!isset ($post->{$rule['field']})) $post->{$rule['field']} = false;
		}
		
		$this->data->group_parents_id = $this->shop_admin_m->group_parents_id();
		$post->next_id = $next_id;

		$this->template
			->title($this->module_details['name'], lang('shop.manage_article_label'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->set('post', $post)
			->build('admin/manage_item');
	}
	
	public function create_group()
	{
		$this->manage_group();
	}
	
	public function manage_group($id = 0)
	{
		$this->form_validation->set_rules($this->group_validation_rules);

		$post = $this->shop_admin_m->get_all_group($id);

		if (!$id) 
		{
			$next_id = $this->shop_admin_m->next_insert_id('shop_items');
			$post->order = 0;
			$post->published = 1;
			if (!empty ($_SESSION['parent_group_id'])) $post->parent_group_id = $_SESSION['parent_group_id'];
		}
		else $next_id = $id;

		if (!empty ($id) and empty($post) )
		{
			$this->session->set_flashdata('error', lang('shop.exists_error'));
			redirect('admin/shop');
		}

		if ( $this->form_validation->run() )
		{		
			if (!empty ($id))
			{
				if ( $this->shop_admin_m->insert_group($_POST, $id) )
				{
					$this->session->set_flashdata('success', lang('shop.update_success'));
					if (!empty ($_POST['btnAction']) and $_POST['btnAction'] == 'save') redirect('admin/shop/manage_group/' . $next_id); 
					else redirect('admin/shop');
				}
				else
				{
					$this->session->set_flashdata('error', lang('shop.update_error'));
					redirect('admin/shop/manage_group/' . $id);
				}
			}
			else
			{
				if ($this->shop_admin_m->insert_group($_POST))
				{
					$this->session->set_flashdata('success', lang('shop.create_success'));
					if (!empty ($_POST['btnAction']) and $_POST['btnAction'] == 'save') redirect('admin/shop/manage_group/' . $next_id); 
					else redirect('admin/shop');
				}
				else
				{
					$this->session->set_flashdata('error', lang('shop.create_error'));
					redirect('admin/shop/create_group');
				}
			}
		}

		foreach($this->group_validation_rules as $rule)
		{
			if (isset ($_POST[$rule['field']])) $post->$rule['field'] = $_POST[$rule['field']];
			if (!isset ($post->{$rule['field']})) $post->$rule['field'] = false;
		}		
		
		$post->group_parents_id = $this->shop_admin_m->group_parents_id($id);
		$post->next_id = $next_id;
		
		$this->template
			->title($this->module_details['name'], lang('shop.manage_article_label'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->set('post', $post)
			->append_css('module::admin.css')
			->append_js('module::published.js')
			->build('admin/manage_group');
	}
	
	public function create_group_item()
	{
		$this->manage_group_item();
	}
	
	public function manage_group_item($id = 0)
	{
		$this->form_validation->set_rules($this->validation_rules);

		$post = $this->shop_admin_m->get_all_group_item($id);
		$this->data->items_id = $this->shop_admin_m->items_id();

		if (!$id) 
		{
			$next_id = $this->shop_admin_m->next_insert_id('shop_group_items');
			$post->order = 0;
			if (!empty ($_SESSION['parent_group_id'])) $post->group_id = $_SESSION['parent_group_id'];
		}
		else $next_id = $id;

		if (!empty ($id) and empty($post) )
		{
			$this->session->set_flashdata('error', lang('shop.exists_error'));
			redirect('admin/shop');
		}

		if ( $this->form_validation->run() )
		{		
			if (!empty ($id))
			{
				if ( $this->shop_admin_m->insert_group_item($_POST, $id) )
				{
					$this->session->set_flashdata('success', lang('shop.update_success'));
					if (!empty ($_POST['btnAction']) and $_POST['btnAction'] == 'save') redirect('admin/shop/manage_group_item/' . $next_id); 
					else redirect('admin/shop');
				}
				else
				{
					$this->session->set_flashdata('error', lang('shop.update_error'));
					redirect('admin/shop/manage_group_item/' . $id);
				}
			}
			else
			{
				if ($this->shop_admin_m->insert_group_item($_POST))
				{
					$this->session->set_flashdata('success', lang('shop.create_success'));
					if (!empty ($_POST['btnAction']) and $_POST['btnAction'] == 'save') redirect('admin/shop/manage_group_item/' . $next_id); 
					else redirect('admin/shop');
				}
				else
				{
					$this->session->set_flashdata('error', lang('shop.create_error'));
					redirect('admin/shop/create_group_item');
				}
			}
			$this->pyrocache->delete_all('shop_m');
		}

		foreach($this->validation_rules as $rule)
		{
			if (isset ($_POST[$rule['field']])) $post->$rule['field'] = $_POST[$rule['field']];
			if (!isset ($post->{$rule['field']})) $post->$rule['field'] = false;
		}		
		
		$post->group_parents_id = $this->shop_admin_m->group_parents_id($id);
		$post->next_id = $next_id;
		
		if (!empty($_REQUEST['item_id'])) $post->item_id = $_REQUEST['item_id'];
		
		$this->template
			->title($this->module_details['name'], lang('shop.manage_article_label'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->set('post', $post)
			->append_css('module::admin.css')
			->append_js('module::published.js')
			->build('admin/manage_group_item');
	}
	
	public function order($id = NULL)
	{
		if (empty ($id)) show_404();
		
		$this->data->item = $this->shop_admin_m->get_order($id);
		
		if (empty ($this->data->item)) show_404();
		
		$this->template
			->title($this->module_details['name'], lang('shop.order_item_label'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->build('admin/order');
	}
	
	public function delete_order($id = NULL)
	{

		if (!empty ($id) and !$this->shop_admin_m->delete_order($id)) 
		{
			show_404();
			exit;
		}
		if (!empty ($_POST['action_order_to']))
		{
			foreach ($_POST['action_order_to'] as $id_value)
			{
				$this->shop_admin_m->delete_order($id_value);
			}
		}
		
		$this->pyrocache->delete_all('shop_m');
		
		$this->session->set_flashdata('success', lang('shop.delete_success'));
		redirect('admin/shop/orders');
		
	}

	public function delete($id = NULL)
	{
		if (!empty ($id) and !$this->shop_admin_m->delete($id)) 
		{
			show_404();
			exit;
		}
		if (!empty ($_POST['action_to']))
		{
			foreach ($_POST['action_to'] as $id_value)
			{
				$this->shop_admin_m->delete($id_value);
			}
		}
		if (!empty ($_POST['action_item_to']))
		{
			foreach ($_POST['action_item_to'] as $id_value)
			{
				$this->shop_admin_m->delete_item($id_value);
			}
		}
		if (!empty ($_POST['action_group_to']))
		{
			foreach ($_POST['action_group_to'] as $id_value)
			{
				$this->shop_admin_m->delete_group($id_value);
			}
		} 
		
		$this->session->set_flashdata('success', lang('shop.delete_success'));
		redirect('admin/shop');
	}
	
	public function delete_item($id = NULL)
	{
		if (!empty ($id) and !$this->shop_admin_m->delete_item($id)) 
		{
			show_404();
			exit;
		}
		$this->session->set_flashdata('success', lang('shop.delete_success'));
		redirect('admin/shop/items');
	}

	public function delete_group($id = NULL)
	{	
		if (!empty ($id) and !$this->shop_admin_m->delete_group($id)) 
		{
			show_404();
		}
		
		$this->session->set_flashdata('success', lang('shop.delete_success'));
		redirect('admin/shop');
	}
	
	public function sort($slug = NULL)
	{
		$obj = json_decode($_POST['order']);
		
		$res = array();
		
		foreach ($obj as $v)
		{
			$res[$v[1]][] = $v[0];
		}
		
		foreach ($res as $k=>$v)
		{
			$id_a = array();
			foreach ($v as $vv) $id_a[] = $vv;
			
			$this->db
				->select('MIN(`order`) AS `min`')
				->from($k)
				->where_in('id', $id_a);
			$res_min = $this->db->get()->result();
			
			if (isset($res_min[0]->min)) $min = $res_min[0]->min;
			else $min = 0;
			
			foreach ($id_a as $vv)
			{
				$this->db->where('id', $vv)->update($k, array('`order`'=>$min));
				$min++;
			}
		}
		
		$this->pyrocache->delete_all('shop_m');
		
		exit;
	}
	
}
