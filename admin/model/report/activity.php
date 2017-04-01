<?php
class ModelReportActivity extends Model {
	public function getTotalCustomers() {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	public function getTotalProvide($status) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_provide_donation WHERE status = '" . (int)$status . "'");
		return $query->row['total'];
	}
	public function getTotalStatusProvide($status, $customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_provide_donation WHERE status = '" . (int)$status . "' AND customer_id = '".(int)$customer_id."'");
		return $query->row['total'];
	}
	
	public function getAllProfitByType($type) {
		$query = $this->db->query("SELECT SUM(receive) AS total FROM " . DB_PREFIX . "profit WHERE  type_profit in (".$type.")");
		return $query->row['total'];
	}
	public function get_total_gd_current_date($status){
		$query = $this->db->query("SELECT COUNT(*) as total
			FROM ".DB_PREFIX."customer_get_donation WHERE date(date_added)=CURRENT_DATE AND status = ".$status."");
		return $query->row['total'];
	}
	public function get_total_pd_current_date($status){
		$query = $this->db->query("SELECT COUNT(*) as total
			FROM ".DB_PREFIX."customer_provide_donation WHERE date(date_added)=CURRENT_DATE AND status = ".$status."");
		return $query->row['total'];
	}
	public function get_all_code_date(){
		$query = $this->db->query("SELECT COUNT(*) as total,SUM(package) as sum
			FROM ".DB_PREFIX."customer_code WHERE date(date_added)=CURRENT_DATE");
		return $query->row;
	}
	public function totalds(){
		$query = $this->db->query("SELECT SUM(filled) as sum
			FROM ".DB_PREFIX."customer_provide_donation A INNER JOIN ".DB_PREFIX."customer B ON A.customer_id = B.customer_id WHERE month(A.date_added)=".date('m')." AND B.status_r_wallet = 0");
		return $query->row;
	}
	public function totaldsthang(){
		$query = $this->db->query("SELECT SUM(filled) as sum
			FROM ".DB_PREFIX."customer_provide_donation WHERE date(date_added)=CURRENT_DATE");
		return $query->row;
	}
	public function getTotalCustomersNewLast() {
		
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "history_customer";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function get_history_customer() {
		
		$sql = "SELECT A.*, B.firstname,B.date_birth FROM " . DB_PREFIX . "history_customer A INNER JOIN " . DB_PREFIX . "customer B ON A.customer_id = B.customer_id ORDER BY B.date_added DESC LIMIT 10";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalCustomersNew() {
		
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "nhanvien";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getTotalCustomersOff() {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "dichvu ";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function onlineToday(){
		$date = date('Y-m-d');
		$total = 0;
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_activity` WHERE `key` = 'login' and `date_added` >= '".$date." 00:00:00' and `date_added` <='".$date." 23:59:59' GROUP BY customer_id");
		if (isset($query->rows)) {
			$total = count($query->rows);
		}
		return $total;
	}
	public function onlineYesterday(){
		$date = date('Y-m-d',strtotime( '-1 days' ));
		$total = 0;
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_activity` WHERE `key` = 'login' and `date_added` >= '".$date." 00:00:00' and `date_added` <='".$date." 23:59:59' GROUP BY customer_id");
		if (isset($query->rows)) {
			$total = count($query->rows);
		}
		return $total;
	}
	
	public function onlineAll(){
		$total = 0;
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_activity` WHERE `key` = 'login' GROUP BY customer_id");
		if (isset($query->rows)) {
			$total = count($query->rows);
		}
		return $total;
	}
}