<?php
session_start();

/*
{
	"errorCode":null,
	"errorMessage":null,
	"id":"B29892EB66884CFEB532EC29FC3C46A8",
	"payeePaymentReference":"DF16021201",
	"paymentReference":"8F129A492C7F4959BC10DAE0E859D132",
	"callbackUrl":"https://example.com/api/swishcb/paymentrequests",
	"payerAlias":"46700000000",
	"payeeAlias":"1231181189",
	"amount":100.00,
	"currency":"SEK",
	"message":"Test 1",
	"status":"PAID",
	"dateCreated":"2016-02-20T19:47:36.345Z",
	"datePaid":"2016-02-20T19:47:36.346Z"
}
*/

// $_SESSION[$_POST["transactionId"]] = $_POST["status"];
if (isset($_POST["errorCode"]) && 
	isset($_POST["errorMessage"]) && 
	isset($_POST["id"]) && 
	isset($_POST["payeePaymentReference"]) && 
	isset($_POST["paymentReference"]) && 
	isset($_POST["callbackUrl"]) && 
	isset($_POST["payerAlias"]) && 
	isset($_POST["payeeAlias"]) && 
	isset($_POST["amount"]) && 
	isset($_POST["currency"]) && 
	isset($_POST["message"]) && 
	isset($_POST["status"]) && 
	isset($_POST["dateCreated"]) && 
	isset($_POST["datePaid"])){

	$_SESSION[$_POST["id"]] = array(
		"errorCode" => $_POST["errorCode"],
		"errorMessage" => $_POST["errorMessage"],
		"id" => $_POST["id"],
		"payeePaymentReference" => $_POST["payeePaymentReference"],
		"paymentReference" => $_POST["paymentReference"],
		"callbackUrl" => $_POST["callbackUrl"],
		"payerAlias" => $_POST["payerAlias"],
		"payeeAlias" => $_POST["payeeAlias"],
		"amount" => $_POST["amount"],
		"currency" => $_POST["currency"],
		"message" => $_POST["message"],
		"status" => $_POST["status"],
		"dateCreated" => $_POST["dateCreated"],
		"datePaid" => $_POST["datePaid"]
	);

}

echo '{"transationId":"' . $_POST["id"] . '", "status":"' . $_SESSION[$_POST["id"]]["status"] . '"}';
?>