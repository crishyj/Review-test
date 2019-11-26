<?php
    echo '---begin cron job2';
    
    require_once 'database.php';        
    $db1->where('SMS_Smileyrating', 0);        
    $externals = $db1->get('queue_calls', null, array('id', 'SMS_Smileyrating'));
    foreach ($externals as $external) {           
        $data = array(
            'SMS_Smileyrating' => 1               
        );
        $db1->where('id', $external['id']);
        $db1->update('queue_calls', $data);            
    }

    echo '---end cron job2';
?>  
