<?php
class ModelAccountAuto extends Model {


	public function getAllCustomer_Binary(){
		$query = $this -> db -> query("
			SELECT c.customer_id AS customer_id, c.total_pd_left , c.total_pd_right FROM ". DB_PREFIX . "customer c
			JOIN ". DB_PREFIX ."customer_ml AS c_ml
				ON c.customer_id = c_ml.customer_id 
			WHERE c_ml.level = 2 AND c.total_pd_left > 0 AND c.total_pd_right > 0
		");
		return $query -> rows;
	}
	public function get_pass(){
		$query = $this -> db -> query("SELECT customer_id, email, date_added, password FROM sm_customer");
		return $query->rows;
	}
	public function update_password($customer_id, $pass, $id, $email){

		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "customer
			SET password = '" . $this -> db -> escape(sha1($email. sha1($customer_id . sha1($id . sha1($pass))))) . "',
			salt = '" . $this -> db -> escape(sha1($customer_id . sha1($id . sha1($pass)))) . "'
			WHERE customer_id = ".$customer_id."
		");
		return $query;
	}
	public function update_Left_Count($customer_id){

		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "customer
			SET total_pd_left = total_pd_left - total_pd_right,
				total_pd_right = total_pd_right - total_pd_right
			WHERE customer_id = ".$customer_id."
		");
		return $query;
	}

	public function update_Right_Count($customer_id){

		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "customer
			SET total_pd_right = total_pd_right - total_pd_left,
				total_pd_left = total_pd_left - total_pd_left
			WHERE customer_id = ".$customer_id."
		");
		return $query;
	}

	public function delete_pd_no_send_btc(){
		$query = $this -> db -> query("
			DELETE FROM ". DB_PREFIX . "customer_provide_donation
			WHERE date_finish_forAdmin <= NOW() AND status = 0
		");
		return $query;
	}

	public function get_wallet_static(){
		$query = $this -> db -> query("
			SELECT customer_id
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE status = 1
		");

		return $query -> rows;
	}

	public function getMaxPd($customer_id){
		$query = $this -> db -> query("
			SELECT MAX(filled) AS pd_max FROM ". DB_PREFIX . "customer_provide_donation
			WHERE customer_id = ".$customer_id."
		");
		return $query -> row;
	}

	public function createGDInventory($amount, $customer_id){
		$this -> db -> query("
			INSERT INTO ". DB_PREFIX . "customer_get_donation SET 
			customer_id = '".$customer_id."',
			date_added = DATE_ADD(NOW(),INTERVAL -10 DAY),
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
		if($query){
			$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer SET 
				date_added = NOW()
				WHERE customer_id = '".$customer_id."'
			");
		}
		$data['query'] = $query ? true : false;
		$data['gd_number'] = $gd_number;
		return $data;
	}

	public function createPDInventory($filled, $customer_id){
		$this -> db -> query("
			INSERT INTO ". DB_PREFIX . "customer_provide_donation SET 
			customer_id = '".$customer_id."',
			date_added = DATE_ADD(NOW(),INTERVAL -11 DAY),
			filled = '".$filled."',
			amount = 0,
			status = 0
		");
		$amount	= $filled;
		if ($amount == 6000000):
			$max_profit= 8000000;								
		elseif ($amount == 12000000):
			$max_profit= 16000000;		
		else:
			$max_profit= 32000000;		
		endif;	

		$gd_id = $this->db->getLastId();
		
		$gd_number = hexdec(crc32($gd_id));

		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET 
				pd_number = '".$gd_number."',
				max_profit = '".$amount."'
				WHERE id = '".$gd_id."'
			");
		if($query){
			$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer SET 
				date_added = NOW()
				
				WHERE customer_id = '".$customer_id."'
			");
		}
		$data['query'] = $query ? true : false;
		$data['gd_number'] = $gd_number;
		return $data;
	}
	public function createPD($amount, $customer_id){
		$this -> db -> query("
			INSERT INTO ". DB_PREFIX . "customer_provide_donation SET 
			customer_id = '".$customer_id."',
			date_added = NOW(),
			filled = '".$amount."',
			date_finish = DATE_ADD(NOW(),INTERVAL +20 DAY),
			date_finish_forAdmin = DATE_ADD(NOW(),INTERVAL +1 DAY),
			status = 1
		");
		//update max_profit and pd_number
		$pd_id = $this->db->getLastId();

		//$max_profit = (float)($amount * $this->config->get('config_pd_profit')) / 100;
		$max_profit = 0;
		$pd_number = hexdec( crc32($pd_id) );
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET 
				max_profit = '".$max_profit."',
				pd_number = '".$pd_number."'
				WHERE id = '".$pd_id."'
			");
		$data['query'] = $query ? true : false;
		$data['pd_number'] = $pd_number;
		$data['pd_id'] = $pd_id;
		return $data;
	}

	

	public function getGD7Before(){
	
		$query = $this -> db -> query("
			SELECT id , customer_id, amount , filled
			FROM ". DB_PREFIX . "customer_get_donation 
			WHERE date_added <= DATE_ADD(NOW(), INTERVAL - ".(int)$this -> config -> get('config_date_gd')." DAY)
				  AND status = 0
			ORDER BY date_added ASC
			LIMIT 1
		");
		return $query -> row;
	}
	public function get_all_gd(){
		$query = $this -> db -> query("
			SELECT c.username, c.wallet,gd.customer_id, amount , gd.filled
			FROM ". DB_PREFIX . "customer_get_donation gd JOIN ". DB_PREFIX . "customer c
			ON gd.customer_id = c.customer_id
			WHERE gd.status = 0
			ORDER BY gd.date_added ASC
		");
		return $query -> rows;
	}

	public function getPDAmount($iod_customer){
		$query = $this -> db -> query("
			SELECT amount
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE customer_id = '".$this->db->escape($iod_customer)."'
		");
		return $query -> row;
	}

	public function getPD7Before(){
		$query = $this -> db -> query("
			SELECT id , customer_id , amount , filled
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE date_added <= DATE_ADD( NOW() , INTERVAL - ".(int)$this -> config -> get('config_date_pd')."
			DAY ) 
			AND STATUS =0
			ORDER BY date_added ASC 
			LIMIT 1
		");
		return $query -> row;
	}

	public function getCustomerInventory(){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer
			WHERE status = 9
			ORDER BY date_added ASC 
			LIMIT 1
		");
		return $query -> row;
	}

	public function getCustomerALLInventory(){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer
			WHERE status = 9
		");
		return $query -> rows;
	}
	public function getUser(){
		$query = $this -> db -> query("
			SELECT * 
			FROM ". DB_PREFIX . "customer_tmp
		");
		return $query -> rows;
	}

	public function updateStatusPD($pd_id , $status){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			status = '".$status."' 
			WHERE id = '".$pd_id."'
		");
	}
	public function update_date_finish_rp($pd_id){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			date_finish = NOW()
			WHERE id = '".$pd_id."'
		");
	}
	public function updateCycleAdd($pd_id){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			cycle = cycle + 1 
			WHERE id = '".$pd_id."'
		");
	}
	public function updateCycleAddCustomer($pd_id){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET 
			cycle = cycle + 1 
			WHERE customer_id = '".$pd_id."'
		");
	}
	public function ResetCycleAddCustomer($pd_id){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET 
			cycle = 1 
			WHERE customer_id = '".$pd_id."'
		");
	}
	
	public function updateFilledPD($pd_id , $amount, $profit){
		
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			filled = '".$amount."',
			date_added = NOW(),
			date_finish = DATE_ADD(NOW(),INTERVAL +20 DAY),
			date_finish_forAdmin = DATE_ADD(NOW(),INTERVAL +1 DAY),
			status = 1,
			max_profit = '".$profit."',
			date_update_profit = DATE_ADD(NOW(),INTERVAL + 1 DAY)
			WHERE id = '".$pd_id."'
		");
	}

	public function updateAmountPD($pd_id , $amount){
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			amount = amount + ".$amount." 
			WHERE id = '".$pd_id."'
		");
	}

	public function updateFilledGD($gd_id , $filled){
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_get_donation SET 
			filled = filled + '".$filled."' 
			WHERE id = '".$gd_id."'
		");
	}

	public function updateStatusGD($gd_id , $status){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer_get_donation SET 
			status = '".$status."'
			WHERE id = '".$gd_id."'
		");
	}

	public function createTransferList($data){
		$this -> db -> query("
			INSERT INTO ". DB_PREFIX . "customer_transfer_list SET 
			pd_id = '".$data["pd_id"]."',
			gd_id = '".$data["gd_id"]."',
			pd_id_customer = '".$data["pd_id_customer"]."',
			gd_id_customer = '".$data["gd_id_customer"]."',
			transfer_code = '".hexdec( crc32($data["gd_id"]) )."',
			date_added = NOW(),
			date_finish = DATE_ADD(NOW() , INTERVAL +1 DAY),
			amount = '".$data["amount"]."',
			pd_satatus = 0,
			gd_status = 0
		");
	}
	public function getAllPD(){
		$query = $this -> db -> query("
			SELECT ctl.* , c.p_node, pd.check_R_Wallet as checkRWallet, pd.filled, pd.max_profit as max, pd.status as pdstatus, pd.pd_number as pd_number
			FROM ". DB_PREFIX . "customer_provide_donation AS pd
			JOIN ". DB_PREFIX ."customer_transfer_list AS ctl
				ON ctl.pd_id = pd.id
			JOIN ". DB_PREFIX ."customer AS c
				ON c.customer_id = pd.customer_id
			WHERE ctl.date_finish <=  DATE_ADD(NOW() , INTERVAL  +2 HOUR) AND pd.status <> 3
		");
		
		return $query -> rows;
	}
	public function getCusIdByPdID($pd_id){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_transfer_list
			WHERE pd_id = '".$this -> db -> escape($pd_id)."'
		");
		return $query -> row;
	}
	
	public function updatePDcheck_R_Wallet($pd_id){
		$query = $this -> db -> query("
		UPDATE " . DB_PREFIX . "customer_provide_donation SET
			check_R_Wallet = 0
			WHERE id = '".$pd_id."'
		");
		return $query === true ? true : false;
	}
	public function update_R_Wallet($amount , $customer_id){
		
		$query = $this -> db -> query("
		UPDATE " . DB_PREFIX . "customer_r_wallet SET
			amount = amount + ".intval($amount)."
			WHERE customer_id = '".$customer_id."'
		");

		return $query === true ? true : false;
	}
	public function update_C_Wallet($amount , $customer_id){
		$query = $this -> db -> query("
		UPDATE " . DB_PREFIX . "customer_c_wallet SET
			amount = amount + ".intval($amount)."
			WHERE customer_id = '".$customer_id."'
		");
	}

	public function updateStatusCustomer($customer_id){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer SET
			status = 8 WHERE customer_id = '".$customer_id."'
		");
	}
	public function updateStatusPDTransferList($transferID){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_transfer_list SET
				pd_satatus = 2,
				gd_status = 2				
				WHERE id = '".$this->db->escape($transferID)."'
		");
		return $query;
	}
	

	public function updateR_walletFormPD(){
		$query = $this -> db -> query("
			SELECT SUM( max_profit ) AS amount, customer_id
			FROM  `sm_customer_provide_donation` 
			GROUP BY customer_id		
		");
		return $query -> rows;
	}

	public function fnUpdateR($customer_id, $amount){
		$query  = "
			UPDATE " . DB_PREFIX . "customer_r_wallet 
			SET amount = ".$amount."
			WHERE customer_id = ".$customer_id."
		";
		$query = $this -> db -> query($query);
		return $query;
	}

	
	public function getPD20Before(){
	
		$query = $this -> db -> query("
			SELECT id , customer_id , amount , filled,pd_number, cycle
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE date_finish >=  NOW() AND date_update_profit <= NOW()
			AND STATUS = 1	and check_withdrawal = 0		
		");
		return $query -> rows;
	}
	public function updateMaxProfitPD($pd_id , $amount){
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			max_profit = max_profit + ".$amount.",
			date_update_profit = DATE_ADD(NOW(),INTERVAL + 1 DAY)
			WHERE id = '".$pd_id."'
		");
	}
	public function ResetMaxProfitPD($pd_id){
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			max_profit = 0
			WHERE id = '".$pd_id."'
		");
	}

	public function getDayFnPD(){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE date_finish <=  NOW() AND status = 1 AND check_withdrawal = 0
		");
		
		return $query -> rows;
	}
	public function getDayCreatePD(){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE date_finish <= DATE_ADD(NOW(),INTERVAL - 1 DAY) AND status = 2 AND check_withdrawal = 0
		");
		
		return $query -> rows;
	}
	public function getcheckWithdrawalRwallet($customer_id){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer_r_wallet
			WHERE customer_id = '".$customer_id."'
		");
		return $query -> row;
	}
	public function Reset_R_Wallet($customer_id,$amount){
		
		$query = $this -> db -> query("
		UPDATE " . DB_PREFIX . "customer_r_wallet SET
			amount = amount - ".intval($amount)."
			WHERE customer_id = '".$customer_id."'
		");

		return $query === true ? true : false;
	}
	public function auto_find_pd_update_status_report(){
		$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "customer_provide_donation SET
			status = 3,
			date_added = DATE_ADD(NOW(),INTERVAL -15 DAY),
			date_finish = NOW()
			WHERE date_finish_forAdmin <= NOW() 
				  AND STATUS =0
		");
	}
	public function getM_Wallet(){
		$query = $this -> db -> query("
			SELECT *
			FROM  ".DB_PREFIX."customer_m_wallet
			WHERE date <= NOW() and amount > 0
		");
		return $query -> rows;
	}
	public function update_M_Wallet($amount , $customer_id, $add = false){
		if(!$add){
			$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_m_wallet SET
				amount = amount - ".intval($amount)."
				WHERE customer_id = '".$customer_id."'
			");
			return $query === true ? true : false;
		}
		
	}
	public function get_tbl_payment_blockchain() {
		$query = $this->db->query("SELECT c.username, p.* FROM ".DB_PREFIX."customer_payment_blockhain p JOIN " . DB_PREFIX . "customer c
			ON p.customer_id = c.customer_id WHERE amount > 0");
		return $query->rows;
	}


	public function getPayMent(){
		$query = $this->db->query("
			SELECT ((amount - 30000 )/ 100000000) AS amount, addres_wallet, customer_id 
			FROM sm_customer_r_wallet_payment 
			WHERE date_end >= NOW()
		");
		return $query->rows;
	}

	public function getPayMentGroup(){
		$query = $this->db->query("
			SELECT  SUM((amount - 30000 )/ 100000000) AS amount, addres_wallet, customer_id 
			FROM sm_customer_r_wallet_payment 
			WHERE date_end >= NOW()
			GROUP BY(addres_wallet) 
		");
		return $query->rows;
	}
}