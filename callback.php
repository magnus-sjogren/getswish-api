<?php
session_start();

$_SESSION[$_POST["transactionId"]] = $_POST["status"];
echo '{"transationId":"' . $_POST["transactionId"] . '", "status":"' . $_SESSION[$_POST["transactionId"]] . '"}';
?>