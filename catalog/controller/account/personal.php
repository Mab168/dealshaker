<?php
class ControllerAccountPersonal extends Controller {
	private $error = array();

	public function index() {
		if (!$this -> customer -> isLogged()) {
			$this -> session -> data['redirect'] = $this -> url -> link('account/personal', '', 'SSL');

			$this -> response -> redirect($this -> url -> link('account/login', '', 'SSL'));
		}
		$this->document->addScript('catalog/view/javascript/personal/personal.js');
		$this->document->addScript('catalog/view/javascript/personal/tree.min.js');
		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['base'] = $server;

		$this -> load -> language('account/personal');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> customer -> getId());
		$language = new Language($getLanguage);
		$language -> load('account/personal');
		$data['lang'] = $language -> data;

		$this -> document -> setTitle($data['lang']['heading_title']);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home'));

		$data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('account/personal', '', 'SSL'));

		$data['heading_title'] = $this -> language -> get('heading_title');

		$data['column_left'] = $this -> load -> controller('common/column_left');
		$data['column_right'] = $this -> load -> controller('common/column_right');
		$data['content_top'] = $this -> load -> controller('common/content_top');
		$data['content_bottom'] = $this -> load -> controller('common/content_bottom');
		$data['footer'] = $this -> load -> controller('common/footer');
		$data['header'] = $this -> load -> controller('common/header');
		$data['idCustomer'] = $this -> customer -> getId();
		$this -> load -> model('account/customer');
		$id_user = $data['idCustomer'];
		$user = $this -> model_account_customer -> getCustomer($id_user);
		$data['self'] = $this;

		$data['trees'] =  HTTPS_SERVER . 'index.php?route=account/personal/getJsonBinaryTree';
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/personal.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/personal.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/personal.tpl', $data));
		}
	}

	public function getInfoCustomer() {
		$id_user = $this -> request -> get['id_user'];

		$this -> load -> model('account/customer');

		$user = $this -> model_account_customer -> getCustomer($id_user);
		$json = array();
		$json['nameCustomer'] = $user['firstname'];
		$json['telephone'] = $user['telephone'];
		$json['total_left'] = $this -> model_account_customer -> getSumLeft($id_user);
		$json['total_right'] = $this -> model_account_customer -> getSumRight($id_user);
		$json['floor'] = $this -> model_account_customer -> getSumFloor($id_user);
		$json['total'] = $json['total_left'] + $json['total_right'];
		$this -> response -> addHeader('Content-Type: application/json');
		$this -> response -> setOutput(json_encode($json));

	}

	public function getJsonBinaryTree() {

		//$id_user = $this -> request -> get['id_user'];
		$id_user = $this -> customer -> getId();
		$this -> load -> model('account/customer');

		$user = $this -> model_account_customer -> getCustomerCustom($id_user);

		$node = new stdClass();

		$node -> id = $user['customer_id'];

		$node -> text = $user['username'] ;
		$node -> iconCls = "level1";
		$node -> total_pd_node = round(doubleval($user['total_pd_node']/100000000),3);
		
		
		switch (intval($user['level'])) {
			case '1':
				$type = 'black';
				break;
			
			case '2':
				$type = 'blue';
				break;
			case '3':
				$type = 'red';
				break;
			case '4':
				$type = 'darkturquoise';
				break;
			case '5':
				$type = 'chartreuse';
				break;
			case '6':
				$type = 'yellow';
				break;
			case '6':
				$type = 'cyan';
				break;
		}
		$node -> type = $type;
		$this -> getBinaryChild($node);

		$node = array($node);

		//	ob_clean();

		echo json_encode($node[0]);

		exit();

	}

	public function getmaxpd($customer_id){
		$this -> load -> model('account/customer');
		return $this -> model_account_customer -> getmaxPD($customer_id)['number'];
	}
	public function getBinaryChild(&$node) {

		$this -> load -> model('account/customer');

		$listChild = $this -> model_account_customer -> getListChild($node -> id);

		$node -> children = array();

		foreach ($listChild as $child) {
			$childNode = new stdClass();

			$childNode -> id = $child['customer_id'];

			$childNode -> text = $child['username'];
			$childNode -> total_pd_node = round(doubleval($child['total_pd_node']/100000000),3);
			
					switch (intval($child['level'])) {
			case '1':
				$type = 'black';
				break;
			
			case '2':
				$type = 'blue';
				break;
			case '3':
				$type = 'red';
				break;
			case '4':
				$type = 'darkturquoise';
				break;
			case '5':
				$type = 'chartreuse';
				break;
			case '6':
				$type = 'yellow';
				break;
			case '6':
				$type = 'cyan';
				break;
		}
$childNode -> type = $type;


			$childNode -> iconCls = "level1";
			array_push($node -> children, $childNode);

			$this -> getBinaryChild($childNode);

		}
		if (count($node -> children) === 0)
			$node -> children = 0;
		return;

	}

	public function countFloor__($limit, $offset){

		$this -> load -> model('account/customer');
		$floor1 = $this->model_account_customer->getCountFloor($this -> customer -> getId());
				//Level 2
		if(!empty($floor1)){
			$data['floor1'] = count($floor1);
			$arrId='';
			foreach ($floor1 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor1'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId1'] = $arrId;
			$floor2 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor2'] = count($floor2);
		}		//Level 3
		if(!empty($floor2)){
			$arrId='';
			foreach ($floor2 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor2'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId2'] = $arrId;
			$floor3 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor3'] = count($floor3);
		}
		//Level 4
		if(!empty($floor3)){
			$arrId='';
			foreach ($floor3 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor3'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId3'] = $arrId;
			$floor4 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor4'] = count($floor4);
		}
		//Level 5
		if(!empty($floor4)){
			$arrId='';
			foreach ($floor4 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor4'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId4'] = $arrId;
			$floor5 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor5'] = count($floor5);
		}
		//Level 6
		if(!empty($floor5)){
			$arrId='';
			foreach ($floor5 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor5'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId5'] = $arrId;
			$floor6 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor6'] = count($floor6);
		}
		//Level 7
		if(!empty($floor6)){
			$arrId='';
			foreach ($floor6 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor6'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId6'] = $arrId;
			$floor7 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor7'] = count($floor7);
		}
		//Level 8
		if(!empty($floor7)){
			$arrId='';
			foreach ($floor7 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor7'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId7'] = $arrId;
			$floor8 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor8'] = count($floor8);
		}
		//Level 9
		if(!empty($floor8)){
			$arrId='';
			foreach ($floor8 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor8'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId8'] = $arrId;
			$floor9 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor9'] = count($floor9);
		}
		//Level 10
		if(!empty($floor9)){
			$arrId='';
			foreach ($floor9 as $value) {
				$arrId .= ','.$value['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$json['customerFloor9'] = $this -> model_account_customer -> getCustomerFloor($arrId, $limit, $offset);
			$json['arrId9'] = $arrId;

			$floor10 = $this->model_account_customer->getCountFloor($arrId);
			$data['floor10'] = count($floor10);
		}
		return $json;
	}
	public function getParrent($customer_id){
		$this -> load -> model('account/customer');
		$parrent = $this -> model_account_customer ->getParrent($customer_id);
		return $parrent;
	}
	public function checkPD($customer_id){
		$this->load->model('account/customer');
		$rows = $this -> model_account_customer -> checkPD($customer_id);
		$count = count($rows) > 0 ? 1 : 2;
		return $count;
	}
	public function getPD($customer_id){
		$this->load->model('account/customer');
		$rows = $this -> model_account_customer -> getPDLimit1($customer_id);
		if (!empty($rows)) {
			$PD = $rows['filled'];
		}else{
			$PD = 0;
		}

		return $PD;
	}
	public function customerFloor(){
		$this -> load -> language('account/personal');
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> customer -> getId());
		$language = new Language($getLanguage);
		$language -> load('account/personal');
		$lang = $language -> data;

		$limits = 10;

		if (isset($this -> request -> get['prev'])) {
			$limits = intval($this -> request -> get['prev'])-10;
		}
		if (isset($this -> request -> get['next'])) {
			$limits = intval($this -> request -> get['next'])+10;
		}
		if ($limits == 0) {
			$limits = 10;
		}

		$page = intval($limits)/10;

		$limit = 10;

		$start = ($page - 1) * 10;

		$customerFloor = $this -> countFloor($limit,$start);

		$floor = $this -> request -> get['floor'];
		if ($floor == 'floor1') {
			$arrId = $customerFloor['arrId1'];
		}
		if ($floor == 'floor2') {
			$arrId = $customerFloor['arrId2'];
		}
		if ($floor == 'floor3') {
			$arrId = $customerFloor['arrId3'];
		}
		if ($floor == 'floor4') {
			$arrId = $customerFloor['arrId4'];
		}
		if ($floor == 'floor5') {
			$arrId = $customerFloor['arrId5'];
		}
		if ($floor == 'floor6') {
			$arrId = $customerFloor['arrId6'];
		}
		if ($floor == 'floor7') {
			$arrId = $customerFloor['arrId7'];
		}
		if ($floor == 'floor8') {
			$arrId = $customerFloor['arrId8'];
		}
		if ($floor == 'floor9') {
			$arrId = $customerFloor['arrId9'];
		}

		$ts_floor = $this -> model_account_customer -> getTotalCustomerFloor($arrId);
		$ts_floor = $ts_floor['number'];

		//Floor 1
		if ($floor == 'floor1') {
			if (!empty($customerFloor['customerFloor1'])) {
				$customerFloor1 = $customerFloor['customerFloor1'];
				//echo "<pre>"; print_r($customerFloor1); echo "</pre>"; die();
				$fl1 = '';
				$fl1 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 1 ('.$ts_floor.')</h3>';
				$fl1 .= '<table id="datatable" class="table table-striped table-bordered">';
		        $fl1 .= '   <thead>';
		        $fl1 .= '      <tr>';
				$fl1 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
				$fl1 .= '           <th>'.$lang["USERNAME"].'</th>';
				$fl1 .= '           <th>'.$lang["Name"].'</th>';
				$fl1 .= '           <th>'.$lang["LEVEL"].'</th>';
				$fl1 .= '           <th>'.$lang["Parrent"].'</th>';
				$fl1 .= '           <th>PD</th>';
		        $fl1 .= '      </tr>';
		        $fl1 .= '       </thead>';
				$fl1 .= '<tbody>';
				$count = 1;
				foreach ($customerFloor1 as $key => $value) {
					$fl1 .= '<tr>';
					$fl1 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
					$fl1 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
					$fl1 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

					$fl1 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
					$fl1 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';
					$fl1 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getPD($value['customer_id']).'</td>';

					$fl1 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';


					$fl1 .= '</tr>';
					$count++;
				}
				$fl1 .= '</tbody>';
				$fl1 .= '</table>';
				$fl1 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl1 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl1'] = $fl1;
				$fl1 = null;
			}
		}

		if ($floor == 'floor2') {
		//Floor 2
			if (!empty($customerFloor['customerFloor2'])) {
				$customerFloor2 = $customerFloor['customerFloor2'];
				//echo "<pre>"; print_r($customerFloor1); echo "</pre>"; die();
				$fl2 = '';
				$fl2 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 2('.$ts_floor.')</h3>';
				$fl2 .= '<table id="datatable" class="table table-striped table-bordered">';
		        $fl2 .= '   <thead>';
		        $fl2 .= '      <tr>';
				$fl2 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
				$fl2 .= '           <th>'.$lang["USERNAME"].'</th>';
				$fl2 .= '           <th>'.$lang["Name"].'</th>';
				$fl2 .= '           <th>'.$lang["LEVEL"].'</th>';
				$fl2 .= '           <th>'.$lang["Parrent"].'</th>';
				$fl2 .= '           <th>PD</th>';
		        $fl2 .= '      </tr>';
		        $fl2 .= '       </thead>';
				$fl2 .= '<tbody>';
				$count = 1;
				foreach ($customerFloor2 as $key => $value) {
					$fl2 .= '<tr>';
					$fl2 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
					$fl2 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
					$fl2 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

					$fl2 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
					$fl2 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';
					$fl2 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getPD($value['customer_id']).'</td>';
					$fl2 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';

					$fl2 .= '</tr>';
					$count++;
				}
				$fl2 .= '</tbody>';
				$fl2 .= '</table>';
				$fl2 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl2 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl2'] = $fl2;
				$fl2 = null;
			}
		}
		//Floor 3
		if ($floor == 'floor3') {


			if (!empty($customerFloor['customerFloor3'])) {
				$customerFloor3 = $customerFloor['customerFloor3'];
				//echo "<pre>"; print_r($customerFloor1); echo "</pre>"; die();
				$fl3 = '';
				$fl3 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 3('.$ts_floor.')</h3>';
				$fl3 .= '<table id="datatable" class="table table-striped table-bordered">';
		        $fl3 .= '   <thead>';
		        $fl3 .= '      <tr>';
				$fl3 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
				$fl3 .= '           <th>'.$lang["USERNAME"].'</th>';
				$fl3 .= '           <th>'.$lang["Name"].'</th>';
				$fl3 .= '           <th>'.$lang["LEVEL"].'</th>';
				$fl3 .= '           <th>'.$lang["Parrent"].'</th>';
				$fl3 .= '           <th>PD</th>';
		        $fl3 .= '      </tr>';
		        $fl3 .= '       </thead>';
				$fl3 .= '<tbody>';
				$count = 1;
				foreach ($customerFloor3 as $key => $value) {
					$fl3 .= '<tr>';
					$fl3 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
					$fl3 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
					$fl3 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

					$fl3 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
					$fl3 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';
					$fl3 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getPD($value['customer_id']).'</td>';
					$fl3 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';

					$fl3 .= '</tr>';
					$count++;
				}
				$fl3 .= '</tbody>';
				$fl3 .= '</table>';
				$fl3 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl3 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl3'] = $fl3;
				$fl3 = null;
			}
		}
		//Floor 4
		if ($floor == 'floor4') {


			if (!empty($customerFloor['customerFloor4'])) {
			$customerFloor4 = $customerFloor['customerFloor4'];
			//echo "<pre>"; print_r($customerFloor1); echo "</pre>"; die();
			$fl4 = '';
			$fl4 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 4('.$ts_floor.')</h3>';
			$fl4 .= '<table id="datatable" class="table table-striped table-bordered">';
	        $fl4 .= '   <thead>';
	        $fl4 .= '      <tr>';
			$fl4 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
			$fl4 .= '           <th>'.$lang["USERNAME"].'</th>';
			$fl4 .= '           <th>'.$lang["Name"].'</th>';
			$fl4 .= '           <th>'.$lang["LEVEL"].'</th>';
			$fl4 .= '           <th>'.$lang["Parrent"].'</th>';
			$fl4 .= '           <th>PD</th>';
	        $fl4 .= '      </tr>';
	        $fl4 .= '       </thead>';
			$fl4 .= '<tbody>';
			$count = 1;
			foreach ($customerFloor4 as $key => $value) {
				$fl4 .= '<tr>';
				$fl4 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
				$fl4 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
				$fl4 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

				$fl4 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
				$fl4 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';
				$fl4 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getPD($value['customer_id']).'</td>';
				$fl4 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';

				$fl4 .= '</tr>';
				$count++;
			}

				$fl4 .= '</tbody>';
				$fl4 .= '</table>';
				$fl4 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl4 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl4'] = $fl4;
				$fl4 = null;
			}
		}
		//Floor 5
		if ($floor == 'floor5') {

				if (!empty($customerFloor['customerFloor5'])) {
				$customerFloor5 = $customerFloor['customerFloor5'];
				//echo "<pre>"; print_r($customerFloor1); echo "</pre>"; die();
				$fl5 = '';
				$fl5 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 5('.$ts_floor.')</h3>';
				$fl5 .= '<table id="datatable" class="table table-striped table-bordered">';
		        $fl5 .= '   <thead>';
		        $fl5 .= '      <tr>';
				$fl5 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
				$fl5 .= '           <th>'.$lang["USERNAME"].'</th>';
				$fl5 .= '           <th>'.$lang["Name"].'</th>';
				$fl5 .= '           <th>'.$lang["LEVEL"].'</th>';
				$fl5 .= '           <th>'.$lang["Parrent"].'</th>';
				$fl5 .= '           <th>PD</th>';
		        $fl5 .= '      </tr>';
		        $fl5 .= '       </thead>';
				$fl5 .= '<tbody>';
				$count = 1;
				foreach ($customerFloor5 as $key => $value) {
					$fl5 .= '<tr>';
					$fl5 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
					$fl5 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
					$fl5 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

					$fl5 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
					$fl5 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';
					$fl5 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getPD($value['customer_id']).'</td>';
					$fl5 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';

					$fl5 .= '</tr>';
					$count++;
				}
				$fl5 .= '</tbody>';
				$fl5 .= '</table>';

				$fl5 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl5 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl5'] = $fl5;
				$fl5 = null;
			}
		}
		//Floor 6
		if ($floor == 'floor6') {


				if (!empty($customerFloor['customerFloor6'])) {
				$customerFloor6 = $customerFloor['customerFloor6'];
				//echo "<pre>"; print_r($customerFloor1); echo "</pre>"; die();
				$fl6 = '';
				$fl6 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 6('.$ts_floor.')</h3>';
				$fl6 .= '<table id="datatable" class="table table-striped table-bordered">';
		        $fl6 .= '   <thead>';
		        $fl6 .= '      <tr>';
				$fl6 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
				$fl6 .= '           <th>'.$lang["USERNAME"].'</th>';
				$fl6 .= '           <th>'.$lang["Name"].'</th>';
				$fl6 .= '           <th>'.$lang["LEVEL"].'</th>';
				$fl6 .= '           <th>'.$lang["Parrent"].'</th>';
				$fl6 .= '           <th>PD</th>';
		        $fl6 .= '      </tr>';
		        $fl6 .= '       </thead>';
				$fl6 .= '<tbody>';
				$count = 1;
				foreach ($customerFloor6 as $key => $value) {
					$fl6 .= '<tr>';
					$fl6 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
					$fl6 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
					$fl6 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

					$fl6 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
					$fl6 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';
					$fl6 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getPD($value['customer_id']).'</td>';
					$fl6 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';

					$fl6 .= '</tr>';
					$count++;
				}
				$fl6 .= '</tbody>';
				$fl6 .= '</table>';
				$fl6 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl6 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl6'] = $fl6;
				$fl6 = null;
			}
		}
		//Floor 7
		if ($floor == 'floor7') {


				if (!empty($customerFloor['customerFloor7'])) {
				$customerFloor7 = $customerFloor['customerFloor7'];
				//echo "<pre>"; print_r($customerFloor1); echo "</pre>"; die();
				$fl7 = '';
				$fl7 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 7('.$ts_floor.')</h3>';
				$fl7 .= '<table id="datatable" class="table table-striped table-bordered">';
		        $fl7 .= '   <thead>';
		        $fl7 .= '      <tr>';
				$fl7 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
				$fl7 .= '           <th>'.$lang["USERNAME"].'</th>';
				$fl7 .= '           <th>'.$lang["Name"].'</th>';
				$fl7 .= '           <th>'.$lang["LEVEL"].'</th>';
				$fl7 .= '           <th>'.$lang["Parrent"].'</th>';
				$fl7 .= '           <th>PD</th>';
		        $fl7 .= '      </tr>';
		        $fl7 .= '       </thead>';
				$fl7 .= '<tbody>';
				$count = 1;
				foreach ($customerFloor7 as $key => $value) {
					$fl7 .= '<tr>';
					$fl7 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
					$fl7 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
					$fl7 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

					$fl7 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
					$fl7 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';
					$fl7 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';

					$fl7 .= '</tr>';
					$count++;
				}
				$fl7 .= '</tbody>';
				$fl7 .= '</table>';

				$fl7 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl7 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl7'] = $fl7;
				$fl7 = null;
			}
		}
		//Floor 8
		if ($floor == 'floor8') {

			if (!empty($customerFloor['customerFloor8'])) {
				$customerFloor8 = $customerFloor['customerFloor8'];
				$fl8 = '';
				$fl8 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 8('.$ts_floor.')</h3>';
				$fl8 .= '<table id="datatable" class="table table-striped table-bordered">';
		        $fl8 .= '   <thead>';
		        $fl8 .= '      <tr>';
				$fl8 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
				$fl8 .= '           <th>'.$lang["USERNAME"].'</th>';
				$fl8 .= '           <th>'.$lang["Name"].'</th>';
				$fl8 .= '           <th>'.$lang["LEVEL"].'</th>';
				$fl8 .= '           <th>'.$lang["Parrent"].'</th>';
				$fl8 .= '           <th>PD</th>';
		        $fl8 .= '      </tr>';
		        $fl8 .= '       </thead>';
				$fl8 .= '<tbody>';
				$count = 1;
				foreach ($customerFloor8 as $key => $value) {
					$fl8 .= '<tr>';
					$fl8 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
					$fl8 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
					$fl8 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

					$fl8 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
					$fl8 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';
					$fl8 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';

					$fl8 .= '</tr>';
					$count++;
				}
				$fl8 .= '</tbody>';
				$fl8 .= '</table>';
				$fl8 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl8 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl8'] = $fl8;
				$fl8 = null;
			}
		}
		//Floor 8
		if ($floor == 'floor9') {


				if (!empty($customerFloor['customerFloor9'])) {
				$customerFloor9 = $customerFloor['customerFloor9'];
				//echo "<pre>"; print_r($customerFloor1); echo "</pre>"; die();
				$fl9 = '';
				$fl9 .=' <h3 class="panel-title">'.$lang["FLOOR"].' 9('.$ts_floor.')</h3>';
				$fl9 .= '<table id="datatable" class="table table-striped table-bordered">';
		        $fl9 .= '   <thead>';
		        $fl9 .= '      <tr>';
				$fl9 .= '       	<th class="text-center">'.$lang["NO"].'</th>';
				$fl9 .= '           <th>'.$lang["USERNAME"].'</th>';
				$fl9 .= '           <th>'.$lang["Name"].'</th>';
				$fl9 .= '           <th>'.$lang["LEVEL"].'</th>';
				$fl9 .= '           <th>'.$lang["Parrent"].'</th>';
				$fl9 .= '           <th>PD</th>';
		        $fl9 .= '      </tr>';
		        $fl9 .= '       </thead>';
				$fl9 .= '<tbody>';
				$count = 1;
				foreach ($customerFloor9 as $key => $value) {
					$fl9 .= '<tr>';
					$fl9 .= '<td data-title="'.$lang["NO"].'" align="center">'.$count.'</td>';
					$fl9 .= '<td data-title="'.$lang["USERNAME"].'">'.$value['name'].'</td>';
					$fl9 .= '<td data-title="'.$lang["Name"].'">'.$value['fullname'].'</td>';

					$fl9 .= '<td data-title="'.$lang["LEVEL"].'">Vip '.($value['level']-1).'</td>';
					$fl9 .= '<td data-title="'.$lang["Parrent"].'">'.$this -> getParrent($value['p_node']).'</td>';

					$fl9 .= '<td data-title="PD">'.(intval($this -> checkPD($value['customer_id'])) === 1 ? '<span class="text-success">true</span>' : '<span class="text-danger">false</span>').'</td>';

					$fl9 .= '</tr>';
					$count++;
				}
				$fl9 .= '</tbody>';
				$fl9 .= '</table>';
				$fl9 .= '<button id="Prev" type="button" class="btn btn-primary">Preview</button>';
				$fl9 .= '<input id="next_page" type="hidden" name="next" value="'.$limits.'">
					<button id="Next" type="button" class="btn btn-primary">Next</button>';

				$json['fl9'] = $fl9;
				$fl9 = null;
			}
		}

		$this -> response -> setOutput(json_encode($json));
	}
	public function add_customer (){
		if(!isset($_COOKIE['code_customer'])) {
			setcookie('code_customer', $_GET['token'], time() + 3600*24*30*12);  	
		}
		
			$this -> load -> model('account/customer');
			$this -> document -> addScript('catalog/view/javascript/register/register.js');
		//language
		
		$this -> document -> setTitle('Register User');
		! array_key_exists('token', $this -> request -> get) && $this -> response -> redirect(HTTPS_SERVER.'login.html');
		$getCustomerbyCode = $this -> model_account_customer -> getCustomerbyCode($_GET['token']);
		count($getCustomerbyCode) === 0 && $this -> response -> redirect(HTTPS_SERVER.'login.html');
		//start load country model
		$this -> load -> model('customize/country');
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;

		$data['country'] = $this -> model_customize_country -> getCountry();
		//end load country model

		//data render website
		$data['self'] = $this;

		//error validate
		$data['error'] = $this -> error;
		
		
		$data['country'] = $this -> model_customize_country -> getCountry();
		$data['action'] = $this -> url -> link('account/registers/confirmSubmit', 'token=' . $this -> request -> get['token'], 'SSL');
		$data['actionCheckUser'] = $this -> url -> link('account/registers/checkuser', '', 'SSL');
		$data['actionWallet'] = $this -> url -> link('account/personal/checkwallet', '', 'SSL');
		$data['actionCheckEmail'] = $this -> url -> link('account/registers/checkemail', '', 'SSL');
		$data['actionCheckPhone'] = $this -> url -> link('account/registers/checkphone', '', 'SSL');
		$data['actionCheckCmnd'] = $this -> url -> link('account/registers/checkcmnd', '', 'SSL');
		// $data['column_left'] = $this->load->controller('common/column_left');

		$data['footer'] = $this -> load -> controller('common/footer');
		$data['header'] = $this -> load -> controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/registers.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/registers.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/registers.tpl', $data));
		}

	}

	public function register_submit(){
		
		//method to call function
		// !call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));

		if ($this->request->server['REQUEST_METHOD'] === 'POST'){
			$this -> load -> model('customize/register');
			$this -> load -> model('account/auto');
			$this -> load -> model('account/customer');

			
				$tmp = $this -> model_customize_register -> addCustomer_custom($this->request->post);

				$cus_id= $tmp;
				$amount = 0;
				$code_active = sha1(md5(md5($cus_id)));
				$this -> model_customize_register -> insert_code_active($cus_id, $code_active);
				$checkC_Wallet = $this -> model_account_customer -> checkR_Wallet($cus_id);
				if(intval($checkC_Wallet['number'])  === 0){
					if(!$this -> model_account_customer -> insertR_WalletR($amount, $cus_id)){
						die();
					}
				}
				$checkM_Wallet = $this -> model_account_customer -> checkM_Wallet($cus_id);
				if(intval($checkM_Wallet)  === 0){
					if(!$this -> model_account_customer ->insert_M_Wallet($cus_id)) {
						die();
					}
				}
				
				$data['has_register'] = true;
				$getCountryByID = $this -> model_account_customer -> getCountryByID(intval($this-> request ->post['country_id']));
				//$this -> response -> redirect($this -> url -> link('account/', '#success', 'SSL'));

				// send mail
				$mail = new Mail();
				$mail -> protocol = $this -> config -> get('config_mail_protocol');
				$mail -> parameter = $this -> config -> get('config_mail_parameter');
				$mail -> smtp_hostname = $this -> config -> get('config_mail_smtp_hostname');
				$mail -> smtp_username = $this -> config -> get('config_mail_smtp_username');
				$mail -> smtp_password = html_entity_decode($this -> config -> get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail -> smtp_port = $this -> config -> get('config_mail_smtp_port');
				$mail -> smtp_timeout = $this -> config -> get('config_mail_smtp_timeout');

				//$mail -> setTo($this -> config -> get('config_email'));
				$mail -> setTo($_POST['email']);
				$mail -> setFrom($this -> config -> get('config_email'));
				$mail -> setSender(html_entity_decode("Fundbtc", ENT_QUOTES, 'UTF-8'));
				$mail -> setSubject("Congratulations Your Registration is Confirmed!");
				$html_mail = '<div style="background: #f2f2f2; width:100%;">
				   <table align="center" border="0" cellpadding="0" cellspacing="0" style="background:#2A363C;border-collapse:collapse;line-height:100%!important;margin:0;padding:0;
				    width:700px; margin:0 auto">
				   <tbody>
				      <tr>
				        <td>
				          <div style="text-align:center" class="ajs-header"><img  src="'.HTTPS_SERVER.'catalog/view/theme/default/img/logo.png" alt="logo" style="margin: 0 auto; width:150px;"></div>
				        </td>
				       </tr>
				       <tr>
				       <td style="background:#fff">
				       	<p class="text-center" style="font-size:20px;color: black;text-transform: uppercase; width:100%; float:left;text-align: center;margin: 30px 0px 0 0;">congratulations !<p>
				       	<p class="text-center" style="color: black; width:100%; float:left;text-align: center;line-height: 15px;margin-bottom:30px;">You have successfully registered account</p>
       	<div style="width:600px; margin:0 auto; font-size=15px">

					       	<p style="font-size:14px;color: black;margin-left: 70px;">Your Username: <b>'.$this-> request ->post['username'].'</b></p>
					       	<p style="font-size:14px;color: black;margin-left: 70px;">Email Address: <b>'.$this-> request ->post['email'].'</b></p>
					       	<p style="font-size:14px;color: black;margin-left: 70px;">Phone Number: <b>'.$this-> request ->post['telephone'].'</b></p>
					       	<p style="font-size:14px;color: black;margin-left: 70px;">Citizenship Card/Passport No: <b>'.$this-> request ->post['cmnd'].'</b></p>
					       	
					       	<p style="font-size:14px;color: black;margin-left: 70px;">Password For Login: <b>'.$this-> request ->post['password'].'</b></p>			       
					       	<p style="font-size:14px;color: black;margin-left: 70px;">Bitcoin Wallet: <b>'.$this-> request ->post['wallet'].'</b>	</p>
					       	<p style="text-align:center;">
					       		<img style="margin:0 auto" src="https://chart.googleapis.com/chart?chs=150x150&chld=L|1&cht=qr&chl=bitcoin:'.$this-> request ->post['wallet'].'"/>
					       	</p>
					       	

					          </div>
				       </td>
				       </tr>
				    </tbody>
				    </table>
				  </div>';
				$mail -> setHtml($html_mail); 
				$mail -> send();

				
				$this-> model_customize_register -> update_template_mail($code_active, $html_mail);
				$this->session->data['register_mail'] = $this-> request ->post['email'];
				unset($_SESSION['customer_id']);
				$this -> response -> redirect(HTTPS_SERVER . 'login.html#success');
			
		}

	}
	public function checkwallet() {
		if ($this -> request -> get['wallet']) {
			$this -> load -> model('customize/register');
			$validate_address = $this -> check_address_btc($this -> request -> get['wallet']);
			$jsonwallet = $this -> model_customize_register -> checkExitWalletBTC($this -> request -> get['wallet']);
			if (intval($validate_address) === 1 && intval($jsonwallet) == 0)   {
				$json['wallet'] = 0;
			} else {
				$json['wallet'] = -1;
			}
			
			
			$this -> response -> setOutput(json_encode($json));
		}
	}


	public function validate($address)
    {
        $decoded = $this->decodeBase58($address);
        $d1      = hash("sha256", substr($decoded, 0, 21), true);
        $d2      = hash("sha256", $d1, true);
        if (substr_compare($decoded, $d2, 21, 4)) {
            throw new Exception("bad digest");
        }
        
        return true;
    }
    
    public function decodeBase58($input)
    {
        $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        $out      = array_fill(0, 25, 0);
        for ($i = 0; $i < strlen($input); $i++) {
            if (($p = strpos($alphabet, $input[$i])) === false) {
                throw new Exception("invalid character found");
            }
            
            $c = $p;
            for ($j = 25; $j--;) {
                $c += (int) (58 * $out[$j]);
                $out[$j] = (int) ($c % 256);
                $c /= 256;
                $c = (int) $c;
            }
            
            if ($c != 0) {
                throw new Exception("address too long");
            }
        }
        
        $result = "";
        foreach ($out as $val) {
            $result .= chr($val);
        }
        
        return $result;
    }
    
    public function check_address_btc($address_btc)
    {
        $address         = $address_btc;
        $message = 1;
        try {
            $abc = $this->validate($address);
        }
        
        catch (Exception $e) {
            $message = -1;
            
            // $json['message'] = $e->getMessage();
            
        }
        
        // $this->response->setOutput(json_encode($json));
        return $message;

    }
    public function sumFloor(){
		$this->load->model('account/customer');
		$floor = $this -> model_account_customer -> getSumFloor($this -> session -> data['customer_id']);
		$floor = intval($floor);
		return $floor;
	}
	public function countFloor(){
		$this -> load -> model('account/customer');
		$json = array();
		$floor = $this->model_account_customer->getCountFloor($this -> session -> data['customer_id']);
		$totalFloor = intval($this -> sumFloor());
		
		for ($i=1; $i <= $totalFloor; $i++) { 
			$member = 0;
			if(!empty($floor)){
				$data['floor'.$i] = count($floor);
				$arrId='';
				foreach ($floor as $value) {
					$arrId .= ','.$value['customer_id'];
					$member += 1;
				}
				$arrId = substr($arrId, 1);
				
				$json['arrId'.$i] = $member;
				$floor = $this->model_account_customer->getCountFloor($arrId);
				$data['floor'.$i] = count($floor);
			}
		}
		return $json;
	}
}