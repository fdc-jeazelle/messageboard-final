<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

<style>
    .img-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-top: 8px;
    }

    .thistextarea {
        height: 100px;
    }

    .addmessagebtn {
        float: right;
    }

    .container {
        margin-top: 20px;
    }

    #newmessagecontainer {
        display: none;
        margin-bottom: 20px;
    }

    .replymsgbtn {
        float: right;
        margin: 10px;

    }

    .deleteconversation {
        font-size: 8px;
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
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <?= $this->Form->button('Add Message', ['class' => 'btn btn-primary addmessagebtn']); ?>
        </div>
    </div>


    <ol class="list-unstyled conversationlist_container" style="margin-top:20px;">

        <li class="row">
            <div class="media col-10" id="newmessagecontainer">
                <div class="media-body ">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <?= $this->Form->create('Message', ['id' => 'MessageForm', 'action', '']); ?>
                            <?= $this->Form->input('message_content', ['type' => 'textarea', 'class' => 'form-control', 'placeholder' => 'Type a new message...']); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <?= $this->Form->button('Reply', ['class' => 'btn btn-success replymsgbtn', 'type' => 'button', 'id' => 'submitMessage']); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </li>
        <?php if (!empty($messages)) :
        ?>
            <?php foreach ($messages as $message) :
                $bgcolor = $message['Message']['creator_id'] == $user_id ? '#007bff' : '#b0b0b0';
                $displayname = $message['creatorid']['first_name'];
                $filepath = !empty($message['userprofile']['img_path']) ? $message['userprofile']['img_path'] : '/app/webroot/img/default_pic.jpg';

                $txt = $message['Message']['creator_id'] == $user_id ? 'text-right' : 'text-left';
                $float = $message['Message']['creator_id'] == $user_id ? 'float:right' : 'float:left';
            ?>
                <li class="row">
                    <div class="media col-10 mr-auto" data-id="<?= $message['Message']['id'] ?>">
                        <?php if ($message['Message']['creator_id'] != $user_id) : ?>
                            <?= $this->Html->image($filepath, ['class' => 'avatar img-circle rounded-circle mr-3', 'alt' => 'avatar']) ?>
                        <?php endif; ?>
                        <div class="media-body">
                            <div class="card text-white">
                                <div class="card-body" style="background-color: <?= $bgcolor ?>">
                                    <p class="card-text"><?= $message['Message']['message_content'] ?></p>
                                    <?= $this->Form->button('Delete', [
                                        'type' => 'button', // Specify the type of button (submit, button, reset)
                                        'class' => 'btn btn-danger deleteconversation', // CSS classes for styling
                                        'style' => 'float:right',
                                        'escape' => false, // Prevent escaping of HTML content
                                    ]) ?>
                                </div>

                            </div>
                            <p class="small text-muted <?= $txt ?>">
                                <strong><?= $displayname ?></strong> · <time><?= date("F d, Y h:i A", strtotime($message['Message']['date_added'])) ?></time>
                            </p>


                        </div>
                        <?php if ($message['Message']['creator_id'] == $user_id) : ?>
                            <?= $this->Html->image($filepath, ['class' => 'avatar img-circle rounded-circle ml-3', 'alt' => 'avatar']) ?>
                        <?php endif; ?>


                    </div>
                </li>
            <?php endforeach ?>
        <?php else : ?>
            <p>No messages yet..</p>
        <?php endif; ?>

    </ol>
    <div class="paging">
        <?php echo $this->Paginator->prev('< ' . __('Previous'), null, null, array('class' => 'disabled')); ?>
        <!-- < ?php echo $this->Paginator->numbers(array('separator' => '')); ?> -->
        <?php echo $this->Paginator->next(__('Show more'), null, null, array('class' => 'disabled')); ?>
    </div>
</div>



<script>
    $(document).ready(function() {
        var base_url = `<?= $this->webroot ?>`;
        $(document).on('click', '.addmessagebtn', function() {
            $('#newmessagecontainer').css('display', 'block');
            $('.addmessagebtn').css('display', 'none');
            $('#MessageForm').find('textarea').val('');
        });

        $(document).on('click', '#submitMessage', function(e) {
            e.preventDefault();
            var formdata = $('#MessageForm').serializeArray();
            // console.log($('#MessageForm').attr('action'));
            $.ajax({
                type: 'POST',
                url: $('#MessageForm').attr('action'), // The URL to send the form data to
                data: formdata,
                dataType: 'html',
                success: function(response) {
                    // Handle the response here
                    $('.conversationlist_container li:not(:first)').remove();
                    // console.log(response);
                    $('.conversationlist_container').append(response);
                    $('#newmessagecontainer').css('display', 'none');
                    $('.addmessagebtn').css('display', 'block');
                    $('#MessageForm').find('textarea').val('');
                    // alert('Message sent successfully!');
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.error(error);
                    alert('An error occurred while sending the message.');
                }
            });


        });


        $(document).on('click', '.deleteconversation', function(e) {
            e.preventDefault();
            var dis = $(this);
            var message_id = dis.parents('.media').attr('data-id');
            console.log(message_id);
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete this conversation?',
                buttons: {
                    confirm: {
                        text: 'Confirm',
                        btnClass: 'btn-blue',
                        action: function() {
                            // console.log(base_url + 'messages/messagelist');
                            $.ajax({
                                type: 'POST',
                                url: base_url + 'messages/deletemessage', // The URL to send the form data to
                                data: {
                                    'message_id': message_id
                                },
                                dataType: 'JSON',
                                success: function(response) {
                                    console.log(response.message_id);
                                    if (response.success) {
                                        dis.parents('.media').attr('data-id', response.message_id).parents('.row').fadeOut();
                                    }
                                },
                            });
                        }
                    },
                    cancel: function() {

                    },
                }
            });
        });

    });
</script>