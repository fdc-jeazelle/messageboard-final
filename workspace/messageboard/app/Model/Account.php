<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 */
class Account extends AppModel
{
    public $useTable = 'user_profile';
    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'user_id';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'user_id';

    /**
     * Validation rules
     *
     * @var array
     */
    // public $virtualFields = array(
    // 	'password_confirm' => false //This ensures that this wont be saved in the database
    // );
    public $validate = array(

        'birthdate' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select birthday.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),

        ),
        'gender' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select gender.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'hobby' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter a hobby.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

    );
}
