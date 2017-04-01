<?php
class ControllerPdCreate extends Controller {
	public function index() {
		$this->document->setTitle('Create New');
		$this->load->model('pd/pd');

	$this -> document -> addScript('view/javascript/register/register.js');

		$this -> document -> addScript('../catalog/view/javascript/autocomplete/jquery.easy-autocomplete.min.js');
		$this -> document -> addStyle('../catalog/view/theme/default/stylesheet/autocomplete/easy-autocomplete.min.css');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$url = '';

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			$this->response->redirect($this->url->link('pd/create', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		

		
		$data['action_upgrade'] = $this->url->link('pd/create/submit', 'token=' . $this->session->data['token'], 'SSL');
		$this -> load -> model('pd/registercustom');
		$data['get_nhanvien'] = $this -> model_pd_registercustom -> get_nhanvien();
		$data['get_dichvu'] = $this -> model_pd_registercustom -> get_dichvu();
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

	$this->response->setOutput($this->load->view('pd/create.tpl', $data));
	}

	public function submit(){
		$this->load->model('pd/registercustom');
		if ($this->request->server['REQUEST_METHOD'] === 'POST'){
			
			$barcode = $this -> model_pd_registercustom -> check_barcode($this -> request -> post['barcode']);
			if ($barcode > 0) die("Mã barcode đã tồn tại");
			$id = $this -> model_pd_registercustom -> addCustomer($this -> request -> post);

			$this-> session -> data['success'] = "complate";
			$this->response->redirect($this->url->link('pd/create/print_user', 'token=' . $this->session->data['token'] .'&id='.$id, 'SSL'));
		}
		
	}

	public function print_user() {
		$data['self'] = $this ;
		$this -> load -> model('pd/registercustom');
		$id = $_GET['id'];
		$data['getCustomer'] = $this -> model_pd_registercustom -> getCustomer_print($id);
		//print_r($data['getCustomer']); die;
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('pd/print_user.tpl', $data));
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
	
	public function up_user()
	{
		$this->load->model('pd/registercustom');
		if ($this->request->server['REQUEST_METHOD'] === 'POST'){
			
			$this -> model_pd_registercustom -> updateCustomer($this -> request -> post,$this -> request -> get['customer_id']);

			$this-> session -> data['success'] = "complate";
			$this->response->redirect($this->url->link('pd/history/edit_user', 'token=' . $this->session->data['token'] .'&customer_id='.$this -> request -> get['customer_id'], 'SSL'));
		}
	}

	public function submit_remove()
	{
		$this->load->model('pd/registercustom');
		if ($this->request->server['REQUEST_METHOD'] === 'GET'){
			
			$this -> model_pd_registercustom -> removeCustomer($this -> request -> get['customer_id']);
			
			$this-> session -> data['success'] = "complate";
			$this->response->redirect($this->url->link('pd/customer', 'token=' . $this->session->data['token'], 'SSL'));
		}

	}
	
}