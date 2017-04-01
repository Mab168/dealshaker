<?php
class ModelAccountCustomer extends Model {
	

	public function update_R_Wallet_add($amount, $customer_id, $wallet){
		
			$query = $this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer_r_wallet_payment SET
				amount = ".$amount.",
				customer_id = ".$customer_id.",
				addres_wallet = '".$wallet."',
				date_end = DATE_ADD( NOW(), INTERVAL + 60 DAY)
			");
		
		return $query === true ? true : false;
	}

	public function getCustomer_Pd_last(){
		$query = $this -> db -> query("
			SELECT pd.amount, c.customer_id FROM sm_customer_invoice_pd AS pd JOIN sm_customer AS c ON c.customer_id = pd.customer_id WHERE `confirmations` = 3
		");
		return $query -> rows;
	}

	public function addCustomer($data) {
		$this -> event -> trigger('pre.customer.add', $data);

		if (isset($data['customer_group_id']) && is_array($this -> config -> get('config_customer_group_display')) && in_array($data['customer_group_id'], $this -> config -> get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this -> config -> get('config_customer_group_id');
		}

		$this -> load -> model('account/customer_group');

		$customer_group_info = $this -> model_account_customer_group -> getCustomerGroup($customer_group_id);

		$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this -> config -> get('config_store_id') . "', firstname = '" . $this -> db -> escape($data['firstname']) . "', lastname = '" . $this -> db -> escape($data['lastname']) . "', email = '" . $this -> db -> escape($data['email']) . "', telephone = REPLACE('" . $this -> db -> escape($data['telephone']) . "', ' ', ''), cmnd = '" . $this -> db -> escape($data['cmnd']) . "', account_bank = '" . $this -> db -> escape($data['account_bank']) . "', address_bank = '" . $this -> db -> escape($data['address_bank']) . "', p_node = '" . $this -> db -> escape($data['p_node']) . "', custom_field = '" . $this -> db -> escape(isset($data['custom_field']['account']) ? serialize($data['custom_field']['account']) : '') . "', salt = '" . $this -> db -> escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this -> db -> escape($this -> request -> server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()");

		$customer_id = $this -> db -> getLastId();

		
		$this -> event -> trigger('post.customer.add', $customer_id);

		return $customer_id;
	}


	public function get_payment_blockchain($customer_id){
		$query = $this -> db -> query("
			SELECT customer_id 
			FROM ".DB_PREFIX."customer_payment_blockhain
			WHERE customer_id = ".$customer_id."
		");
		return $query -> row;
	}

	public function insert_payment_blockain($customer_id){
		$query = $this -> db -> query("
			INSERT INTO ".DB_PREFIX."customer_payment_blockhain
			SET customer_id = ".$customer_id."
		");
		return $query;
	}

	public function getInfoUsers_binary($id_id){

		$query = $this->db->query("select u.*,ml.level, l.name_vn as level_member from ". DB_PREFIX . "customer_ml as ml Left Join " . DB_PREFIX . "customer as u ON ml.customer_id = u.customer_id Left Join " . DB_PREFIX . "member_level as l ON l.id = ml.level Where ml.customer_id = " . $id_id);
		$return  = $query->row;
		return $return;
	}

	public function saveTranstionHistory($customer_id, $wallet, $text_amount, $system_decsription, $url = ''){
		$query = $this -> db -> query("
			INSERT INTO ".DB_PREFIX."customer_transaction_history SET
			customer_id = '".$customer_id."',
			wallet = '".$wallet."',
			text_amount = '".$text_amount."',
			system_decsription = '".$system_decsription."',
			url = '".$url."',
			date_added = NOW()
		");
		return $query;
	}
	
	public function getGdFromTransferList($gd_id){
		$query = $this -> db -> query("
			SELECT ctl.* , c.username
			FROM ". DB_PREFIX . "customer_transfer_list AS ctl
			JOIN ". DB_PREFIX ."customer AS c
				ON ctl.pd_id_customer = c.customer_id
			WHERE ctl.gd_id = '".$this->db->escape($gd_id)."'
		");
		return $query -> rows;
	}
	public function updateCheck_R_WalletPD($pd_id){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET
				check_R_Wallet = 1
				WHERE id = '".$pd_id."'
			");
		return $query;
	}

	public function getGDTranferByID($transacion_id){

		$query = $this -> db -> query("
			SELECT c.username, ctl.*
			FROM ". DB_PREFIX . "customer_transfer_list AS ctl
			JOIN ". DB_PREFIX ."customer AS c
				ON ctl.pd_id_customer = c.customer_id
			WHERE ctl.id = '".$this->db->escape($transacion_id)."' AND gd_id_customer = ".$this -> session -> data['customer_id']."
		");
		return $query -> row;
	}

	public function getPNode($customer_id){
		$query = $this -> db -> query("
			SELECT * FROM sm_customer_provide_donation pd JOIN sm_customer_get_donation gd on pd.customer_id = gd.customer_id WHERE pd.customer_id in 
			(SELECT customer_id FROM sm_customer WHERE p_node = ".$customer_id.") AND pd.status = 2 AND gd.status = 2 GROUP BY pd.customer_id		");
		return $query -> rows;
	}
	
	public function getPDByTranferID($transacion_id){
		$query = $this -> db -> query("
			SELECT id
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE id = '".$transacion_id."'
		");
		return $query -> row;
	}
	public function countStatusPDTransferList($pd_id){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM ". DB_PREFIX ."customer_transfer_list
			WHERE pd_id = '". $pd_id ."' AND pd_status = 0
			");
		return $query -> row;
	}
	public function countStatusGDTransferList($pd_id){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM ". DB_PREFIX ."customer_transfer_list
			WHERE gd_id = '". $pd_id ."' AND pd_status = 0
			");
		return $query -> row;
	}
	public function updateStusPD($pd_id){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET
				status = 2
				WHERE id = '".$pd_id."'
			");
		return $query;
	}
	public function updateStusPDActive($pd_id){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET
				status = 1
				WHERE id = '".$pd_id."'
			");
		return $query;
	}
	public function updateStusGDActive($pd_id){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_get_donation SET
				status = 1
				WHERE id = '".$pd_id."'
			");
		return $query;
	}
	
	public function updateStusGD($gd_id){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_get_donation SET
				status = 2
				WHERE id = '".$gd_id."'
			");
		return $query;
	}

	public function updateStatusPDTransferList($transferID, $transaction_hash,$input_transaction_hash){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_transfer_list SET
				pd_status = 1,
				gd_status = 1,
				
				transaction_hash ='".$transaction_hash."',
				input_transaction_hash ='".$input_transaction_hash."'
				WHERE transfer_code = '".$this->db->escape($transferID)."'
		");
		return $query;
	}

	public function getPDTranferByID($transacion_id){
		$query = $this -> db -> query("
			SELECT c.*, ctry.name, ctl.*
			FROM ". DB_PREFIX . "customer_transfer_list AS ctl
			JOIN ". DB_PREFIX ."customer AS c
				ON ctl.gd_id_customer = c.customer_id
			JOIN ". DB_PREFIX ."country AS ctry
				ON ctry.country_id = c.country_id
			WHERE ctl.id = '".$this->db->escape($transacion_id)."'
		");
		return $query -> row;
	}
	public function getCountryByID($id){
		$query = $this -> db -> query("
			SELECT name
			FROM ". DB_PREFIX ."country 
			WHERE country_id = '".$this->db->escape($id)."'
		");
		return $query -> row;
	}

	public function getPdFromTransferList($pd_id){

		$query = $this -> db -> query("
			SELECT ctl.* , c.username, c.wallet
			FROM ". DB_PREFIX . "customer_transfer_list AS ctl
			JOIN ". DB_PREFIX ."customer AS c
				ON ctl.gd_id_customer = c.customer_id
			WHERE ctl.pd_id = '".$this->db->escape($pd_id)."'
		");
		return $query -> rows;
	}
	
	public function getGDByCustomerIDAndToken($customer_id, $token){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM ". DB_PREFIX ."customer_get_donation
			WHERE customer_id = '". $customer_id ."' AND id = '".$token."'
			");
		return $query -> row;
	}
	public function getPD($iod_customer){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE customer_id = '".$this->db->escape($iod_customer)."'
		");
		return $query -> rows;
	}
	public function getPDById($id_customer, $limit, $offset){

		$query = $this -> db -> query("
			SELECT pd.*, c.username
			FROM  ".DB_PREFIX."customer_provide_donation AS pd
			JOIN ". DB_PREFIX ."customer AS c
			ON pd.customer_id = c.customer_id
			WHERE pd.customer_id = '".$this -> db -> escape($id_customer)."' AND pd.status = 1
			ORDER BY pd.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}

	public function getPDByCustomerIDAndToken($customer_id, $token){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM ". DB_PREFIX ."customer_provide_donation
			WHERE customer_id = '". $customer_id ."' AND id = '".$token."'
			");
		return $query -> row;
	}
	public function getPDConfirm($id){
		
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE id = '".$this->db->escape($id)."'
		");
		return $query -> row;
	}
	public function createPD($data){
		$this -> db -> query("
			INSERT INTO ". DB_PREFIX . "customer_provide_donation_lottery SET 
			customer_id = '".$this -> session -> data['customer_id']."',
			date_added = NOW(),
			date_danh = '".$data['ngay_danh']."',
			id_tranfer	= '".$data['id_tranfer']."',
			total_btc_danh = '".(round($data['total_btc_danh'],8)*100000000)."',
			status = 0,
			type_lottery = '".$data['type_lottery']."',
			btc_tren_number	= '".(round($data['btc_tren_number'],8)*100000000)."',
			win_btc_number	= '".(round($data['win_btc_number'],8)*100000000)."',
			bet_numbers	= '".$data['bet_numbers']."',
			bet_rate	= '".intval($data['bet_rate'])."',
			domain_id = '".intval($data['domain_id'])."'
		");
		
		$pd_id = $this->db->getLastId();

		
		
		$pd_number = hexdec( crc32($pd_id) );
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation_lottery SET 
				
				pd_number = '".$pd_number."'
				WHERE id = '".$pd_id."'
			");
		$data['query'] = $query ? true : false;
		$data['pd_number'] = $pd_number;
		$data['pd_id'] = $pd_id;
		return $data;
	}

	public function insertR_Wallet($id_customer){
		$query = $this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer_r_wallet SET
			customer_id = '".$this -> db -> escape($id_customer)."',
			amount = '0.0'
		");
		return $query;
	}
	public function insertR_WalletR($amount, $id_customer){
		$query = $this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer_r_wallet SET
			customer_id = '".$this -> db -> escape($id_customer)."',
			amount = ".$amount."
		");
		return $query;
	}

	public function insertC_Wallet($id_customer){
		$query = $this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer_c_wallet SET
			customer_id = '".$this -> db -> escape($id_customer)."',
			amount = '0'
		");
		return $query;
	}
	public function insertCN_Wallet($id_customer){
		$query = $this -> db -> query("
			INSERT INTO " . DB_PREFIX . "customer_cn_wallet SET
			customer_id = '".$this -> db -> escape($id_customer)."',
			amount = '0'
		");
		return $query;
	}
	public function checkR_Wallet($id_customer){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM  ".DB_PREFIX."customer_r_wallet
			WHERE customer_id = '".$this -> db -> escape($id_customer)."'
		");
		return $query -> row;
	}
	public function checkCN_Wallet_payment($id_customer){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM  ".DB_PREFIX."customer_cn_wallet_payment
			WHERE customer_id = '".$this -> db -> escape($id_customer)."'
		");
		return $query -> row;
	}
	public function updateR_Wallet($id_customer, $amount){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_r_wallet SET
			amount = '" . $this -> db -> escape((float)$amount) . "'
			WHERE customer_id = '" . (int)$id_customer . "'");

		return $query;
	}

	public function checkC_Wallet($id_customer){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM  ".DB_PREFIX."customer_c_wallet
			WHERE customer_id = '".$this -> db -> escape($id_customer)."'
		");
		return $query -> row;
	}
	public function checkCN_Wallet($id_customer){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM  ".DB_PREFIX."customer_cn_wallet
			WHERE customer_id = '".$this -> db -> escape($id_customer)."'
		");
		return $query -> row;
	}

	public function getmaxPD($id_customer){
		$query = $this -> db -> query("
			SELECT max(amount_usd) AS number
			FROM  ".DB_PREFIX."customer_provide_donation
			WHERE customer_id = '".$this -> db -> escape($id_customer)."' AND status = 1
		");

		return $query -> row;
	}
	public function getTotalPD($id_customer){
		$query = $this -> db -> query("
			SELECT sum(amount_usd) AS number
			FROM  ".DB_PREFIX."customer_provide_donation 
			WHERE status = 1 AND customer_id = '".$this -> db -> escape($id_customer)."'
		");

		return $query -> row;
	}
	public function getTableCustomerMLByUsername($customer_id){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_ml
			WHERE customer_id = '".$customer_id."'
		");

		return $query -> row;
	}


	public function update_pd_binary($left = true, $customer_id, $total_pd){
		if($left){
			$query = $this -> db -> query("
				UPDATE ".DB_PREFIX."customer
				SET total_pd_left = total_pd_left + ".$total_pd."
				WHERE customer_id = '".$customer_id."'
			");
		}else{
			$query = $this -> db -> query("
				UPDATE ".DB_PREFIX."customer
				SET total_pd_right = total_pd_right + ".$total_pd."
				WHERE customer_id = '".$customer_id."'
			");
		}
		return $query;
	}

	public function getR_Wallet_payment($id_customer){
		$query = $this -> db -> query("
			SELECT sum(amount) as amount
			FROM  ".DB_PREFIX."customer_r_wallet_payment
			WHERE customer_id = '".$this -> db -> escape($id_customer)."' 
		");
		return $query -> row;
	}

	public function getC_Wallet($id_customer){

		$query = $this -> db -> query("
			SELECT amount
			FROM  ".DB_PREFIX."customer_c_wallet
			WHERE customer_id = '".$this -> db -> escape($id_customer)."'
		");
		return $query -> row;
	}
	public function getCN_Wallet($id_customer){
		$query = $this -> db -> query("
			SELECT amount
			FROM  ".DB_PREFIX."customer_cn_wallet
			WHERE customer_id = '".$this -> db -> escape($id_customer)."'
		");
		return $query -> row;
	}

	public function getLikeMember($name = '', $idUserLogin){
		if($name === ''){
			$customer_query = $this->db->query("
				SELECT username AS name , customer_id AS code FROM " . DB_PREFIX . "customer WHERE customer_id <> ". $this->db->escape($idUserLogin) ."
				LIMIT 8");
			return $customer_query -> rows;
		}
		if($name !== ''){
			$customer_query = $this->db->query("
				SELECT username AS name , customer_id AS code FROM " . DB_PREFIX . "customer
				WHERE customer_id <> ". $idUserLogin ." AND username Like '%".$this->db->escape($name)."%'
				LIMIT 8");
			return $customer_query -> rows;
		}
	}

	public function getPasswdTransaction($password=''){
		if($password !== ''){
			$customer_query = $this->db->query("
				SELECT COUNT(*) AS number FROM " . DB_PREFIX . "customer
				WHERE customer_id = '". $this -> session -> data['customer_id'] ."' AND transaction_password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) AND status <> 0 ");
			return $customer_query -> row;
		}
	}

	public function countGdOfDay($month, $year, $day){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM ". DB_PREFIX . "customer_get_donation
			WHERE customer_id = '".$this -> session -> data['customer_id']."'
				  AND MONTH(date_added) = '".$month."'
				  AND YEAR(date_added) = '".$year."'
				  AND DAY(date_added) = '".$day."'
		");

		return $query -> row;
	}

	public function update_C_Wallet($amount , $customer_id, $add = false){
		if(!$add){
			$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_c_wallet SET
				amount = amount - ".floatval($amount)."
				WHERE customer_id = '".$customer_id."'
			");
			
		}else{

			$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_c_wallet SET
				amount = amount + ".floatval($amount).",
				date_added = NOW()
				WHERE customer_id = '".$customer_id."'
			");
		}
		
		return $query === true ? true : false;
	}
	public function inser_history($text_amount, $wallet,$system_decsription,$customer_id){
		$query = $this -> db -> query("
			INSERT INTO ". DB_PREFIX . "customer_transaction_history SET
			text_amount = '".$text_amount."',
			date_added = NOW(),
			wallet = '".$wallet."',
			system_decsription = '".$system_decsription."',
			customer_id = '".$customer_id."'
		");
		return $this->db->getLastId();
	}
	public function update_R_Wallet($amount , $customer_id, $add = false){
		if(!$add){
			$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_r_wallet SET
				amount = amount - ".floatval($amount)."
				WHERE customer_id = '".$customer_id."'
			");
		}else{
			$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_r_wallet SET
				amount = amount + ".floatval($amount)."
				WHERE customer_id = '".$customer_id."'
			");
		}
		return $query === true ? true : false;
	}

	public function createGD($amount){
		$this -> db -> query("
			INSERT INTO ". DB_PREFIX . "customer_get_donation SET
			customer_id = '".$this -> session -> data['customer_id']."',
			date_added = NOW(),
			amount = '".$amount."',
			status = 0
		");

		$gd_id = $this->db->getLastId();

		$gd_number = hexdec(crc32($gd_id));

		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_get_donation SET
				gd_number = '".$gd_number."'
				WHERE id = '".$gd_id."'
			");
		$data['query'] = $query ? true : false;
		$data['gd_number'] = $gd_number;
		return $data;
	}

	public function editPasswordCustomForEmail($data, $password) {
		$this -> event -> trigger('pre.customer.edit.password');
		$customer_id = $data['customer_id'];
		$salt = $data['salt'];

		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET
			password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($password)))) . "'
			WHERE customer_id = '" . $this -> db -> escape($customer_id) . "'");

		$this -> event -> trigger('post.customer.edit.password');
	}
	public function getCustomLike($name, $id_user) {
		$listId = '';
		$query = $this -> db -> query("
			SELECT c.username AS name, c.customer_id AS code FROM ". DB_PREFIX ."customer AS c
			JOIN ". DB_PREFIX ."customer_ml AS ml
			ON ml.customer_id = c.customer_id
			WHERE ml.p_node = ". $id_user ." AND c.username Like '%".$this->db->escape($name)."%'");
		$array_id = $query -> rows;
		foreach ($array_id as $item) {
			$listId .= ',' . $item['name'];
			$listId .= $this -> getCustomLike($name,$item['code']);
		}
		return $listId;
	}
	public function checkUserName($id_user) {
		$listId = '';
		$query = $this -> db -> query("
			SELECT c.username AS name, c.customer_id AS code FROM ". DB_PREFIX ."customer AS c
			JOIN ". DB_PREFIX ."customer_ml AS ml
			ON ml.customer_id = c.customer_id
			WHERE ml.p_node = ". $id_user ."");
		$array_id = $query -> rows;
		foreach ($array_id as $item) {
			$listId .= ',' . $item['name'];
			$listId .= $this -> checkUserName($item['code']);
		}
		return $listId;
	}


	public function getTotalGD($id_customer){
		$query = $this -> db -> query("
			SELECT COUNT( * ) AS number
			FROM  ".DB_PREFIX."customer_get_donation
			WHERE customer_id = '".$this -> db -> escape($id_customer)."'
		");

		return $query -> row;
	}
	
	public function getGDById($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_get_donation
			WHERE customer_id = '".$this -> db -> escape($id_customer)."'
			ORDER BY date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");

		return $query -> rows;
	}

	public function checkpasswd($password=''){
		if($password !== ''){
			$customer_query = $this->db->query("
				SELECT COUNT(*) AS number FROM " . DB_PREFIX . "customer
				WHERE customer_id = '". $this -> session -> data['customer_id'] ."' AND password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) AND status <> 0 ");
			return $customer_query -> row;
		}
	}

	public function updatePin($id_customer, $pin){

		$this -> event -> trigger('pre.customer.edit', $data);
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer SET
			ping = '" . $this -> db -> escape((int)$pin) . "'
			WHERE customer_id = '" . (int)$id_customer . "'");

		$this -> event -> trigger('post.customer.edit', $id_customer);

	}

	public function updateStatus($id_customer,  $status){
		if($id_customer && $status){
			$query =  $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer SET
				status = '" . $this -> db -> escape((int)$status) . "'
				WHERE customer_id = '" . (int)$id_customer. "'");
			if($query){
				$query =  $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_ml SET
				status = '" . $this -> db -> escape((int)$status) . "'
				WHERE customer_id = '" . (int)$id_customer. "'");
			}else{
				$query = false;
			}

			return $query;
		}
	}

	public function getLevel($customer_id, $level){
		$query =  $this -> db -> query("
			SELECT * 
					FROM " . DB_PREFIX . "customer_ml
					WHERE customer_id
					IN ( SELECT customer_id FROM " . DB_PREFIX . "customer WHERE p_node = ".$customer_id." )
					AND level = ".$level."
					GROUP BY customer_id");
		return $query -> rows;
	}

	public function updateLevel($customer_id, $level){
		$query =  $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_ml SET
				level = ".$level."
				WHERE customer_id = '" . (int)$customer_id. "'");
		return $query;
	}

	public function updateCheckNEwuser($id_customer){
		if($id_customer){
			$query =  $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer SET
				check_Newuser = 0
				WHERE customer_id = '" . (int)$id_customer. "'");
			return $query;
		}
	}
	


	public function saveHistoryPin($id_customer, $amount, $user_description, $type , $system_description){
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "ping_history SET
			id_customer = '" . $this -> db -> escape($id_customer) . "',
			amount = '" . $this -> db -> escape( $amount ) . "',
			date_added = NOW(),
			user_description = '" .$this -> db -> escape($user_description). "',
			type = '" .$this -> db -> escape($type). "',
			system_description = '" .$this -> db -> escape($system_description). "'
		");
		return $this -> db -> getLastId();
	}

	public function getTotalRefferalByID($id_customer){

		$query = $this -> db -> query("
			SELECT COUNT( * ) AS number
			FROM ".DB_PREFIX."customer_ml
			WHERE p_node =  '".$this -> db -> escape($id_customer)."'
		");

		return $query -> row;
	}

	public function getRefferalByID($id_customer ,$limit, $offset){
		$query = $this -> db -> query("
			SELECT c.email , c.username,c.telephone,c.cmnd,c.wallet,c.country_id,c.total_pd_node, c.customer_id, ml.level, c.date_added
			FROM ".DB_PREFIX."customer_ml AS ml
			JOIN ". DB_PREFIX ."customer AS c
			ON ml.customer_id = c.customer_id
			WHERE ml.p_node =  '".$this -> db -> escape($id_customer)."'
			ORDER BY ml.level DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");

		return $query -> rows;
	}

	public function getTotalTokenHistory($id_customer){
		$query = $this -> db -> query("
			SELECT COUNT( * ) AS number
			FROM  ".DB_PREFIX."ping_history
			WHERE id_customer = ".$this -> db -> escape($id_customer)." AND amount <> '- 0' AND amount <> '+ 0'
		");

		return $query -> row;
	}

	public function getTokenHistoryById($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."ping_history
			WHERE id_customer = ".$this -> db -> escape($id_customer)." AND amount <> '- 0' AND amount <> '+ 0'
			ORDER BY date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."

		");

		return $query -> rows;
	}

	public function editCustomerWallet($wallet) {

		$data['wallet'] = $wallet;
		$this -> event -> trigger('pre.customer.edit', $data);
		$customer_id = $this -> customer -> getId();
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET wallet = '". $wallet ."' WHERE customer_id = '" . (int)$customer_id . "'");
		$this -> event -> trigger('post.customer.edit', $customer_id);
	}

	public function editCustomerBanks($data) {

		$data_arr = $data;
		$this -> event -> trigger('pre.customer.edit', $data_arr);
		$customer_id = $this -> customer -> getId();
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET account_holder = '". $data_arr['account_holder'] ."',bank_name = '". $data_arr['bank_name'] ."',account_number = '". $data_arr['account_number'] ."',branch_bank = '". $data_arr['branch_bank'] ."' WHERE customer_id = '" . (int)$customer_id . "'");
		$this -> event -> trigger('post.customer.edit', $customer_id);
	}
	public function editCustomerProfile($data) {

		$data_arr = $data;
		$this -> event -> trigger('pre.customer.edit', $data_arr);
		$customer_id = $this -> customer -> getId();
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET username = '". $data_arr['username'] ."',email = '". $data_arr['email'] ."',telephone = '". $data_arr['telephone'] ."' WHERE customer_id = '" . (int)$customer_id . "'");
		$this -> event -> trigger('post.customer.edit', $customer_id);
	}

	public function editCustomer($data) {

		$this -> event -> trigger('pre.customer.edit', $data);

		$customer_id = $this -> customer -> getId();

		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this -> db -> escape($data['firstname']) . "', lastname = '" . $this -> db -> escape($data['lastname']) . "', email = '" . $this -> db -> escape($data['email']) . "', telephone = '" . $this -> db -> escape($data['telephone']) . "', account_bank = '" . $this -> db -> escape($data['account_bank']) . "', address_bank = '" . $this -> db -> escape($data['address_bank']) . "', custom_field = '" . $this -> db -> escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "' WHERE customer_id = '" . (int)$customer_id . "'");

		$this -> event -> trigger('post.customer.edit', $customer_id);
	}

	public function editCustomerCusotm($data) {


		$this -> event -> trigger('pre.customer.edit', $data);

		$customer_id = $this -> customer -> getId();
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer SET
			email = '" . $this -> db -> escape($data['email']) . "',
			telephone = '" . $this -> db -> escape($data['telephone']) . "'
			WHERE customer_id = '" . (int)$customer_id . "'");

		$this -> event -> trigger('post.customer.edit', $customer_id);
	}

	public function editPasswordCustom($password) {
		$this -> event -> trigger('pre.customer.edit.password');
		$customer_id = $this -> customer -> getId();

		$salt = $this -> getCustomer($customer_id);
		$salt = $salt['salt'];

		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET
			password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($password)))) . "'
			WHERE customer_id = '" . $this -> db -> escape($customer_id) . "'");

		$this -> event -> trigger('post.customer.edit.password');
	}

	public function editPasswordTransactionCustom($password) {
		$this -> event -> trigger('pre.customer.edit.password');
		$customer_id = $this -> customer -> getId();

		$salt = $this -> getCustomer($customer_id);
		$salt = $salt['salt'];

		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET
			transaction_password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($password)))) . "'
			WHERE customer_id = '" . $this -> db -> escape($customer_id) . "'");

		$this -> event -> trigger('post.customer.edit.password');
	}

	public function editPassword($email, $password) {
		$this -> event -> trigger('pre.customer.edit.password');

		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this -> db -> escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this -> db -> escape(utf8_strtolower($email)) . "'");

		$this -> event -> trigger('post.customer.edit.password');
	}

	public function editNewsletter($newsletter) {
		$this -> event -> trigger('pre.customer.edit.newsletter');

		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this -> customer -> getId() . "'");

		$this -> event -> trigger('post.customer.edit.newsletter');
	}

	public function getCustomer($customer_id) {
		$query = $this -> db -> query("SELECT c.* FROM " . DB_PREFIX . "customer c  WHERE c.customer_id = '" . (int)$customer_id . "'");
		return $query -> row;
	}
	public function getCustomerbyCode($customer_id) {
		$query = $this -> db -> query("SELECT c.* FROM " . DB_PREFIX . "customer c  WHERE c.customer_code = '" . $customer_id . "'");
		return $query -> row;
	}

	public function getCustomerPDForPD($p_node) {
		$query = $this -> db -> query("
			SELECT c.customer_id 
			FROM " . DB_PREFIX . "customer c  
			JOIN sm
			WHERE c.p_node = '" . (int)$p_node . "'"
		);
		return $query -> row;
	}

	public function getTotalHistory($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".intval($customer_id)."' AND wallet LIKE 'Hours rates'
		");

		return $query -> row;
	}
	public function getTotalHistory_reffernal($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".intval($customer_id)."' AND wallet = 'Refferal Commistion'
		");

		return $query -> row;
	}
	public function getTotalHistory_withdraw($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".intval($customer_id)."' AND wallet = 'Widthdraw'
		");

		return $query -> row;
	}
	public function getTransctionHistory_withdraw($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".$this -> db -> escape($id_customer)."' AND wallet = 'Widthdraw' 
			ORDER BY date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}
	public function getTransctionHistory_reffernal($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".$this -> db -> escape($id_customer)."' AND wallet = 'Refferal Commistion' 
			ORDER BY date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}
	public function getTotalHistory_binary($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".intval($customer_id)."' AND wallet LIKE 'Bitcoin%' OR wallet LIKE 'VND%'
		");

		return $query -> row;
	}

	public function getTransctionHistory_binary($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".$this -> db -> escape($id_customer)."' AND wallet LIKE 'Bitcoin%' OR wallet LIKE 'VND%'
			ORDER BY date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}
	public function getTotalHistory_binary_new($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".intval($customer_id)."' AND wallet LIKE 'System Commission'
		");

		return $query -> row;
	}
	public function getTransctionHistory_binary_new($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_transaction_history
			WHERE customer_id = '".$this -> db -> escape($id_customer)."' AND wallet LIKE 'System Commission' 
			ORDER BY date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}
	public function getTransctionHistory($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_history_lottery A INNER JOIN ".DB_PREFIX."customer_invoice_lottery B ON A.invoice_id = B.invoice_id
			WHERE A.customer_id = '".$this -> db -> escape($id_customer)."'
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}

	public function getCustomerCustom($customer_id) {
		$query = $this -> db -> query("SELECT c.username, c.telephone, c.customer_id , ml.level,c.total_pd_node FROM ". DB_PREFIX ."customer AS c
				JOIN ". DB_PREFIX ."customer_ml AS ml
				ON ml.customer_id = c.customer_id
				WHERE c.customer_id = '" . (int)$customer_id . "'");
		return $query -> row;
	}

	public function getCustomerBank($customer_id) {
		$query = $this -> db -> query("SELECT account_holder, bank_name, account_number,branch_bank   FROM ". DB_PREFIX ."customer WHERE customer_id = '" . (int)$customer_id . "'");
		return $query -> row;
	}

	public function editPasswordTransactionCustomForEmail($data, $password) {
		$this -> event -> trigger('pre.customer.edit.password');
		$customer_id = $data['customer_id'];
		$salt = $data['salt'];
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET
			transaction_password = '" . $this -> db -> escape(sha1($salt . sha1($salt . sha1($password)))) . "'
			WHERE customer_id = '" . $this -> db -> escape($customer_id) . "'");

		$this -> event -> trigger('post.customer.edit.password');
	}

	public function getCustomerCustomFormSetting($customer_id) {
		$query = $this -> db -> query("SELECT c.firstname,c.address_cmnd,
			ip.date_added as date_add_login,ip.ip, date(c.date_added) as date_added,c.username, 
			c.telephone , c.email , wl.wallet , ml.level,ct.name as countryname 
			FROM ". DB_PREFIX ."customer AS c
				JOIN ". DB_PREFIX ."customer_ml AS ml 
				ON ml.customer_id = c.customer_id JOIN ". DB_PREFIX ."customer_activity ip ON ip.customer_id = c.customer_id
				JOIN sm_country ct ON ct.country_id = c.country_id JOIN ". DB_PREFIX ."customer_wallet_btc_ wl ON c.customer_id = wl.customer_id
				WHERE c.customer_id = '" . (int)$customer_id . "'");
		return $query -> row;
	}

	public function getUserOff($listIdChild) {
		if ($listIdChild != '') {
			$query = $this -> db -> query("SELECT c.* FROM " . DB_PREFIX . "customer c  WHERE c.customer_id IN (" . $listIdChild . ") AND c.status = 0");
			return $query -> rows;
		}
		return array();
	}

	public function getUserNotHP($listIdChild) {
		if ($listIdChild != '') {
			$date = strtotime(date('Y-m-d'));
			$month = date('m', $date);
			$year = date('Y', $date);
			$arrNotHP = array();
			$query = $this -> db -> query("SELECT c.* FROM " . DB_PREFIX . "customer c  WHERE c.customer_id IN (" . $listIdChild . ") AND c.status = 1");
			$arrUser = $query -> rows;
			foreach ($arrUser as $user) {
				$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "profit WHERE  user_id = " . $user['customer_id'] . " and type_profit = 1 and year = '" . $year . "' AND month = '" . $month . "'");
				if (!$query -> row) {
					array_push($arrNotHP, $user);
				}
			}
			return $arrNotHP;
		} else {
			return array();
		}
	}

	public function getListChild($id_package) {
		$query = $this -> db -> query("SELECT cm.*,c.username,c.telephone,c.status AS status_cus,c.firstname,c.cmnd,CONCAT(c.firstname, ' ', c.lastname) as name_customer,ml.name_vn as package_vn,c.total_pd_node FROM " . DB_PREFIX . "customer_ml cm LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = cm.customer_id) LEFT JOIN " . DB_PREFIX . "member_level ml ON (cm.level = ml.id)  WHERE cm.p_node = '" . (int)$id_package . "'");

		return $query -> rows;
	}

	public function getListChildCustom($id_package) {
		$query = $this -> db -> query("
				SELECT cm.level, c.username, c.telephone , c.customer_id
				FROM ". DB_PREFIX ."customer_ml cm LEFT JOIN ". DB_PREFIX ."customer c ON (c.customer_id = cm.customer_id)
				WHERE cm.p_node = '2'
			");

		return $query -> rows;
	}

	public function getListChildNotPackage($id_user) {
		$id_user = $id_user * (-1);
		$query = $this -> db -> query("SELECT cm.*,c.username,c.firstname,c.cmnd,CONCAT(c.firstname, ' ', c.lastname) as name_customer,ml.name_vn as package_vn FROM " . DB_PREFIX . "customer_ml cm LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = cm.customer_id) LEFT JOIN " . DB_PREFIX . "member_level ml ON (cm.level = ml.id)  WHERE cm.p_node = '" . $id_user . "'");

		return $query -> rows;
	}

	public function getCustomerByEmail($email) {
		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this -> db -> escape(utf8_strtolower($email)) . "'");

		return $query -> row;
	}

	public function getCustomerByUsername($username) {
		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(username) = '" . $this -> db -> escape(utf8_strtolower($username)) . "'");

		return $query -> row;
	}

	public function getCustomerByToken($token) {
		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this -> db -> escape($token) . "' AND token != ''");

		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET token = ''");

		return $query -> row;
	}

	public function getTotalCustomersById($customer_id) {
		$query = $this -> db -> query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

		return $query -> row['total'];
	}

	public function getTotalCustomersByEmail($email) {
		$query = $this -> db -> query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this -> db -> escape(utf8_strtolower($email)) . "'");

		return $query -> row['total'];
	}

	public function getTotalCustomersByTelephone($telephone) {
		$query = $this -> db -> query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(telephone) = REPLACE('" . $this -> db -> escape(utf8_strtolower($telephone)) . "'" . ", ' ', '')");

		return $query -> row['total'];
	}

	public function getIps($customer_id) {
		$query = $this -> db -> query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

		return $query -> rows;
	}

	public function isBanIp($ip) {
		$query = $this -> db -> query("SELECT * FROM `" . DB_PREFIX . "customer_ban_ip` WHERE ip = '" . $this -> db -> escape($ip) . "'");

		return $query -> num_rows;
	}

	public function addLoginAttempt($email) {
		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this -> db -> escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this -> db -> escape($this -> request -> server['REMOTE_ADDR']) . "'");

		if (!$query -> num_rows) {
			$this -> db -> query("INSERT INTO " . DB_PREFIX . "customer_login SET email = '" . $this -> db -> escape(utf8_strtolower((string)$email)) . "', ip = '" . $this -> db -> escape($this -> request -> server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this -> db -> escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this -> db -> escape(date('Y-m-d H:i:s')) . "'");
		} else {
			$this -> db -> query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this -> db -> escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query -> row['customer_login_id'] . "'");
		}
	}

	public function getLoginAttempts($email) {
		$query = $this -> db -> query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this -> db -> escape(utf8_strtolower($email)) . "'");

		return $query -> row;
	}

	public function deleteLoginAttempts($email) {
		$this -> db -> query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this -> db -> escape(utf8_strtolower($email)) . "'");
	}

	public function getPackages($customer_id) {
		$query = $this -> db -> query("SELECT cm.*,ml.name_vn AS package_vn FROM " . DB_PREFIX . "customer_ml cm LEFT JOIN " . DB_PREFIX . "member_level ml ON (cm.level = ml.id) WHERE cm.customer_id = '" . (int)$customer_id . "' ORDER BY cm.date_added");

		return $query -> rows;
	}

	public function getInfoPackages($id_package) {
		$query = $this -> db -> query("SELECT cm.*,ml.name_vn AS package_vn,c.username,c.firstname FROM " . DB_PREFIX . "customer_ml cm LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = cm.customer_id) LEFT JOIN " . DB_PREFIX . "member_level ml ON (cm.level = ml.id) WHERE cm.id_package = '" . (int)$id_package . "'");

		return $query -> row;
	}

	public function getNameParent($customer_id) {
		$query = $this -> db -> query("SELECT c.firstname AS name_parent FROM " . DB_PREFIX . "customer_ml cm LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = cm.customer_id) WHERE cm.customer_id = '" . (int)$customer_id . "'");
		if (isset($query -> row['name_parent'])) {
			return $query -> row['name_parent'];
		} else
			return "";
	}

	public function getMonthRegister($customer_id) {
		$date = strtotime(date('Y-m-d'));
		$yearNow = date('Y', $date);
		$monthNow = date('m', $date);
		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		$rowCus = $query -> row;
		$dateRegis = strtotime($rowCus['date_added']);
		$yearRegis = date('Y', $dateRegis);
		$monthRegis = date('m', $dateRegis);
		$numYear = $yearNow - $yearRegis;
		if ($numYear > 0) {
			$monthNow = $monthNow + (12 * $numYear);
		}
		return $monthNow - $monthRegis;
	}

	public function getAllProfitByType($user_id, $type) {
		$query = $this -> db -> query("SELECT SUM(receive) AS total FROM " . DB_PREFIX . "profit WHERE user_id = '" . (int)$user_id . "' and type_profit in (" . $type . ")");
		return $query -> row['total'];
	}

	public function countProfitByType($user_id, $type) {
		$query = $this -> db -> query("SELECT count(*) AS total FROM " . DB_PREFIX . "profit WHERE user_id = '" . (int)$user_id . "' and type_profit in (" . $type . ")");
		return $query -> row['total'];
	}

	function getBParent($id) {
		$query = $this -> db -> query("select p_binary from " . DB_PREFIX . "customer as u1 INNER join " . DB_PREFIX . "customer_ml AS u2 ON u1.customer_id = u2.customer_id where u1.customer_id = " . (int)$id);
		return $query -> row['p_binary'];
	}

	function getInfoUsers($id_ids) {
		if (!is_array($id_ids))
			$ids = array($id_ids);
		else
			$ids = $id_ids;
		$array_id = "( " . implode(',', $ids) . " )";
		$query = $this -> db -> query("select u.*,mlm.level, l.name_vn as level_member from " . DB_PREFIX . "customer as u Left Join " . DB_PREFIX . "customer_ml as mlm ON mlm.customer_id = u.customer_id  Left Join " . DB_PREFIX . "member_level as l ON l.id = mlm.level  Where u.customer_id IN " . $array_id);
		if (!is_array($id_ids)) {
			$return = $query -> row;
		} else {
			$return = $query -> rows;
		}
		return $return;
	}

	//	lay tong so thanh vien
	function getSumNumberMember($node) {
		$result = 0;
		return $result;
	}

	function getLeftO($id) {
		$query = $this -> db -> query('select u2.email, u2.telephone, u2.date_added, mlm.customer_id as id, mlm.level,CONCAT(u2.firstname," (ĐT: ",u2.telephone,")") as text, CONCAT( "level1"," left") as iconCls,CONCAT(u2.firstname," (ĐT: ",u2.telephone,")") as name,l.name_vn as level_user,u2.username,u2.status,u2.date_added  from ' . DB_PREFIX . 'customer AS u2 LEFT join ' . DB_PREFIX . 'customer_ml AS mlm ON u2.customer_id = mlm.customer_id INNER join ' . DB_PREFIX . 'customer_ml AS u1 ON u1.left = mlm.customer_id left Join ' . DB_PREFIX . 'member_level as l ON l.id = mlm.level where mlm.p_binary = ' . (int)$id);
		//	return json_decode(json_encode($query->row), false);
		return $query -> row;
	}

	function getRightO($id) {
		$query = $this -> db -> query('select u2.email, u2.telephone,u2.date_added, mlm.customer_id as id, mlm.level,CONCAT(u2.firstname," (ĐT: ",u2.telephone,")") as text, CONCAT( "level1"," right") as iconCls,CONCAT(u2.firstname," (ĐT: ",u2.telephone,")") as name,l.name_vn as level_user,u2.username,u2.status,u2.date_added from ' . DB_PREFIX . 'customer AS u2 LEFT join ' . DB_PREFIX . 'customer_ml AS mlm ON u2.customer_id = mlm.customer_id INNER join ' . DB_PREFIX . 'customer_ml AS u1 ON u1.right = mlm.customer_id left Join ' . DB_PREFIX . 'member_level as l ON l.id = mlm.level where mlm.p_binary = ' . (int)$id);
		//return json_decode(json_encode($query->row), false);
		return $query -> row;
	}

	function getLeft($id) {
		$query = $this -> db -> query("select u2.left from " . DB_PREFIX . "customer as u1 
			INNER JOIN " . DB_PREFIX . "customer_ml AS u2 ON u1.customer_id = u2.customer_id 
			where u1.customer_id = " . (int)$id);
		return null;
	}

	function getRight($id) {
		$query = $this -> db -> query("select u2.right from " . DB_PREFIX . "customer as u1 INNER JOIN " . DB_PREFIX . "customer_ml AS u2 ON u1.customer_id = u2.customer_id where u1.customer_id = " . (int)$id);
		return null;
	}

	function getSumLeft($id) {
		$result = 0;
		$left = $this -> getLeft($id);
		if ($left) {
			$result += 1;
			$result += $this -> getSumMember($left);
		}
		return $result;
	}

	//Get sum right node binarytree
	function getSumRight($id) {
		$result = 0;
		$right = $this -> getRight($id);
		if ($right) {
			$result += 1;
			$result += $this -> getSumMember($right);
		}
		return $result;
	}

	//Get sum left node and right node for any node bynary
	function getSumMember($id) {

		$result = 0;
		$left = $this -> getLeft($id);
		$right = $this -> getRight($id);
		if ($left) {
			$result += 1;
			$result += $this -> getSumMember($left);
		}
		if ($right) {
			$result += 1;
			$result += $this -> getSumMember($right);
		}

		//print_r($result);
		return $result;
	}

	function getSumFloor($arrId) {
		$floor = 0;
		$query = $this -> db -> query("select mlm.customer_id from " . DB_PREFIX . "customer as u Left Join " . DB_PREFIX . "customer_ml as mlm ON mlm.customer_id = u.customer_id  Where mlm.p_binary IN (" . $arrId . ")");
		$arrChild = $query -> rows;

		if (!empty($arrChild)) {
			$floor += 1;
			$arrId = '';
			foreach ($arrChild as $child) {
				$arrId .= ',' . $child['customer_id'];
			}
			$arrId = substr($arrId, 1);
			$floor += $this -> getSumFloor($arrId);
		}
		return $floor;
	}



	function checkActiveUser($id_user = 0) {
		$query = $this -> db -> query("select u1.status from " . DB_PREFIX . "customer as u1 where u1.customer_id = " . (int)$id_user);
		return $query -> row['status'];
	}

	function getCountTreeCustom($id_user) {
		$listId = 0;
		$query = $this -> db -> query("select customer_id from " . DB_PREFIX . "customer_ml where p_node = " . (int)$id_user);
		$array_id = $query -> rows;
		foreach ($array_id as $item) {
			$listId ++;
			$listId = $listId + $this -> getCountTreeCustom($item['customer_id']);
		}
		return $listId;
	}

	function getCountBinaryTreeCustom($id_user) {
		$listId =0 ;
		$query = $this -> db -> query("select customer_id from " . DB_PREFIX . "customer_ml where p_binary = " . (int)$id_user);
		$array_id = $query -> rows;
		foreach ($array_id as $item) {
			$listId ++;
			$listId = $listId + $this -> getCountBinaryTreeCustom($item['customer_id']);
		}
		return $listId;
	}


	function getCount_ID_BinaryTreeCustom($id_user) {
		$listId = '';
		$query = $this -> db -> query("select customer_id from " . DB_PREFIX . "customer_ml where p_binary = " . (int)$id_user);
		$array_id = $query -> rows;
		foreach ($array_id as $item) {
			$listId .= ','.$item['customer_id'];
			$listId .= $this -> getCount_ID_BinaryTreeCustom($item['customer_id']);
		}
		return $listId;
	}



	function getCountLevelCustom($id_user, $level) {
		$listId = 0;

		$query = $this -> db -> query("select customer_id , level from " . DB_PREFIX . "customer_ml where p_node = " . (int)$id_user);
		$array_id = $query -> rows;

		foreach ($array_id as $item) {
			intval($item['level']) === intval($level) && $listId ++;
			$listId = $listId + $this -> getCountLevelCustom($item['customer_id'], $level);
		}
		return $listId;
	}

	function getListIdChild($id_user) {
		$listId = '';
		$query = $this -> db -> query("select customer_id from " . DB_PREFIX . "customer_ml 
			where p_binary = " . (int)$id_user);
		$array_id = $query -> rows;

		foreach ($array_id as $item) {
			$listId .= ',' . $item['customer_id'];
			$listId .= $this -> getListIdChild($item['customer_id']);
		}
		return $listId;
	}

	
	

	public function getLanguage($customer_id){
		$query = $this -> db -> query("
			SELECT language 
			FROM ". DB_PREFIX . "customer
			WHERE customer_id = ".$customer_id."
		");
		return $query -> row['language'];
	}

	public function updateLanguage($customer_id, $language){
		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "customer SET
			language = '".$language."'
			WHERE customer_id = ".$customer_id."			
		");
		return $query;
	}

	public function u_infomation_shop($data)
	{
		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "shop SET
			lat = '".$data['lat']."',
			lng = '".$data['lng']."',
			name = '".$data['name']."',
			logo = '".$data['logo']."',
			address = '".$data['address']."',
			description = '".$data['description']."',
			category_shop = '".$data['type_shop']."'
			WHERE customer_id = ".$this -> session -> data['customer_id']."		
		");
		return $query;
	}

	public function get_category_all()
	{
		$category_data = array();
			$sql = "SELECT sc.simple_blog_category_id,sc.parent_id,scd.name as title FROM `" . DB_PREFIX . "simple_blog_category` sc LEFT JOIN `" . DB_PREFIX . "simple_blog_category_description` scd ON (sc.simple_blog_category_id = scd.simple_blog_category_id) WHERE scd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			$query = $this->db->query($sql);
		return $query->rows;
	}
	public function get_shop_customer($customer_id)
	{
		$query = $this -> db -> query("
			SELECT * 
			FROM ". DB_PREFIX . "shop
			WHERE customer_id = '".$customer_id."'
		");
		return $query -> row;
	}
	public function get_shop_id($id)
	{
		$query = $this -> db -> query("
			SELECT logo as images, description,name as title, lat, lng, address, id 
			FROM ". DB_PREFIX . "shop
			WHERE id = '".$id."'
		");
		return $query -> row;
	}
	public function i_product_customer($data,$customer_id)
	{
		$query = $this -> db -> query("
			INSERT INTO ". DB_PREFIX . "product SET
			customer_id = '".$customer_id."',
			shop_id = '".$customer_id."',
			name_product = '".$data['name_product']."',
			price_gdg = '".str_replace(",",".",$data['input_giasp_gdg'])."',
			price_btc = '".str_replace(",",".",$data['input_giasp_btc'])."',
			category = '".$data['input_danhmuc']."',
			descript_ngan = '".htmlspecialchars_decode($data['descript_ngan'])."',
			description = '".htmlspecialchars_decode($data['description'])."',
			date_added = NOW()
		");
		$id_product = $this -> db -> getLastId();
		
		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "product SET
			alias = '".$this -> gen_slug($data['name_product'])."-".$id_product."'
			WHERE product_id = '".$id_product."'
		");

		$query = $this -> db -> query("
			INSERT INTO ". DB_PREFIX . "url_alias SET
			query = 'account/product/product_details/id=".$id_product."',
			keyword = '".$this -> gen_slug($data['name_product'])."-".$id_product."'
		");

		foreach ($data['image'] as $value) {
			$query = $this -> db -> query("
				INSERT INTO ". DB_PREFIX . "product_image SET
				customer_id = '".$customer_id."',
				product_id = '".$id_product."',
				image = '".$value."',
				date_added = NOW()
			");
		}
	}

	public function gen_slug($str){
	   	
	    $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
	    $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
	    return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
	}
	public function getTotalproduct_shop($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."product
			WHERE customer_id = '".intval($customer_id)."'
		");

		return $query -> row;
	}
	public function getproductshop($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."product
			WHERE customer_id = '".$this -> db -> escape($id_customer)."' 
			ORDER BY date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}
	public function get_images_product($product_id)
	{
		$query = $this -> db -> query("
			SELECT *
			FROM ".DB_PREFIX."product_image
			WHERE product_id = '".intval($product_id)."' ORDER BY date_added DESC
		");
		return $query -> row;
	}

	public function get_images_products($product_id)
	{
		$query = $this -> db -> query("
			SELECT *
			FROM ".DB_PREFIX."product_image
			WHERE product_id = '".intval($product_id)."' ORDER BY date_added DESC
		");
		return $query -> rows;
	}


	public function get_product_id($product_id)
	{
		$query = $this -> db -> query("
			SELECT A.*,B.username,B.email,B.telephone,B.customer_code,B.wallet,B.username_gdg,B.address_cus
			FROM ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id
			WHERE product_id = '".intval($product_id)."'
		");
		return $query -> row;
	}

	public function u_product_customer($data,$customer_id,$product_id)
	{
		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "product SET
			customer_id = '".$customer_id."',
			name_product = '".$data['name_product']."',
			price_gdg = '".str_replace(",",".",$data['input_giasp_gdg'])."',
			price_btc = '".str_replace(",",".",$data['input_giasp_btc'])."',
			category = '".$data['input_danhmuc']."',
			descript_ngan = '".htmlspecialchars_decode($data['descript_ngan'])."',
			description = '".htmlspecialchars_decode($data['description'])."',
			date_modified = NOW()
			WHERE product_id = '".$product_id."'
		");
			
		$querys = $this -> db -> query("
			SELECT alias
			FROM ".DB_PREFIX."product
			WHERE product_id = '".intval($product_id)."'
		");
		$url_alias_id =  $querys -> row['alias'];
		
		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "product SET
			alias = '".$this -> gen_slug($data['name_product'])."-".$product_id."'
			WHERE product_id = '".$product_id."'
		");

		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "url_alias SET
			query = 'account/product/product_details/id=".$product_id."',
			keyword = '".$this -> gen_slug($data['name_product'])."-".$product_id."'
			WHERE keyword = '".$url_alias_id."'
		");

		$query = $this -> db -> query("
			DELETE FROM ". DB_PREFIX . "product_image WHERE
			product_id = '".$product_id."'
		");
		

		foreach ($data['image'] as $value) {
			$query = $this -> db -> query("
				INSERT INTO ". DB_PREFIX . "product_image SET
				customer_id = '".$customer_id."',
				product_id = '".$product_id."',
				image = '".$value."',
				date_added = NOW()
			");
		}
	}

	public function de_product_customer($customer_id,$product_id)
	{
		$query = $this -> db -> query("
			DELETE FROM ". DB_PREFIX . "product
			WHERE product_id = '".$product_id."' AND customer_id = '".$customer_id."'
		");
		
		$query = $this -> db -> query("
			DELETE FROM ". DB_PREFIX . "product_image WHERE
			product_id = '".$product_id."' AND customer_id = '".$customer_id."'
		");
	}

	public function get_shop_all()
	{
		$query = $this -> db -> query("
			SELECT logo as images, description,name as title, lat, lng, address, id
			FROM ". DB_PREFIX . "shop
		");
		return $query -> rows;
	}

	public function getproductshop_dashboard($limit, $offset){
		$query = $this -> db -> query("
			SELECT A.*,B.*,C.username,C.customer_code
			FROM  ".DB_PREFIX."shop A INNER JOIN ".DB_PREFIX."category B ON A.category_shop = B.category_id INNER JOIN ".DB_PREFIX."customer C ON A.customer_id = C.customer_id
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}

	public function getproduct_all($limit, $offset){
		$query = $this -> db -> query("
			SELECT A.*,B.username
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		return $query -> rows;
	}
	public function getproduct_all_category($limit, $offset,$category){
		$query = $this -> db -> query("
			SELECT A.*,B.username
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id WHERE category IN (".$category.")
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		return $query -> rows;
	}

	public function getproduct_all_namesearch($limit, $offset,$name_search){
		$query = $this -> db -> query("
			SELECT A.*,B.username
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id WHERE name_product LIKE '%".$name_search."%'
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		return $query -> rows;
	}

	public function i_comment_product($customer_id,$product_id,$rating,$comment){
		$query = $this -> db -> query("
			INSERT INTO ". DB_PREFIX . "comment_product SET
			customer_id = '".$customer_id."',
			product_id = '".$product_id."',
			rating = '".$rating."',
			comment = '".$comment."',
			date_added = NOW()
		");
	}
	public function set_rating_product_id($product_id){
		$query = $this -> db -> query("
			SELECT AVG(rating) as tbc_rating
			FROM  ".DB_PREFIX."comment_product A
			WHERE product_id = '".$product_id."'
		");
		$tbc_rating = round($query -> row['tbc_rating'],1);

		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "product SET
			rating = '".$tbc_rating."'
			WHERE product_id = '".$product_id."'
		");
	}

	public function get_rating_product_id($product_id){
		$query = $this -> db -> query("
			SELECT A.*,B.username 
			FROM  ".DB_PREFIX."comment_product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id
			WHERE A.product_id = '".$product_id."' ORDER BY A.date_added DESC
		");
		return $query -> rows;
	}

	public function get_category_customer($customer_id){
		$query = $this -> db -> query("
			SELECT B.title,B.category_id
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."category B ON A.category = B.category_id
			GROUP BY B.title
		");
		return $query -> rows;
	}
	
	public function get_product_category($category_id){
		$query = $this -> db -> query("
			SELECT A.*,B.username
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id
			
			WHERE A.category = '".$category_id."' ORDER BY A.date_added DESC
		");
		return $query -> rows;
	}
	public function get_rating_product_customer_id($customer_id){
		$query = $this -> db -> query("
			SELECT  AVG(rating) as tbc_rating FROM ". DB_PREFIX . "product 
			WHERE customer_id = '".$customer_id."'
		");
		return $query -> row;
	}

	public function getCategories($parent_id = 0) {
		$category_data = array();
		$sql = "SELECT sc.simple_blog_category_id,sc.parent_id,scd.name FROM `" . DB_PREFIX . "simple_blog_category` sc LEFT JOIN `" . DB_PREFIX . "simple_blog_category_description` scd ON (sc.simple_blog_category_id = scd.simple_blog_category_id) WHERE sc.parent_id = '" . (int)$parent_id . "' AND scd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function count_product($category_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."product
			WHERE category IN (".$category_id.")
		");
		return $query -> row['number'];
	}
	
	public function breadcrumb($child) {
		$category_data = array();
		$sql = "SELECT sc.simple_blog_category_id,sc.parent_id,scd.name FROM `" . DB_PREFIX . "simple_blog_category` sc LEFT JOIN `" . DB_PREFIX . "simple_blog_category_description` scd ON (sc.simple_blog_category_id = scd.simple_blog_category_id) WHERE sc.simple_blog_category_id = '" . (int)$child . "' AND scd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getproduct_desc(){
		$query = $this -> db -> query("
			SELECT A.*,B.username
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id
			ORDER BY RAND()
			LIMIT 1
		");
		return $query -> row;
	}

	public function add_product_wishlist($product_id)
	{
		$query = $this -> db -> query(" 
			INSERT INTO  ".DB_PREFIX."product_wishlist SET
			customer_id = '".$this -> session -> data['customer_id']."',
			product_id = '".$product_id."',
			date_added = NOW()
		");
		return $query;
	}
	public function check_product_wishlist($product_id)
	{
		$query = $this -> db -> query(" 
			SELECT count(*) as number FROM  ".DB_PREFIX."product_wishlist WHERE
			customer_id = '".$this -> session -> data['customer_id']."' AND
			product_id = '".$product_id."'
		");
		return $query->row['number'];
	}

	public function add_order_payemnt($data,$customer_buy,$customer_sell,$qty,$total,$product_id,$payment_code){
		$query = $this -> db -> query("
			INSERT INTO ". DB_PREFIX . "order SET
			customer_buy = '".$customer_buy."',
			customer_sell = '".$customer_sell."',
			firstname = '" . $this -> db -> escape($data['first_name']) . "',
			email = '" . $this -> db -> escape($data['email']) . "',
			telephone = '" . $this -> db -> escape($data['telephone']) . "',
			product_id = '" . $this -> db -> escape($product_id) . "',
			qty = '" . $this -> db -> escape($qty) . "',
			total = '" . $this -> db -> escape($total) . "',
			address_payment = '" . $this -> db -> escape($data['address']) . "',
			payment = '" . $this -> db -> escape($data['payment']) . "',
			ghichu = '" . $this -> db -> escape($data['ghichu']) . "',
			ip = '".$_SERVER['REMOTE_ADDR']."',
			date_added = NOW()
		");
		$id = $this->db->getLastId();
		if (!$payment_code)
		{

			$payment_code = hexdec(crc32($id)).rand();
			
		}
		$query = $this -> db -> query("
		UPDATE " . DB_PREFIX . "order SET 
			payment_code = '".$payment_code."'
			WHERE order_id = '".$id."'
		");
		return $payment_code;
	}
	public function get_order_code($code)
	{
		$query = $this -> db -> query("
			SELECT * FROM " . DB_PREFIX . "order 
				WHERE payment_code = '".$code."'
			");
		return $query->rows;
	}


	public function update_profile($data)
	{
		$query = $this -> db -> query("
			UPDATE  ".DB_PREFIX."customer SET 
			date_birth = '".$data['date_birth']."',
			email = '".$data['email']."',
			telephone = '".$data['telephone']."',
			male = '".$data['male']."',
			address_cus = '".$data['address_cus']."',
			wallet = '".$data['wallet']."',
			username_gdg = '".$data['username_gdg']."'
			WHERE customer_id = '".$this -> session -> data['customer_id']."'
		");
	} 

	public function update_avatar($link)
	{
		$query = $this -> db -> query("
			UPDATE  ".DB_PREFIX."customer SET 
			img_profile = '".$link."'
			WHERE customer_id = '".$this -> session -> data['customer_id']."'
		");
	} 

	public function getTotalorder_sell($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."order
			WHERE customer_sell = '".intval($customer_id)."'
		");

		return $query -> row;
	}
	public function getproductorder_sell($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."order A INNER JOIN ".DB_PREFIX."product B ON A.product_id = B.product_id
			WHERE A.customer_sell = '".intval($id_customer)."'
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}

	public function getTotalorder_buy($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."order
			WHERE customer_buy = '".intval($customer_id)."'
		");

		return $query -> row;
	}
	public function getproductorder_buy($id_customer, $limit, $offset){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."order A INNER JOIN ".DB_PREFIX."product B ON A.product_id = B.product_id
			WHERE A.customer_buy = '".intval($id_customer)."'
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		
		return $query -> rows;
	}

	public function getproduct_price_gdg($limit, $offset,$price_min_gdg,$price_max_gdg){
		$query = $this -> db -> query("
			SELECT A.*,B.username
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id WHERE A.price_gdg >= '".$price_min_gdg."' AND A.price_gdg <= '".$price_max_gdg."'
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		return $query -> rows;
	}

	public function getproduct_price_btc($limit, $offset,$price_min_btc,$price_max_btc){
		$query = $this -> db -> query("
			SELECT A.*,B.username
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id WHERE A.price_btc >= '".$price_min_btc."' AND A.price_btc <= '".$price_max_btc."'
			ORDER BY A.date_added DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		return $query -> rows;
	}

	public function getproduct_sort_order($limit, $offset,$sort_order){
		$query_q = "
			SELECT A.*,B.username
			FROM  ".DB_PREFIX."product A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id ";
		if ($sort_order == "datestart_asc")
		{
			$query_q = $query_q. " ORDER BY A.date_added ASC ";
		}
		if ($sort_order == "datestart_desc")
		{
			$query_q = $query_q. " ORDER BY A.date_added DESC ";
		}
		if ($sort_order == "price_desc")
		{
			$query_q = $query_q. " ORDER BY A.price_gdg DESC ";
		}

		if ($sort_order == "price_asc")
		{
			$query_q = $query_q. " ORDER BY A.price_gdg ASC ";
		}
		$query_q = $query_q." LIMIT ".$limit." ".
			" OFFSET ".$offset." ";
		$query = $this -> db -> query($query_q);
		return $query -> rows;
	}

}
