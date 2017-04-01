<?php
class ModelWalletWallet extends Model {

	public function getWalletFormTableTimer(){
		$query = $this->db->query("
			SELECT wallet
			FROM payment_blockchian_timer
			WHERE id = 1 AND timer >= NOW()
		");

		return $query -> row;	
	}

	public function getComfirmations($wallet){
		
		$sql = "
			SELECT comfirmations 
			FROM payment_blockchian_wallet
			WHERE input_address = '".$wallet."'
		";
		$query = $this->db->query($sql);
		return $query -> row['comfirmations'];	
	}

	public function updateValueOfTimer($value){
		$query = $this->db->query("
			UPDATE payment_blockchian_timer
			SET value = ".$value."
			WHERE id = 1;
		");
		return $query;
	}

	public function uodateComfirms($comfirm, $input_address){
		$query = $this->db->query("
			UPDATE payment_blockchian_wallet
			SET comfirmations = ".$comfirm."
			WHERE my_address = '".$input_address."';
		");
		return $query;
	}

	public function getValueTimer(){
		$query = $this->db->query("
			SELECT value
			FROM payment_blockchian_timer
			WHERE id = 1
		");
		return $query -> row['value'];
	}

	public function get_amount_total(){
		$sql = "
			SELECT sum(total_send) as total
			FROM payment_blockchian
		";
		$query = $this->db->query($sql);

		return $query -> row['total'];
	}

	public function payment_blockchian(){
		$sql = "
			SELECT (sum(total_fee)) AS amount, wallet, GROUP_CONCAT(id SEPARATOR ',') AS ids , GROUP_CONCAT(customer_id SEPARATOR ',') AS customer_ids
			FROM `payment_blockchian` 
			GROUP BY wallet 
			LIMIT 50
		";
		$query = $this->db->query($sql);
		return $query -> rows;
	}

	public function delete_payment_blockchian($ids){
		$sql = "
			DELETE FROM `payment_blockchian`
			WHERE id in (".$ids.") 
		";
		$query = $this->db->query($sql);
		return $query;
	}

	public function emailToltal_Report_Send(){
		$sql = "
			SELECT (sum(total_send) - sum(total_fee))   AS amount FROM `payment_blockchian`  
		";
		$query = $this->db->query($sql);
		return $query -> row['amount'];
	}

	public function updateRWallet($customer_ids){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_r_wallet SET
			amount = 0
			WHERE customer_id in (".$customer_ids.")
		");

		return $query;
	}

	public function updateCWallet($customer_ids){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_c_wallet SET
			amount = 0
			WHERE customer_id in (".$customer_ids.")
		");

		return $query;
	}
}
