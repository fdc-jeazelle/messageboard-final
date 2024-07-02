<?php if (!empty($messages)) : ?>
    <?php foreach ($messages as $message) :
        $bgcolor = $message['Message']['creator_id'] == $user_id ? '#007bff' : '#b0b0b0';
        $displayname = $message['creatorid']['first_name'];
        $filepath = !empty($message['userprofile']['img_path']) ? $message['userprofile']['img_path'] : '/app/webroot/img/default_pic.jpg';

        $txt = $message['Message']['creator_id'] == $user_id ? 'text-right' : 'text-left';
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