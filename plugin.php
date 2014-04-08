<?php

class Plugin_shop extends Plugin
{
	
	function search_form()
	{
		return $this->module_view('shop', 'catalog/search_form', false);
	}
	
	function navi()
	{
		$this->load->helper('html');
		$this->load->model('shop_m');
		
		$data = new stdClass;
		
		$data->group_current_id = $this->shop_m->group_current_id;
		
		$data->groups = $this->pyrocache->model('shop_m', 'group_rec', array(0, 2));
		
		$data->level = 0;
		
		if (!count ($data->groups)) return false;
		
		return $this->module_view('shop', 'catalog/navi', $data);
	}
	
	function sidebar()
	{
		$this->load->helper('html');
		$this->load->model('shop_m');
		
		$data = new stdClass;
		
		$data->group_current_id = $this->shop_m->group_current_id;
		
		$data->groups = $this->pyrocache->model('shop_m', 'group_rec', array(0, 2));
		
		$data->level = 0;
		
		if (!count ($data->groups)) return false;
		
		return $this->module_view('shop', 'catalog/sidebar', $data);
	}

	function home()
	{
		$this->load->helper('html');
		$this->load->helper('shop/text');
		$this->load->model('shop_m');
		$this->config->load('settings');
		
		$data = new stdClass;
		
		$data->upload_dir = BASE_URL.UPLOAD_PATH.$this->config->item('shop.upload_dir');
		
		$data->pagination = false;
		$data->items = $this->shop_m->set_prices( $this->pyrocache->model('shop_m', 'get_home', array()) );
		
		$data->list = $this->module_view('shop', 'catalog/goods_list', $data);
		
		return $this->module_view('shop', 'catalog/home', $data);
	}
	
	function head()
	{
		return $this->module_view('shop', 'catalog/head', false);
	}
	
	function small_cart()
	{
		return $this->module_view('shop', 'catalog/small_cart', false);
	}
}

?>