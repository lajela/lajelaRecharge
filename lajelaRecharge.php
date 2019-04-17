<?php 
class lajelaRecharge{
     protected $api;
 
 
 /*******************************************************************************
*                              Constructor                               *
*******************************************************************************/
 
 function __construct($api){
 $this->api = $api;
 }
 
 
/*******************************************************************************
*                               Public methods                                 *
*******************************************************************************/
 
function getCategory(){
     return file_get_contents("https://recharge.lajela.com/api/category");
 }
 function getSubCategory($categroy){
 return file_get_contents("https://recharge.lajela.com/api/sub-category?category=$categroy");
 }
 function getService($serviceID){
 return file_get_contents("https://recharge.lajela.com/api/service?service=$serviceID");
 }
 
 function getPlans($serviceID){
   return file_get_contents("https://recharge.lajela.com/api/plans?service=$serviceID");
 } 
 
function getCustomer($serviceID,$customerID){
   return file_get_contents("https://recharge.lajela.com/api/customer?$serviceID=&id=$customerID");
 }
 
 function getVariation($serviceID,$plan){
   return file_get_contents("https://recharge.lajela.com/api/variation?service=$serviceID&plan=$plan");
 }
 
 function pay($serviceID,$amount,$phone,$customerID="",$plan="",$email="",$requestID="",$test=false){
    $host = 'http://recharge.lajela.com/api/pay';
	if($test){
	  $host = 'https://recharge.lajela.com/api/testpay';
	}
	if($requestID=="" || empty($requestID)){
	 $requestID = time()+mt_rand();
	}
	$refer= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $api = $this->api;
	$data = array(
	'serviceID'=> "$serviceID", //Merchants or Operator ID ( gotv, airtel, dstv, glo-data etc)
	'plan'=> "$plan", //The plan Subscribing for (gotv-plus, gotv-value etc)
	'amount' =>  "$amount", // (Required) Amount to pay 
	'customerID' => "$customerID", // (e.g Dstv SmartCard Number) (Optional).
	'phone' => "$phone", //without country code
	'email' => "$email", //string
	'requestID' => "$requestID" // unique for every transaction
	);  
	$curl       = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => $host,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST => true,
	CURLOPT_ENCODING => "",
	CURLOPT_POSTFIELDS => $data,
	CURLOPT_REFERER => $refer,
	CURLOPT_HTTPHEADER => array("Authorization: Bearer $api"),
	CURLOPT_FOLLOWLOCATION=> true,
	CURLOPT_MAXREDIRS => 10,   
	CURLOPT_POSTREDIR => 3,   
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	));
	$r =  curl_exec($curl); 
	curl_close($curl);
	return $r;
 
 }
 
 function verifyPayment($requestID,$test=false){
	$host = 'http://recharge.lajela.com/api/verify';
	if($test){
	$host = 'http://recharge.lajela.com/api/testverify';
	}
	$api =  $this->api; //Your API Key
	$data = array(
	'requestID' => "$requestID" // For the transaction
	);  
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => $host,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST => true,
	CURLOPT_ENCODING => "",
	CURLOPT_POSTFIELDS => $data,
	CURLOPT_HTTPHEADER => array("Authorization: Bearer $api"),
	CURLOPT_FOLLOWLOCATION=> true,
	CURLOPT_MAXREDIRS => 10,   
	CURLOPT_POSTREDIR => 3,   
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	));
	$response =  curl_exec($curl); 
	 curl_close($curl);
	return $response;
 
 }
 
 function getBalance(){
 $host = 'https://recharge.lajela.com/api/balance';
		$data = array(
		  'api' => $this->api // API KEY
		);
		$curl       = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $host,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_USERPWD => $username.":" .$password,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
		));
	         curl_close($curl);
		return curl_exec($curl);
 }
 
 function getPurchaseCode($requestID){
 $host = 'http://recharge.lajela.com/api/purchase-code';
	$api =  $this->api; //Your API Key
	$data = array(
	'requestID' => "$requestID" // For the transaction
	);  
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => $host,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST => true,
	CURLOPT_ENCODING => "",
	CURLOPT_POSTFIELDS => $data,
	CURLOPT_HTTPHEADER => array("Authorization: Bearer $api"),
	CURLOPT_FOLLOWLOCATION=> true,
	CURLOPT_MAXREDIRS => 10,   
	CURLOPT_POSTREDIR => 3,   
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	));
	$response =  curl_exec($curl); 
	curl_close($curl);
	return $response;
 }
 
}
