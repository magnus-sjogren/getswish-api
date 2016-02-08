<h1>Hello world!</h1>
<?php



function createPayment($paymentReference, $payerAlias, $amount, $message, $config){
	try{

		if($payerAlias != ""){

			$data = array("payeePaymentReference" => $paymentReference,
				"callbackUrl" => $config["callbackUrl"],
				"payerAlias" => $payerAlias, //"46720000001",
				"payeeAlias" => $config["payeeAlias"],
				"amount" => $amount, 
				"currency" => $config["currency"],
				"message" => $message);

		}else{
			
			$data = array("payeePaymentReference" => $paymentReference,
				"callbackUrl" => $config["callbackUrl"],
				"payeeAlias" => $config["payeeAlias"],
				"amount" => $amount, 
				"currency" => $config["currency"],
				"message" => $message);

		}

		$data_string = json_encode($data);

		//Debug: request body
		echo "<h2>Sent data:</h2>" . "<pre>" . $data_string . "</pre>" . "<hr>";

		$ch = curl_init('https://mss.swicpc.bankgirot.se/swish-cpcapi/api/v1/paymentrequests/'); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Uncomment this if you didn't add the root CA, curl will then ignore the SSL verification error.
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)) );

		curl_setopt($ch, CURLOPT_CAINFO,  $config["CAINFO"]);
		curl_setopt($ch, CURLOPT_SSLCERT,  $config["SSLCERT"]);
		curl_setopt($ch, CURLOPT_SSLKEY,  $config["SSLKEY"]);
		curl_setopt($ch, CURLOPT_SSLCERTPASSWD,  $config["SSLCERTPASSWD"]);
		curl_setopt($ch, CURLOPT_SSLKEYPASSWD,  $config["SSLKEYPASSWD"]);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$result = curl_exec($ch);

		//Debug: result, including headers
		echo "<h2>Result</h2>";
		echo "<pre>";
		echo $result;
		echo "</pre>";
		echo "<pre>";
		echo "CURLINFO_EFFECTIVE_URL: " . curl_getinfo($ch, CURLINFO_EFFECTIVE_URL) . "\n";
		echo "CURLINFO_HTTP_CODE: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
		echo "CURLINFO_SSL_VERIFYRESULT: " . curl_getinfo($ch, CURLINFO_SSL_VERIFYRESULT) . "\n";
		echo "CURLINFO_HEADER_SIZE: " . curl_getinfo($ch, CURLINFO_HEADER_SIZE) . "\n";

		echo "</pre>";

		if (FALSE === $result)
		        throw new Exception(curl_error($ch), curl_errno($ch));

	} catch(Exception $e) {

	    trigger_error(sprintf(
	        'Curl failed with error #%d: %s',
	        $e->getCode(), $e->getMessage()),
	        E_USER_ERROR);

	}
	curl_close($ch);


}



function getPayment($paymentId, $config){
	try{

		if($paymentId != ""){

			$ch = curl_init('https://mss.swicpc.bankgirot.se/swish-cpcapi/api/v1/paymentrequests/' . $paymentId); 
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Uncomment this if you didn't add the root CA, curl will then ignore the SSL verification error.

			curl_setopt($ch, CURLOPT_CAINFO,  $config["CAINFO"]);
			curl_setopt($ch, CURLOPT_SSLCERT,  $config["SSLCERT"]);
			curl_setopt($ch, CURLOPT_SSLKEY,  $config["SSLKEY"]);
			curl_setopt($ch, CURLOPT_SSLCERTPASSWD,  $config["SSLCERTPASSWD"]);
			curl_setopt($ch, CURLOPT_SSLKEYPASSWD,  $config["SSLKEYPASSWD"]);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_HEADER, 1);

			$result = curl_exec($ch);

			//Debug: response, including headers
			echo "<h2>Result</h2>";
			echo "<pre>";
			var_dump($result);
			echo "</pre>";
			echo "<hr>";
			echo "<pre>";
			echo $result;
			echo "</pre>";
			echo "<pre>";
			echo "CURLINFO_EFFECTIVE_URL: " . curl_getinfo($ch, CURLINFO_EFFECTIVE_URL) . "\n";
			echo "CURLINFO_HTTP_CODE: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
			echo "CURLINFO_SSL_VERIFYRESULT: " . curl_getinfo($ch, CURLINFO_SSL_VERIFYRESULT) . "\n";
			echo "CURLINFO_HEADER_SIZE: " . curl_getinfo($ch, CURLINFO_HEADER_SIZE) . "\n";

			echo "</pre>";
		}else{
			echo "No payment ID specified";
		}

		if (FALSE === $result)
		        throw new Exception(curl_error($ch), curl_errno($ch));

	} catch(Exception $e) {

	    trigger_error(sprintf(
	        'Curl failed with error #%d: %s',
	        $e->getCode(), $e->getMessage()),
	        E_USER_ERROR);

	}
	curl_close($ch);


}

// Globals
$config = array(
	"callbackUrl" => "https://example.com/api/swishcb/paymentrequests",
	"payeeAlias" => "1231181189",
	"currency" => "SEK",

	"CAINFO" => 'C:\wamp\bin\apache\apache2.4.9\conf\ssl\ca.pem', //Path to root CA
	"SSLCERT" => 'C:\wamp\bin\apache\apache2.4.9\conf\ssl\client.pem', //Path to client certificate
	"SSLKEY" => 'C:\wamp\bin\apache\apache2.4.9\conf\ssl\key.pem', //Path to private key
	"SSLCERTPASSWD" => 'swish', //Password for client certificate, if it's protected
	"SSLKEYPASSWD" => 'swish' //Password for private key password, if it's protected
);

// createPayment("davidBet01", "", "2435", "Test 1", $config);
getPayment("7452784219594AA89AF511CED4ED03DA", $config);


// Location: http://172.31.21.186:8580/swish-cpcapi/api/v1/paymentrequests/7452784219594AA89AF511CED4ED03DA
// PaymentRequestToken: dFJ4QhlZSqia9RHO1O0D2qHbaGzSjYVz

?>