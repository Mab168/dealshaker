<?php
class ControllerAccountRegisters extends Controller {
	private $error = array();

	public function index() {

		//!array_key_exists('ref', $this -> request -> get) && $this -> response -> redirect($this -> url -> link('account/login', '', 'SSL'));
		

		$this -> document -> addScript('catalog/view/javascript/register/register.js');
		$this -> load -> language('account/register');

		 $this -> document -> setTitle('Register User');

		$this -> load -> model('account/customer');
		$this -> load -> model('customize/country');
		/*check ---- sql*/
			$filter_wave2 = Array('"', "'");
    		foreach($_POST as $key => $value)
        	$_POST[$key] = $this -> replace_injection($_POST[$key], $filter_wave2);
    		foreach($_GET as $key => $value)
        	$_GET[$key] = $this -> replace_injection($_GET[$key], $filter_wave2);
        /*check ---- sql*/

		$customer_get = $this -> model_account_customer -> getCustomerbyCode($_GET['ref']);

		count($customer_get) === 0 && $this -> response -> redirect($this -> url -> link('account/login', '', 'SSL'));

		$data['self'] = $this;

		$data['customer_id'] = $customer_get['customer_id'];
		$data['actionWallet'] = $this -> url -> link('account/personal/checkwallet', '', 'SSL');

		$data['country'] = $this -> model_customize_country -> getCountry();
		$data['action'] = $this -> url -> link('account/registers/confirmSubmit', 'ref=' . $_GET['ref'], 'SSL');
		$data['actionCheckUser'] = $this -> url -> link('account/registers/checkuser', '', 'SSL');
		$data['actionCheckEmail'] = $this -> url -> link('account/registers/checkemail', '', 'SSL');
		$data['actionCheckPhone'] = $this -> url -> link('account/registers/checkphone', '', 'SSL');
		$data['actionCheckCmnd'] = $this -> url -> link('account/registers/checkcmnd', '', 'SSL');
		// $data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this -> load -> controller('common/footer');
		$data['header'] = $this -> load -> controller('common/header');
		$this -> load -> model('account/customer');
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/register.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/register.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/register.tpl', $data));
		}
	}
	public function replace_injection($str, $filter)
	{
		foreach($filter as $key => $value)
			$str = str_replace($filter[$key], "", $str);
			return $str;
	}
	public function confirmSubmit() {
		
		$filter_wave2 = Array('"', "'");
		foreach($_POST as $key => $value)
    	$_POST[$key] = $this -> replace_injection($_POST[$key], $filter_wave2);
		foreach($_GET as $key => $value)
    	$_GET[$key] = $this -> replace_injection($_GET[$key], $filter_wave2);
       
		if ($this->request->server['REQUEST_METHOD'] === 'POST'){

			$this -> load -> model('customize/register');
			$this -> load -> model('account/auto');
			$this -> load -> model('account/customer');
			
			$checkUser = intval($this -> model_customize_register -> checkExitUserName($_POST['username'])) === 1 ? 1 : -1;
			
			if ($checkUser == 1) {
				die('Error');
			}
			
			$tmp = $this -> model_customize_register -> addCustomerByToken($this->request->post);

			$cus_id= $tmp;
				

				$code_active = sha1(md5(md5($cus_id)));
				$this -> model_customize_register -> insert_code_active($cus_id, $code_active);

				$amount = 0;
				
				
				$data['has_register'] = true;
				$mail = new Mail();
				$mail -> protocol = $this -> config -> get('config_mail_protocol');
				$mail -> parameter = $this -> config -> get('config_mail_parameter');
				$mail -> smtp_hostname = $this -> config -> get('config_mail_smtp_hostname');
				$mail -> smtp_username = $this -> config -> get('config_mail_smtp_username');
				$mail -> smtp_password = html_entity_decode($this -> config -> get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail -> smtp_port = $this -> config -> get('config_mail_smtp_port');
				$mail -> smtp_timeout = $this -> config -> get('config_mail_smtp_timeout');

				$mail -> setTo($_POST['email']);
				$mail -> setFrom($this -> config -> get('config_email'));
				$mail -> setSender(html_entity_decode("Diamonds freefall", ENT_QUOTES, 'UTF-8'));
				$mail -> setSubject("Congratulations Your Registration is Confirmed!");
				$html_mail = '

				<div style="background:#2C276C; width:100%;">
				   <table align="center" border="0" cellpadding="0" cellspacing="0" style="background:#26105C;border-collapse:collapse;line-height:100%!important;margin:0;padding:0;
				    width:700px; margin:0 auto">
				   <tbody>
				      <tr>
				        <td>
				           <div style="text-align:center" class="ajs-header"><img  src="'.HTTPS_SERVER.'catalog/view/theme/default/images/logo.png" alt="logo" style="margin: 20px auto; width:350px;"></div>
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
					       	<p style="text-align:center;">
					       		<img style="margin:0 auto" src="https://chart.googleapis.com/chart?chs=150x150&chld=L|1&cht=qr&chl=bitcoin:'.$this-> request ->post['wallet'].'"/>
					       	</p>
					       	<p style="font-size:14px;color: black; text-align:center"><b>'.$this-> request ->post['wallet'].'</b></p>
					       	<p style="font-size:14px;color: black;margin-left: 70px; line-height: 20px; margin-right: 70px; ">You\'ll receive 2,000 coins after the account active and we are responsible for mining within 6 months to pay enough coin for you, you will be selling 100% or purchasing goods or international airfares</p>
					       	<p style="font-size:14px;color: black;margin-left: 70px;line-height: 20px; margin-right: 70px;"><b>*Note:</b>
All of your registration information can not be modified. If you want to modify information please contact administrator@aircoin.org</p>
					       	<p style="font-size:14px;color: black;text-align:center; margin-bottom:60px; margin-top:30px;"><a href="'.HTTPS_SERVER.'active.html&token='.$code_active.'" style="margin: 0 auto;width: 200px;background: #d14836; text-transform: uppercase; border-radius: 5px; font-weight: bold;text-decoration:none;color:#f8f9fb;display:block;padding:12px 10px 10px">Active Account</a>
					       	</p
					          </div>
				       </td>
				       </tr>
				       <tr>
			       <td style="width:100%; height: 35px; background: #26105C; color: #fff; line-height:35px; text-align: center">© 2017 Diamonds freefall - All Rights Reserved<td>
			       </tr>
			       </tr>
				    </tbody>
				    </table>
				  </div>';
				
				$this-> model_customize_register -> update_template_mail($code_active, $html_mail);
				$mail -> setHtml($html_mail);	
				//$mail -> send();

				$this->session->data['register_mail'] = $this-> request ->post['email'];
				unset($this->session->data['customer_id']);
				$this -> response -> redirect(HTTPS_SERVER . 'login.html#success');
			
		}
	}
	public function create_wallet_blockio($lable){
		$block_io_a = new BlockIo(key_cm, pin_cm, block_version);
		$wallet = $block_io_a->get_new_address(array('label' => $lable));
		unset($block_io_a);
		return $wallet->data->address;
	}
	public function get_address_balance($address){
		$block_io_a = new BlockIo(key_cm, pin_cm, block_version);
		$balances = $block_io_a->get_address_balance(array('addresses' => $address));
		$balances['available_balance'] = $balances->data->available_balance;
		$balances['pending_received_balance'] = $balances->data->pending_received_balance;
		unset($block_io_a);
		return $balances;
	}

	public function create_wallet_coinmax($customercode) {
		$length = 33;
		$str ="";
		$secret = substr(hash_hmac('sha1', hexdec(crc32(md5($customercode))), 'secret'), 0, 100);
		$chars = $secret."ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
		 }
		return '7'.$str;
	}
	public function checkuser() {
		if ($this -> request -> get['username']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitUserName($this -> request -> get['username'])) === 1 ? 1 : 0;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function checkemail() {
		if ($this -> request -> get['email']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitEmail($this -> request -> get['email'])) < 100 ? 0 : 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}
	public function checkphone() {
		if ($this -> request -> get['phone']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitPhone($this -> request -> get['phone'])) < 100 ? 0 : 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function checkcmnd() {
		if ($this -> request -> get['cmnd']) {
			$this -> load -> model('customize/register');
			$json['success'] = intval($this -> model_customize_register -> checkExitCMND($this -> request -> get['cmnd'])) < 100 ? 0 : 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function add_tree()
	{
		die;
		$this -> load -> model('account/customer');
		$customer_id = $_GET['id'];
		$parent = 1;
		//signupUser(customer,parent)
		$user = $this -> model_account_customer -> getTableCustomerMLByUsername($parent);
		$userPonser = $this -> findPonser($user);
		if ($userPonser['ponser_id'] == -1){
			$userPonser = $this -> reduceFindPonser($user);
			//$userPonser = $this -> session-> data['reduceUser'];
		}
       	
       	$this -> model_account_customer -> update_p_binary($customer_id,$userPonser['ponser_id']);
		
		if ($userPonser['left'])
		{
    		$this -> model_account_customer -> update_p_left($userPonser['ponser_id'],$customer_id );
		}
    	else
    	{
    		$this -> model_account_customer -> update_p_right($userPonser['ponser_id'] ,$customer_id );
    	}

	}
	public function findPonser($user){

		$ponser_id = -1;
    	$left = True;
    	if ($user['left'] == 0)
    	{
    		$ponser_id = $user['customer_id'];
    	}
    	if ($user['right'] == 0 and $user['left'] != 0)
    	{
    		$left = False;
        	$ponser_id = $user['customer_id'];
    	}
        $array = array('left' => $left,'ponser_id' => $ponser_id);
    	return $array;
	}

	public function reduceFindPonser($parent)
	{
		$users = array_reverse($this -> model_account_customer -> getTableCustomerMLByp_binary($parent['customer_id']));
		if ($users)
		{

			for ($i=1;$i<=count($users);$i++)
	    	{
	    		$reduceUser = $this->findPonser($users[$i]);
	    		if ($reduceUser['ponser_id'] != -1)
	    		{
	    			$userPonser = $reduceUser;
	    			//$this -> session-> data['reduceUser'] = $reduceUser;
	    			break;
	    		}
               	
               	if (!isset($userPonser))
               	{
               		$sizeLeft = $this -> BST_size($users[0], []);
	                $sizeLeft = count($sizeLeft);
	                $sizeRight = $this ->BST_size($users[1], []);
	                $sizeRight = count($sizeRight);

	                if($sizeLeft > $sizeRight){
	                	
                    	$this ->reduceFindPonser($users[1]);
	                }
	                if($sizeLeft <= $sizeRight){

	                    $this ->reduceFindPonser($users[0]);
	                
	               	}
	            }
	    	}
		}
		return $userPonser;
	}

	public function BST_size($parent, $json){

		$user = $this -> model_account_customer -> getTableCustomerMLByp_binary($parent['customer_id']);
		foreach ($user as $key => $value) {
			array_push($json,$user['customer_id']);
	    	$this -> BST_size($user['customer_id'] , $json);
		}

	    return $json;
	}

    
}
