<?php
clearstatcache();
ob_start();
session_start();
  	if(empty($_SESSION['wa_contacts'])){
    $waApiClient = WaApiClient::getInstance();
    
    $waApiClient->initTokenByApiKey('s4qe2842k599yaiws14s9ty7w0x1ty');
  	
	
    $account = getAccountDetails();
    $accountUrl = $account['Url'];
    
    $contactsResult = getContactsList(); 
    $contacts =  $contactsResult['Contacts'];
	
	
 //print_r($contacts);
	//$wa_contacts = [];
	
		foreach($contacts as $key => $value){
			$data = [];
			$data['FirstName'] = $value['FirstName'];
			$data['LastName'] = $value['LastName'];
			$data['Email'] = $value['Email'];
			$data['Organization'] = $value['Organization'];
			$data['expirationDate'] = $value['FieldValues'][32]['Value'];
			
			$data['MembershipLevel'] = $value['MembershipLevel']['Id'];	

		$wa_contacts[] = $data;
	}

		$_SESSION['wa_contacts'] = $wa_contacts;
		//echo "<pre>";
		//print_r($wa_contacts);

}

/****************************Litmos*********************************/

if(empty($_SESSION['litmos_contacts'])){

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.litmos.com/v1.svc/users?apikey=3B47E4B8-2DA6-4832-B82F-D81ABAE7110A&source=MY-APP&limit=1000");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


$headers = array();
$headers[] = "Accept: */*";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Cache-Control: no-cache";
$headers[] = "Connection: keep-alive";
$headers[] = "Host: api.litmos.com";
$headers[] = "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A";
$headers[] = "cache-control: no-cache";


curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

	$_SESSION['litmos_contacts'] = $result;
	//print_r($result);
}


/****************************Litmos Api *****************************************************/

function litmos_log($logg){

	$log  = 'Time: '.date("F j, Y, g:i a").PHP_EOL;
	$log  .= $logg;
	$log  .= '___________________________'.PHP_EOL;
	
	if (!file_exists('logs')) {
		mkdir('logs', 0777, true);
	}
	//Save string to log, use FILE_APPEND to append.
	file_put_contents('logs/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
	
}



function getTeamUsers($team){
	$team;
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.litmos.com/v1.svc/teams/$team/users?apikey=3B47E4B8-2DA6-4832-B82F-D81ABAE7110A&source=MY-APP&limit=1000");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


$headers = array();
$headers[] = "Accept: */*";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Cache-Control: no-cache";
$headers[] = "Connection: keep-alive";
$headers[] = "Host: api.litmos.com";
$headers[] = "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A";
$headers[] = "cache-control: no-cache";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
	return json_decode($result,true);

	
}
function getUser($id){

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.litmos.com/v1.svc/users/$id?source=MY-APP&limit=1000");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


	$headers = array();
$headers[] = "Accept: */*";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Cache-Control: no-cache";
$headers[] = "Connection: keep-alive";
$headers[] = "Host: api.litmos.com";
$headers[] = "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A";
$headers[] = "cache-control: no-cache";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
	return json_decode($result,true);

}

function addUserToTeam($userId){
  $userId;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.litmos.com/v1.svc/teams/G5ZFsJKLTpc1/users?source=MY-APP",
    CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<Users>  \r\n   <User>  \r\n   <Id>".$userId."</Id>\r\n   </User> \r\n   </Users>",
		   CURLOPT_HTTPHEADER => array(
			 "Content-Type: application/xml",
            "Accept-Encoding: gzip, deflate",
        		"Connection: keep-alive",
  		  "Host: api.litmos.com",
   		  "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A",
   		 "cache-control: no-cache"
		  ),
		));

		 $response = curl_exec($curl);
		 $err = curl_error($curl);

		curl_close($curl);


}

function addUserToTeam2($userId){
  $userId;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.litmos.com/v1.svc/teams/cNydBDNYDCE1/users?source=MY-APP",
    CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<Users>  \r\n   <User>  \r\n   <Id>".$userId."</Id>\r\n   </User> \r\n   </Users>",
		   CURLOPT_HTTPHEADER => array(
			 "Content-Type: application/xml",
            "Accept-Encoding: gzip, deflate",
        		"Connection: keep-alive",
  		  "Host: api.litmos.com",
   		  "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A",
   		 "cache-control: no-cache"
		  ),
		));

		 $response = curl_exec($curl);
		 $err = curl_error($curl);

		curl_close($curl);


}



function UpdateExpirationdate($user,$expirationdate){
	$curl = curl_init();

	$u_id = $user['Id'];
	curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.litmos.com/v1.svc/users/$u_id?apikey=3B47E4B8-2DA6-4832-B82F-D81ABAE7110A&source=MY-APP",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "PUT",
	  CURLOPT_POSTFIELDS => "<User>\r\n\t<Id>".$user['Id']."</Id> \r\n\t<UserName>".$user['UserName']."</UserName> \r\n\t<FirstName>".$user['FirstName']."</FirstName> \r\n\t<LastName>".$user['LastName']."</LastName> \r\n\t<FullName></FullName> \r\n\t<Email>".$user['Email']."</Email> \r\n\t<Active>true</Active> \r\n\t<ExpirationDate>".$expirationdate."</ExpirationDate>\r\n</User>\r\n",
	  CURLOPT_HTTPHEADER => array(
		 "Accept: */*",
    "Accept-Encoding: gzip, deflate",
     "Connection: keep-alive",
    "Host: api.litmos.com",
    "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A",
    "cache-control: no-cache"
	  ),
	));

	$response = curl_exec($curl);

	$err = curl_error($curl);

}


function createUserLitmos($wa_apricot){


        // Assign password to users
        $user_password = 'ACss1234$';

	/*	$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://api.litmos.com/v1.svc/users?apikey=3B47E4B8-2DA6-4832-B82F-D81ABAE7110A&source=MY-APP",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "<User> \r\n<Id></Id> \r\n<UserName>".$wa_apricot['Email']."</UserName> \r\n<FirstName>".$wa_apricot['FirstName']."</FirstName> \r\n<LastName>".$wa_apricot['LastName']."</LastName> \r\n<FullName></FullName> \r\n<Email>".$wa_apricot['Email']."</Email> \r\n<AccessLevel>Learner</AccessLevel> \r\n<DisableMessages>false</DisableMessages> \r\n<Active>true</Active> \r\n<LastLogin></LastLogin> \r\n<LoginKey></LoginKey> \r\n<IsCustomUsername>false</IsCustomUsername> \r\n<Password>".$user_password."</Password> \r\n<SkipFirstLogin>true</SkipFirstLogin> \r\n<TimeZone></TimeZone>\r\n<CompanyName>".$wa_apricot['Organization']."</CompanyName> \r\n<ExpirationDate>".$wa_apricot['expirationDate']."</ExpirationDate>\r\n</User>",
				  CURLOPT_HTTPHEADER => array(
					"Content-Type: application/xml",
					"Postman-Token: 1756e488-a0fa-49b7-854b-d3db34e050d1",
    "Accept-Encoding: gzip, deflate",
    "Connection: keep-alive",
    "Host: api.litmos.com",
    "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A",
    "cache-control: no-cache"
				  ),
				));

					$response = curl_exec($curl);
	
	print_r($response);
	
					$err = curl_error($curl);
                       
 					curl_close($curl);
	
				return Xml2Array($response);
				*/
				
	//print_r($wa_apricot);			
	  $org = htmlentities( $wa_apricot['Organization'] ); 			
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.litmos.com/v1.svc/users?source=MY-APP",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>" <User>\r\n	<Id></Id>\r\n        <UserName>".$wa_apricot['Email']."</UserName>\r\n        <FirstName>".$wa_apricot['FirstName']."</FirstName>\r\n        <LastName>".$wa_apricot['LastName']."</LastName>\r\n 	<Email>".$wa_apricot['Email']."</Email>\r\n        <AccessLevel>Learner</AccessLevel>\r\n <Active>true</Active>\r\n   <Password>".$user_password."</Password>\r\n <SkipFirstLogin>true</SkipFirstLogin>\r\n	<CompanyName>".$org."</CompanyName>\r\n  <CustomField1>".$wa_apricot['MembershipLevel']."</CustomField1>\r\n </User>",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/xml",
    "Accept-Encoding: gzip, deflate",
    "Connection: keep-alive",
    "Host: api.litmos.com",
    "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A",
    "cache-control: no-cache"
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
 return $response;

	
				
/*				
				
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.litmos.com/v1.svc/users?source=MY-APP");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_ENCODING, "");
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, "<User> \r\n<Id></Id> \r\n<UserName>".$wa_apricot['Email']."</UserName> \r\n<FirstName>".$wa_apricot['FirstName']."</FirstName> \r\n<LastName>".$wa_apricot['LastName']."</LastName> \r\n<FullName></FullName> \r\n<Email>".$wa_apricot['Email']."</Email> \r\n<AccessLevel>Learner</AccessLevel> \r\n<DisableMessages>false</DisableMessages> \r\n<Active>true</Active> \r\n<LastLogin></LastLogin> \r\n<LoginKey></LoginKey> \r\n<IsCustomUsername>false</IsCustomUsername> \r\n<Password>".$user_password."</Password> \r\n<SkipFirstLogin>true</SkipFirstLogin> \r\n<TimeZone></TimeZone>\r\n<CompanyName>".$wa_apricot['Organization']."</CompanyName> \r\n<ExpirationDate>".$wa_apricot['expirationDate']."</ExpirationDate>\r\n</User>");
	


$headers = array();
$headers[] = "Content-Type: text/xml";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Connection: keep-alive";
$headers[] = "Host: api.litmos.com";
$headers[] = "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A";
$headers[] = "cache-control: no-cache";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	print_r($result);
	curl_close ($ch);
	return json_decode($result,true);
				
				
				
*/				
				
}


/************************************Helper-fns**********************************************/
function Xml2Array($xmlString){
		$xml = new SimpleXMLElement($xmlString);
		return $xml;
}



function searchLitmosEmail($email){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.litmos.com/v1.svc/users?apikey=3B47E4B8-2DA6-4832-B82F-D81ABAE7110A&source=MY-APP&search=$email");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


		$headers = array();
$headers[] = "Accept: */*";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Cache-Control: no-cache";
$headers[] = "Connection: keep-alive";
$headers[] = "Host: api.litmos.com";
$headers[] = "apikey: 3B47E4B8-2DA6-4832-B82F-D81ABAE7110A";
$headers[] = "cache-control: no-cache";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result1 = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
	
		if($result1){
			/*$result = json_decode($result,true);
				return @$result[0];*/
					$new = simplexml_load_string($result1); 
				$con = json_encode($new); 
  				$newArr1= json_decode($con, true); 
				 foreach($newArr1 as $key => $value1){
		 return  $result = $value1['UserName'];
		 
			  }
		}else{
				
			return false;
		}
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

		<label for="Email">Enter email: </label>
		<input type="Email" class="input" placeholder="" name="Email" />
		<button style="" type="submit" name="submit">Search</button>
	

	</form>
</div>


<?php
	 
	$litmos_contacts =json_decode($_SESSION['litmos_contacts'],true);
	//print_r($litmos_contacts);
	$wa_contacts = $_SESSION['wa_contacts'];
	//$teamA = getTeamUsers('G5ZFsJKLTpc1');
	//$teamB = getTeamUsers('cNydBDNYDCE1');
	$user_name =trim(@$_REQUEST['Email']);
	$render = false;
session_destroy();
	if(isset($_POST['submit'])){
		

		if(!empty($user_name)){
	
		$user_wa_contacts = array_search($user_name, array_column($wa_contacts, 'Email'));
		$user_records = $wa_contacts[$user_wa_contacts];


		if(is_int($user_wa_contacts)){
			
			$litmoss = searchLitmosEmail($user_name);
		
			echo '<div class="success_msg yes"><span>&#10004;</span>User Found in WildApricot</div>';

			if(!$litmoss){
				
				$render=true;

				if(!empty($user_records)){

				$newuser = createUserLitmos($user_records);
				
				if(!empty($newuser)){	
			
				$new = simplexml_load_string($newuser); 
				$con = json_encode($new); 
  				$newArr[] = json_decode($con, true); 
				
				 foreach($newArr as $key => $value1){
		  $dataid = $value1['Id'];
		  $data1 = $value1['OriginalId']; 
			  }
		
		if($data1){					
							addUserToTeam($dataid);
							addUserToTeam2($dataid);
							//addUserToTeam('cNydBDNYDCE1',$newuser->Id);
							$html = 'User Added to Litmos';
							$html1 = 'User added to Teams';
					        echo '<div class="success_msg yes "><span>&#10004;</span>'.$html.'</div>';
							 echo '<div class="success_msg yes"><span>&#10004;</span>'.$html1.'</div>';
					        ?>
							<style>
					        	.aaavailable-wildapricot{display:none !important;}

					        </style><?php

		}
		else{
			echo '<div class="mydiv no"><span>&#10006;</span>User not added. Please contact Administrator.</div>';
			
		}
		
		
				}
			}


			}else{

				echo '<div class="mydiv no"><span>&#10006;</span>User already exists in Litmos</div>';
			}

			} else {
				echo '<div class="mydiv no"><span>&#10006;</span>User not exists in wildapricot</div>';
			}

		}
		else{

			echo '<div class="mydiv no"><span>&#10006;</span>Please Enter Email</div>';

		}
	}

 ?>

 	<?php if($render){?>
	 <div class="offer_listing">

	 <?php

	 $userdata= $wa_contacts[$user_wa_contacts];
	 ?>
	 <h2>First Name: <?php echo $userdata['FirstName']; ?></h2> <br>
	 <h2>Last Name: <?php echo $userdata['LastName']; ?></h2> <br>
	 <h2>Email: <?php echo $userdata['Email']; ?></h2> <br>
	 <h2>Company: <?php echo $userdata['Organization']; ?></h2> <br>

	 </div>
	<?php }?>

</div>
</div>
<style type="text/css">

.yes span {
    font-size: 23px;
    margin-right: 10px;
}
.no span {
    font-size: 23px;
    margin-right: 10px;color: red;
}
body{background: #f5f5f5;}
.search-section {
	font-size: 18px;
}
.wrap {
    padding: 5% 0% 5% 5%;
}
.search-section input.input {
    width: 30%;
    height: 35px;
}
.search-section  button {
    background: black;
    color: #fff;
    padding: 10px;
    width: 130px;
    margin-left: 15px;
    border: 0px;
    font-size: 15px;
    cursor: pointer;
    border-radius: 8px;
}
.search-section {
    margin-bottom: 25px;
    border: 1px solid #ccc;
    padding: 40px;
    background: #f5f5f5;
    border-radius: 5px;
    width: 90%;
}
.mydiv {
   
    width: 47%;
    text-align: center;
    padding: 7px;
    border-radius: 3px;
    color: red;
    font-size: 18px;
    margin-left: 20%;
    margin-top: 10px;
}
.offer_listing {
	margin-bottom: 25px;
    border: 1px solid #ccc;
    padding: 44px;
    background: #f5f5f5;
    border-radius: 5px;
    width: 41%;
    text-align: center;
    margin-top: 13px;
    margin-left: 20%;
}
.offer_listing h2 {
    font-size: 16px;
    padding: 0px;
    margin: 0px;
    font-weight: 500;
}
.available-wildapricot {
    background: green;
    width: 47%;
    text-align: center;
    padding: 7px;
    border-radius: 3px;
    color: white;
    font-size: 18px;
    margin-left: 20%;
}
.success_msg {
    text-align: center;
    padding-top: 20px;
    color: green;
    font-size: 22px;
    margin-right: 122px;
}
</style>
						