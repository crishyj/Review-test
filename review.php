<?php
require_once 'database.php';
if (isset($_POST['id'])) {
   
    $id = $_POST['id'];
    $db->where('id', $id);
    $row = $db->getOne('sms_logs', array('customer_country', 'brand_title', 'customer_phone'));
    $brand = $row['brand_title'];
    $country = $row['customer_country'];
    $customer_phone = $row['customer_phone'];
    $feedback_score = $_POST['feedback_score'];
    $feedback_text = $_POST['feedback_text'];    
    $data = array(
        'is_receive_feedback' => 'Yes',
        'feedback_score' => $feedback_score,
        'feedback_text' => $feedback_text,
    );
    $db->where('id', $id);
    $db->update('sms_logs', $data);    

    $db1->where('caller_id', $customer_phone);
    $row1 = $db1->getOne('queue_calls', array('agent'));
    $agent = $row1['agent'];
    $data1 = array(
        'userRefID' => 214,
        'companyFBRefID' => 2,
        'text' => 'Der er modtaget en smiley fra en kunde til '.$brand.' udført af '.$agent.' URL to smiley '.$feedback_text,
        'metaTimeCreated' => date('Y-m-d H:i:s')         
    );
    $db1->insert('tagwall', $data1);
    echo '<h1>' . __t($feedback_thanks[$country]) . '</h1>';
    exit;
}
if (!isset($_GET['id'])) {
    exit;
}

$id = $_GET['id'];
$db->where('id', $id);
$row = $db->getOne('sms_logs', array('is_receive_feedback', 'customer_country', 'brand_title'));
if ($row == null) {
    $country = 'Denmark';
    $brand = 'Brand';
} else {
    $brand = $row['brand_title'];
    $country = $row['customer_country'];
    if ($row['is_receive_feedback'] == 'Yes') {
        echo '<h1>' . __t($feedback_duplicate[$country]) . '</h1>';
        exit;
    }
}

function __t($v)
{
    global $brand;
    $str = str_replace("[brand]", $brand, $v);
    $dow_numeric = date('w');
    $dow_text = date('D', strtotime("Sunday +{$dow_numeric} days"));
    return str_replace("[day]", $dow_text, $str);
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo __t($feedback_title[$country]); ?></title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link href="style.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <h2 class="text-center"><?php echo __t($feedback_titles[$country]); ?></h2>
        <form action="" class="needs-validation" method="post" novalidate>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" id="feedback_score" name="feedback_score">
                <div class="card" id="smile">
                    <div class="card-body">
                        <div class="row justify-content-md-center" >
                            <div class="col-xs-auto">
                                <img src="smile.png">
                            </div>
                            <div class="col">
                                <?php echo __t($feedback_happy[$country]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3" id="sad">
                    <div class="card-body">
                        <div class="row justify-content-md-center" >
                            <div class="col-xs-auto">
                                <img src="sad.png">
                            </div>
                            <div class="col">
                                <?php echo __t($feedback_sad[$country]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="step2 mt-3" style="display: none;">
                <div class="row">
                    <div class="col">
                        <textarea rows="8" cols="30" placeholder="<?php echo __t($feedback_placeholder[$country]); ?>" class="form-control" name="feedback_text" id="feedback_text" required></textarea>
                        <div class="invalid-feedback"><?php echo __t($feedback_invalid[$country]); ?></div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-left">
                        <button class="btn btn-danger back-button" type="button"><?php echo $feedback_back[$country]; ?></button>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-primary"><?php echo $feedback_submit[$country]; ?></button>
                    </div>
                </div>
            </div>
        </form>

    </div>


    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            $('#smile').click(function() {
                $('#feedback_score').val('Smile');
                $('#sad').fadeOut();
                                $('.step2').fadeIn();
            });
            $('#sad').click(function() {
                $('#feedback_score').val('Sad');
                $('#smile').fadeOut();
                $('.step2').fadeIn();
            });
            $('.back-button').click(function() {
                $('.step2').fadeOut();
                $('#smile').fadeIn();
                                $('#sad').fadeIn();
            });

            $('.needs-validation').submit(function(event) {
                var form_valid = true;
                if (this.checkValidity() === false) {
                    form_valid = false;
                }
                this.classList.add('was-validated');
                return form_valid;
            });
        });
    </script>
</body>

</html>