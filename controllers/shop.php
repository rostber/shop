<?php

class shop extends Public_Controller {
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('shop_m');
		$this->load->model('shop_cart_m');
		$this->lang->load('shop');
		$this->load->helper('html');
		$this->config->load('settings');
		$this->load->helper('edit_files');
		$this->load->library('email');
		
		$this->data = new stdClass;
		
		$this->data->upload_dir = site_url().UPLOAD_PATH.$this->config->item('shop.upload_dir');
		$this->data->upload_groups_dir = site_url().UPLOAD_PATH.$this->config->item('shop.upload_groups_dir');
		
		$this->template->title(lang('shop.h1'));
		
		$this->template->set_breadcrumb(lang('shop.h1'), 'shop', false);
	}
	
	public function show_blank($id = null)
	{
		$this->load->model('shop_admin_m');
		$post = $this->shop_admin_m->get_order($id);
		if (!$post) show_404();
		$this->data->blank = $post->blank;
		echo $this->load->view('shop/checkout/show_blank', $this->data, TRUE);
	}
	
	function index()
	{
		$pagination = create_pagination('shop/goods/0', $this->shop_m->count_items());
		$this->data->items = $this->shop_m->set_prices( $this->shop_m->get_items($pagination) );
		
		$this->template->set('pagination', $pagination)->build('catalog/goods', $this->data);
	}
	
	function goods($id = 0)
	{
		$this->data->group_current = $this->pyrocache->model('shop_m', 'get_group', array($id));
		
		if ($id and !$this->data->group_current) show_404();
		
		$this->data->groups = $this->pyrocache->model('shop_m', 'get_groups', array($id));
		
		if ($this->data->group_current)
		{
			$bk = $this->shop_m->bk($id);
			foreach($bk as $bk_group) $this->template->set_breadcrumb($bk_group->title, 'shop/goods/'.$bk_group->id, false);
		}
		
		$this->shop_m->group_current_id = $id;
		
		$pagination = create_pagination('shop/goods/'.$id, $this->pyrocache->model('shop_m', 'count_items', array($id)));
		
		$this->data->items = $this->shop_m->set_prices( $this->pyrocache->model('shop_m', 'get_items', array($pagination, $id)) );
		
		$this->template->set('pagination', $pagination)->build('catalog/goods', $this->data);
	}
	

	
	function product($id = 0)
	{
		$this->data->item = $this->shop_m->get_item($id);
		
		$this->data->item->price = $this->shop_m->set_price( $this->data->item->price );
		
		if (!count ($this->data->item)) show_404();
		
		$this->template->title($this->data->item->title.', '.$this->data->item->model.' ('.$this->data->item->code.') - '.$this->data->item->price.' '.lang('shop.currency'));
		
		$this->data->group_current = $this->shop_m->get_group($this->data->item->gi_group_id);
		
		$bk = $this->shop_m->bk($this->data->item->gi_group_id);
		foreach($bk as $bk_group) $this->template->set_breadcrumb($bk_group->title, 'shop/goods/'.$bk_group->id, false);
		
		$this->template->set_breadcrumb($this->data->item->title, 'shop/product/'.$id, false);
		
		$this->data->items = $this->shop_m->get_items($this->data->item->gi_group_id);
		
		$this->template->build('shop/catalog/product', $this->data);
	}
	
	function search()
	{
		// для autocomplete
		if ( isset($_GET['q']) )
		{
			$this->data->items = $this->shop_m->get_search_list($_GET['q']);
			$ret = array();
			foreach ($this->data->items as $v) $ret[] = $v->title;
			echo implode("\n", $ret);
		}
		else
		{		
			$this->template->set_breadcrumb(lang('shop.search'), 'shop/search/', false);
			
			if (!empty ($_GET['search'])) $this->data->search = $_GET['search'];
			else $this->data->search = false;
			
			$this->data->items = $this->shop_m->set_prices( $this->shop_m->get_search_items($this->data->search) );
			
			$this->template->build('shop/catalog/search', $this->data);
		}
	}
	
	/* оформление заказа */
	
	function cart()
	{
		if (!empty ($_COOKIE['cart'])) $this->data->items = $this->shop_m->set_prices( $this->shop_cart_m->get_cart_items($_COOKIE['cart']) );
		else $this->data->items = array();
		
		$this->template->set_breadcrumb(lang('shop.cart'), 'shop/cart/', false);
		
		$this->template->build('shop/checkout/cart', $this->data);
	}
	
	function checkout()
	{
		if (!empty ($_COOKIE['cart'])) $this->data->items = $this->shop_cart_m->get_cart_items($_COOKIE['cart']);
		else $this->data->items = array();
		
		if ( !count($this->data->items) ) redirect('shop/cart');
		
		$this->data->type_payment = $this->shop_cart_m->get_type_payments();
		$this->data->type_delavery = $this->shop_cart_m->get_type_delavery();
		
		$fields = array(
			'name', 'address', 'email', 'phone', 'text'
		);
		foreach($fields as $v)
		{
			if (isset($_POST[$v])) 
			{
				$this->data->$v = $_POST[$v];
				setcookie($v, $_POST[$v], time()+3600, '/');
			}
			else show_404();
		}
		
		// переходим к способу оплаты
		if (isset($_REQUEST['checkout']) and isset($_REQUEST['type_payment']) and isset($_REQUEST['type_delavery'])) 
		{
			setcookie('type_payment', $_REQUEST['type_payment'], time()+3600, '/');
			setcookie('type_delavery', $_REQUEST['type_delavery'], time()+3600, '/');
			
			foreach ($this->data->type_payment as $payment)
			{
				if ($payment->id == $_REQUEST['type_payment'])
				{
					if (!empty ($payment->redirect)) redirect($payment->redirect);
					else redirect('shop/finish');
					break;
				}
			}
		}
		
		$this->template->set_breadcrumb(lang('shop.cart'), 'shop/cart/', false);
		$this->template->set_breadcrumb(lang('shop.checkout'), 'shop/checkout/', false);
		
		$this->template->build('shop/checkout/checkout', $this->data);
	}
	
	private function insert_order( $items = array() )
	{
		$this->data->total = 0;
		foreach ($this->data->items as $k=>$v)
		{
			$this->data->total = $this->data->total + $v->price*$v->num;
		}
	
		$this->template->set_breadcrumb(lang('shop.finish'), 'shop/finish/', false);
		
		$type_payment = $_COOKIE['type_payment'];
		$type_delavery = $_COOKIE['type_delavery'];

		$name = $this->data->name = !empty($_COOKIE['name']) ? $_COOKIE['name'] : null;
		$email = $this->data->email = !empty($_COOKIE['email']) ? $_COOKIE['email'] : null;
		$phone = $this->data->phone = !empty($_COOKIE['phone']) ? $_COOKIE['phone'] : null;
		$address = $this->data->address = !empty($_COOKIE['address']) ? $_COOKIE['address'] : null;
		$text = $this->data->text = !empty($_COOKIE['text']) ? $_COOKIE['text'] : null;
		
		$order_id = $this->data->order_id = $this->shop_cart_m->insert_order($type_payment, $type_delavery, $items, $name, $email, $phone, $address, $text);

		$this->email->from( $this->settings_m->get('server_email')->value, $this->settings_m->get('site_name')->value );
		$this->email->to( $this->settings_m->get('contact_email')->value );
		$this->email->subject( lang('shop.mail_cart_subject') );
		$this->data->admin = true;
		$mess = $this->load->view('shop/checkout/mail', $this->data, TRUE);
		$this->email->message( $mess );
		$this->email->send();
		
		if ($email)
		{
			$this->email->from( $this->settings_m->get('server_email')->value, $this->settings_m->get('site_name')->value );
			$this->email->to( $email );
			$this->email->subject( lang('shop.mail_cart_subject') );
			$this->data->admin = false;
			$mess = $this->load->view('shop/checkout/mail', $this->data, TRUE);
			$this->email->message( $mess );

			$this->email->send();
		}
		
		setcookie('name', '', 0, '/');
		setcookie('email', '', 0, '/');
		setcookie('phone', '', 0, '/');
		setcookie('cart', '', 0, '/');
		setcookie('type_payment', '', 0, '/');
		setcookie('type_delavery', '', 0, '/');
		
		return $order_id;
	}
	
	private function update_order($blank = false, $order_id = 0)
	{	
		$this->shop_cart_m->update_order($blank, $order_id);
	}
	
	function finish()
	{		
		$this->insert_order();
		
		$this->data->blank = false;
		
		$this->template->build('shop/checkout/finish', $this->data);
	}
	
	/* формы оплаты */
	
	function blank()
	{	
		if (empty($_REQUEST['blank']))
		{
			$this->template->set_breadcrumb(lang('shop.cart'), 'shop/cart/', false);
			$this->template->set_breadcrumb(lang('shop.checkout'), 'shop/checkout/', false);
		
			$this->template->build('shop/checkout/pay_form', $this->data);
		}
		else
		{
			$this->data->id = $this->shop_cart_m->next_insert_id('shop_orders');
			$this->data->rec_inn = $this->config->item('shop.rec_inn');
			$this->data->rec_kpp = $this->config->item('shop.rec_kpp');
			$this->data->rec_num = $this->config->item('shop.rec_num');
			$this->data->rec_bank_address = $this->config->item('shop.rec_bank_address');
			$this->data->rec_bik = $this->config->item('shop.rec_bik');
			$this->data->rec_kor_sch = $this->config->item('shop.rec_kor_sch');
			$this->data->rec_title = $this->config->item('shop.rec_title');
			$this->data->rec_company = $this->config->item('shop.rec_company');
			
			if (!empty ($_COOKIE['cart'])) $this->data->items = $this->shop_m->set_prices( $this->shop_cart_m->get_cart_items($_COOKIE['cart']) );
			else $this->data->items = array();
			
			$this->data->order_id = $this->insert_order( $this->data->items );
			
			$this->data->blank = $this->load->view('shop/pay_blank', $this->data, TRUE);
			
			$this->update_order($this->data->blank, $this->data->order_id);
		
			$this->template->build('shop/checkout/finish', $this->data);
		}
	}
	
	/* / формы оплаты */
	
}