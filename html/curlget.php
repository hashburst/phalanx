 <?php $curl = curl_init();


 	ini_set('display_errors', 1);
 	ini_set('display_startup_errors', 1);
 	error_reporting(E_ALL);


/*
 	function cypher($r, $l, $v) {
		$output = false;
		$encrypt_method = 'AES-256-CBC';
		$output = openssl_encrypt($r, $encrypt_method, $l, 0, $v);		
		return base64_encode($output);
	}
*/


 	$cmd = "nmap 192.168.1.0/24";

 	$token = cypher($cmd, "6a223d312e3ffc554882f067bf36e090ba86ee88d50af394ee09905e6aba58b1", "6a223d312e3ffc55");

 	$cli = base64_encode($token);

 	$url = $targetUri."/probe/".$cli;

 	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_POSTFIELDS => "",
		CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
	  	),
	));

 	echo $url."&nbsp;";


 	// Response o Errore
	$response = curl_exec($curl);
	$err = curl_error($curl);

	// Chiusura curl
	curl_close($curl);

	// Gestione Errore o JSON Risposta
	if($err) {
		$error = array("cURL Error" => "#:".$err);
		echo json_encode($error);
		echo "::::::";
	} else {
		echo "CURL_GET: ".$response; // JSON Response object
		if (preg_match('/logged in/', $response, $match)) {
			$login = true;
			//print_r($match);
		}
	}

 ?>