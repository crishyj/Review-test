<?php
if (isset($_GET['phone']) &&  isset($_GET['brand'])) {
    $phone = $_GET['phone'];
    if (strlen($phone) < 10) {
        echo 'error 1';
        exit;
    }
    $countries = array('+45' => 'Denmark', '+46' => 'Sweden', '+47' => 'Norway',);
    var_dump(substr($phone, 0, 3));
    if (!array_key_exists(substr($phone, 0, 3), $countries)) {
        echo 'error 2';
        exit;
    }
    $country = $countries[substr($phone, 0, 3)];
    $phone = substr($phone, 1);
    require_once 'database.php';
    $db->where("brand_title", $_GET['brand']);
    $brand = $db->getOne("brands");
    if ($brand == null) {
        $brand = array(
            'brand_title' => $_GET['brand'],
            'must_send_customer' => 'Yes',
            'must_send_reminder_1' => 'No',
            'reminder_phone_1' => '',
            'must_send_reminder_2' => 'No',
            'reminder_phone_2' => '',
            'email' => '',
            'email_frequency' => 'New Review',
        );
    }
    $logData = array(
        'brand_title' => $brand['brand_title'],
        'customer_phone' => $phone,
        'customer_country' => $country,
        'must_send_customer' => $brand['must_send_customer'],
        'must_send_reminder_1' => $brand['must_send_reminder_1'],
        'reminder_phone_1' => $brand['reminder_phone_1'],
        'must_send_reminder_2' => $brand['must_send_reminder_2'],
        'reminder_phone_2' => $brand['reminder_phone_2'],
        'email' => $brand['email'],
        'email_frequency' => $brand['email_frequency'],
    );
    var_dump($logData);
    $db->insert('sms_logs', $logData);
    require_once 'cron.php';
}
