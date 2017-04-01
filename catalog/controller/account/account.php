<?php
class ControllerAccountAccount extends Controller {
	public function check_sotrung()
	{
		$this -> load -> model('account/customer');
		include('simple_html_dom.php');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$today = date("d-m-Y");
		$this -> mientrung($today);
		$this -> miennam($today);

		$get_provine_lottery = $this -> model_account_customer -> get_provine_lottery($today);
		//print_r($get_provine_lottery);die;
		foreach ($get_provine_lottery as $key => $value) {
			
			$check_History_lottery = $this -> model_account_customer -> check_History_lottery($value['id']);
			if ($check_History_lottery['number'] == 0)
			{
				/*bao lô 2*/
				if ($value['type_lottery'] == "baolo2")
				{
					if (intval($this -> giai_bao_lo_2($today,$value['bet_numbers'],$value['domain_id'])['kq']) > 0)
					{
						$count_trung = intval($this -> giai_bao_lo_2($today,$value['bet_numbers'],$value['domain_id'])['kq']);

						$chuoi_trung = $this -> giai_bao_lo_2($today,$value['bet_numbers'],$value['domain_id'])['chuoi_trung'];
						
						$id_history_trung = $this -> model_account_customer -> saveTranstionHistory_lottery($value['customer_id'], 
		                  "Trúng sổ đề bao lô 2 số", 
		                  "+ ".($value['win_btc_number']/100000000*$count_trung)." BTC", 
		                  "Trúng sổ đề bao lô 2 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
		                  $chuoi_trung, 
		                  $value['type_lottery'],
		                  $value['id_tranfer'],
		                  'Pending',
		                  $value['date_danh'],
		                  $value['id'],
		                  $value['btc_tren_number'],
		                  $value['win_btc_number']
		                );

						$getCustomer = $this -> model_account_customer -> getCustomer($value['customer_id']);
						$date_danh = date('Y-m-d',strtotime($today));
						$check_p_node_today = $this -> model_account_customer -> check_p_node_today($date_danh,$getCustomer['p_node']);

						if ($check_p_node_today > 0){

							$this -> model_account_customer -> saveTranstionHistory_lottery($getCustomer['p_node'], 
			                  "Hoa hồng trực tiếp số đề", 
			                  "+ ".($value['win_btc_number']/100000000*$count_trung*0.1)." BTC", 
			                  "Hoa hồng trực tiếp của ".$this -> get_username($value['customer_id'])." số đề bao lô 2 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
			                  $chuoi_trung, 
			                  $value['type_lottery'],
			                  $value['id_tranfer'],
			                  'Pending',
			                  $value['date_danh'],
			                  $value['id'],
			                  $value['btc_tren_number'],
			                  $value['win_btc_number']
			                );
						}

					}
				}

				/*bao lô 3*/
				if ($value['type_lottery'] == "baolo3")
				{
					if (intval($this -> giai_bao_lo_3($today,$value['bet_numbers'],$value['domain_id'])['kq']) > 0)
					{
						$count_trung = intval($this -> giai_bao_lo_3($today,$value['bet_numbers'],$value['domain_id'])['kq']);

						$chuoi_trung = $this -> giai_bao_lo_3($today,$value['bet_numbers'],$value['domain_id'])['chuoi_trung'];
						
						$id_history_trung = $this -> model_account_customer -> saveTranstionHistory_lottery($value['customer_id'], 
		                  "Trúng sổ đề bao lô 3 số", 
		                  "+ ".($value['win_btc_number']/100000000*$count_trung)." BTC", 
		                  "Trúng sổ đề bao lô 3 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
		                  $chuoi_trung, 
		                  $value['type_lottery'],
		                  $value['id_tranfer'],
		                  'Pending',
		                  $value['date_danh'],
		                  $value['id'],
		                  $value['btc_tren_number'],
		                  $value['win_btc_number']
		                );
		                $getCustomer = $this -> model_account_customer -> getCustomer($value['customer_id']);
						$date_danh = date('Y-m-d',strtotime($today));
						$check_p_node_today = $this -> model_account_customer -> check_p_node_today($date_danh,$getCustomer['p_node']);

						if ($check_p_node_today > 0){

							$this -> model_account_customer -> saveTranstionHistory_lottery($getCustomer['p_node'], 
			                  "Hoa hồng trực tiếp số đề", 
			                  "+ ".($value['win_btc_number']/100000000*$count_trung*0.1)." BTC", 
			                  "Hoa hồng trực tiếp của ".$this -> get_username($value['customer_id'])." số đề bao lô 3 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
			                  $chuoi_trung, 
			                  $value['type_lottery'],
			                  $value['id_tranfer'],
			                  'Pending',
			                  $value['date_danh'],
			                  $value['id'],
			                  $value['btc_tren_number'],
			                  $value['win_btc_number']
			                );
						}
					}
				}
				/*đầu 2*/
				if ($value['type_lottery'] == "dau2")
				{

					if (intval($this -> giai_dau_2($today,$value['bet_numbers'],$value['domain_id'])['kq']) > 0)
					{
						
						$count_trung = intval($this -> giai_dau_2($today,$value['bet_numbers'],$value['domain_id'])['kq']);

						$chuoi_trung = $this -> giai_dau_2($today,$value['bet_numbers'],$value['domain_id'])['chuoi_trung'];
						
						$id_history_trung = $this -> model_account_customer -> saveTranstionHistory_lottery($value['customer_id'], 
		                  "Trúng sổ đề đầu 2 số", 
		                  "+ ".($value['win_btc_number']/100000000*$count_trung)." BTC", 
		                  "Trúng sổ đề đầu 2 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
		                  $chuoi_trung, 
		                  $value['type_lottery'],
		                  $value['id_tranfer'],
		                  'Pending',
		                  $value['date_danh'],
		                  $value['id'],
		                  $value['btc_tren_number'],
		                  $value['win_btc_number']
		                );
		                $getCustomer = $this -> model_account_customer -> getCustomer($value['customer_id']);
						$date_danh = date('Y-m-d',strtotime($today));
						$check_p_node_today = $this -> model_account_customer -> check_p_node_today($date_danh,$getCustomer['p_node']);

						if ($check_p_node_today > 0){

							$this -> model_account_customer -> saveTranstionHistory_lottery($getCustomer['p_node'], 
			                  "Hoa hồng trực tiếp số đề", 
			                  "+ ".($value['win_btc_number']/100000000*$count_trung*0.1)." BTC", 
			                  "Hoa hồng trực tiếp của ".$this -> get_username($value['customer_id'])." số đề đầu 2 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
			                  $chuoi_trung, 
			                  $value['type_lottery'],
			                  $value['id_tranfer'],
			                  'Pending',
			                  $value['date_danh'],
			                  $value['id'],
			                  $value['btc_tren_number'],
			                  $value['win_btc_number']
			                );
						}
					}
				}

				/*đầu 3*/
				if ($value['type_lottery'] == "dau3")
				{

					if (intval($this -> giai_dau_3($today,$value['bet_numbers'],$value['domain_id'])['kq']) > 0)
					{
						
						$count_trung = intval($this -> giai_dau_3($today,$value['bet_numbers'],$value['domain_id'])['kq']);

						$chuoi_trung = $this -> giai_dau_3($today,$value['bet_numbers'],$value['domain_id'])['chuoi_trung'];
						
						$id_history_trung = $this -> model_account_customer -> saveTranstionHistory_lottery($value['customer_id'], 
		                  "Trúng sổ đề đầu 3 số", 
		                  "+ ".($value['win_btc_number']/100000000*$count_trung)." BTC", 
		                  "Trúng sổ đề đầu 3 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
		                  $chuoi_trung, 
		                  $value['type_lottery'],
		                  $value['id_tranfer'],
		                  'Pending',
		                  $value['date_danh'],
		                  $value['id'],
		                  $value['btc_tren_number'],
		                  $value['win_btc_number']
		                );
		                $getCustomer = $this -> model_account_customer -> getCustomer($value['customer_id']);
						$date_danh = date('Y-m-d',strtotime($today));
						$check_p_node_today = $this -> model_account_customer -> check_p_node_today($date_danh,$getCustomer['p_node']);

						if ($check_p_node_today > 0){

							$this -> model_account_customer -> saveTranstionHistory_lottery($getCustomer['p_node'], 
			                  "Hoa hồng trực tiếp số đề", 
			                  "+ ".($value['win_btc_number']/100000000*$count_trung*0.1)." BTC", 
			                  "Hoa hồng trực tiếp của ".$this -> get_username($value['customer_id'])." số đề đầu 3 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
			                  $chuoi_trung, 
			                  $value['type_lottery'],
			                  $value['id_tranfer'],
			                  'Pending',
			                  $value['date_danh'],
			                  $value['id'],
			                  $value['btc_tren_number'],
			                  $value['win_btc_number']
			                );
						}
					}
				}
				/*đuôi 2*/
				if ($value['type_lottery'] == "duoi2")
				{

					if (intval($this -> giai_cuoi_2($today,$value['bet_numbers'],$value['domain_id'])['kq']) > 0)
					{
						
						$count_trung = intval($this -> giai_cuoi_2($today,$value['bet_numbers'],$value['domain_id'])['kq']);

						$chuoi_trung = $this -> giai_cuoi_2($today,$value['bet_numbers'],$value['domain_id'])['chuoi_trung'];
						
						$id_history_trung = $this -> model_account_customer -> saveTranstionHistory_lottery($value['customer_id'], 
		                  "Trúng sổ đề đuôi 2 số", 
		                  "+ ".($value['win_btc_number']/100000000*$count_trung)." BTC", 
		                  "Trúng sổ đề đuôi 2 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
		                  $chuoi_trung, 
		                  $value['type_lottery'],
		                  $value['id_tranfer'],
		                  'Pending',
		                  $value['date_danh'],
		                  $value['id'],
		                  $value['btc_tren_number'],
		                  $value['win_btc_number']
		                );
		                $getCustomer = $this -> model_account_customer -> getCustomer($value['customer_id']);
						$date_danh = date('Y-m-d',strtotime($today));
						$check_p_node_today = $this -> model_account_customer -> check_p_node_today($date_danh,$getCustomer['p_node']);

						if ($check_p_node_today > 0){

							$this -> model_account_customer -> saveTranstionHistory_lottery($getCustomer['p_node'], 
			                  "Hoa hồng trực tiếp số đề", 
			                  "+ ".($value['win_btc_number']/100000000*$count_trung*0.1)." BTC", 
			                  "Hoa hồng trực tiếp của ".$this -> get_username($value['customer_id'])." số đề đuôi 2 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
			                  $chuoi_trung, 
			                  $value['type_lottery'],
			                  $value['id_tranfer'],
			                  'Pending',
			                  $value['date_danh'],
			                  $value['id'],
			                  $value['btc_tren_number'],
			                  $value['win_btc_number']
			                );
						}
					}
				}
				/*đuôi 3*/
				if ($value['type_lottery'] == "duoi3")
				{

					if (intval($this -> giai_cuoi_3($today,$value['bet_numbers'],$value['domain_id'])['kq']) > 0)
					{
						
						$count_trung = intval($this -> giai_cuoi_3($today,$value['bet_numbers'],$value['domain_id'])['kq']);

						$chuoi_trung = $this -> giai_cuoi_3($today,$value['bet_numbers'],$value['domain_id'])['chuoi_trung'];
						
						$id_history_trung = $this -> model_account_customer -> saveTranstionHistory_lottery($value['customer_id'], 
		                  "Trúng sổ đề đuôi 3 số", 
		                  "+ ".($value['win_btc_number']/100000000*$count_trung)." BTC", 
		                  "Trúng sổ đề đuôi 3 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
		                  $chuoi_trung, 
		                  $value['type_lottery'],
		                  $value['id_tranfer'],
		                  'Pending',
		                  $value['date_danh'],
		                  $value['id'],
		                  $value['btc_tren_number'],
		                  $value['win_btc_number']
		                );
		                $getCustomer = $this -> model_account_customer -> getCustomer($value['customer_id']);
						$date_danh = date('Y-m-d',strtotime($today));
						$check_p_node_today = $this -> model_account_customer -> check_p_node_today($date_danh,$getCustomer['p_node']);

						if ($check_p_node_today > 0){

							$this -> model_account_customer -> saveTranstionHistory_lottery($getCustomer['p_node'], 
			                  "Hoa hồng trực tiếp số đề", 
			                  "+ ".($value['win_btc_number']/100000000*$count_trung*0.1)." BTC", 
			                  "Hoa hồng trực tiếp của ".$this -> get_username($value['customer_id'])." số đề đuôi 3 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
			                  $chuoi_trung, 
			                  $value['type_lottery'],
			                  $value['id_tranfer'],
			                  'Pending',
			                  $value['date_danh'],
			                  $value['id'],
			                  $value['btc_tren_number'],
			                  $value['win_btc_number']
			                );
						}
					}
				}
				/*cặp 2*/
				if ($value['type_lottery'] == "cap2")
				{

					if (intval($this -> giai_cap_2($today,$value['bet_numbers'],$value['domain_id'])['kq']) > 0)
					{
						
						$count_trung = intval($this -> giai_cap_2($today,$value['bet_numbers'],$value['domain_id'])['kq']);

						$chuoi_trung = $this -> giai_cap_2($today,$value['bet_numbers'],$value['domain_id'])['chuoi_trung'];
						
						$id_history_trung = $this -> model_account_customer -> saveTranstionHistory_lottery($value['customer_id'], 
		                  "Trúng sổ đề cặp 2 số", 
		                  "+ ".($value['win_btc_number']/100000000*$count_trung)." BTC", 
		                  "Trúng sổ đề cặp 2 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
		                  $chuoi_trung, 
		                  $value['type_lottery'],
		                  $value['id_tranfer'],
		                  'Pending',
		                  $value['date_danh'],
		                  $value['id'],
		                  $value['btc_tren_number'],
		                  $value['win_btc_number']
		                );
		                $getCustomer = $this -> model_account_customer -> getCustomer($value['customer_id']);
						$date_danh = date('Y-m-d',strtotime($today));
						$check_p_node_today = $this -> model_account_customer -> check_p_node_today($date_danh,$getCustomer['p_node']);

						if ($check_p_node_today > 0){

							$this -> model_account_customer -> saveTranstionHistory_lottery($getCustomer['p_node'], 
			                  "Hoa hồng trực tiếp số đề", 
			                  "+ ".($value['win_btc_number']/100000000*$count_trung*0.1)." BTC", 
			                  "Hoa hồng trực tiếp của ".$this -> get_username($value['customer_id'])." số đề cặp 2 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
			                  $chuoi_trung, 
			                  $value['type_lottery'],
			                  $value['id_tranfer'],
			                  'Pending',
			                  $value['date_danh'],
			                  $value['id'],
			                  $value['btc_tren_number'],
			                  $value['win_btc_number']
			                );
						}
					}
				}
				/*cặp 3*/
				if ($value['type_lottery'] == "cap3")
				{

					if (intval($this -> giai_cap_3($today,$value['bet_numbers'],$value['domain_id'])['kq']) > 0)
					{
						
						$count_trung = intval($this -> giai_cap_3($today,$value['bet_numbers'],$value['domain_id'])['kq']);

						$chuoi_trung = $this -> giai_cap_3($today,$value['bet_numbers'],$value['domain_id'])['chuoi_trung'];
						
						$id_history_trung = $this -> model_account_customer -> saveTranstionHistory_lottery($value['customer_id'], 
		                  "Trúng sổ đề cặp 3 số", 
		                  "+ ".($value['win_btc_number']/100000000*$count_trung)." BTC", 
		                  "Trúng sổ đề cặp 3 số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
		                  $chuoi_trung, 
		                  $value['type_lottery'],
		                  $value['id_tranfer'],
		                  'Pending',
		                  $value['date_danh'],
		                  $value['id'],
		                  $value['btc_tren_number'],
		                  $value['win_btc_number']
		                );
		                $getCustomer = $this -> model_account_customer -> getCustomer($value['customer_id']);
						$date_danh = date('Y-m-d',strtotime($today));
						$check_p_node_today = $this -> model_account_customer -> check_p_node_today($date_danh,$getCustomer['p_node']);

						if ($check_p_node_today > 0){

							$this -> model_account_customer -> saveTranstionHistory_lottery($getCustomer['p_node'], 
			                  "Hoa hồng trực tiếp số đề", 
			                  "+ ".($value['win_btc_number']/100000000*$count_trung*0.1)." BTC", 
			                  "Hoa hồng trực tiếp của ".$this -> get_username($value['customer_id'])." số đề cặp số từ số đánh ".$value['bet_numbers']." từ đài ".$this->load_name_dai_lottery($value['domain_id']), 
			                  $chuoi_trung, 
			                  $value['type_lottery'],
			                  $value['id_tranfer'],
			                  'Pending',
			                  $value['date_danh'],
			                  $value['id'],
			                  $value['btc_tren_number'],
			                  $value['win_btc_number']
			                );
						}
					}
				}
			}

		}
		
	
	}
	public function replace_injection($str, $filter){
			foreach($filter as $key => $value)
			$str = str_replace($filter[$key], "", $str);
			return $str;
		}
	public function replace_injections($str, $filter){
		foreach($filter as $key => $value)
		$str = str_replace($filter[$key], '-'.$filter[$key], $str);
		return $str;
	}

	
	public function miennam($date){
		$filter=Array('TrVinh','TháiBình','KiênGiang','TiềnGiang','KonTum','ĐàLạt','KhánhHòa','AnGiang','HàNội','TPHCM','CàMau','Huế','PhúYên','QuảngNinh','VũngTàu','Vũngtàu','BếnTre','BạcLiêu','ĐắkLắk','QuảngNam','BắcNinh','CầnThơ','SócTrăng','ĐồngNai','TâyNinh','BìnhThuận','BìnhĐịnh','QuảngBình','QuảngTrị','HảiPhòng','VĩnhLong','BìnhDương','TràVinh','NinhThuận','GiaLai','NamĐịnh','LongAn','BìnhPhước','HậuGiang','QuảngNgãi','ĐắkNông','ĐàNẵng','TP.HCM','Đ�Nẵng','ĐồngTháp');
		$filter2 = Array('Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhật','	');
		$html = file_get_html('http://sode24h.com/index_ajax.php?module_name=home_page&action=soxo&ngay='.$date);
		$response ='';
		foreach($html->find('#miennam') as $e){
			 $response .= $e->innertext;
		}

		$response = strip_tags($response);
		$response = str_replace(" 						 						 							","-",$response);
		$response =  preg_replace('/\s{2}+/','',$response);
		$response = trim($response);
		$response = $this->replace_injection($response, $filter2);
		$response = str_replace(" ","",$response);
		$response = str_replace("GiảitámGiảibảyGiảisáuGiảinămGiảitưGiảibaGiảinhìGiảinhấtGiảiĐặcBiệt","",$response);
		$response = str_replace("Thứ 4	","",$response);


		$response = str_replace(" ","",$response);
		$response = $this->replace_injections($response, $filter);
		$array 	= explode("-", $response);
		//print_r($array );die;
		unset($array[0]);
		$leng = count($array);
		
		if ($leng > 50)
		{
			$array1	= array_slice($array, 0, 19);
			$array2	= array_slice($array, 19, 19);
			$array3	= array_slice($array, 38, 57);
			
			echo $array1[0];echo '<br>';
			echo $array2[0];echo '<br>';
			echo $array3[0];echo '<br>';

			$this -> load-> model('account/customer');
			$get_all_dai_lottery = $this -> model_account_customer ->get_all_dai_lottery();
			foreach ($get_all_dai_lottery as $key => $value) {
				if ($value['name_lottery'] == $array1[0]){
					$array1[19] = $array1[0];
					$array1[0] = $value['id'];
					
				}
				if ($value['name_lottery'] == $array2[0]){
					$array2[19] = $array2[0];
					$array2[0] = $value['id'];
				}
				if ($value['name_lottery'] == $array3[0]){
					$array3[19] = $array3[0];
					$array3[0] = $value['id'];
				}
			}
			$this -> model_account_customer -> get_ket_qua_now($array1,$date);
			$this -> model_account_customer -> get_ket_qua_now($array2,$date);
			$this -> model_account_customer -> get_ket_qua_now($array3,$date);
			echo "<pre>"; print_r($array1); echo "</pre><br>";
			echo "<pre>"; print_r($array2); echo "</pre><br>";
			echo "<pre>"; print_r($array3); echo "</pre>";
		}
		
		
	}

	
	
	public function mientrung($date){
		$filter=Array('TrVinh','TháiBình','KiênGiang','TiềnGiang','KonTum','ĐàLạt','KhánhHòa','AnGiang','HàNội','TPHCM','CàMau','Huế','PhúYên','QuảngNinh','VũngTàu','Vũngtàu','BếnTre','BạcLiêu','ĐắkLắk','QuảngNam','BắcNinh','CầnThơ','SócTrăng','ĐồngNai','TâyNinh','BìnhThuận','BìnhĐịnh','QuảngBình','QuảngTrị','HảiPhòng','VĩnhLong','BìnhDương','TràVinh','NinhThuận','GiaLai','NamĐịnh','LongAn','BìnhPhước','HậuGiang','QuảngNgãi','ĐắkNông','ĐàNẵng','TP.HCM','Đ�Nẵng','ĐồngTháp');
		$filter2 = Array('Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhật','	');
		$html = file_get_html('http://sode24h.com/index_ajax.php?module_name=home_page&action=soxo&ngay='.$date);
		$response ='';
		foreach($html->find('#mientrung') as $e){
			 $response .= $e->innertext;
		}

		$response = strip_tags($response);
		$response = str_replace(" 						 						 							","-",$response);
		$response =  preg_replace('/\s{2}+/','',$response);
		$response = trim($response);
		$response = $this->replace_injection($response, $filter2);
		$response = str_replace(" ","",$response);
		$response = str_replace("GiảitámGiảibảyGiảisáuGiảinămGiảitưGiảibaGiảinhìGiảinhấtGiảiĐặcBiệt","",$response);
		$response = str_replace("Thứ 4	","",$response);


		$response = str_replace(" ","",$response);
		$response = $this->replace_injections($response, $filter);
		$array 	= explode("-", $response);

		unset($array[0]);
		$leng = count($array);
		//echo "<pre>"; print_r($array); echo "</pre><br>";die();
		if ($leng > 18)
		{

			$array1	= array_slice($array, 0, 19);
			$array2	= array_slice($array, 19, 19);
			if ($leng > 38)
			{
				$array3	= array_slice($array, 38, 57);
			}
			
			echo $array1[0];echo '<br>';
			echo $array2[0];echo '<br>';
			if ($leng > 38)
			{
				echo $array3[0];echo '<br>';
			}
			$this -> load-> model('account/customer');
			$get_all_dai_lottery = $this -> model_account_customer ->get_all_dai_lottery();
			foreach ($get_all_dai_lottery as $key => $value) {
				if ($value['name_lottery'] == $array1[0]){
					$array1[19] = $array1[0];
					$array1[0] = $value['id'];
					
				}
				if ($value['name_lottery'] == $array2[0]){
					$array2[19] = $array2[0];
					$array2[0] = $value['id'];
				}
				if ($leng > 38) {
					if ($value['name_lottery'] == $array3[0]){
						$array3[19] = $array3[0];
						$array3[0] = $value['id'];
					}
				}
			}
			$this -> model_account_customer -> get_ket_qua_now($array1,$date);
			$this -> model_account_customer -> get_ket_qua_now($array2,$date);
			
			echo "<pre>"; print_r($array1); echo "</pre><br>";
			echo "<pre>"; print_r($array2); echo "</pre><br>";
			if ($leng > 38)
			{
				$this -> model_account_customer -> get_ket_qua_now($array3,$date);
				echo "<pre>"; print_r($array3); echo "</pre>";
		
			}
		}
	}

	public function mienbac($date){
		$filter=Array('TrVinh','TháiBình','KiênGiang','TiềnGiang','KonTum','ĐàLạt','KhánhHòa','AnGiang','HàNội','TPHCM','CàMau','Huế','PhúYên','QuảngNinh','VũngTàu','Vũngtàu','BếnTre','BạcLiêu','ĐắkLắk','QuảngNam','BắcNinh','CầnThơ','SócTrăng','ĐồngNai','TâyNinh','BìnhThuận','BìnhĐịnh','QuảngBình','QuảngTrị','HảiPhòng','VĩnhLong','BìnhDương','TràVinh','NinhThuận','GiaLai','NamĐịnh','LongAn','BìnhPhước','HậuGiang','QuảngNgãi','ĐắkNông','ĐàNẵng','TP.HCM','Đ�Nẵng','ĐồngTháp');

		$filter2 = Array('Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhật','	');
		$html = file_get_html('http://sode24h.com/index_ajax.php?module_name=home_page&action=soxo&ngay='.$date);
		$response ='';
		foreach($html->find('#mienbac') as $e){
			 $response .= $e->innertext;
		}

		$response = strip_tags($response);
		$response = str_replace(" 						 						 							","-",$response);
		$response =  preg_replace('/\s{2}+/','',$response);
		$response = trim($response);
		$response = $this->replace_injection($response, $filter2);
		$response = str_replace(" ","",$response);
		$response = str_replace("GiảitámGiảibảyGiảisáuGiảinămGiảitưGiảibaGiảinhìGiảinhấtGiảiĐặcBiệt","",$response);
		$response = str_replace("Thứ 4	","",$response);


		$response = str_replace(" ","",$response);
		$response = $this->replace_injections($response, $filter);
		$array 	= explode("-", $response);

		unset($array[0]);
		$leng = count($array);
		//echo "<pre>"; print_r($array); echo "</pre><br>";die();
		
		$array1	= array_slice($array, 0, 19);
		
		echo $array1[0];echo '<br>';
		$this -> load-> model('account/customer');
		$get_all_dai_lottery = $this -> model_account_customer ->get_all_dai_lottery();
		foreach ($get_all_dai_lottery as $key => $value) {
			if ($value['name_lottery'] == $array1[0]){
				$array1[0] = $value['id'];
			}
		}
		echo "<pre>"; print_r($array1); echo "</pre><br>";
		
	}

	public function giai_bao_lo_2($date,$so_danh,$dai_danh){
		$this -> load-> model('account/customer');
		$get_ket_qua_kq = $this -> model_account_customer -> get_ket_qua_kq($date,$dai_danh);
		
		$so_trung = explode("-", $get_ket_qua_kq['so_trung']);
		$so_danh = explode("-", $so_danh);
		$kq = 0;
		$chuoi_trung = "";
		foreach ($so_trung as  $value) {
			foreach ($so_danh as  $value_danh) {
				if (substr($value,-2) == $value_danh)
				{
					$kq ++;
					$chuoi_trung .= $value." ";
				}
			}
		}
		$json['kq'] = $kq;
		$json['chuoi_trung'] = $chuoi_trung;
		return $json;
	}

	public function giai_bao_lo_3($date,$so_danh,$dai_danh){
		$this -> load-> model('account/customer');
		$get_ket_qua_kq = $this -> model_account_customer -> get_ket_qua_kq($date,$dai_danh);
		$so_trung = explode("-", $get_ket_qua_kq['so_trung']);
		$so_danh = explode("-", $so_danh);
		$kq = 0;
		$chuoi_trung = "";
		foreach ($so_trung as  $value) {
			foreach ($so_danh as  $value_danh) {
				if (substr($value,-3) == $value_danh)
				{
					$kq ++;
					$chuoi_trung .= $value." ";
				}
			}
		}
		$json['kq'] = $kq;
		$json['chuoi_trung'] = $chuoi_trung;
		return $json;
	}

	public function giai_dau_2($date,$so_danh,$dai_danh){
		$this -> load-> model('account/customer');
		$get_ket_qua_kq = $this -> model_account_customer -> get_ket_qua_kq($date,$dai_danh);
		$so_trung = explode("-", $get_ket_qua_kq['so_trung']);
		$so_danh = explode("-", $so_danh);
		$kq = 0;
		$chuoi_trung = "";
		foreach ($so_danh as  $value_danh) {

			if (substr($so_trung[0],-2) == $value_danh) 
			{
				$kq ++;
				$chuoi_trung .= $so_trung[0];
			}
		}
		$json['kq'] = $kq;
		$json['chuoi_trung'] = $chuoi_trung;
		return $json;
	}

	public function giai_dau_3($date,$so_danh,$dai_danh){

		$this -> load-> model('account/customer');
		$get_ket_qua_kq = $this -> model_account_customer -> get_ket_qua_kq($date,$dai_danh);
		$so_trung = explode("-", $get_ket_qua_kq['so_trung']);

		$so_danh = explode("-", $so_danh);
		$kq = 0;
		$chuoi_trung = "";
		foreach ($so_danh as  $value_danh) {

			if ($so_trung[1] == $value_danh)
			{
				$kq ++;
				$chuoi_trung .= $so_trung[1];
			}
		}
		
		$json['kq'] = $kq;
		$json['chuoi_trung'] = $chuoi_trung;
		return $json;
	}

	public function giai_cuoi_2($date,$so_danh,$dai_danh){
		$this -> load-> model('account/customer');
		$get_ket_qua_kq = $this -> model_account_customer -> get_ket_qua_kq($date,$dai_danh);
		$so_trung = explode("-", $get_ket_qua_kq['so_trung']);
		$so_danh = explode("-", $so_danh);
		$kq = 0;
		$chuoi_trung = "";
		foreach ($so_danh as  $value_danh) {
			
			if (substr($so_trung[17],-2) == $value_danh)
			{
				$kq ++;
				$chuoi_trung .= $so_trung[17];
			}
		}
		
		$json['kq'] = $kq;
		$json['chuoi_trung'] = $chuoi_trung;
		return $json;
	}
	public function giai_cuoi_3($date,$so_danh,$dai_danh){
		$this -> load-> model('account/customer');
		$get_ket_qua_kq = $this -> model_account_customer -> get_ket_qua_kq($date,$dai_danh);
		$so_trung = explode("-", $get_ket_qua_kq['so_trung']);
		$so_danh = explode("-", $so_danh);
		$kq = 0;
		$chuoi_trung = "";
		foreach ($so_danh as  $value_danh) {
			
			if (substr($so_trung[17],-3) == $value_danh)
			{
				$kq ++;
				$chuoi_trung .= $so_trung[17];
			}
		}
		
		$json['kq'] = $kq;
		$json['chuoi_trung'] = $chuoi_trung;
		return $json;
	}
	public function giai_cap_2($date,$so_danh,$dai_danh){
		$this -> load-> model('account/customer');
		$get_ket_qua_kq = $this -> model_account_customer -> get_ket_qua_kq($date,$dai_danh);
		$so_trung = explode("-", $get_ket_qua_kq['so_trung']);
		$so_danh = explode("-", $so_danh);
		$kq = 0;	
		$chuoi_trung = "";
		if ($so_trung[0] == $so_danh[0] && substr($so_trung[17],-2) == $so_danh[1])
		{
			$kq ++;
			$chuoi_trung .= $so_trung[0]."-".$so_trung[17];
		}
		$json['kq'] = $kq;
		$json['chuoi_trung'] = $chuoi_trung;
		return $json;
	}

	public function giai_cap_3($date,$so_danh,$dai_danh){
		$this -> load-> model('account/customer');
		$get_ket_qua_kq = $this -> model_account_customer -> get_ket_qua_kq($date,$dai_danh);
		$so_trung = explode("-", $get_ket_qua_kq['so_trung']);
		$so_danh = explode("-", $so_danh);
		$kq = 0;	
		$chuoi_trung = "";
		
		if (substr($so_trung[1],-3) == $so_danh[0] && substr($so_trung[17],-3) == $so_danh[1])
		{
			$kq ++;
			$chuoi_trung .= $so_trung[1]."-".$so_trung[17];
		}	
		$json['kq'] = $kq;
		$json['chuoi_trung'] = $chuoi_trung;
		return $json;
	}
	 public function load_name_dai_lottery($id){
        
        $this->load->model('account/customer');
        return $get_name_dai_lottery = $this -> model_account_customer -> get_name_dai_lottery($id)['name_lottery'];
        
    }
    public function get_username($customer_id){
    	$this->load->model('account/customer');
    	return $this -> model_account_customer -> getCustomer($customer_id)['username'];
    }

    public function auto_tranfer(){
    	$this -> load-> model('account/customer');
    	date_default_timezone_set('Asia/Ho_Chi_Minh');
		$date_added= date('Y-m-d H:i:s');
		$date_finish = strtotime ('+1 day' , strtotime ($date_added ));
		$date_finish= date('Y-m-d H:i:s',$date_finish) ;	
		$weekday = date("l");
		$weekday = strtolower($weekday);
		switch($weekday) {
		    case 'monday':
		        $weekday = 'T3';
		        break;
		    case 'tuesday':
		        $weekday = 'T4';
		        break;
		    case 'wednesday':
		        $weekday = 'T5';
		        break;
		    case 'thursday':
		        $weekday = 'T6';
		        break;
		    case 'friday':
		        $weekday = 'T7';
		        break;
		    case 'saturday':
		        $weekday = 'CN';
		        break;
		    default:
		        $weekday = 'T2';
		        break;
		}

    	$get_thu_lottery = $this -> model_account_customer -> get_thu_lottery();
    	if ($get_thu_lottery['weekday'] == $weekday) die("Da tao");


		$this -> model_account_customer ->update_tranfer_finish();

		$get_all_type_lottery = $this -> model_account_customer -> get_all_type_lottery();
        foreach ($get_all_type_lottery as $key => $value) {
            $check_transfer_lottery = $this -> model_account_customer -> check_transfer_lottery($value['id']);
            if ($check_transfer_lottery['number'] == 0) $this -> model_account_customer -> in_transfer_lottery($value['type'],$value['rate'],$value['id']);
        }
    }
}
