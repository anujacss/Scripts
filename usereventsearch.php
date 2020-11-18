<?php


/************************************Helper-fns**********************************************/
function Xml2Array($xmlString){
		$xml = new SimpleXMLElement($xmlString);
		return $xml;
}







    function getAccountDetails()
    {
       global $waApiClient;
       $url = 'https://api.wildapricot.org/v2/Accounts/';
       $response = $waApiClient->makeRequest($url); 
       return  $response[0]; 
    }
    function getContactsList()
    {
       global $waApiClient;
       global $accountUrl;
       $queryParams = array(
          '$async' => 'false',  
          '$filter' => 'Member eq true',
          '$select' => 'First name, Last name'
       ); 
       $url = $accountUrl . '/Contacts/?' . http_build_query($queryParams);
       return $waApiClient->makeRequest($url);
    }
	
	function getEventsList()
    {
       global $waApiClient;
       global $accountUrl;
   
       $url = $accountUrl . '/eventregistrations?contactId=52319995';
       return $waApiClient->makeRequest($url);
    }



    class WaApiClient{
       const AUTH_URL = 'https://oauth.wildapricot.org/auth/token';
             
       private $tokenScope = 'auto';
       private static $_instance;
       private $token;
       
       public function initTokenByContactCredentials($userName, $password, $scope = null)
       {
          if ($scope) {
             $this->tokenScope = $scope;
          }
          $this->token = $this->getAuthTokenByAdminCredentials($userName, $password);
          if (!$this->token) {
             throw new Exception('Unable to get authorization token.');
          }
       }
       public function initTokenByApiKey($apiKey, $scope = null)
       {
          if ($scope) {
             $this->tokenScope = $scope;
          }
          $this->token = $this->getAuthTokenByApiKey($apiKey);
          if (!$this->token) {
             throw new Exception('Unable to get authorization token.');
          }
       }


       public function makeRequest($url, $verb = 'GET', $data = null)
       {
          if (!$this->token) {
             throw new Exception('Access token is not initialized. Call initTokenByApiKey or initTokenByContactCredentials before performing requests.');
          }
          $ch = curl_init();
          $headers = array(
             'Authorization: Bearer ' . $this->token,
             'Content-Type: application/json'
          );
          curl_setopt($ch, CURLOPT_URL, $url);
          
          if ($data) {
             $jsonData = json_encode($data);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
             $headers = array_merge($headers, array('Content-Length: '.strlen($jsonData)));
          }
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $jsonResult = curl_exec($ch);
          if ($jsonResult === false) {
             throw new Exception(curl_errno($ch) . ': ' . curl_error($ch));
          }
         
          curl_close($ch);
          return json_decode($jsonResult, true);
       }

       private function getAuthTokenByAdminCredentials($login, $password)
       {
          if ($login == '') {
             throw new Exception('login is empty');
          }
          $data = sprintf("grant_type=%s&username=%s&password=%s&scope=%s", 'password', urlencode($login), urlencode($password), urlencode($this->tokenScope));
          throw new Exception('Change clientId and clientSecret to values specific for your authorized application. For details see:  https://help.wildapricot.com/display/DOC/Authorizing+external+applications');
          $clientId = 'SamplePhpApplication';
          $clientSecret = 'open_wa_api_client';
          $authorizationHeader = "Authorization: Basic " . base64_encode( $clientId . ":" . $clientSecret);
          return $this->getAuthToken($data, $authorizationHeader);
       }

       private function getAuthTokenByApiKey($apiKey)
       {
          $data = sprintf("grant_type=%s&scope=%s", 'client_credentials', $this->tokenScope);
          $authorizationHeader = "Authorization: Basic " . base64_encode("APIKEY:" . $apiKey);
          return $this->getAuthToken($data, $authorizationHeader);
       }

       private function getAuthToken($data, $authorizationHeader)
       {
          $ch = curl_init();
          $headers = array(
             $authorizationHeader,
             'Content-Length: ' . strlen($data)
          );
          curl_setopt($ch, CURLOPT_URL, WaApiClient::AUTH_URL);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  $response = curl_exec($ch);
		  if ($response === false) {
             throw new Exception(curl_errno($ch) . ': ' . curl_error($ch));
          }
         	
		  
          $result = json_decode($response , true);
          curl_close($ch);
          return $result['access_token'];
       }

       public static function getInstance()
       {
          if (!is_object(self::$_instance)) {
             self::$_instance = new self();
          }
          return self::$_instance;
       }

       public final function __clone()
       {
          throw new Exception('It\'s impossible to clone singleton "' . __CLASS__ . '"!');
       }

       private function __construct()
       {
          if (!extension_loaded('curl')) {
             throw new Exception('cURL library is not loaded');
          }
       }

       public function __destruct()
       {
          $this->token = null;
       }
    }
?>
 <div class="wrap">
<div class="container">
<div class="search-section">
	<form action="" method="post" id="attomey_ref_form">

		<label for="Name">Enter Last Name: </label>
		<input type="text" class="input" placeholder="Enter Last  Name" name="name" style="text-transform: capitalize;" />
        <label for="Name">Enter First Name: </label>
		<input type="text" class="input" placeholder="Enter First Name" name="fname" style="text-transform: capitalize;" />
		<button style="" type="submit" name="submit">Search</button>
	

	</form>
</div>


<?php
	
	

	if(isset($_POST['submit'])){
$name = $_POST['name'];
$fname = $_POST['fname'];
ob_start();
session_start();
  //	if(empty($_SESSION['wa_contacts'])){
    $waApiClient = WaApiClient::getInstance();
    
    $waApiClient->initTokenByApiKey('s4qe2842k599yaiws14s9ty7w0x1ty');
  	
	
    $account = getAccountDetails();
    $accountUrl = $account['Url'];
	//echo "<pre>";
	//print_r($account);
    //$eventsResult = getEventsList(); 
	 global $waApiClient;
       global $accountUrl;
   
     
    $contactsResult = getContactsList(); 
    $contacts =  $contactsResult['Contacts'];
	//echo'gfxjg';
	//echo "<pre>";
// print_r($contacts);

	//$wa_contacts = [];
	if($name && $fname){
		
						foreach($contacts as $key => $value){
			if($name == $value['LastName'] && $fname == $value['FirstName']){
			
			  $url = $accountUrl . '/eventregistrations?contactId='.$value['Id'];
      $eventsResult =  $waApiClient->makeRequest($url);
	  foreach($eventsResult as $key => $value1){
		 
		 $data1[] = $value1['Event']['Name']; 
		 $data2[] = $value1['RegistrationDate']; 
		
	  }
	   
		 $data1;
//print_r($data1);
			$data = [];
			$data['Id'] = $value['Id'];
			$data['Email'] = $value['Email'];
			$data['FirstName'] = $value['FirstName'];
			$data['FirstName'] = $value['FirstName'];
			$data['LastName'] = $value['LastName'];
			//$data['Email'] = $value['Email'];
			$data['Organization'] = $value['Organization'];
			$data['MembershipLevel'] = $value['MembershipLevel']['Name'];
			$data['events'] = $data1;
			$data['RegistrationDate'] = $data2;
			//$data['expirationDate'] = $value['FieldValues'][31]['Value'];	

		$wa_contacts[] = $data;
			}
			
			
			
	}
				
			}
			else{
				if($name){
					$name;
				}
				else{
				$name = 'NULL';	
				}
				if($fname){
					$fname;
				}
				else{
				$fname = 'NULL';	
				}
				
				
					foreach($contacts as $key => $value){
			if($name == $value['LastName'] || $fname == $value['FirstName'] || $name == $value['FirstName'] || $fname == $value['LastName']){
			  $url = $accountUrl . '/eventregistrations?contactId='.$value['Id'];
      $eventsResult =  $waApiClient->makeRequest($url);
	  foreach($eventsResult as $key => $value1){
		 
		 $data1[] = $value1['Event']['Name']; 
		$data2[] = $value1['RegistrationDate'];
	  }
	  
		 $data1;
//print_r($data1);
			$data = [];
			$data['Id'] = $value['Id'];
			$data['Email'] = $value['Email'];
			$data['FirstName'] = $value['FirstName'];
			$data['FirstName'] = $value['FirstName'];
			$data['LastName'] = $value['LastName'];
			//$data['Email'] = $value['Email'];
			$data['Organization'] = $value['Organization'];
			$data['MembershipLevel'] = $value['MembershipLevel']['Name'];
			$data['events'] = $data1;
			$data['RegistrationDate'] = $data2;
			//$data['expirationDate'] = $value['FieldValues'][31]['Value'];	

		$wa_contacts[] = $data;
			}
			
			
			
	}	
				
				
		}

	//echo "<pre>";
	//print_r($wa_contacts); 
	

		//$_SESSION['wa_contacts'] = $wa_contacts;
		//echo "<pre>";
	////	print_r($wa_contacts);

//}

	}

 ?>

 	<?php if($wa_contacts){?>
	 <div class="offer_listing">

	 <?php

	// $userdata= $wa_contacts[$user_wa_contacts];
	 ?>
	<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>


<h2>Response</h2>

<table>
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Company</th>
    <th>Type of Membership</th>
    <th>Events being assigned to</th>
    <th>Events Registration Date</th>
  </tr>
  <?php
  // global $waApiClient;
       //$url = 'https://api.wildapricot.org/v2/Contacts/{52319995}/events';
     //  $response = $waApiClient->makeRequest($url); 
	   print_r($response); 
   foreach($wa_contacts as $userdata){ 
   $even = $userdata['events'];
   $RegistrationDate = $userdata['RegistrationDate'];
      ?>
  <tr>
    <td><?php echo $userdata['FirstName']; echo ' ',$userdata['LastName'];?></td>
    <td><?php echo $userdata['Email']; ?></td>
    <td><?php echo $userdata['Organization']; ?></td>
    <td><?php echo $userdata['MembershipLevel']; ?></td>
     <td><?php foreach($even as $eventdata){ echo $eventdata; echo "<br>";} ?></td>
     <td><?php foreach($RegistrationDate as $eventdate){ 
	 
	 
	 $timestamp = strtotime($eventdate);
echo $new_date_format = date('d-m-Y h:i a', $timestamp);
	 
	 echo "<br>";} ?></td>
  </tr>

  <?php } ?>
  </table>
	 </div>
	<?php }?>

</div>
</div>

						