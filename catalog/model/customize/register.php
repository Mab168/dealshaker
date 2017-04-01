<?php
class ModelCustomizeRegister extends Model {
	public function checkExitUserName($username) {
		$query = $this -> db -> query("
			SELECT EXISTS(SELECT 1 FROM " . DB_PREFIX . "customer WHERE username = '" . $this -> db -> escape($username) . "')  AS 'exit'
			");

		return $query -> row['exit'];
	}

	public function checkExitUserNameForToken($username, $idUserNameLogin) {
		$query = $this -> db -> query("
			SELECT EXISTS(SELECT 1 FROM " . DB_PREFIX . "customer WHERE customer_id <> '". $idUserNameLogin ."' AND  username = '" . $username . "')  AS 'exit'
			");

		return $query -> row['exit'];
	}

	public function checkExitEmail($email) {
		$query = $this -> db -> query("
			SELECT count(*) AS number FROM " . DB_PREFIX . "customer WHERE email = '" . $this -> db -> escape($email) . "'
			");

		return $query -> row['number'];
	}

	public function checkExitPhone($telephone) {
		$query = $this -> db -> query("
			SELECT count(*) AS number FROM " . DB_PREFIX . "customer WHERE telephone = '" . $this -> db -> escape($telephone) . "'
			");

		return $query -> row['number'];
	}
	public function checkExitWalletBTC($wallet) {
		
		$query = $this -> db -> query("
			SELECT count(*) AS number FROM " . DB_PREFIX . "customer WHERE wallet = '" . $this -> db -> escape($wallet) . "'
			");

		return $query -> row['number'];
	}

	public function checkExitCMND($cmnd) {
		$query = $this -> db -> query("
			SELECT count(*) AS number FROM " . DB_PREFIX . "customer WHERE cmnd = '" . $this -> db -> escape($cmnd) . "'
			");

		return $query -> row['number'];
	}

	public function getId_by_username($username) {
		$query = $this -> db -> query("
			SELECT customer_id FROM " . DB_PREFIX . "customer WHERE customer_code = '" . $this -> db -> escape($username) . "'
			");

		return $query -> row['customer_id'];
	}
	public function signup_custom($data){
		
		
		$data['p_node'] = 1;

		//$data['p_node'] = $this -> session -> data['customer_id'];

		$this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer SET
			p_node = '" . $this -> db -> escape($data['p_node']) . "',
			customer_code = '".hexdec(crc32(md5($data['username'])))."',
			email = '" . $this -> db -> escape($data['email']) . "', 
			username = '" . $this -> db -> escape($data['username']) . "', 
			telephone = '" . $this -> db -> escape($data['telephone']) . "', 
			salt = '" . $this -> db -> escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
			password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
			status = '1',
			wallet= '" . $this -> db -> escape($data['wallet']) . "', 
			cmnd = '" . $this -> db -> escape($data['cmnd']) . "', 
			country_id = '". $this -> db -> escape($data['country_id']) ."',
			transaction_password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['transaction_password'])))) . "',
			date_added = NOW(),
			check_signup = 1,
			check_Newuser = 1,
			language = 'english'
		");

		$customer_id = $this -> db -> getLastId();
		$data['p_binary'] = 1;
		// p_binary = '" . $data['p_node'] . "',
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_ml SET 
			customer_id = '" . (int)$customer_id . "',
			customer_code = '".hexdec(crc32(md5($data['email'])))."',
			level = '1', 
			p_binary = '" . $data['p_binary'] . "', 
			p_node = '" . $data['p_node'] . "', 
			date_added = NOW()");
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_wallet_btc_ SET 
			customer_id = '" . (int)$customer_id . "',
			wallet = '" . $this -> db -> escape($data['wallet']) . "'");

		//update p_binary

		// if($data['postion'] === 'right'){
		// 	$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `right` = '" . (int)$customer_id . "' WHERE customer_id = '" . $data['p_binary'] . "'");
		// }else{
		// 	$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `left` = '" . (int)$customer_id . "' WHERE customer_id = '" . $data['p_binary'] . "'");
		// }
		return $customer_id;
	}

	public function addCustomer_custom($data){
		
		
		$data['p_node'] = $this->getId_by_username($data['node']);

		//$data['p_node'] = $this -> session -> data['customer_id'];

		$this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer SET
			p_node = '" . $this -> db -> escape($data['p_node']) . "',
			customer_code = '".hexdec(crc32(md5($data['username'])))."',
			email = '" . $this -> db -> escape($data['email']) . "', 
			username = '" . $this -> db -> escape($data['username']) . "', 
			telephone = '" . $this -> db -> escape($data['telephone']) . "', 
			salt = '" . $this -> db -> escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
			password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
			status = '1',
			wallet= '" . $this -> db -> escape($data['wallet']) . "', 
			cmnd = '" . $this -> db -> escape($data['cmnd']) . "', 
			country_id = '". $this -> db -> escape($data['country_id']) ."',
			transaction_password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['transaction_password'])))) . "',
			date_added = NOW(),
			check_Newuser = 1,
			language = 'english'
		");

		$customer_id = $this -> db -> getLastId();

		// p_binary = '" . $data['p_node'] . "',
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_ml SET 
			customer_id = '" . (int)$customer_id . "',
			level = '1', 
			customer_code = '".hexdec(crc32(md5($data['email'])))."',
			p_binary = '" . $data['p_node'] . "', 
			p_node = '" . $data['p_node'] . "', 
			date_added = NOW()");

		
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_wallet_btc_ SET 
			customer_id = '" . (int)$customer_id . "',
			wallet = '" . $this -> db -> escape($data['wallet']) . "'");
		//update p_binary
		return $customer_id;
	}
public function addCustomer_auto($data){
		
		
		$data['p_node'] = $this->session->data['customer_id'];

		//$data['p_node'] = $this -> session -> data['customer_id'];

		$this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer SET
			p_node = '" . $this -> db -> escape($data['p_node']) . "',
			customer_code = '".hexdec(crc32(md5($data['username'])))."',
			email = '" . $this -> db -> escape($data['email']) . "', 
			username = '" . $this -> db -> escape($data['username']) . "', 
			telephone = '" . $this -> db -> escape($data['telephone']) . "', 
			salt = '" . $this -> db -> escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
			password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
			status = '1',
			wallet= '" . $this -> db -> escape($data['wallet']) . "', 
			cmnd = '" . $this -> db -> escape($data['cmnd']) . "', 
			country_id = '". $this -> db -> escape($data['country_id']) ."',
			transaction_password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['transaction_password'])))) . "',
			date_added = NOW(),
			check_Newuser = 1,
			language = 'english'
		");

		$customer_id = $this -> db -> getLastId();
		$id_p_binary = $this -> get_customer_ml();
	    $p_binary = $id_p_binary['customer_id'];

		// p_binary = '" . $data['p_node'] . "',
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_ml SET 
			customer_id = '" . (int)$customer_id . "',
			customer_code = '".hexdec(crc32(md5($data['email'])))."',
			level = '1', 
			p_binary = '" . $p_binary . "', 
			p_node = '" . $data['p_node'] . "', 
			date_added = NOW()");
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_wallet_btc_ SET 
			customer_id = '" . (int)$customer_id . "',
			wallet = '" . $this -> db -> escape($data['wallet']) . "'");
		//update p_binary

		if(intval($id_p_binary['left']) === 0){
			$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `left` = '" . (int)$customer_id . "' WHERE customer_id = '" . $p_binary . "'");
		}else{
			$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `right` = '" . (int)$customer_id . "' WHERE customer_id = '" . $p_binary . "'");
		}
		return $customer_id;
	}
	public function get_customer_ml(){
		$query = $this -> db -> query("SELECT customer_id, `left`, `right` FROM `sm_customer_ml` WHERE `left` = 0 OR `right` = 0 ORDER BY `date_added` ASC LIMIT 1");
		return $query -> row;
	}
	public function update_customer_ml($customer_id, $p_node, $id_p_binary){
		
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_ml SET 
			customer_id = '" . (int)$customer_id . "',
			customer_code = '".hexdec(crc32(md5($customer_id)))."',
			level = '1',
			status = '1',
			p_binary = '" . $id_p_binary . "', 
			p_node = '" . $p_node . "',
			date_added = NOW()");
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `right` = '" . (int)$customer_id . "' 
			WHERE customer_id = '" . $id_p_binary . "'");
	}
	public function addCustomer($data) {
		
		
		$data['p_node'] = $this -> session -> data['customer_id'];

		$this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer SET
			p_node = '" . $this -> db -> escape($data['p_node']) . "', 
			email = '" . $this -> db -> escape($data['email']) . "', 
			username = '" . $this -> db -> escape($data['username']) . "', 
			telephone = '" . $this -> db -> escape($data['telephone']) . "', 
			salt = '" . $this -> db -> escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
			password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
			status = '1', 
			cmnd = '" . $this -> db -> escape($data['cmnd']) . "', 
			country_id = '". $this -> db -> escape($data['country_id']) ."',
			transaction_password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['transaction_password'])))) . "',
			date_added = NOW(),
			check_Newuser = 1,
			language = 'english'
		");

		$customer_id = $this -> db -> getLastId();

		// p_binary = '" . $data['p_node'] . "',
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_ml SET 
			customer_id = '" . (int)$customer_id . "',
			level = '1', 
			p_binary = '" . $data['p_node'] . "', 
			p_node = '" . $data['p_node'] . "', 
			date_added = NOW()");

		//update p_binary
		$totalChild = $this -> getTotalChild($data['p_node']);
		if ($totalChild > 2) {
			//update p_binary
			$tmp_id = $this -> reduce_p_binary($data['p_node'], $customer_id);

			$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `p_binary` = '" . (int)$tmp_id . "' WHERE customer_id = '" . $customer_id . "' AND status <> 0");
			
			$customerParent = $this -> getCustomer_ml($tmp_id);
			if(intval($customerParent['left']) === 0){
				$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `left` = '" . (int)$customer_id . "' WHERE customer_id = '" . $tmp_id . "'");
			}else{
				$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `right` = '" . (int)$customer_id . "' WHERE customer_id = '" . $tmp_id . "'");
			}
		}else{
			$totalChild = $this -> getTotalChild($data['p_node']);
			if ($totalChild == 1) {
				$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `left` = '" . (int)$customer_id . "' WHERE customer_id = '" . $data['p_node'] . "'");
			} else {
				$this -> db -> query("UPDATE " . DB_PREFIX . "customer_ml SET `right` = '" . (int)$customer_id . "' WHERE customer_id = '" . $data['p_node'] . "'");
			}
			
		}

		return $customer_id;

	}

	public function getCustomer_ml($customer_id) {
		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer_ml  WHERE customer_id = '" . (int)$customer_id . "'");
		return $query -> row;
	}

	public function getTotalChild($customer_id) {
		$query = $this -> db -> query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_ml WHERE p_binary = '" . (int)$customer_id . "' AND status <> 0");
		return intval($query -> row['total']);
	}

	function reduce_p_binary($p_node, $customer_id) {

		$query = $this -> db -> query("SELECT customer_id FROM " . DB_PREFIX . "customer_ml 
			WHERE p_node = '" . (int)$p_node . " ' 
			AND customer_id <> '" . $customer_id . "'
			AND status <> 0
			OR p_binary =  '" . $p_node . "'
			ORDER BY id");
		$rows = $query -> rows;

		foreach ($rows as $key => $value) {

			if ($this -> getTotalChild($value['customer_id']) < 2) {
				$query = null;
				$rows = null;
				return $value['customer_id'];
				break;
			}
			// else{
			// 	$this -> reduce_p_binary($value['customer_id'], $customer_id);
			// }
		}
	}
	public function addCustomerByToken($data) {

		

		$this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer SET
			
			email = '" . $this -> db -> escape($data['email']) . "', 
			username = '" . $this -> db -> escape($data['username']) . "', 
			telephone = '" . $this -> db -> escape($data['telephone']) . "', 
			salt = '" . $this -> db -> escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
			password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
			status = '1', 
			cmnd = '" . $this -> db -> escape($data['cmnd']) . "', 
			
			
			date_added = NOW(),
			check_Newuser = 1,
			language = 'vietnam'
		");

		$customer_id = $this -> db -> getLastId();

		

		return $customer_id;
	}
	public function insert_code_active($customer_id, $code){
		
		$query = $this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_code_active SET 
			customer_id = '" . (int)$customer_id . "',
			code_active = '".$code."',
			status = 1
			
			");
		return $query;
	}
	public function update_code_active($code){
		
		$query = $this -> db -> query("UPDATE " . DB_PREFIX . "customer_code_active SET status = 1 WHERE code_active = '" . $code . "'");
		return $query;
	}
	public function update_template_mail($code,$mail){
		
		$query = $this -> db -> query("UPDATE " . DB_PREFIX . "customer_code_active SET template_mail = '".$mail."' WHERE code_active = '" . $code . "'");
		return $query;
	}
	public function get_code_active($customer_id){
		
		$query = $this -> db -> query("SELECT COUNT(*) as number FROM " . DB_PREFIX . "customer_code_active  WHERE status = 1 AND customer_id = '" . (int)$customer_id . "'");
		return $query -> row;
	}
}
