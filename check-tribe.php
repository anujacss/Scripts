<?php


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://community.sanctionsassociation.org/api/v1/oauth/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "grant_type=password&client_id=5ea402acb923a239c3db07f8-vIF5N4dRAxnZSyubLFWEQAwbZvJFHkol&client_secret=04QxqvnX1OcNWfquugPgQjesSdGLWWl4tNBRqVMl38eg0zyG3L8BxzHFaQBCnLKP&username=anuj_nagpal&password=Google@%21123",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response,true);

echo $bearer_token = $response['access_token'];







/*






$row = 1;
//$skip = 172;

if (($handle = fopen('trib.csv', "r")) !== FALSE) {
    for ($a = 0; $a < '680'; $a++) {
        fgets($handle);
    }
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		
		$number[] = $data;
	
		
    }
    fclose($handle);
}


foreach($number as $userdata){
	 $fname = $userdata[0];
$fname1 = str_replace(' ', '_', $fname);
	 $lname = $userdata[1];
	 $lname1 = str_replace(' ', '_', $lname);
	 $lname1 = htmlentities($lname1);
	 $fname1 = htmlentities($fname1);
	 $email = $userdata[2];
	 	 $fname = htmlentities($fname);
	 $lname = htmlentities($lname);
	 $org = $userdata[3];
echo "hlll";*/
/*	$curl = curl_init();
  $content = json_encode(array("username" => $fname1.'_'.$lname1,"name" => $fname.' '.$lname,"email" => $email,"password" => 'ACss1234$', "role" => 'member'));
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://community.sanctionsassociation.org/api/v1/users",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $content,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
		"Authorization: Bearer $bearer_token",
  ),
));
*/
$curl = curl_init();
  $content = json_encode(array("username" => 'ankush_hh',"name" => 'dddd',"email" => 'ankush.swarnatek@gmail.com',"password" => 'ACss1234$', "role" => 'member'));
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://community.sanctionsassociation.org/api/v1/users",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $content,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
		"Authorization: Bearer $bearer_token",
  ),
));
echo $response = curl_exec($curl);

curl_close($curl);
$newArr1= json_decode($response, true); 
print_r($newArr1);
$user_id = $newArr1['id'];


	$curl = curl_init();
  $content = json_encode(array("title" => 'United Nations'));
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://community.sanctionsassociation.org/api/v1/users/$user_id",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => $content,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
		"Authorization: Bearer $bearer_token",
  ),
));

$response = curl_exec($curl);

curl_close($curl);
 $response;
/*}
	}
*/
?>



						