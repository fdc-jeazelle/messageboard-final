<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<style>
  .img-circle {
    width: 200px;
    border-radius: 50%;
  }

  .thistextarea {
    height: 100px;
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
  </div>
</nav>



<div class="container">
  <div class="row" style="display:flex;">
    <div class="col-md-6">
      <h3>Edit Account </h3>
    </div>
    <div class="col-md-6 pull-right">
      <!-- < ?php echo $this->Html->link('Edit Profile', ['controller' => 'Accounts', 'action' => 'account'], ['class' => "btn btn-primary editprofilebtn"]); ?> -->

    </div>
  </div>

  <hr>
  <div class="row">
    <!-- left column -->

    <div class="col-md-3">
      <div class="text-center">
        <?php
        $filepath = !empty($accounts['Account']['img_path']) ? $accounts['Account']['img_path'] : '/app/webroot/img/default_pic.jpg';

        ?>
        <?= $this->Html->image($filepath, ['class' => 'avatar img-circle', 'id' => 'imagepreview', 'alt' => 'avatar']) ?>

        <?= $this->Form->create('Profile', ['type' => 'file']); ?>
        <?= $this->Form->control('images', ['type' => 'file', 'label' => 'Upload Image']); ?>

      </div>
    </div>

    <!-- edit form column -->
    <div class="col-md-9 personal-info">
      <h2>Personal Info</h2>

      <!-- edit form column -->



      <div class="form-group">
        <div class="col-md-8">
          <?= $this->Form->input('first_name', ['class' => 'form-control', 'value' => !empty($users['User']['first_name']) ? $users['User']['first_name'] : '']); ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-8">
          <?= $this->Form->input('last_name', ['class' => 'form-control', 'value' => !empty($users['User']['last_name']) ? $users['User']['last_name'] : '']); ?>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label">Birthdate</label>
        <div class="col-md-8">
          <?= $this->Form->control('birthdate', ['type' => 'date', 'class' => 'form-control datepicker', 'value' => !empty($accounts['Account']['birthdate']) ? $accounts['Account']['birthdate'] : '']); ?>
        </div>
      </div>

      <div class="form-group">

        <div class="col-md-8">
          <label for="">Gender</label>
          <div class="form-radio" style="display: flex;justify-content: left;">

            <?php echo $this->Form->radio('gender', ['1' => 'Male', '2' => 'Female'], [
              'legend' => false,
              'default' => !empty($accounts['Account']['gender']) ? $accounts['Account']['gender'] : '',
              'class'  => 'form-control',

            ]); ?>
          </div>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label">Hobby</label>
        <div class="col-md-8">
          <?= $this->Form->control('hobby', ['type' => 'textarea', 'class' => 'form-control thistextarea', 'value' => !empty($accounts['Account']['hobby']) ? $accounts['Account']['hobby'] : '']); ?>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-8">
          <?= $this->Form->button('Save Changes', ['class' => 'btn btn-primary']); ?>
          <span></span>
          <?= $this->Html->link(
            'Cancel',
            array('controller' => 'accounts', 'action' => 'userprofile'),
            array('class' => 'btn btn-secondary')
          ) ?>
        </div>
      </div>
      <?= $this->Form->end() ?>

    </div>
  </div>
  <hr>


  <script>
    $('#datepicker').datepicker({
      dateFormat: 'mm/dd/yy',
      changeMonth: true,
      changeYear: true,
    });

    $(document).ready(function() {

      $(document).on('change', '#ProfileImages', function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#imagepreview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
      })
    })
  </script>