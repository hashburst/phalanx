<?php $curl = curl_init();

	//print_r($_POST);	
	// Funzione che si occupa di cifrare con la chiave privata assegnata i parametri che compogono il POST
	function cypher($r, $l, $v) {
		$output = false;
		$encrypt_method = 'AES-256-CBC';
		$output = openssl_encrypt($r, $encrypt_method, $l, 0, $v);		
		return base64_encode($output);
	}
	
	$method = $_SERVER['REQUEST_METHOD'];
	$request = $_SERVER['REDIRECT_SCRIPT_URI'];
	$preset = array('nids'=>'nmap 192.168.1.0/24', 'nips'=>'nmap -A 192.168.1.0/24');
	
	$request_uri = "";
	$reg_string = "";
	$register = array();
	$logon = array();
	$param = array();
	$token = array();
	$login = false;
    $logout = false;
	$nids = @$_GET['nids'];
	$nips = @$_GET['nips'];

	foreach($_POST as $key => $value) {
		//echo $key."-->".$value."  :::  ";

		// Verifico che il POST sia di registrazione o di login
		if(count($_POST) > 2 ) {
			$register[$key] = cypher($value, "6a223d312e3ffc554882f067bf36e090ba86ee88d50af394ee09905e6aba58b1", "6a223d312e3ffc55");
			//echo $register[$key]."<br>";
		} elseif(count($_POST) == 2) {
			$logon[$key] = cypher($value, "6a223d312e3ffc554882f067bf36e090ba86ee88d50af394ee09905e6aba58b1", "6a223d312e3ffc55");
			//echo $logon[$key]."<br>";
		} elseif(count($_POST) == 1) {
			$logout = true;
	        }	
	}


	if($register != array()) {
		$reg_string = base64_encode(implode(",", $register));
		$param[0] = "register";
		$param[1] = $reg_string;
	}

	if($logon != array()) {
		$auth = base64_encode(implode(",", $logon));
		$param[0] = "auth";
		$param[1] = $auth;
	}

        if($logout === true) {
		$param[0] = "logout";
		$param[1] = "destroySession";
	}       


	if(isset($_GET['nips'])) {
		$token[$_GET['nips']] = cypher($preset[$_GET['nips']], "6a223d312e3ffc554882f067bf36e090ba86ee88d50af394ee09905e6aba58b1", "6a223d312e3ffc55");
		//echo $token[$_GET['nips']]."<br>";
	} else {
		$token[$_GET['nids']] = cypher($preset[$_GET['nids']], "6a223d312e3ffc554882f067bf36e090ba86ee88d50af394ee09905e6aba58b1", "6a223d312e3ffc55");
		//echo $token[$_GET['nids']]."<br>";
	}

	if ($token != array()) {
		$cli = base64_encode(implode(",", $token));
		$request_uri = "/probe/".$cli;
	} elseif (preg_match($token, $_SERVER['REQUEST_URI'])) {
		$request_uri = "transactionProcessing".$token;
	}

        /*
	echo "<br>REGISTER:<br>".$reg_string."<br>";	
 	echo "<br>AUTH:<br>".$auth."<br>";
 	echo "<br>";
        */

	// Verifica che il Web Server Remoto è raggiungibile, in caso contrario parte modalità off-line
	$wsUrl = "http://hpvm.multimediatrader.com/ws.php"; // Indirizzo sandbox per test

	$file_headers = get_headers($wsUrl);
	
	if(preg_match("/200/",$file_headers[0],$match))
	{
		if ($method == 'POST') {
			// Request alla url del Web Service Remoto se la VM non è isolata e ha accesso a internet
			$targetUri = $wsUrl;
		} elseif ($method == 'GET') {
			if (preg_match('/probe/', $request_uri, $matches)) {
				$targetUri = $wsUrl."/".$matches[0]."/".$matches[1];
			} elseif (preg_match('/transactionProcessing/', $request_uri, $matches)) {
				$targetUri = $wsUrl."/".$matches[0]."/".$matches[1];
			}
		}
	} else {
		if ($method == 'POST') {
			// Request alla url del Web Service Locale se la VM è isolata e dunque non esce dal perimetro della intranet
			$targetUri = "http://localhost/localservice/localservices.php"; // 192.168.1.3
		} elseif ($method == 'GET') {
			if (preg_match('/probe/', $request_uri, $matches)) {
				$targetUri = "http://localhost/localservice/localservices.php/".$matches[0]."/".$matches[1];
			} elseif (preg_match('/transactionProcessing/', $request_uri, $matches)) {
				$targetUri = "http://localhost/localservice/localservices.php/".$matches[0]."/".$matches[1];
			}
		}
	}

        /*
	echo "METHOD: \"".$method."\"<br>";
	echo "METHOD_CURL: \"".$method_curl."\"<br>";
	echo "REQUEST: \"".$request."\"<br>";
        */

	switch ($method) {
		case 'POST':
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
			break;
		case 'GET':
			curl_setopt_array($curl, array(
				CURLOPT_URL => $targetUri,
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
			break;

	}

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
		echo $response; // JSON Response object
		if (preg_match('/logged in/', $response, $match)) {
			$login = true;
			//print_r($match);
		}
	}
	
?>
