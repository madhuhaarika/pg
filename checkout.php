<?php

    // Merchant Key and Salt as provided by Payu.
    $MERCHANT_KEY = "tGVTfd";
    $SALT = "VgeWh824uVGAkOOnuhB2bKKOs0AsqLSj";

    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

    $PAYU_BASE_URL = "https://test.payu.in";                // For Sandbox Mode
    // $PAYU_BASE_URL = "https://sandboxsecure.payu.in";    // For Sandbox Mode
    // $PAYU_BASE_URL = "https://secure.payu.in";           // For Live Mode

    $action = '';

    $posted = array();
    if(!empty($_POST)) {
        foreach($_POST as $key => $value) {
            $posted[$key] = $value;
        }
    }

    $formError = 0;

    if(empty($posted['txnid'])) {
        // Generate random transaction id
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    } else {
        $txnid = $posted['txnid'];
    }

    $hash = '';
    // Hash Sequence
    $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
    if(empty($posted['hash']) && sizeof($posted) > 0) {

        if(empty($posted['key']) || empty($posted['txnid']) || empty($posted['amount']) || empty($posted['firstname']) || empty($posted['email']) || empty($posted['phone']) || empty($posted['productinfo']) || empty($posted['surl']) || empty($posted['furl']) || empty($posted['service_provider']) ) {
            $formError = 1;
        } else {
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';

            foreach($hashVarsSeq as $hash_var) {
              $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
              $hash_string .= '|';
            }

            $hash_string .= $SALT;

            $hash = strtolower(hash('sha512', $hash_string));
            $action = $PAYU_BASE_URL . '/_payment';
        }
    } elseif(!empty($posted['hash'])) {
        $hash = $posted['hash'];
        $action = $PAYU_BASE_URL . '/_payment';
    }

?>
<html>

<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>PayUMoney Payment Gateway Integration in PHP Step by Step</title>
 <!-- Bootstrap CSS -->
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
 <!-- Include External CSS -->
 <link rel="stylesheet" href="inc/style.css" />
 <script>
  var hash = '<?php echo $hash ?>';

  function submitPayuForm() {
   if (hash == '') {
    return;
   }
   var payuForm = document.forms.payuForm;
   payuForm.submit();
  }
 </script>
</head>

<body onload="submitPayuForm()">
 <div class="container" style="background: #f2f2f2; padding-bottom:20px; border: 1px solid #d9d9d9; border-radius: 5px;">
  <div class="py-5 text-center">
   <h2> PayUMoney Payment Gateway Integration Checkout</h2>
   
  <?php if($formError) { ?>
   <div class="alert alert-danger align-items-center">Please fill all mandatory fields.</div>
  <?php } ?>
   <form action="<?php echo $action; ?>" method="post" name="payuForm">
   <div class="row">
    <div class="col-md-8">
     <div class="card p-3">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>" />
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <div class="row">
       <div class="col-md-6 mb-3">
        <label for="firstname">Firstname</label>
        <input name="firstname" class="form-control" value="<?php echo (empty($posted['firstname'])) ? 'madhu' : $posted['firstname']; ?>" placeholder="First Name" />
       </div>
       <div class="col-md-6 mb-3">
        <label for="lastname">Lastname</label>
        <input name="lastname" class="form-control" id="lastname" value="<?php echo (empty($posted['lastname'])) ? 'ss' : $posted['lastname']; ?>" placeholder="Last Name" />
       </div>
      </div>
      <div class="row">
       <div class="col-md-6 mb-3">
        <label for="email">Email</label>
        <input name="email" id="email" class="form-control" value="<?php echo (empty($posted['email'])) ? 'madhu189@gmail.com' : $posted['email']; ?>" placeholder="Email" />
       </div>
       <div class="col-md-6 mb-3">
        <label for="phone">Mobile number</label>
        <input name="phone" class="form-control" value="<?php echo (empty($posted['phone'])) ? '9566556795' : $posted['phone']; ?>" placeholder="Mobile number" />
       </div>
      </div>
      <div class="row">
       <div class="col-md-12 mb-3">
        <label for="address">Flat, House no. Area, Street, Sector, Village</label>
        <input name="address1" class="form-control" value="<?php echo (empty($posted['address1'])) ? 'gfdgdghdh' : $posted['address1']; ?>" placeholder="Full Address" />
       </div>
       <input type="hidden" name="surl" value="http://localhost/madhu/success.php" />
       <input type="hidden" name="furl" value="http://localhost/madhu/failure.php" />
       <input type="hidden" type="hidden" name="service_provider" value="payu_paisa" size="64" />
       <input type="hidden" name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" />
       <input type="hidden" name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" />
       <input type="hidden" name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" />
       <input type="hidden" name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" />
       <input type="hidden" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />
       <input type="hidden" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" />
      </div>

      <div class="row">
       <div class="col-md-6 mb-3">
        <label for="city">City</label>
        <input name="city" class="form-control" value="<?php echo (empty($posted['city'])) ? 'chennai' : $posted['city']; ?>" placeholder="City" />
       </div>
       <div class="col-md-6 mb-3">
        <label for="pincode">Pin code</label>
        <input name="zipcode" class="form-control" value="<?php echo (empty($posted['zipcode'])) ? '605023' : $posted['zipcode'] ?>" placeholder="Pincode" />
       </div>
      </div>
     </div>
    </div>
    <div class="col-md-4">
                  
     
     <ul class="list-group mb-3 sticky-top">
     
      <li class="list-group-item d-flex justify-content-between">
       <strong> Order Total: </strong>
       
       <input type="hidden" name="amount" value="1" />
       <input type="hidden" name="productinfo" value="dummyprdt" />
      </li>
     </ul>
     
     <?php if(!$hash) { ?>
      <div class="row">
       <div class="col-md-12 mb-3">
        <button type="submit" class="btn-submit btn-block text-white">Continue to checkout</button>
       </div>
      </div>
     <?php } ?>
    </div>
   </div>
  </form>
 </div>
</body>
</html>