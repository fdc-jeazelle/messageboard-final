<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<style>
    .img-circle {
        width: 200px;
        border-radius: 50%;
    }

    .thistextarea {
        height: 100px;
    }

    .container {
        background-color: #fdf8f8;
        border-radius: 10px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
    }

    .sendmsgbtn {
        float: right;
    }
</style>
<!-- nav bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'messagelist')); ?>">Message board</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $this->Html->url(array('controller' => 'accounts', 'action' => 'account')); ?>">My Account <span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')); ?>">Logout</a>
            </li>

        </ul>
</nav>



<h2>New Message</h2>

<div class="container">
    <?= $this->Form->create('NewMessage'); ?>
    <?= $this->Form->input('recipient_id', ['type' => 'select', 'class' => 'form-control selectrecipient', 'options' => $users]);  ?>
    <?= $this->Form->input('message_content', ['type' => 'textarea', 'class' => 'form-control', 'placeholder' => 'Compose a new message....']);  ?>
    <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <?= $this->Form->button('Send Message', ['class' => 'btn btn-success sendmsgbtn']); ?>
        </div>

    </div>

    <?= $this->Form->end(); ?>
</div>



<script>
    $(document).ready(function() {

        $('.selectrecipient').select2({
            'placeholder': 'Search for a recipient'
        });

    });
</script>