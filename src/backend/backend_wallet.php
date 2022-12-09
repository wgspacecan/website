<?php

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'http://cardano-wallet:8090/v2/wallets/39fcb465f58313308733a20cbc0c16d80c803e77',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'GET',
CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
),
));

$response = curl_exec($curl);

curl_close($curl);

$obj = json_decode($response);

#echo $response;

echo "wallet: " . $obj->{'name'};

$bal = $obj->{'balance'};
echo "<br>ballance: " . $bal->{'available'}->{'quantity'};

?>