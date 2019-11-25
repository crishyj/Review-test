<?php
require_once '../database.php';
if (isset($_POST['submit_type'])) {
    if ($_POST['submit_type'] == 'update_brand') {
        $data = array(
            'brand_title' => $_POST['brand_title'],
            'must_send_customer' => isset($_POST['must_send_customer']) ? 'Yes' : 'No',
            'must_send_reminder_1' => isset($_POST['must_send_reminder_1']) ? 'Yes' : 'No',
            'reminder_phone_1' => $_POST['reminder_phone_1'],
            'must_send_reminder_2' => isset($_POST['must_send_reminder_2']) ? 'Yes' : 'No',
            'reminder_phone_2' => $_POST['reminder_phone_2'],
        );
        $db->where('id', $_POST['brand_id']);
        $db->update('brands', $data);
    }
    if ($_POST['submit_type'] == 'add_brand') {
        $data = array(
            'brand_title' => $_POST['brand_title'],
            'must_send_customer' => isset($_POST['must_send_customer']) ? 'Yes' : 'No',
            'must_send_reminder_1' => isset($_POST['must_send_reminder_1']) ? 'Yes' : 'No',
            'reminder_phone_1' => $_POST['reminder_phone_1'],
            'must_send_reminder_2' => isset($_POST['must_send_reminder_2']) ? 'Yes' : 'No',
            'reminder_phone_2' => $_POST['reminder_phone_2'],
        );
       
        $db->insert('brands', $data);
    }
    if ($_POST['submit_type'] == 'remove_brand') {
        $db->where('id', $_POST['brand_id']);
        $db->delete('brands');
    }

}
$brands = $db->get('brands');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Brand List</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">SMS Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="javascript:void(0)">Brands <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="templates.php">SMS Templates</a>
                </li>
            </ul>
        </div>
        <button class="btn btn-outline-success my-2 my-sm-0" type="button" data-toggle="modal" data-target="#editModal">New Brand</button>
    </nav>
    <div class="container">
        <h1 class="text-center">Brand List</h1>
        <?php
        if (count($brands) > 0) {
            ?>
            <table class="table table-responsive">
                <thead>
                    <th>No</th>
                    <th>Brand Name</th>
                    <th class="text-center">Must Send SMS to customer</th>
                    <th class="text-center">Must Send SMS to reminder1</th>
                    <th>Reminder1 Phone</th>
                    <th class="text-center">Must Send SMS to reminder2</th>
                    <th>Reminder2 Phone</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Remove</th>
                </thead>
                <tbody>
                    <?php foreach ($brands as $index => $brand) { ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $brand['brand_title']; ?></td>
                            <td class="text-center"><?php echo $brand['must_send_customer']; ?></td>
                            <td class="text-center"><?php echo $brand['must_send_reminder_1']; ?></td>
                            <td><?php echo $brand['reminder_phone_1']; ?></td>
                            <td class="text-center"><?php echo $brand['must_send_reminder_2']; ?></td>
                            <td><?php echo $brand['reminder_phone_2']; ?></td>
                            <td class="text-center">
                                <button type="button" brand_id="<?php echo $brand['id']; ?>" brand_title="<?php echo $brand['brand_title']; ?>" must_send_customer="<?php echo $brand['must_send_customer']; ?>" must_send_reminder_1="<?php echo $brand['must_send_reminder_1']; ?>" reminder_phone_1="<?php echo $brand['reminder_phone_1']; ?>" must_send_reminder_2="<?php echo $brand['must_send_reminder_2']; ?>" reminder_phone_2="<?php echo $brand['reminder_phone_2']; ?>" update-brand-data class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal"><i class="far fa-edit"></i></button>
                            </td>
                            <td class="text-center"><button type="button" brand_id="<?php echo $brand['id']; ?>" class="btn btn-outline-danger" data-toggle="modal" data-target="#removeModal"><i class="far fa-trash-alt"></i></button></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        <?php
        }
        ?>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="needs-validation" method="post" novalidate>
                    <input type="hidden" name="brand_id" id="brand_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">New Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="text" placeholder="Brand Name" class="form-control" name="brand_title" id="brand_title" required>
                                <div class="invalid-feedback">Please provide a brand name.</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="checkbox" name="must_send_customer" id="must_send_customer" checked data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger">
                                <span>Must send SMS to customer</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="checkbox" name="must_send_reminder_1" id="must_send_reminder_1" data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger">
                                <span>Must send SMS to reminder1</span>
                                <input type="text" class="form-control" name="reminder_phone_1" id="reminder_phone_1" style="display:inline-block; width:350px;" placeholder="Reminder1 Phone Number">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="checkbox" name="must_send_reminder_2" id="must_send_reminder_2" data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger">
                                <span>Must send SMS to reminder2</span>
                                <input type="text" class="form-control" name="reminder_phone_2" id="reminder_phone_2" style="display:inline-block; width:350px;" placeholder="Reminder2 Phone Number">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit_type" id="modal_submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeModalLabel">Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really remove this brand?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="" method="post">
                        <input type="hidden" name="brand_id" id="remove_id">
                        <button type="submit" name="submit_type" value="remove_brand" class="btn btn-primary">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        $(function() {
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                if (button.is('[update-brand-data]')) {
                    $('.modal-title').html('Update Brand');
                    $('#modal_submit').html('Update');
                    $('#modal_submit').val('update_brand');
                    $('#brand_id').val(button.attr('brand_id'))
                    $('#brand_title').val(button.attr('brand_title'));
                    $("#must_send_customer").bootstrapToggle(button.attr('must_send_customer') == 'Yes' ? 'on' : 'off');
                    $('#reminder_phone_1').val(button.attr('reminder_phone_1'));
                    $('#reminder_phone_2').val(button.attr('reminder_phone_2'));
                    $("#must_send_reminder_1").bootstrapToggle(button.attr('must_send_reminder_1') == 'Yes' ? 'on' : 'off');
                    $("#must_send_reminder_2").bootstrapToggle(button.attr('must_send_reminder_2') == 'Yes' ? 'on' : 'off');
                } else {
                    $('.modal-title').html('New Brand');
                    $('#modal_submit').html('Add New');
                    $('#modal_submit').val('add_brand');
                    $('#brand_title').val('');
                    $("#must_send_customer").bootstrapToggle('on');
                    $('#reminder_phone_1').val('');
                    $('#reminder_phone_2').val('');
                    $("#must_send_reminder_1").bootstrapToggle('off');
                    $("#must_send_reminder_2").bootstrapToggle('off');
                }
            });
            $('#removeModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                $('#remove_id').val(button.attr('brand_id'));
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