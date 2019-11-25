<?php

    echo '---begin cron job1';
    require_once 'database.php';

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
?>  
