<?php
class ControllerPdBarcode extends Controller {
	public function index() {
		$this->document->setTitle('Customer ');
		$this->load->model('pd/pd');
	
		
		if (isset($this->request->get['filter_status'])) {
				$status = $this->request->get['filter_status'];
				$data['filter_status'] = $this->request->get['filter_status'];
			
		} else{
			$status = null;
			$data['filter_status'] = null;
		}
		// echo "<pre>"; print_r($status); echo "</pre>"; die();
		$data['self'] = $this;
		
		$str = HTTPS_SERVER;

		$data['getaccount'] = $this->url->link('pd/history/getaccount&token='.$this->session->data['token']);
		$data['getaccount_username'] = $this->url->link('pd/history/getaccount_username&token='.$this->session->data['token']);
		$data['link_search'] = $this -> url -> link('pd/customer/search_name&token='.$this->session->data['token'].'', '', 'SSL');
		$data['link_search_username'] = $this -> url -> link('pd/history/link_search_username&token='.$this->session->data['token'].'', '', 'SSL');
		$data['link_search_tuoi'] = $this -> url -> link('pd/customer/link_search_tuoi&token='.$this->session->data['token'].'', '', 'SSL');
		$data['query_child'] = $this -> url -> link('pd/history/query_child&token='.$this->session->data['token'].'', '', 'SSL');
		$data['load_date'] = $this -> url -> link('pd/history/load_date&token='.$this->session->data['token'].'', '', 'SSL');
		$data['getaccount_tuoi'] = $this->url->link('pd/history/getaccount_tuoi&token='.$this->session->data['token']);
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this -> load -> model('pd/registercustom');
		if (isset($this -> session -> data['barcode']))
		{
			$data['customer'] =  $this-> model_pd_registercustom->get_barcode_customer_id($this -> session -> data['barcode']);
		}
		else
		{
			$data['customer'] = array();
		}
		
	
		$this->response->setOutput($this->load->view('pd/barcode.tpl', $data));
	}

	public function getaccount_tuoi(){
		if ($this -> request -> post['keyword']) {
			$this -> load -> model('pd/registercustom');
			$tree = $this -> model_pd_registercustom -> getCustomLike_tuoi($this -> request -> post['keyword']);
			print_r($tree); die;
			if (count($tree) > 0) {
				foreach ($tree as $value) {
					 echo '<li class="list-group-item" onClick="selectU_username(' . "'" . $value['name'] . "'" . ');">' . $value['name'] . '</li>';
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

	public function check_barcode()
	{
		$this -> load -> model('pd/registercustom');
		$barcode = $this -> request ->post['barcode'];
		$barcode = $this -> model_pd_registercustom -> check_barcode($barcode);
		echo $barcode;die;
	}

	public function link_search_tuoi()
	{
		$customer_id = $this -> request ->post['customer_id'];
		$this -> load -> model('pd/registercustom');
		$get_name_customer = $this -> model_pd_registercustom -> get_name_customer_id($customer_id);
		
		$i = 1;
		foreach ($get_name_customer as $value) {
			
		?>
			<tr>
            <td><?php echo $i ?></td>
            <td><?php echo $value['firstname'];?></td>
            <td><?php echo date('d/m/Y',strtotime($value['date_birth'])) ?></td>
            <td><?php echo $this -> getAge(date('Y-m-d',strtotime($value['date_birth'])));?> </td>
            
            <td><?php echo ($value['telephone']);?></td>
            
            <td><?php echo $value['address'];?></td>
            <td><?php echo date('d/m/Y H:i:s',strtotime($value['date_added'])) ?></td>
           
            <td class="text-center"><a href="<?php echo $this->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
            <td class="text-center"><a href="<?php echo $this->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary  "><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>   
            <td class="text-center">
              <a onclick="return confirm('Bạn có chắc chắn không?')" href="index.php?route=pd/create/submit_remove&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
               </a>
            </td>
            <td class="text-center">
              <a href="index.php?route=pd/customer/create_bill&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i></i></button>
               </a>
            </td>
          </tr>
		<?php
		}

	}

	public function search_thang()
	{
		$thang = $this -> request ->post['thang'];
		$this -> load -> model('pd/registercustom');
		$get_name_customer = $this -> model_pd_registercustom -> get_thang_customer_id($thang);
		
		$i = 1;
		foreach ($get_name_customer as $value) {
			
		?>
			<tr>
            <td><?php echo $i ?></td>
            <td><?php echo $value['firstname'];?></td>
            <td><?php echo date('d/m/Y',strtotime($value['date_birth'])) ?></td>
            <td><?php echo $this -> getAge(date('Y-m-d',strtotime($value['date_birth'])));?> </td>
            
            <td><?php echo ($value['telephone']);?></td>
            
            <td><?php echo $value['address'];?></td>
            <td><?php echo date('d/m/Y H:i:s',strtotime($value['date_added'])) ?></td>
           
            <td class="text-center"><a href="<?php echo $this->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
            <td class="text-center"><a href="<?php echo $this->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary  "><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>   
            <td class="text-center">
              <a onclick="return confirm('Bạn có chắc chắn không?')" href="index.php?route=pd/create/submit_remove&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
               </a>
            </td>
            <td class="text-center">
              <a href="index.php?route=pd/customer/create_bill&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i></i></button>
               </a>
            </td>
          </tr>
		<?php
		}
	}

	public function load_barcode()
	{

		$barcode = $this -> request ->post['barcode'];
		$this -> session -> data['barcode'] = $barcode;
		$this -> load -> model('pd/registercustom');
		$value = $this -> model_pd_registercustom -> get_barcode_customer_id($barcode);
		if (count($value) > 0) {
		$i = 1;
		?>	
			<h2 class="text-center" style="margin-bottom: 20px;">Thông tin khách hàng</h2>
	        <div class="col-md-6">
	          <h3>Tên khách hàng: <?php echo $value['firstname'] ?></h3>
	          <h3>Ngày sinh: <?php echo date('d/m/Y',strtotime($value['date_birth'])) ?></h3>
	          <h3>Số điện thoại: <?php echo $value['telephone'] ?></h3>
	        </div>
	        <div class="col-md-6">
	          <h3>Tuổi: <?php echo $this -> getAge(date('Y-m-d',strtotime($value['date_birth'])));?></h3>
	          <h3>Địa chỉ: <?php echo $value['address'] ?></h3>
	          <h3>Ngày tạo: <?php echo date('d/m/Y H:i:s',strtotime($value['date_added'])) ?></h3>
	        </div>

			<table class="table table-bordered table-hover">
     		<thead>
     			<tr>
     				
     				
     				<th>Họ Tên</th>
            <th>Ngày sinh</th>
            <th>Tuổi</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Thời gian</th>
            <th>Lịch sử</th>
            <th>Sửa</th>
            <th>Xóa</th>
            <th>Tạo hóa đơn</th>
     			</tr>
     		</thead>
     		<tbody >
			<tr>
           
            <td><?php echo $value['firstname'];?></td>
            <td><?php echo date('d/m/Y',strtotime($value['date_birth'])) ?></td>
            <td><?php echo $this -> getAge(date('Y-m-d',strtotime($value['date_birth'])));?> </td>
            
            <td><?php echo ($value['telephone']);?></td>
            
            <td><?php echo $value['address'];?></td>
            <td><?php echo date('d/m/Y H:i:s',strtotime($value['date_added'])) ?></td>
           
            <td class="text-center"><a href="<?php echo $this->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
            <td class="text-center"><a href="<?php echo $this->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary  "><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>   
            <td class="text-center">
              <a onclick="return confirm('Bạn có chắc chắn không?')" href="index.php?route=pd/create/submit_remove&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
               </a>
            </td>
            <td class="text-center">
              <a href="index.php?route=pd/customer/create_bill&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i></i></button>
               </a>
            </td>
          </tr>
          </tbody>
     	</table>
         <div class="clearfix" style="margin-top: 20px;"></div>
         <h3 class="text-center">Lịch sử</h3>
		<?php
		
		$get_history = $this -> model_pd_registercustom -> get_history_customer($value['customer_id']);
		if (count($get_history) > 0)
		{ ?>
			<table class="table table-bordered table-hover">
     		<thead>
     			<tr>
     				
     		<th>STT</th>
     		<th>Thông tin tư vấn</th>
            <th>Dịch vụ</th>
            <th>Nhân viên quản lý</th>
            <th>Ghi chú</th>
            <th>Giá tiền</th>
            <th>Thời gian</th>
            
     			</tr>
     		</thead>
     		<tbody >
     		<?php $i=0; foreach ($get_history as $values) { $i++;?>
     		<tr>
     			<td><?php echo $i ?></td>
     			<td><?php echo $values['thongtintuvan'];?></td>
	            <td><?php echo $values['dichvu']; ?></td>
	            <td><?php echo $values['nhanvientao'];?> </td>
	            <td><?php echo $values['ghichu'];?></td>
	            <td><?php echo (number_format($values['giatien']));?></td>
	            <td><?php echo date('d/m/Y H:i:s',strtotime($values['date_added'])) ?></td>	
	         </tr>
     		<?php } ?>

     		</tbody>
     		</table>
		<?php } else {
			?> <h3 class="text-center">Không có dữ liệu</h3> <?php
		}

		} else{
			?> <h3 class="text-center">Không có dữ liệu</h3> <?php
		}



	}

	public function search_name(){
		$name = $this -> request ->post['name'];
		$this -> load -> model('pd/registercustom');
		$get_name_customer = $this -> model_pd_registercustom -> get_name_customer_id($name);
		
		$i = 1;
		foreach ($get_name_customer as $value) {
			
		?>
			<tr>
            <td><?php echo $i ?></td>
            <td><?php echo $value['firstname'];?></td>
            <td><?php echo date('d/m/Y',strtotime($value['date_birth'])) ?></td>
            <td><?php echo $this -> getAge(date('Y-m-d',strtotime($value['date_birth'])));?> </td>
            
            <td><?php echo ($value['telephone']);?></td>
            
            <td><?php echo $value['address'];?></td>
            <td><?php echo date('d/m/Y H:i:s',strtotime($value['date_added'])) ?></td>
           
            <td class="text-center"><a href="<?php echo $this->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
            <td class="text-center"><a href="<?php echo $this->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary  "><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>   
            <td class="text-center">
              <a onclick="return confirm('Bạn có chắc chắn không?')" href="index.php?route=pd/create/submit_remove&customer_id=<?php echo $value['customer_id']?>&token=<?php echo $_GET['token'];?>">
                  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
               </a>
            </td>
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
				<td><?php echo $value['firstname'];?></td>
				<td><?php echo number_format($get_filled_by_id['sum_filled']);?></td>
				<td class="text-center"><i class="fa fa-circle  <?php echo ($value['status_r_wallet'] == 1) ? "text-danger" : "text-success" ?>" aria-hidden="true"></i></td>
				<td><?php echo $value['date_register_tree'];?></td>
				<td><?php echo number_format($value['total_pd_left'])."/".number_format($value['total_pd_right']);?></td>
				<td><?php echo $this->getCustomer($value['p_node']);?></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/history/view_history&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></button></a></td>
				<td class="text-center"><a href="<?php echo $this->url->link('pd/history/edit_user&customer_id='.$value['customer_id'].'&token='.$this->session->data['token']);?>"><button class="btn btn-primary	"><i class="fa fa-eyedropper" aria-hidden="true"></i></button></a></td>	
			
			</tr>
		<?php
		}

	}

	public function getCustomer($customer_id){
		$this -> load -> model('pd/registercustom');
		$getCustomer = $this -> model_pd_registercustom -> getCustomer($customer_id);
		if (count($getCustomer) > 0 )
			return $getCustomer['username'];
		else
			return 0;
	}
	
	public function getaccount() {
		if ($this -> request -> post['keyword']) {
			$this -> load -> model('pd/registercustom');
			$tree = $this -> model_pd_registercustom -> getCustomLike_name($this -> request -> post['keyword']);
			//print_r($tree); die;
			if (count($tree) > 0) {
				foreach ($tree as $value) {
					 echo '<li class="list-group-item" onClick="selectU(' . "'" . $value['firstname'] . "'" . ');">' . $value['firstname'] . '</li>';
				}
			}
		}
	}
	public function getaccount_username(){
		if ($this -> request -> post['keyword']) {
			$this -> load -> model('pd/register');
			$tree = $this -> model_pd_register -> getCustomLike($this -> request -> post['keyword']);
			
			if (count($tree) > 0) {
				foreach ($tree as $value) {
					 echo '<li class="list-group-item" onClick="selectU_username(' . "'" . $value['name'] . "'" . ');">' . $value['name'] . '</li>';
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
				<td><?php echo $value['firstname'];?></td>
				<td><?php echo number_format($get_filled_by_id['sum_filled']);?></td>
				
				<td><?php echo $value['date_register_tree'];?></td>
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
		$data['customer'] = $this -> model_pd_registercustom ->get_username_id($customer_id);
		$data['history'] = $this -> model_pd_registercustom ->get_history_buyid($customer_id);
		$data['baotro'] = $this -> model_pd_registercustom -> get_baotro($customer_id);
		$data['get_name_customer'] = $this -> model_pd_registercustom -> get_name_customer($customer_id);
		
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
		$customer = $this -> model_pd_registercustom ->get_username_id($customer_id);
		return $customer['package'];
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
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('pd/edit_user.tpl', $data));
	}

	public function create_bill(){
		$customer_id  = $this ->request -> get['customer_id'];
		$this -> load -> model('pd/registercustom');
		$data['customer'] = $this -> model_pd_registercustom ->get_username_id($customer_id);
		$data['seft'] = $this;
		$data['action_update'] = $this->url->link('pd/history/submit_update&customer_id='.$customer_id, 'token=' . $this->session->data['token'], 'SSL');
		$data['get_nhanvien'] = $this -> model_pd_registercustom -> get_nhanvien();
		$data['get_dichvu'] = $this -> model_pd_registercustom -> get_dichvu();

		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('pd/create_bill.tpl', $data));
	}


	public function submit_create_bill()
	{
		$this->load->model('pd/registercustom');
		if ($this->request->server['REQUEST_METHOD'] === 'POST'){
			
			$id = $this -> model_pd_registercustom -> create_bill($this -> request -> post,$this -> request -> get['customer_id']);

			$this-> session -> data['success'] = "complate";
			$this->response->redirect($this->url->link('pd/create/print_user', 'token=' . $this->session->data['token'] .'&id='.$id, 'SSL'));
		}
	}


	public function submit_update(){
		$this -> load -> model('pd/registercustom');
		$customer_id  = $this ->request -> get['customer_id'];
		$newDate = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$_POST['date_cmnd']);
		$date_cmnd = date('Y-m-d',strtotime($newDate));
		//print_r($date_cmnd); die;
		/*print_r($date_cmnd); die;*/
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


	public function dautu_user(){
		$customer_id  = $this ->request -> get['customer_id'];
		$this -> load -> model('pd/registercustom');
		$data['customer'] = $this -> model_pd_registercustom ->get_username_id($customer_id);

		$data['show_pd_customer'] = $this -> model_pd_registercustom ->show_pd_customer($customer_id);
		//createPD
		
		$data['seft'] = $this;

		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('pd/dautu_user.tpl', $data));
	}

	public function invesment()
	{

		$customer_id  = $this ->request -> post['customer_id'];
		$package  = $this ->request -> post['package']*1000;
		$this -> load -> model('pd/registercustom');

		$getCustomer = $this -> model_pd_registercustom -> getCustomer($customer_id);

		$check_pd_customer = $this -> model_pd_registercustom -> check_pd_customer($customer_id,$package);
		$check_pd_customer > 0 && die("error");
		// tao pd
		switch ($package) {
			case 100000:
				$doanhso = 0;
				$loinhuan = 0;
				break;
			case 200000:
				$doanhso = 0;
				$loinhuan = 0;
				break;
			case 300000:
				$doanhso = 0;
				$loinhuan = 12;
				break;
			case 3333000:
				$doanhso = 6;
				$loinhuan = 12;
				break;
			case 6666000:
				$doanhso = 9;
				$loinhuan = 15;
				break;
			case 16666000:
				$doanhso = 12;
				$loinhuan = 18;
				break;
			case 24166000:
				$doanhso = 15;
				$loinhuan = 24;
				break;
			default:
				$doanhso = 0;
				$loinhuan = 0;
				$percent = 0;
				break;
		}
		$this -> model_pd_registercustom -> createPD($customer_id, $package,$doanhso,$loinhuan);

		// update ML
		$this -> model_pd_registercustom -> update_customer_binary($customer_id, $getCustomer['p_node']);
		
		// update level
		$this -> model_pd_registercustom -> update_level_ml($customer_id, 2);

		
		// cap nhap total pd 
		$this -> model_pd_registercustom -> upadate_totla_pd($customer_id, $package,true);


		
		$get_parent = $this -> model_pd_registercustom -> getCustomer_ml($getCustomer['p_node']);
		if (count($get_parent) > 0)
		{
			//hoa hong truc tiep
			$amount = $this -> refferal_commision($customer_id,$package);
			
			// hoa hong cua hoa hong
			if (doubleval($amount) > 0)
			{
				$this -> hoahongf1($getCustomer['p_node'],$amount);
			}
			
		}
	
		$this-> session -> data['complate'] = "complate";
		$this->response->redirect($this->url->link('pd/customer/dautu_user', 'token=' . $this->session->data['token'] .'&customer_id='.$customer_id, 'SSL'));
	}

	public function upgray_invesment()
	{
		$customer_id  = $this ->request -> post['customer_id'];
		$package  = $this ->request -> post['package']*1000;
		$this -> load -> model('pd/registercustom');

		$getCustomer = $this -> model_pd_registercustom -> getCustomer($customer_id);

		$check_pd_customer = $this -> model_pd_registercustom -> check_pd_customer($customer_id,$package);
		$check_pd_customer > 0 && die("error");
		// tao pd
		switch ($package) {
			case 100000:
				$doanhso = 0;
				$loinhuan = 0;
				break;
			case 200000:
				$doanhso = 0;
				$loinhuan = 0;
				break;
			case 300000:
				$doanhso = 0;
				$loinhuan = 12;
				break;
			case 3333000:
				$doanhso = 6;
				$loinhuan = 12;
				break;
			case 6666000:
				$doanhso = 9;
				$loinhuan = 15;
				break;
			case 16666000:
				$doanhso = 12;
				$loinhuan = 18;
				break;
			case 24166000:
				$doanhso = 15;
				$loinhuan = 24;
				break;
			default:
				$doanhso = 0;
				$loinhuan = 0;
				$percent = 0;
				break;
		}
		$this -> model_pd_registercustom -> createPD($customer_id, $package,$doanhso,$loinhuan);
		
		// cap nhap total pd 
		$this -> model_pd_registercustom -> upadate_totla_pd($customer_id, $package,true);

		$get_parent = $this -> model_pd_registercustom -> getCustomer_ml($getCustomer['p_node']);
		if (count($get_parent) > 0)
		{
			//hoa hong truc tiep
			$amount = $this -> refferal_commision($customer_id,$package);
			
			// hoa hong cua hoa hong
			if (doubleval($amount) > 0)
			{
				$this -> hoahongf1($getCustomer['p_node'],$amount);
			}
			
		}
	
		$this-> session -> data['complate'] = "complate";
		$this->response->redirect($this->url->link('pd/customer/dautu_user', 'token=' . $this->session->data['token'] .'&customer_id='.$customer_id, 'SSL'));
		
	}

	public function hoahongf1($parent_id,$amount)
	{
		$customer_id_f = $parent_id;
	
		while (true) {
			
			$get_customer_id_f = $this -> model_pd_registercustom -> getCustomer($customer_id_f);
			
			$get_parent_f = $this -> model_pd_registercustom -> getCustomer_ml_donation($get_customer_id_f['p_node']);
			
			if (count($get_parent_f) > 0)
			{
				$get_child_active = $this -> model_pd_registercustom -> get_customer_ml_pnode($get_parent_f['customer_id']);
				// level cha va co 3 con active
				if (intval($get_parent_f['level']) >= 2 && intval($get_child_active) >= 3)
				{	
					

					switch ($get_parent_f['filled']) {
						case 100000:
							$percent = 30;
							break;
						case 200000:
							$percent = 40;
							break;
						case 300000:
							$percent = 50;
							break;
						case 3333000:
							$percent = 50;
							break;
						case 6666000:
							$percent = 50;
							break;
						case 16666000:
							$percent = 50;
							break;
						case 24166000:
							$percent = 50;
							break;
						default:
							$percent = 0;
							break;
					}
					if ($percent > 0)
					{
						$check_packet_active = $this -> model_pd_registercustom -> get_ml_child_active($get_parent_f['customer_id'],$get_parent_f['filled']);

						if (intval($check_packet_active) >= 3)
						{
							$per_cent =  $percent;
						}
						else
						{
							$per_cent =  $percent-10;
						}
						$amount_receve = $amount * $per_cent /100;
						// cong diem
						$this -> model_pd_registercustom ->update_amount_hh_wallet($get_parent_f['customer_id'],$amount_receve,true);
						// luu lich su
						$id_history = $this -> model_pd_registercustom -> saveTranstionHistory(
		                $get_parent_f['customer_id'],
		                'Hoa hồng trên thu nhập trực tiếp F1', 
		                '+ ' . ($amount_receve/1000) . ' PV',
		                "Nhận ".$per_cent."% hoa hồng từ tài khoản ".$get_customer_id_f['username']." nhận ".($amount/1000)." PV");
						
					}
					
				}
				else
				{
					break;
				}	
			}
			else
			{
				break;
			}
			$customer_id_f = $get_parent_f['customer_id'];
		}
	}

	public function refferal_commision($customer_id,$package)
	{
		$getCustomer = $this -> model_pd_registercustom -> getCustomer($customer_id);

		$amount = 0;
		$get_parent = $this -> model_pd_registercustom -> getCustomer_ml($getCustomer['p_node']);
		if ($get_parent['level'] == 2)
		{
			$get_goidautu = $this -> model_pd_registercustom -> get_goidautu($getCustomer['p_node']);
			switch ($get_goidautu['package']) {
				case 100000:
					$percent = 6;
					$max_profit = 1000000;
					break;
				case 200000:
					$percent = 8;
					$max_profit = 1333000;
					break;
				case 300000:
					$percent = 10;
					$max_profit = 1666000;
					break;
				case 3333000:
					$percent = 10;
					$max_profit = 1666000;
					break;
				case 6666000:
					$percent = 10;
					$max_profit = 1666000;
					break;
				case 16666000:
					$percent = 10;
					$max_profit = 1666000;
					break;
				case 24166000:
					$percent = 10;
					$max_profit = 1666000;
					break;
				default:
					$percent = 0;
					$max_profit = 0;
					break;
			}
			if ($percent > 0)
			{
				$amount = doubleval($package) * $percent/100;

				if ($amount > $max_profit)
				{
					$amount = $max_profit;
				}
				$this -> model_pd_registercustom ->update_amount_r_wallet($get_parent['customer_id'],$amount,true);
				 $id_history = $this -> model_pd_registercustom -> saveTranstionHistory(
	                $get_parent['customer_id'],
	                'Hoa hồng trực tiếp', 
	                '+ ' . ($amount/1000) . ' PV',
	                "Nhận ".$percent."% hoa hồng trực tiếp từ tài khoản ".$getCustomer['username']." khi tri ân gói ".(number_format($package/1000))." PV."); 
			}
			
		}
		return $amount;
	}

	
}