<?php
$to = '4528282835';
$msg = 'Test Message';
$from = 'Brand 1';
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.cpsms.dk/v2/send",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => '{"to":"' . $to . '", "message": "' . $msg . '", "from": "' . $from . '"}',
    CURLOPT_HTTPHEADER => array(
        "authorization: Basic bm9yZGljY2FsbDo2OTkxMmQ2Ny01ZWUxLTQ5NTMtYjg5MC03Nzc3NzQxMGQyMGQ="
    ),
));

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

if ($httpCode == 200) {
    echo 'OK: ' . $response;
} else {

    echo 'Read response message for details: ' . $response;
}
