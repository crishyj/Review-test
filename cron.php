<?php
echo '---begin cron job';
require_once 'database.php';
$db->where('must_send_customer', 'Yes');
$db->where('is_sent_customer', 'No');
$customers = $db->get('sms_logs', null, array('id', 'brand_title', 'customer_phone', 'customer_country'));

foreach ($customers as $customer) {
    $db->where('brand_title', $customer['brand_title']);
    $db->where('country', $customer['customer_country']);
    $template = $db->getOne('sms_templates', 'template');   

    if ($template == null) {
        $db->where('brand_title', GLOBAL_BRAND);
        $db->where('country', $customer['customer_country']);
        $template = $db->getOne('sms_templates', 'template');
    }
    $to = $customer['customer_phone'];
    
    $msg = $template['template'];
    $msg .= '\n' . REVIEW_URL . $customer['id'];
    $from = $customer['brand_title'];
    // var_dump($to, $msg, $from);
    if (sendSMS($to, $msg, $from)) {
        $data = array(
            'is_sent_customer' => 'Yes',
            'time_sent_customer' => $db->now(),
        );
        $db->where('id', $customer['id']);
        $db->update('sms_logs', $data);
    }
}

//reminder 1
$db->where('must_send_customer', 'Yes');
$db->where('is_sent_customer', 'Yes');
$db->where('DATE(time_sent_customer) < NOW() - INTERVAL 1 HOUR');
$db->where('is_receive_feedback', 'No');
$db->where('must_send_reminder_1', 'Yes');
$db->where('reminder_phone_1', '', '>');
$db->where('is_sent_reminder_1', 'No');
$reminders = $db->get('sms_logs', null, array('id', 'brand_title', 'customer_phone', 'customer_country', 'reminder_phone_1'));

foreach ($reminders as $reminder) {
    $to = $reminder['reminder_phone_1'];
    $msg = $reminder_msg_1[$reminder['customer_country']];
    $msg = str_replace('[brand]', $reminder['brand_title'], $msg);
    $from = $reminder['brand_title'];
    if (sendSMS($to, $msg, $from)) {
        $data = array(
            'is_sent_reminder_1' => 'Yes',
            'time_sent_reminder_1' => $db->now(),
        );
        $db->where('id', $reminder['id']);
        $db->update('sms_logs', $data);
    }
}

//reminder 2
$db->where('must_send_customer', 'Yes');
$db->where('is_sent_customer', 'Yes');
$db->where('DATE(time_sent_customer) < NOW() - INTERVAL 2 HOUR');
$db->where('is_receive_feedback', 'No');
$db->where('must_send_reminder_2', 'Yes');
$db->where('reminder_phone_2', '', '>');
$db->where('is_sent_reminder_2', 'No');

$reminders = $db->get('sms_logs', null, array('id', 'brand_title', 'customer_phone', 'customer_country', 'reminder_phone_2'));
foreach ($reminders as $reminder) {
    $to = $reminder['reminder_phone_2'];
    $msg = $reminder_msg_2[$reminder['customer_country']];
    $msg = str_replace('[brand]', $reminder['brand_title'], $msg);
    $from = $reminder['brand_title'];
    if (sendSMS($to, $msg, $from)) {
        $data = array(
            'is_sent_reminder_2' => 'Yes',
            'time_sent_reminder_2' => $db->now(),
        );
        $db->where('id', $reminder['id']);
        $db->update('sms_logs', $data);
    }
}

//email
$db->where('is_receive_feedback', 'Yes');
$db->where('email', '', '>');
$db->where('email_frequency', 'New Review');
$db->where('is_receive_feedback', 'Yes');
$db->where('is_sent_email', 'No');
//$reviews = $db->get('sms_logs', null, array('id', 'customer_phone', 'feedback_score', 'feedback_text', 'email'));
$email = $db->getOne('sms_logs', 'email');
if ($email != NULL) {
    $email = $email['email'];
    $db->where('is_receive_feedback', 'Yes');
    $db->where('email', $email);
    $db->where('email_frequency', 'New Review');
    $db->where('is_receive_feedback', 'Yes');
    $db->where('is_sent_email', 'No');
    $reviews = $db->get('sms_logs', null, array('id', 'customer_phone', 'feedback_score', 'feedback_text'));
    $html = '<html><body>';
    //var_dump($reviews);
    foreach ($reviews as $index => $review) {

        $html .= '<table>' .
            '  <tr>' .
            '    <td rowspan=2><img src="' . ($review['feedback_score'] == 'Smile' ? 'http://smileyrating.dk/smile.png' : 'http://smileyrating.dk/sad.png') . '"></td>' .
            '    <td><h4>' . $review['customer_phone'] . '</h4></td>' .
            '  </tr>' .
            '  <tr>' .
            '    <Td><p>' . $review['feedback_text'] . '</p></Td>' .
            '  ' .
            '  </tr>' .
            '</table>';
        $db->where('id', $review['id']);
        $data = array(
            'is_sent_email' => 'Yes'
        );
        $db->update('sms_logs', $data);
    }
    $html .= '</body></html>';
    $to = $email;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $subject = "SMS Review";
    mail($to, $subject, $html, $headers);
}

$db->where('is_receive_feedback', 'Yes');
$db->where('email', '', '>');
$db->where('email_frequency', 'Daily');
$db->where('is_receive_feedback', 'Yes');
$db->where('is_sent_email', 'No');
$db->where('time_receive_feedback < CURRENT_DATE()');
//$reviews = $db->get('sms_logs', null, array('id', 'customer_phone', 'feedback_score', 'feedback_text', 'email'));
$email = $db->getOne('sms_logs', 'email');
if ($email != NULL) {
    $email = $email['email'];
    $db->where('is_receive_feedback', 'Yes');
    $db->where('email', '', '>');
    $db->where('email_frequency', 'Daily');
    $db->where('is_receive_feedback', 'Yes');
    $db->where('is_sent_email', 'No');
    $db->where('time_receive_feedback < CURRENT_DATE()');
    $reviews = $db->get('sms_logs', null, array('id', 'customer_phone', 'feedback_score', 'feedback_text'));
    $html = '<html><body>';
    //var_dump($reviews);
    foreach ($reviews as $index => $review) {

        $html .= '<table>' .
            '  <tr>' .
            '    <td rowspan=2><img src="' . ($review['feedback_score'] == 'Smile' ? 'http://smileyrating.dk/smile.png' : 'http://smileyrating.dk/sad.png') . '"></td>' .
            '    <td><h4>' . $review['customer_phone'] . '</h4></td>' .
            '  </tr>' .
            '  <tr>' .
            '    <Td><p>' . $review['feedback_text'] . '</p></Td>' .
            '  ' .
            '  </tr>' .
            '</table>';
        $db->where('id', $review['id']);
        $data = array(
            'is_sent_email' => 'Yes'
        );
        $db->update('sms_logs', $data);
    }
    $html .= '</body></html>';
    $to = $email;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $subject = "SMS Review";
    mail($to, $subject, $html, $headers);
}

$db->where('is_receive_feedback', 'Yes');
$db->where('email', '', '>');
$db->where('email_frequency', 'Weekly');
$db->where('is_receive_feedback', 'Yes');
$db->where('is_sent_email', 'No');
$db->where('time_receive_feedback < CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE())-1 DAY');
//$reviews = $db->get('sms_logs', null, array('id', 'customer_phone', 'feedback_score', 'feedback_text', 'email'));
$email = $db->getOne('sms_logs', 'email');
if ($email != NULL) {
    $email = $email['email'];  
    $db->where('is_receive_feedback', 'Yes');
    $db->where('email', '', '>');
    $db->where('email_frequency', 'Weekly');
    $db->where('is_receive_feedback', 'Yes');
    $db->where('is_sent_email', 'No');
    $db->where('time_receive_feedback < CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE())-1 DAY');
    $reviews = $db->get('sms_logs', null, array('id', 'customer_phone', 'feedback_score', 'feedback_text'));
    $html = '<html><body>';
    //var_dump($reviews);
    foreach ($reviews as $index => $review) {

        $html .= '<table>' .
            '  <tr>' .
            '    <td rowspan=2><img src="' . ($review['feedback_score'] == 'Smile' ? 'http://smileyrating.dk/smile.png' : 'http://smileyrating.dk/sad.png') . '"></td>' .
            '    <td><h4>' . $review['customer_phone'] . '</h4></td>' .
            '  </tr>' .
            '  <tr>' .
            '    <Td><p>' . $review['feedback_text'] . '</p></Td>' .
            '  ' .
            '  </tr>' .
            '</table>';
        $db->where('id', $review['id']);
        $data = array(
            'is_sent_email' => 'Yes'
        );
        $db->update('sms_logs', $data);
    }
    $html .= '</body></html>';
    $to = $email;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $subject = "SMS Review";
    mail($to, $subject, $html, $headers);
}

// pallel29_c7nordiccall_dk

    $brands = $db->get('brands', null, array('brand_title'));
    foreach($brands as $brand){  
        $db1->where('status', 0);
        $db1->where('queue_name2', $brand['brand_title']);
        $db1->where('SMS_Smileyrating', 0);
        $externals = $db1->get('queue_calls', null, array('id', 'queue_name', 'caller_id', 'unique_id', 'call_time', 'status', 'agent', 'queue_time', 'queue_name2', 'SMS_Smileyrating'));
        foreach ($externals as $external) {            
            $to = $external['caller_id'];
            $template = $db->getOne('sms_templates', 'template');   

            if ($template == null) {
                $db->where('brand_title', GLOBAL_BRAND);
                $db->where('country', $customer['customer_country']);
                $template = $db->getOne('sms_templates', 'template');
            }
            $msg = $template['template'];
            echo $msg;
            echo '<br>';
             
            $from = $external['queue_name2'];
            if (sendSMS($to, $msg, $from)) {
                $data = array(
                    'status' => 1,
                    'SMS_Smileyrating' => 0
                );
                $db1->where('id', $external['id']);
                $db1->update('queue_calls', $data);
            }
        }
    }

echo '---end cron job';




