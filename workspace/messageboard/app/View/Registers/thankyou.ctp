

<?php

echo $this->Html->link(
    'Go to homepage',
    array('controller' => 'accounts', 'action' => 'userprofile'),
    array('class' => 'btn btn-primary')
);
?>