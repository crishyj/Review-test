<?php
    echo '---begin cron job1' . '<br>';
    require_once 'database.php';
    $brands = $db->get('brands', null, array('brand_title', 'email'));
    foreach($brands as $brand){  
        $email = $brand['email'];
        $db1->where('status', 0);
        $db1->where('queue_name2', $brand['brand_title']);
        $db1->where('SMS_Smileyrating', 0);
        $externals = $db1->get('queue_calls', null, array('id', 'queue_name', 'caller_id', 'unique_id', 'call_time', 'status', 'agent', 'queue_time', 'queue_name2', 'SMS_Smileyrating'));
        foreach ($externals as $external) {  

            $to = $external['caller_id'];
            $caller_id = $external['caller_id'];
            $agent = $external['agent'];
            $queue_name2 = $external['queue_name2'];
            $call_time = $external['call_time'];        
            $template = $db->get('sms_templates', null, array('template'));   

            if ($template == null) {
                $db->where('brand_title', GLOBAL_BRAND);
                $db->where('country', $customer['customer_country']);
                $template = $db->getOne('sms_templates', 'template');
            }

            $db->where('brand_title', $queue_name2);    
            $template = $db->getOne('sms_templates', 'template');            
            $msg = $template['template'];
            $msg.= ' '.REVIEW_URL .$external['id'];                     
            $msg.=' '.$brand['brand_title'];          
            $from = $external['queue_name2'];

            $data1 = array(
                'status' => 1,
                'SMS_Smileyrating' => 1
            );

            $db1->where('id', $external['id']);
            $db1->update('queue_calls', $data1);

            $data = array(
                'email'=>$email,
                'review_id'=>$external['id'],
                'brand_title'=>$external['queue_name2'],
                'customer_phone'=>$external['caller_id'],
                'time_register'=>date('Y-m-d H:i:s'),
                'NC_caller_id' => $caller_id,
                'NC_agent' => $agent,
                'NC_queue_name2' => $queue_name2,
                'NC_call_time' => $call_time
            );
            
            echo $msg.'<br>';
            var_dump($data);
            $db->insert('sms_logs', $data);
        }
    }
?>  