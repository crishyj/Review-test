<?php
require_once 'MysqliDb.php';
// $db = new MysqliDb('localhost', 'pallel29_lin', 'J]H?]h_&Vb3*', 'pallel29_smileyrating');
$db = new MysqliDb('localhost', 'root', '', 'pallel29_smileyrating');
$db1 = new MysqliDb('localhost', 'root', '', 'pallel29_c7nordiccall_dk');
date_default_timezone_set('Europe/Copenhagen');
define('GLOBAL_BRAND', '_Global');
define('REVIEW_URL', 'http://smileyrating.dk/review.php?id=');
$reminder_msg_1=array(
    'Denmark' => 'SMS for reminder1(Denmark)[brand]',
    'Sweden' => 'SMS for reminder1(Sweden)[brand]',
    'Norway' => 'SMS for reminder1(Norway)[brand]',
);
$reminder_msg_2=array(
    'Denmark' => 'SMS for reminder2(Denmark)[brand]',
    'Sweden' => 'SMS for reminder2(Sweden)[brand]',
    'Norway' => 'SMS for reminder2(Norway)[brand]',
);
$feedback_title = array(
    'Denmark' => 'Tilfredshedsundersøgelse for [brand]',
    'Sweden' => 'Leave Feedback(Sweden)',
    'Norway' => 'Leave Feedback(Norway)',
);
$feedback_titles = array(
    'Denmark' => 'Hvordan vil du bedømme den samtale, du netop har haft med [brand]',
    'Sweden' => 'Leave Feedback(Sweden)',
    'Norway' => 'Leave Feedback(Norway)',
);
$feedback_happy = array(
    'Denmark' => '<center><strong>Det var en god oplevelse</strong><br>Imødekommende, professionel og venlig. Godt arbejde!1<center>',
    'Sweden' => '<center><strong>Det var en bra upplevelse</strong><br>välkomnande, professionella och vänliga. Bra jobb!<center>',
    'Norway' => '<center><strong>Det var en god opplevelse</strong><br>innbydende, profesjonell og vennlig. Bra jobb!<center>',
);
$feedback_sad = array(
    'Denmark' => '<center><strong>Desværre, dårligt</strong><br>Samtalen levede desværre ikke op til mine forventninger.<center>',
    'Sweden' => 'I am sad.(Sweden)',
    'Norway' => 'I am sad.(Norway)',
);
$feedback_invalid = array(
    'Denmark' => 'Hvis du har en kommentar til [brand], så skriv den gerne her',
    'Sweden' => 'Write feedback.(Sweden)',
    'Norway' => 'Write feedback.(Norway)',
);
$feedback_placeholder = array(
    'Denmark' => 'Hvis du har en kommentar til [brand], så skriv den gerne her',
    'Sweden' => 'Write feedback here...(Sweden)',
    'Norway' => 'Write feedback here...(Norway)',
);
$feedback_back = array(
    'Denmark' => 'Tilbage',
    'Sweden' => 'Back(Sweden)',
    'Norway' => 'Back(Norway)',
);
$feedback_submit = array(
    'Denmark' => 'Godkend',
    'Sweden' => 'Submit(Sweden)',
    'Norway' => 'Submit(Norway)',
);
$feedback_thanks = array(
    'Denmark' => 'Mange tak for din feedback.<br>Rigtig god <br> Med venlig hilsen<br><br> [brand]',
    'Sweden' => 'Thank you for your feedback. (Sweden)',
    'Norway' => 'Thank you for your feedback. (Norway)',
);
$feedback_duplicate = array(
    'Denmark' => 'Tak - Du har allerede givet os din feedback.<br>Det er vi rigtige glade for<br>Rigtig god <br> Med venlig hilsen<br><br> [brand] [day]',
    'Sweden' => 'You had left feedback already. (Sweden)',
    'Norway' => 'You had left feedback already. (Norway)',
);


function sendSMS($to, $msg, $from)
{
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
        return true;
    } else {
        echo 'Read response message for details: ' . $response;
        return false;
    }
}
