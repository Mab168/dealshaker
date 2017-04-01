<?php
class ControllerPdNhanvien extends Controller {
	public function index() {
		$this->document->setTitle('Create New');
		$this->load->model('pd/registercustom');
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['seft'] = $this;
		$data['get_nhanvien'] = $this -> model_pd_registercustom -> get_nhanvien();

	$this->response->setOutput($this->load->view('pd/nhanvien.tpl', $data));
	}

	public function create() {
		$this->document->setTitle('Create New');
		$this->load->model('pd/registercustom');
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

	

	$this->response->setOutput($this->load->view('pd/nhanvien_create.tpl', $data));
	}

	public function submit_create()
	{	
		if ($this -> request->post)
		{	
			//print_r($this -> request->post);die;
			$this -> load -> model('pd/registercustom');
			$this -> model_pd_registercustom -> create_nhanvien($this -> request->post);
		}

		$this-> session -> data['success'] = "complate";
		$this->response->redirect($this->url->link('pd/nhanvien', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function edit()
	{	
		$this->document->setTitle('Edit');
		$this->load->model('pd/registercustom');
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['get_nhanvien'] = $this -> model_pd_registercustom -> get_nhanvien_id(intval($this -> request -> get['id']));

		$this->response->setOutput($this->load->view('pd/nhanvien_edit.tpl', $data));
	
	}

	public function submit_edit()
	{	
		if ($this -> request->post)
		{
			$this -> load -> model('pd/registercustom');
			$this -> model_pd_registercustom -> update_nhanvien_id(intval($this -> request -> get['id']),$this -> request->post);
		}

		$this-> session -> data['success'] = "complate";
		$this->response->redirect($this->url->link('pd/nhanvien', 'token=' . $this->session->data['token'] .'&customer_id='.$customer_id, 'SSL'));
	}

	public function submit_remove()
	{	
		if ($this -> request -> get)
		{
			$this -> load -> model('pd/registercustom');
			$this -> model_pd_registercustom -> remove_nhanvien_id(intval($this -> request -> get['id']),$this -> request->post);
		}

		$this-> session -> data['success'] = "complate";
		$this->response->redirect($this->url->link('pd/nhanvien', 'token=' . $this->session->data['token'] .'&customer_id='.$customer_id, 'SSL'));
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
}