<?php
class ControllerPdDichvu extends Controller {
	public function index() {
		$this->document->setTitle('Create New');
		$this->load->model('pd/registercustom');
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['get_dichvu'] = $this -> model_pd_registercustom -> get_dichvu();

	$this->response->setOutput($this->load->view('pd/dichvu.tpl', $data));
	}

	public function create() {
		$this->document->setTitle('Create New');
		$this->load->model('pd/registercustom');
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['get_dichvu'] = $this -> model_pd_registercustom -> get_dichvu();

	$this->response->setOutput($this->load->view('pd/dichvu_create.tpl', $data));
	}

	public function submit_create()
	{	
		if ($this -> request->post)
		{
			$this -> load -> model('pd/registercustom');
			$this -> model_pd_registercustom -> create_dichvu($this -> request->post);
		}

		$this-> session -> data['success'] = "complate";
		$this->response->redirect($this->url->link('pd/dichvu', 'token=' . $this->session->data['token'] .'&customer_id='.$customer_id, 'SSL'));
	}

	public function edit()
	{	
		$this->document->setTitle('Edit');
		$this->load->model('pd/registercustom');
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['get_dichvu'] = $this -> model_pd_registercustom -> get_dichvu_id(intval($this -> request -> get['id']));

		$this->response->setOutput($this->load->view('pd/dichvu_edit.tpl', $data));
	
	}

	public function submit_edit()
	{	
		if ($this -> request->post)
		{
			$this -> load -> model('pd/registercustom');
			$this -> model_pd_registercustom -> update_dichvu_id(intval($this -> request -> get['id']),$this -> request->post);
		}

		$this-> session -> data['success'] = "complate";
		$this->response->redirect($this->url->link('pd/dichvu', 'token=' . $this->session->data['token'] .'&customer_id='.$customer_id, 'SSL'));
	}

	public function submit_remove()
	{	
		if ($this -> request -> get)
		{
			$this -> load -> model('pd/registercustom');
			$this -> model_pd_registercustom -> remove_dichvu_id(intval($this -> request -> get['id']),$this -> request->post);
		}

		$this-> session -> data['success'] = "complate";
		$this->response->redirect($this->url->link('pd/dichvu', 'token=' . $this->session->data['token'] .'&customer_id='.$customer_id, 'SSL'));
	}

}