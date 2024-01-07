<?php 
    include('./config/config.php');

    $order_id = uniqid(); 

    $get_data_sql = mysqli_query($conn, "SELECT fullname, email, contact FROM users WHERE id = '". $_SESSION['id'] . "'");
    $get_data = mysqli_fetch_assoc($get_data_sql);

    $merchant_transaction_id = "MT7850590068188104"; //to be generated randomly
    $planId = $_POST['plan_id']; // amount in INR
    $get_plan_sql = mysqli_query($conn, "SELECT price, description FROM plan WHERE id = $planId");
    $get_plan_row = mysqli_fetch_assoc($get_plan_sql);

    $amount = $get_plan_row['price'];
    $description = $get_plan_row['description'];

    $paymentData = array(
        'merchantId' => PHONE_PE_MERCHANT_ID,
        'merchantTransactionId' => $merchant_transaction_id, // test transactionID
        "merchantUserId"=> $_SESSION['id'],
        'amount' => $amount*100,
        'redirectUrl'=> PHONE_PE_SUCCESS_URL,
        'redirectMode'=>"POST",
        'callbackUrl'=> PHONE_PE_SUCCESS_URL,
        "merchantOrderId"=> $order_id,
       "mobileNumber"=> $get_data['contact'],
       "message"=> $description,
       "email"=> $get_data['email'],
       "shortName"=> $get_data['fullname'],
       "paymentInstrument"=> array(    
        "type"=> "PAY_PAGE",
      )
    );

    $jsonencode = json_encode($paymentData);
    $payloadMain = base64_encode($jsonencode);

    $salt_index = PHONE_PE_KEY_INDEX;
    $payload = $payloadMain . "/pg/v1/pay" . PHONE_PE_API_KEY;
    $sha256 = hash("sha256", $payload);
    $final_x_header = $sha256 . '###' . $salt_index;
    $request = json_encode(array('request'=>$payloadMain));

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $request,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-VERIFY: " . $final_x_header,
            "accept: application/json"
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $res = json_decode($response);
    
        if(isset($res->success) && $res->success=='1'){
            $paymentCode=$res->code;
            $paymentMsg=$res->message;
            $payUrl=$res->data->instrumentResponse->redirectInfo->url;
            
            echo json_encode($payUrl);
        }
    }
?>