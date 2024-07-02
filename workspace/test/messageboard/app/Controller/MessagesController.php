<?php
class MessagesController extends AppController
{

    public $components = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Message.date_added' => 'desc'
        )
    );
    public function messagelist()
    {
        $userId = $this->Auth->user('user_id');

        $messageList = $this->Message->find('all', [
            'joins' => [
                [
                    'table' => 'message_recipient',
                    'alias' => 'MessageRecipient',
                    'type' => 'LEFT',
                    'conditions' => [
                        'MessageRecipient.message_id = Message.id'
                    ]
                ],
                [
                    'table' => 'users',
                    'alias' => 'CreatorUser',
                    'type' => 'LEFT',
                    'conditions' => [
                        'CreatorUser.user_id = Message.creator_id'
                    ]
                ],
                [
                    'table' => 'users',
                    'alias' => 'RecipientUser',
                    'type' => 'LEFT',
                    'conditions' => [
                        'RecipientUser.user_id = MessageRecipient.recipient_id'
                    ]
                ],
                [
                    'table' => 'user_profile',
                    'alias' => 'CreatorProfile',
                    'type' => 'LEFT',
                    'conditions' => [
                        'CreatorProfile.user_id = MessageRecipient.recipient_id'
                    ]
                ],
            ],
            'conditions' => [
                'OR' => array(
                    'Message.creator_id' => $userId,
                    'MessageRecipient.recipient_id' => $userId
                ),

            ],
            'fields' => [
                'Message.*',
                'MessageRecipient.*',
                'CreatorUser.first_name',
                'RecipientUser.*',
                'CreatorProfile.*',
                '(SELECT first_name FROM users WHERE user_id = MessageRecipient.recipient_id) as recipient_name',
                '(SELECT first_name FROM users WHERE user_id = Message.creator_id) as creator_name',

            ],
            'group' =>  ['LEAST(Message.creator_id, MessageRecipient.recipient_id)', 'GREATEST(Message.creator_id, MessageRecipient.recipient_id)'],
            'order' => ['Message.date_added' => 'DESC']
        ]);

        $msgprev = [];
        foreach ($messageList as $key => $msg) {
            $todisplay = $msg['MessageRecipient']['recipient_id'] == $userId ? $msg['Message']['creator_id'] : $msg['MessageRecipient']['recipient_id'];
            $tempmessage = $this->getConversation($userId, $todisplay);

            $img =  $this->getIMG($todisplay);
            // pr($img);
            $msgprev[$key]['imgpath'] = $img;
            $msgprev[$key]['content'] = $tempmessage[0]['Message']['message_content'];
            $msgprev[$key]['date_added'] = $tempmessage[0]['Message']['date_added'];
        }
        // pr($msgprev);




        // exit;
        $this->set('previewmessage', $msgprev);
        $this->set('user_id', $userId);
        $this->set('messages', $messageList);
    }
    public function getIMG($userid)
    {
        $this->loadModel('User');
        $img  = $this->User->find('all', array(
            'conditions'    => array(
                'userprofile.user_id' => $userid
            ),
            'joins' => array(
                array(
                    'table' => 'user_profile',
                    'alias' => 'userprofile',
                    'type'  => 'LEFT',
                    'conditions' => array(
                        'userprofile.user_id = User.user_id',
                    )
                )
            ),
            'fields' => array(
                'User.*',
                'userprofile.img_path',
            ),
        ));
        return !empty($img) ? $img[0]['userprofile']['img_path'] : '';
    }
    public function conversation($recipientid)
    {

        $this->loadModel('Message');
        $this->loadModel('MessageRecipient');
        $this->loadModel('User');
        $userId = $this->Auth->user('user_id');
        $messageList = $this->getConversation($userId, $recipientid);

        // pr($userId);
        // pr($messageList);
        $this->set('user_id', $userId);
        $this->set('messages', $messageList);

        if ($this->request->is('post')) {

            $messagedata = $this->request->data['Message'];
            //set recipient id 
            $messagedata['recipient_id'] = $recipientid;
            $isSuccessful = $this->insertNewMessageFlow($messagedata, $userId);

            if ($isSuccessful) {
                //get updated conversation 
                $messages = $this->getConversation($userId, $recipientid);


                $this->set(compact('messages'));
                $this->render('/messages/conversation_format', 'ajax');
            }
        }
    }
    public function getConversation($userId, $recipientid)
    {

        $this->Paginator->settings =  array(
            'conditions'    => array(
                'OR' => array(
                    array(
                        'Message.creator_id' => $userId,
                        'MessageRecipient.recipient_id' => $recipientid
                    ),
                    array(
                        'Message.creator_id' => $recipientid,
                        'MessageRecipient.recipient_id' => $userId
                    ),
                ),
            ),
            'fields' => array(
                'Message.id',
                'Message.message_content',
                'Message.creator_id',
                'MessageRecipient.recipient_id',
                'Message.date_added',
                'creatorid.first_name',
                'userprofile.img_path',
            ),
            'joins' => array(
                array(
                    'table' => 'message_recipient',
                    'alias' => 'MessageRecipient',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Message.id = MessageRecipient.message_id'
                    )
                ),
                array(
                    'table' => 'users',
                    'alias' => 'creatorid',
                    'type'  => 'LEFT',
                    'conditions' => array(
                        'creatorid.user_id = Message.creator_id',
                    )
                ),
                array(
                    'table' => 'user_profile',
                    'alias' => 'userprofile',
                    'type'  => 'LEFT',
                    'conditions' => array(
                        'userprofile.user_id = Message.creator_id',
                        // 'userprofile.user_id = MessageRecipient.recipient_id',
                    )
                ),
            ),
            'order' => ['Message.date_added' => 'DESC'],
            'limit' => 10


        );
        $messageList = $this->Paginator->paginate('Message');
        return !empty($messageList) ? $messageList : array();
    }
    public function addmessage()
    {
        // Load necessary models
        $this->loadModel('Message');
        $this->loadModel('MessageRecipient');
        $this->loadModel('User');

        $users = $this->User->find(
            'list',
            ['fields' => ['User.user_id', 'User.email']]
        );


        $this->set('users', $users);

        if ($this->request->is('post')) {
            $userId = $this->Auth->user('user_id');
            $messagedata = $this->request->data['NewMessage'];
            //set date added 


            $isSuccessful = $this->insertNewMessageFlow($messagedata, $userId);

            if ($isSuccessful) {
                $this->Session->setFlash('Message sent!');
            }
        }
    }
    public function insertNewMessageFlow($data, $userId)
    {
        //prepare message data to insert
        $toInsert = array(
            'message_content' => !empty($data['message_content']) ? $data['message_content'] : '',
            'date_added' => date("Y-m-d H:i:s"),
            'creator_id' => $userId,
        );


        //insert message content, returns message id
        $message_id = $this->insertMessages($toInsert);
        if (!empty($message_id) && $message_id) {
            $messagesdata = array(
                'recipient_id' => !empty($data['recipient_id']) ? $data['recipient_id'] : '',
                'message_id' => $message_id
            );

            if ($this->insertMessageRecipient($messagesdata)) {
                return true;
            }
        } else {
            return false;
        }
    }
    public function insertMessages($data)
    {
        $this->Message->create();
        $this->Message->set($data);
        if ($this->Message->validates()) {
            if ($this->Message->save($data)) {
                return $this->Message->getLastInsertID();
            } else {
                return false;
            }
        }
    }

    public function insertMessageRecipient($data)
    {
        $this->MessageRecipient->create();
        $this->MessageRecipient->set($data);
        if ($this->MessageRecipient->validates()) {
            return $this->MessageRecipient->save($data);
        }
    }


    public function deleteconversation()
    {
        $this->loadModel('Message');
        $this->loadModel('MessageRecipient');
        $response = ['success' => false, 'recipient_id' => null];
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('user_id');
            $recipient_id = $this->request->data['recipient_id'];

            $messageList = $this->Message->MessageRecipient->find('all', array(
                'conditions'    => array(
                    'OR' => array(
                        array(
                            'Message.creator_id' => $userId,
                            'MessageRecipient.recipient_id' => $recipient_id
                        ),
                        array(
                            'Message.creator_id' => $recipient_id,
                            'MessageRecipient.recipient_id' => $userId
                        ),
                    ),
                ),
                'fields' => array(
                    'Message.id',
                ),

            ));

            $messagesid = array_column(array_column($messageList, 'Message'), 'id');
            // pr(implode(',', $messagesid));

            if (!empty($messagesid)) {
                if ($this->Message->deleteAll([
                    'Message.id IN' => $messagesid
                ])) {
                    $this->MessageRecipient->deleteAll([
                        'message_id IN' => $messagesid
                    ]);
                    $response['success'] = true;
                    $response['recipient_id'] = $recipient_id;

                    // Return the recipient ID as JSON response

                }
            }
        } else {
            $response['error'] = 'Invalid request method';
        }


        $this->response->type('json');
        die(json_encode($response));
    }

    public function deletemessage()
    {
        $this->loadModel('Message');
        $this->loadModel('MessageRecipient');
        $response = ['success' => false, 'message_id' => null];
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('user_id');
            $message_id = $this->request->data['message_id'];
            if (!empty($message_id)) {
                if ($this->Message->deleteAll([
                    'Message.id' => $message_id
                ])) {
                    $this->MessageRecipient->deleteAll([
                        'message_id' => $message_id
                    ]);
                    $response['success'] = true;
                    $response['message_id'] = $message_id;

                    // Return the recipient ID as JSON response

                }
            }
        }

        $this->response->type('json');
        die(json_encode($response));
    }
}
