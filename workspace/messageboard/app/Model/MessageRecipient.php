<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 */
class MessageRecipient extends AppModel
{
    public $useTable = 'message_recipient';

    public $belongsTo = array(
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'message_id'
        )
    );

    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * Display field
     *
     * @var string
     */
    // public $displayField = 'user_id';

    /**
     * Validation rules
     *
     * @var array
     */
    // public $virtualFields = array(
    // 	'password_confirm' => false //This ensures that this wont be saved in the database
    // );
    public $validate = array(

        'recipient_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),

                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),

        ),
        'message_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),

                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),

        ),

    );
}
