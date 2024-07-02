<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 */
class Message extends AppModel
{
    public $useTable = 'messages';

    public $hasMany = array(
        'MessageRecipient' => array(
            'className' => 'MessageRecipient',
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

        'message_content' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select birthday.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'minLength' => array(
                'rule' => array('minLength', '2'),
                'message' => 'First name must be at least 2 character long.'
            ),

        ),

    );
}
