<?php
class ControllerHomePage extends Controller {
	public function index() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/home.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/home.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/home.tpl', $data));
		}
	}
	public function about() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/about.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/about.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/about.tpl', $data));
		}
	}
	public function contact() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/contact.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/contact.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/contact.tpl', $data));
		}
	}
	public function faq() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/faq.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/faq.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/faq.tpl', $data));
		}
	}
	public function blog() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/blog.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/blog.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/blog.tpl', $data));
		}
	}
	public function service() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/service.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/service.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/service.tpl', $data));
		}
	}
	public function header() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/home/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/home/header.tpl', $data);
		} else {
			return $this->load->view('default/template/home/header.tpl', $data);
		}
	}
	public function footer() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		$data['add_date'] = intval($this -> config -> get('add_date'));
		$this -> load -> model('account/customer');
		$data['getmaxPD_all'] = $this -> model_account_customer -> getmaxPD_all()['number'];
		$data['get_all_customer'] = $this -> model_account_customer -> get_all_customer()['number'];
		$data['count_getmaxPD_all'] = $this -> model_account_customer -> count_getmaxPD_all()['number'];
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/home/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/home/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/home/footer.tpl', $data);
		}
	}
	
}