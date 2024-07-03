<?php
class RegistersController extends AppController
{
    public $uses = array('Register');
    public $components = array('Session');
    // public function beforeFilter(){
    //     $this->Auth->allow('index');
    // }
    public function index()
    {
    }
    public function register()
    {
        $this->loadModel('User');
        if ($this->request->is('post')) {
            $this->Register->create(); //create a model 

            $this->Register->set($this->request->data);
            if ($this->Register->validates()) { //Validate Fields
                // $this->request->data['Register']['password'] = AuthComponent::password($this->data['Register']['password']);
                // $this->request->data['Register']['password_confirm'] = AuthComponent::password($this->data['Register']['password_confirm']);
                // unset($this->request->data['Register']['password_confirm']);

                if ($this->Register->save($this->request->data)) {
                    //create userprofile entry 

                    $user = $this->User->findByUserId($this->Register->id);
                    pr($this->Register->id);
                    $this->userprofile($this->Register->id);
                    // exit;
                    if ($user) {
                        $this->Auth->login($user['User']);
                        $this->Register->saveField('last_logged_in', date('Y-m-d H:i:s'), array('user_id', $user['User']['user_id']));
                        $this->Session->setFlash('Registration Successful!');

                        return $this->redirect(array('action' => 'thankyou'));
                    } else {
                        $this->Session->setFlash('Error logging in');
                    }
                }
            } else {
                $this->Session->setFlash('Error saving user.');
            }
        }
    }
    public function userprofile($data)
    {
        $this->loadModel('Account');

        $toinsert = array(
            'user_id' => $data,
            'birthdate' => date("Y-m-d"),
            'gender' => 0,
            'hobby' => '...',
            'img_path' => '/app/webroot/img/default_pic.jpg',
            'profile_picture_name' => 'default_pic.jpg'
        );

        $this->Account->save($toinsert);
    }
    public function thankyou()
    {
    }

    public function account()
    {
    }
}
