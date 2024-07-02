<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

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
    }

    .thistextarea {
        height: 100px;
    }

    .list-group a {
        text-decoration: none;
        color: #000;
    }

    .list-group a:hover {
        color: #57b1ff;
        background-color: #eeee;
    }

    .deleteconversation {
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
    </div>
</nav>



<h2>Inbox</h2>

<div class="container">
    <?= $this->Html->link('Compose new message', ['controller' => 'messages', 'action' => 'addmessage'], ['class' => 'btn btn-primary']); ?>
    <ol class="list-group mb-3">
        <?php if (!empty($messages)) :
            // pr($messages);
        ?>
            <?php foreach ($messages as $key => $message) :
                $dataid = $message['MessageRecipient']['recipient_id'] == $user_id ? $message['Message']['creator_id'] : $message['MessageRecipient']['recipient_id'];
                $displayname = $message['MessageRecipient']['recipient_id'] == $user_id ? $message[0]['creator_name'] : $message[0]['recipient_name'];
                $filepath = !empty($message['CreatorProfile']['img_path']) ? $message['CreatorProfile']['img_path'] : '/app/webroot/img/default_pic.jpg';
            ?>
                <?= $this->Html->link(
                    '<div class="media" data-id="' . $dataid . '">' .
                        $this->Html->image($previewmessage[$key]['imgpath'], ['class' => 'avatar img-circle rounded-circle mr-3', 'alt' => 'avatar']) .
                        '<div class="media-body">' .
                        '<p>' .
                        '<strong>' . $displayname . '</strong>' .
                        '<time class="text-muted float-right">' . date("Y-m-d h:i A", strtotime($previewmessage[$key]['date_added'])) . '</time>' .
                        '</p>' .
                        '<p class="card-text">' . h($previewmessage[$key]['content']) . '</p>' .
                        $this->Form->button('Delete', ['class' => 'btn btn-danger deleteconversation']) .
                        '</div>' .
                        '</div>',
                    [
                        'controller' => 'messages',
                        'action' => 'conversation',
                        $dataid
                    ],
                    [
                        'escape' => false,
                        'class' => 'list-group-item m-2'
                    ]
                ); ?>
            <?php endforeach ?>
        <?php endif ?>
    </ol>
</div>



<script>
    $(document).ready(function() {
        var base_url = `<?= $this->webroot ?>`;
        $(document).on('click', '.deleteconversation', function(e) {
            e.preventDefault();
            var dis = $(this);
            var recipient_id = dis.parents('.media').attr('data-id');
            // console.log(recipient_id);
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
                                url: base_url + 'messages/deleteconversation', // The URL to send the form data to
                                data: {
                                    'recipient_id': recipient_id
                                },
                                dataType: 'JSON',
                                success: function(response) {
                                    // console.log(response.recipient_id);
                                    if (response.success) {
                                        dis.parents('.media').attr('data-id', response.recipient_id).parents('a').fadeOut();
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