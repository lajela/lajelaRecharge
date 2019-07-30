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
 
 function getLink($link){
		$curl  = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $link,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_ENCODING => "",
		CURLOPT_FOLLOWLOCATION=> true,
		CURLOPT_MAXREDIRS => 10,   
		CURLOPT_POSTREDIR => 3,   
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		));   
		return  curl_exec($curl);
		curl_close($curl);
 }
 
 
function getCategory(){
     return $this->getLink("https://lajela.com/api/category");
 }
 function getSubCategory($categroy){
 return $this->getLink("https://lajela.com/api/sub-category?category=$categroy");
 }
 function getService($serviceID){
 return $this->getLink("https://lajela.com/api/service?service=$serviceID");
 }
 
 function getPlans($serviceID){
   return $this->getLink("https://lajela.com/api/plans?service=$serviceID");
 } 
 
function getCustomer($serviceID,$customerID){
   return $this->getLink("https://lajela.com/api/customer?service=$serviceID&id=$customerID");
 }
 
 function getVariation($serviceID,$plan){
   return $this->getLink("https://lajela.com/api/variation?service=$serviceID&plan=$plan");
 }
 
 function pay($serviceID,$amount,$phone,$customerID="",$plan="",$email="",$requestID="",$test=false){
    $host = 'https://lajela.com/api/pay';
	if($test){
	  $host = 'https://lajela.com/api/testpay';
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
	$host = 'https://lajela.com/api/verify';
	if($test){
	$host = 'https://lajela.com/api/testverify';
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
 $host = 'https://lajela.com/api/balance';
		$api =  $this->api;
		$curl       = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $host,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_ENCODING => "",
		CURLOPT_HTTPHEADER => array("Authorization: Bearer $api"),
		CURLOPT_FOLLOWLOCATION=> true,
		CURLOPT_MAXREDIRS => 10,   
		CURLOPT_POSTREDIR => 3,   
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		));
	       
		return curl_exec($curl);
		curl_close($curl);
 }
 
 function getPurchaseCode($requestID){
 $host = 'https://lajela.com/api/purchase-code';
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
