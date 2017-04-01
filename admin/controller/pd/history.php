<?php
class ControllerPdHistory extends Controller {
	public function index() {
		$this->document->setTitle('Provide Donation');
		$this->load->model('pd/pd');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$url = '';

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			$this->response->redirect($this->url->link('pd/pd', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		

		if (isset($this->request->get['filter_status'])) {
				$status = $this->request->get['filter_status'];
				$data['filter_status'] = $this->request->get['filter_status'];
			
		} else{
			$status = null;
			$data['filter_status'] = null;
		}
		// echo "<pre>"; print_r($status); echo "</pre>"; die();
		$data['self'] = $this;
		$data['allGd'] = $this -> model_pd_pd -> get_all_gd_current_date($status);
		
		$str = HTTPS_SERVER;

		$data['getaccount'] = $this->url->link('pd/history/getaccount&token='.$this->session->data['token']);
		$data['getaccount_username'] = $this->url->link('pd/history/getaccount_username&token='.$this->session->data['token']);
		$data['getaccount_tuoi'] = $this->url->link('pd/history/getaccount_tuoi&token='.$this->session->data['token']);
		$data['link_search'] = $this -> url -> link('pd/history/search_name&token='.$this->session->data['token'].'', '', 'SSL');
		$data['link_search_username'] = $this -> url -> link('pd/history/link_search_username&token='.$this->session->data['token'].'', '', 'SSL');
		$data['query_child'] = $this -> url -> link('pd/history/query_child&token='.$this->session->data['token'].'', '', 'SSL');
		$data['load_date'] = $this -> url -> link('pd/history/load_date&token='.$this->session->data['token'].'', '', 'SSL');
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('pd/history.tpl', $data));
	}
	
	public function search_name(){
		$name = $this -> request ->post['name'];
		$this -> load -> model('pd/registercustom');
		$get_name_customer = $this -> model_pd_registercustom -> get_name_customer($name);
		$i = 1;
		foreach ($get_name_customer as $value) {
			$get_filled_by_id = $this -> model_pd_registercustom -> get_filled_by_id($value['customer_id']);
		?>
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $value['username'];?></td>
				<td><?php echo $value['account_holder'];?></td>
				<td><?php echo number_format($get_filled_by_id['sum_filled']);?></td>
				
				<td><?php echo date('d/m/Y',strtotime($value['date_added'])) ;?></td>
				<td class="text-center">
	              <?php if ($value['level'] >= 2) { ?>
	                <i class="fa fa-circle" style="color: #4caf50" aria-hidden="true"></i>
	              <?php } else { ?>
	                  <i class="fa fa-circle" style="color: red" aria-hidden="true"></i>
	              <?php } ?>
	            </td>
				<td><?php echo $this->getCustomer($value['p_node']);?></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary	"><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>	
				<td class="text-center"><a href="<?php echo $this->url->link('pd/customer/dautu_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary  "><i class="fa fa-university" aria-hidden="true"></i></button></a></td> 	
			
			</tr>
		<?php
		}

	}


	public function load_date(){
		$date = $this -> request ->post['date'];
		$this -> load -> model('pd/registercustom');

		$get_name_customer = $this -> model_pd_registercustom -> load_date($date);
		//print_r($get_name_customer); die;
		$i = 1;
		foreach ($get_name_customer as $value) {
			$get_filled_by_id = $this -> model_pd_registercustom -> get_filled_by_id($value['customer_id']);
		?>
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $value['username'];?></td>
				<td><?php echo $value['account_holder'];?></td>
				<td><?php echo number_format($get_filled_by_id['sum_filled']);?></td>
				
				<td><?php echo date('d/m/Y',strtotime($value['date_added'])) ;?></td>
				<td class="text-center">
	              <?php if ($value['level'] >= 2) { ?>
	                <i class="fa fa-circle" style="color: #4caf50" aria-hidden="true"></i>
	              <?php } else { ?>
	                  <i class="fa fa-circle" style="color: red" aria-hidden="true"></i>
	              <?php } ?>
	            </td>
				<td><?php echo $this->getCustomer($value['p_node']);?></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary	"><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/customer/dautu_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary  "><i class="fa fa-university" aria-hidden="true"></i></button></a></td> 	
			
			</tr>
		<?php
		}

	}

	public function getCustomer($customer_id){
		$this -> load -> model('pd/registercustom');
		$getCustomer = $this -> model_pd_registercustom -> getCustomer($customer_id);
		if (count($getCustomer) > 0)
		{
			return $getCustomer['username'];
		}
		else
		{
			return 0;
		}
	}
	
	public function getaccount() {
		if ($this -> request -> post['keyword']) {
			$this -> load -> model('pd/registercustom');
			$tree = $this -> model_pd_registercustom -> getCustomLike_name($this -> request -> post['keyword']);
			//print_r($tree); die;
			if (count($tree) > 0) {
				foreach ($tree as $value) {
					 echo '<li class="list-group-item" onClick="selectU(' . "'" . $value['firstname'] . "',".$value['customer_id']."" . ');"><p class="pull-left">Họ tên: ' . $value['firstname'] . '</p><br><p class="pull-left">SĐT: ' . $value['telephone'] . '</p><p class="pull-right">Tuổi: '.$this ->getAge(date('Y-m-D',strtotime( $value['date_birth']))).'</p><br></li>';
				}
			}
		}
	}

	public function getaccount_tuoi() {
		if ($this -> request -> post['keyword']) {
			$this -> load -> model('pd/registercustom');
			$tree = $this -> model_pd_registercustom -> getCustomLike_tuoi($this -> request -> post['keyword']);
			
			if (count($tree) > 0) {
				foreach ($tree as $value) {
					 echo '<li class="list-group-item" onClick="selectU_tuoi(' . "'" . $value['firstname'] . "',".$value['customer_id']."" . ');"><p class="pull-left">Họ tên: ' . $value['firstname'] . '</p><br><p class="pull-left">SĐT: ' . $value['telephone'] . '</p><p class="pull-right">Tuổi: '.$this ->getAge(date('Y-m-D',strtotime( $value['date_birth']))).'</p><br></li>';
				}
			}
		}
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
	public function getaccount_username(){
		if ($this -> request -> post['keyword']) {
			$this -> load -> model('pd/registercustom');
			$tree = $this -> model_pd_registercustom -> getCustomLike_telephone($this -> request -> post['keyword']);
			
			if (count($tree) > 0) {
				foreach ($tree as $value) {
					 echo '<li class="list-group-item" onClick="selectU_username(' . "'" . $value['telephone'] . "'" . ');"><p>Họ tên: ' . $value['firstname'] . '</p><p>SĐT: ' . $value['telephone'] . '</p></li>';
				}
			}
		}
	}
	

	public function link_search_username(){
		$name = $this -> request ->post['name'];
		$this -> load -> model('pd/registercustom');
		$get_name_customer = $this -> model_pd_registercustom -> get_name_customer_username($name);
		
		$i = 1;
		//print_r($get_name_customer); die;
		foreach ($get_name_customer as $value) {
			$get_filled_by_id = $this -> model_pd_registercustom -> get_filled_by_id($value['customer_id']);
			//print_r($value); die;
		?>
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $value['username'];?></td>
				<td><?php echo $value['account_holder'];?></td>
				<td><?php echo number_format($get_filled_by_id['sum_filled']);?></td>
				
				<td><?php echo date('d/m/Y',strtotime($value['date_added'])) ;?></td>
				<td class="text-center">
	              <?php if ($value['level'] >= 2) { ?>
	                <i class="fa fa-circle" style="color: #4caf50" aria-hidden="true"></i>
	              <?php } else { ?>
	                  <i class="fa fa-circle" style="color: red" aria-hidden="true"></i>
	              <?php } ?>
	            </td>
				<td><?php echo $this->getCustomer($value['p_node']);?></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary	"><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>	
				 <td class="text-center"><a href="<?php echo $this->url->link('pd/customer/dautu_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary  "><i class="fa fa-university" aria-hidden="true"></i></button></a></td>

			</tr>
		<?php
		}
	}
	public function get_childrend($customer_id){
		$this -> load -> model('pd/registercustom');
		$get_childrend = $this -> model_pd_registercustom -> get_childrend($customer_id);
		return substr($get_childrend, 1);
	}
	public function view_history(){
		$customer_id  = $this ->request -> get['customer_id'];
		$this -> load -> model('pd/registercustom');
		$data['customerss'] = $this -> model_pd_registercustom ->get_username_id($customer_id);

		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;
		$data['self'] = $this;
		$limit = 40;
		$start = ($page - 1) * 40;

		$ts_history = $this -> model_pd_registercustom -> get_count_customer_id_history($customer_id);

		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text'; 
		$pagination -> url = $this -> url -> link('pd/history/view_history', 'page={page}&token='.$this->session->data['token'].'', 'SSL');
		
		$data['customer'] =  $this-> model_pd_registercustom->get_all_customer_id_history($customer_id,$limit, $start);
		
		$data['pagination'] = $pagination -> render();
		
		$data['seft'] = $this;

		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('pd/view_history.tpl', $data));
	}
	public function query_child(){
		$customer_id = $this -> request-> get['id'];
		echo $customer_id;
		$get_childrend = $this -> get_childrend($customer_id);
		//print_r($get_childrend);die;
	}
	
	public function get_pakege_cha($customer_id){
		$this -> load -> model('pd/registercustom');
		$customer = $this -> model_pd_registercustom ->get_goidautu($customer_id);

		return $customer['package']/1000;
		
		
	}
	public function get_goidautu($customer_id){
		$this -> load -> model('pd/registercustom');
		$customer = $this -> model_pd_registercustom ->get_goidautu($customer_id);
		return $customer['package'];
	}
	public function get_hhtructiep($goicha,$goicon){
		if (intval($goicha) <= intval($goicon)) {
    		switch (intval($goicha)) {
	    		case 5000000:
	    			$per = 10;
	    			break;
	    		case 20000000:
	    			$per = 15;
	    			break;
	    		case 50000000:
	    			$per = 18;
	    			break;
	    		case 100000000:
	    			$per = 20;
	    			break;
	    		case 500000000:
	    			$per = 25;
	    			break;
	    		case 1000000000:
	    			$per = 32;
	    			break;
    		}
    	
    		$price = (intval($goicon) * $per) / 100;
    	} else{
    		switch (intval($goicon)) {
	    		case 5000000:
	    			$per = 10;
	    			break;
	    		case 20000000:
	    			$per = 15;
	    			break;
	    		case 50000000:
	    			$per = 18;
	    			break;
	    		case 100000000:
	    			$per = 20;
	    			break;
	    		case 500000000:
	    			$per = 25;
	    			break;
	    		case 1000000000:
	    			$per = 32;
	    			break;
    		}
    		$price = (intval($goicon) * $per) / 100;
    	}
    	
		$double = intval($goicha)*2;

		if ($price > $double) {
			$per_comission = $double;
		}else {
			$per_comission = $price;
		}
		return $per_comission;
	}
	public function edit_user(){
		$customer_id  = $this ->request -> get['customer_id'];
		$this -> load -> model('pd/registercustom');
		$data['customer'] = $this -> model_pd_registercustom ->get_username_id($customer_id);
		$data['seft'] = $this;
		$data['action_update'] = $this->url->link('pd/history/submit_update&customer_id='.$customer_id, 'token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];
		$data['get_nhanvien'] = $this -> model_pd_registercustom -> get_nhanvien();
		$data['get_dichvu'] = $this -> model_pd_registercustom -> get_dichvu();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('pd/edit_user.tpl', $data));
	}

	public function submit_update(){
		$this -> load -> model('pd/registercustom');
		$customer_id  = $this ->request -> get['customer_id'];
		
	
		$_POST['address_cus'] = $date_cmnd = '';
		if ($_POST['password'] == "")
		{
			$this -> model_pd_registercustom ->update_user($_POST['firstname'],$_POST['email'],$_POST['telephone'],$_POST['cmnd'],$_POST['account_holder'],$_POST['account_number'],$_POST['bank_name'],$_POST['branch_bank'],$_POST['address_cmnd'],$date_cmnd,$_POST['address_cus'],$customer_id,$password = false);
		}
		else
		{
			$this -> model_pd_registercustom ->update_user($_POST['firstname'],$_POST['email'],$_POST['telephone'],$_POST['cmnd'],$_POST['account_holder'],$_POST['account_number'],$_POST['bank_name'],$_POST['branch_bank'],$_POST['address_cmnd'],$date_cmnd,$_POST['address_cus'],$customer_id,$_POST['password']);
		}
		$data['customer'] = $this -> model_pd_registercustom ->get_username_id($customer_id);
		$data['action_update'] = $this->url->link('pd/history/submit_update&customer_id='.$customer_id, 'token=' . $this->session->data['token'], 'SSL');
		$data['seft'] = $this;
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this-> session -> data['complate'] = "complate";
		$this->response->setOutput($this->load->view('pd/edit_user.tpl', $data));
	}
}