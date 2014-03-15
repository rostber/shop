<?php

class Plugin_shop extends Plugin
{
	
	function navi()
	{
		$this->load->helper('html');
		$this->load->model('shop_m');
		
		$data = new stdClass;
		
		$data->groups = $this->shop_m->group_rec(0, 2);
		
		if (!count ($data->groups)) return false;
		
		return $this->load->view('shop/catalog/navi', $data, TRUE);
	}

	function home_catalog()
	{
		$this->load->helper('html');
		$this->load->model('shop_m');
		$this->config->load('settings');
		
		$data = new stdClass;
		
		$data->upload_dir = site_url().UPLOAD_PATH.$this->config->item('shop.upload_dir');
		$data->upload_groups_dir = site_url().UPLOAD_PATH.$this->config->item('shop.upload_groups_dir');
		
		$data->group_current = false;
		
		$data->groups = $this->pyrocache->model('shop_m', 'group_rec', array(0));
		$data->sidebar_html = $this->load->view('shop/sidebar', $data, true);
		
		$data->pagination = create_pagination('shop/goods/0', $this->shop_m->count_items());
		
		$data->items = $this->shop_m->set_prices( $this->pyrocache->model('shop_m', 'get_items', array($data->pagination)) );
		
		return $this->load->view('shop/catalog/goods', $data, TRUE);
	}
	
}

?>