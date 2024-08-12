<?php
$logFile = 'payu_logs.txt';
$logData = print_r($_GET, true) . print_r($_POST, true);
file_put_contents($logFile, $logData, FILE_APPEND);

    $status = $_POST["status"];
    $amount = $_POST["amount"];
    $txnid = $_POST["txnid"];
    $firstname = $_POST["firstname"];
    $posted_hash = $_POST["hash"];
    $key = $_POST["key"];
    $productinfo = $_POST["productinfo"];
    $email = $_POST["email"];

    $salt="VgeWh824uVGAkOOnuhB2bKKOs0AsqLSj";


    // Salt should be same Post Request 

    If (isset($_POST["additionalCharges"])) {
        $additionalCharges = $_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
    } else {
        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
    }

    $hash = hash("sha512", $retHashSeq);

    if ($hash != $posted_hash) {
        echo "Invalid Transaction. Please try again";
    } else {
        echo "<h3>Your order status is ". $status .".</h3>";
        echo "<h4>Your transaction id for this transaction is ".$txnid.". You may try making the payment by clicking the link below.</h4>";    
    }

?>