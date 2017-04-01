<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_map'] = $this->language->get('text_map');
		$data['text_activity'] = $this->language->get('text_activity');
		$data['text_recent'] = $this->language->get('text_recent');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['banner'] = $this->load->controller('dashboard/banner');
		$data['customer'] = $this->load->controller('dashboard/customer');
		$data['customer_account'] = $this->load->controller('dashboard/customer_account');
		$data['online'] = $this->load->controller('dashboard/online');
		$data['map'] = $this->load->controller('dashboard/map');
		$data['chart'] = $this->load->controller('dashboard/chart');
		$data['activity'] = $this->load->controller('dashboard/activity');
		$data['recent'] = $this->load->controller('dashboard/recent');
		$data['footer'] = $this->load->controller('common/footer');
		$this->load->model('report/activity');
		
		

		$data['totalHP'] = $this->model_report_activity->getAllProfitByType(1);
		
		$data['totalhoadon'] = $this->model_report_activity->getTotalCustomersNewLast();
		
		$data['totalnhanvien'] = $this->model_report_activity->getTotalCustomersNew();
		
		$data['totaldichvu'] = $this->model_report_activity->getTotalCustomersOff();
		
		
		
		$data['get_history_customer'] = $this -> model_report_activity -> get_history_customer();
		
		
		$data['self'] = $this;
		//$data['status_withdraw'] = $this ->model_report_activity -> get_status_withdraw();
		// Run currency update
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			$this->model_localisation_currency->refresh();
		}

		$this->response->setOutput($this->load->view('common/dashboard.tpl', $data));
	}
	public function getAge($birthdate = '0000-00-00') {
	    if ($birthdate == '0000-00-00') return 'Unknown';
	 
	    $bits = explode('-', $birthdate);
	    $age = date('Y') - $bits[0] - 1;
	 
	    $arr[1] = 'm';
	    $arr[2] = 'd';
	 
	    for ($i = 1; $arr[$i]; $i++) {
	        $n = date($arr[$i]);
	        if ($n < $bits[$i])
	            break;
	        if ($n > $bits[$i]) {
	            ++$age;
	            break;
	        }
	    }
	    return $age;
	}
	public function update_status_withdraw_on(){
		$this->load->model('report/activity');
		$this->model_report_activity->update_status_withdraw('1');
		
		$this -> response -> redirect($this -> url -> link('common/dashboard&token='.$_GET['token']));
	}
	public function update_status_withdraw_off(){
		$this->load->model('report/activity');
		$this->model_report_activity->update_status_withdraw('0');
		
		$this -> response -> redirect($this -> url -> link('common/dashboard&token='.$_GET['token']));
	}
}