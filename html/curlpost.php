 <?php $curl = curl_init();

 	ini_set('display_errors', 1);
 	ini_set('display_startup_errors', 1);
 	error_reporting(E_ALL);



	function cypher($r, $l, $v) {
		$output = false;
		$encrypt_method = 'AES-256-CBC';
		$output = openssl_encrypt($r, $encrypt_method, $l, 0, $v);		
		return base64_encode($output);
	}

 	$logon['username'] = cypher('giovanni.finetto@fidemsrl.it', "6a223d312e3ffc554882f067bf36e090ba86ee88d50af394ee09905e6aba58b1", "6a223d312e3ffc55");
 	$logon['password'] = cypher('asdf', "6a223d312e3ffc554882f067bf36e090ba86ee88d50af394ee09905e6aba58b1", "6a223d312e3ffc55");

 	if($logon != array()) {
		$auth = base64_encode(implode(",", $logon));
		$param[0] = "auth";
		$param[1] = $auth;
	}


	$targetUri = "http://hpvm.multimediatrader.com/ws.php";
 	curl_setopt_array($curl, array(
		CURLOPT_URL => $targetUri,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"".$param[0]."\"\r\n\r\n".$param[1]."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"authorization: Basic YWRtaW5fb3duZXI6d3NpYmN4MTg=",
			"cache-control: no-cache",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	));



 	// Response o Errore
	$response = curl_exec($curl);
	$err = curl_error($curl);

	// Chiusura curl
	curl_close($curl);

	// Gestione Errore o JSON Risposta
	if($err) {
		$error = array("cURL Error" => "#:".$err);
		echo json_encode($error);
	} else {
		echo "CURL_POST: ".$response; // JSON Response object
		if (preg_match('/logged in/', $response, $match)) {
			include('curlget.php');
			//print_r($match);
		}
	}

 ?>