<?php
require_once '../database.php';
if (isset($_POST['submit_type'])) {
    if ($_POST['submit_type'] == 'update_template') {
        $data = array(
            'country' => $_POST['country'],
            'brand_title' => $_POST['brand_title'],
            'template' => $_POST['template']
        );
        $db->where('id', $_POST['template_id']);
        $db->update('sms_templates', $data);
    }
    if ($_POST['submit_type'] == 'add_template') {
        $data = array(
            'country' => $_POST['country'],
            'brand_title' => $_POST['brand_title'],
            'template' => $_POST['template']
        );
        $db->insert('sms_templates', $data);
    }
    if ($_POST['submit_type'] == 'remove_template') {
        $db->where('id', $_POST['template_id']);
        $db->delete('sms_templates');
    }
}
$templates = $db->get('sms_templates');
$brand_titles = $db->get('brands', null, array('brand_title'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Brand List</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Brands <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="javascript:void(0)">SMS Templates</a>
                </li>
            </ul>
        </div>
        <button class="btn btn-outline-success my-2 my-sm-0" type="button" data-toggle="modal" data-target="#editModal">Add/Update</button>
    </nav>
    <div class="container">
        <h1 class="text-center">SMS Templates List</h1>
        <?php
        if (count($templates) > 0) {
            ?>
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Brand Name</th>
                    <th class="text-center">Country</th>
                    <th>Template</th>
                    <th class="text-center">Remove</th>
                </thead>
                <tbody>
                    <?php foreach ($templates as $index => $template) { ?>
                        <tr template_id="<?php echo $template['id']; ?>" country="<?php echo $template['country']; ?>" template="<?php echo $template['template']; ?>" brand_title="<?php echo $template['brand_title']; ?>">
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $template['brand_title']; ?></td>
                            <td class="text-center"><?php echo $template['country']; ?></td>
                            <td><?php echo $template['template']; ?></td>
                            <?php if ($template['brand_title'] == '_Global') { ?>
                                <td></td>
                            <?php } else { ?>
                                <td class="text-center"><button type="button" template_id="<?php echo $template['id']; ?>" class="btn btn-outline-danger" data-toggle="modal" data-target="#removeModal"><i class="far fa-trash-alt"></i></button></td>
                            <?php } ?>
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
                    <input type="hidden" name="template_id" id="template_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">New Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label for="brand_title">Brand</label>
                                <select class="form-control" id="brand_title" name="brand_title" required>
                                    <option selected value="_Global">Global Brand</option>
                                    <?php foreach ($brand_titles as $brand_title) { ?>
                                        <option value="<?php echo $brand_title['brand_title']; ?>"><?php echo $brand_title['brand_title']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="country">Country</label>
                                <select class="form-control" id="country" name="country" required>
                                    <option selected value="Denmark">Denmark</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Norway">Norway</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <textarea rows="8" cols="30" placeholder="Write sms template text here..." class="form-control" name="template" id="template" required></textarea>
                                <div class="invalid-feedback">Please provide a template.</div>
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
                    Do you really remove this template?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="" method="post">
                        <input type="hidden" name="template_id" id="remove_id">
                        <button type="submit" name="submit_type" value="remove_template" class="btn btn-primary">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                // if (button.is('[update-brand-data]')) {
                //     $('.modal-title').html('Update Brand');
                //     $('#modal_submit').html('Update');
                //     $('#modal_submit').val('update_brand');
                //     $('#brand_id').val(button.attr('brand_id'))
                //     $('#brand_title').val(button.attr('brand_title'));
                //     $("#must_send_customer").bootstrapToggle(button.attr('must_send_customer') == 'Yes' ? 'on' : 'off');
                //     $('#reminder_phone_1').val(button.attr('reminder_phone_1'));
                //     $('#reminder_phone_2').val(button.attr('reminder_phone_2'));
                //     $("#must_send_reminder_1").bootstrapToggle(button.attr('must_send_reminder_1') == 'Yes' ? 'on' : 'off');
                //     $("#must_send_reminder_2").bootstrapToggle(button.attr('must_send_reminder_2') == 'Yes' ? 'on' : 'off');
                // } else {
                //     $('.modal-title').html('New Brand');
                //     $('#modal_submit').html('Add New');
                //     $('#modal_submit').val('add_brand');
                //     $('#brand_title').val('');
                //     $("#must_send_customer").bootstrapToggle('on');
                //     $('#reminder_phone_1').val('');
                //     $('#reminder_phone_2').val('');
                //     $("#must_send_reminder_1").bootstrapToggle('off');
                //     $("#must_send_reminder_2").bootstrapToggle('off');
                // }
            });


            function updateModal() {
                var el = $('tr[country="' + $('#country').val() + '"][brand_title="' + $('#brand_title').val() + '"]');
                if (el.length > 0) {
                    $('#template').val(el.attr('template'));
                    $('#template_id').val(el.attr('template_id'));
                    $('.modal-title').html('Update Template');
                    $('#modal_submit').html('Update');
                    $('#modal_submit').val('update_template');
                } else {
                    $('#template').val('');
                    $('.modal-title').html('Add Template');
                    $('#modal_submit').html('Add New');
                    $('#modal_submit').val('add_template');
                }
            }

            $('#removeModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                $('#remove_id').val(button.attr('template_id'));
            });
            $('.needs-validation').submit(function(event) {
                var form_valid = true;
                if (this.checkValidity() === false) {
                    form_valid = false;
                }
                this.classList.add('was-validated');
                return form_valid;
            });
            updateModal();
            $('#country').change(function(){
                updateModal();
            });
            $('#brand_title').change(function(){
                updateModal();
            });
        });
    </script>
</body>

</html>