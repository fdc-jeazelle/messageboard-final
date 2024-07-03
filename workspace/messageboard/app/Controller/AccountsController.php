<?php


class AccountsController extends AppController
{
    public function account()
    {
        // Load necessary models
        $this->loadModel('Register');
        $this->loadModel('User');
        $this->loadModel('Account');

        //get the id of logged in user 
        $userId = $this->Auth->user('user_id');

        //Find existing profile of user
        $profile = $this->Account->find('all', [
            'conditions' => ['Account.user_id' => $userId]
        ]);

        //load existing details
        $user = $this->User->findByUserId($userId);
        $account = $this->Account->findByUserId($userId);

        $this->set('users', $user);
        $this->set('accounts', $account);

        if ($this->request->is(['post', 'put'])) {
            $profiledata = $this->request->data['Profile'];
            if (!empty($profiledata['images']['tmp_name'] && $profiledata['images']['error'] == 0)) {
                $file = $this->request->data['Profile']['images'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION); //get file extension
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $userId . '_' . 'img.' . $ext;


                //check if ext is allowed 
                if (!in_array($ext, $allowed_ext)) {
                    $this->Session->setFlash(__($ext . ' file extension is not allowed.'));
                    return $this->redirect(['action' => 'userprofile']);
                }

                $uploadPath = WWW_ROOT . 'img/';
                $uploadFile = $uploadPath . $filename;

                // Check if file already exists
                if (file_exists($uploadFile)) {
                    // Attempt to delete the existing file
                    unlink($uploadFile);
                    // Handle unable to delete file error if needed

                }

                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    // Set the file path to save in the database
                    $this->request->data['Profile']['images'] = '/app/webroot/img/' . $filename;
                }
            } else {
                unset($this->request->data['Profile']['images']);
            }


            $userprofiledata = array(
                'birthdate' => !empty($profiledata['birthdate']) ? date('Y-m-d', strtotime($profiledata['birthdate'])) : '',
                'gender' => !empty($profiledata['gender']) ? $profiledata['gender'] : '',
                'hobby' => !empty($profiledata['hobby']) ? $profiledata['hobby'] : '',
                'user_id' => $userId
            );

            if (!empty($profiledata['images']['tmp_name'] && $profiledata['images']['error'] == 0)) {
                $userprofiledata['img_path'] = $this->request->data['Profile']['images'];
            }
            if (!empty($filename)) {
                $userprofiledata['profile_picture_name'] = $filename;
            }

            if (empty($profile)) {
                $this->insertProfile($userprofiledata);
            } else {
                $profiledataid = $profile[0]['Account']['id'];


                if (!$this->updateProfile($profiledataid, $userprofiledata)) {
                    $validationErrors = $this->Account->validationErrors;
                    $this->set('validationErrors', $validationErrors);
                    return $this->Session->setFlash(__('Unable to save your profile.'));
                }
            }
            $userdata = $this->request->data['Profile'];
            $users_data = array(
                'first_name' => !empty($users_data['first_name']) ? $users_data['first_name'] : '',
                'last_name' => !empty($users_data['last_name']) ? $users_data['last_name'] : '',
            );

            if ($this->updateUsers($userId, $userdata)) {
                $this->Session->setFlash(__('Your profile has been saved.'));
                $this->redirect(['action' => 'userprofile']);
            } else {
                $validationErrors = $this->Register->validationErrors;

                $this->set('validationErrors', $validationErrors);
                // exit;
                $this->Session->setFlash(__('Unable to save your profile.'));
            }
        }
    }

    public function userprofile()
    {
        $this->loadModel('Register');
        $this->loadModel('User');
        $this->loadModel('Account');
        //get the id of logged in user 
        $userId = $this->Auth->user('user_id');
        $user = $this->User->findByUserId($userId);
        $account = $this->Account->findByUserId($userId);

        //get age 
        if (!empty($account)) {
            $age = $this->getAge($account['Account']['birthdate']);
        }

        // pr($account);
        // exit;
        $account['Account']['Age'] = !empty($age) ? $age : '';
        $this->set('users', $user);
        $this->set('accounts', $account);
    }
    private function createUserDirectory($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }
    private function getAge($birthdate)
    {
        $birthdate = date('Y-m-d', strtotime($birthdate)); // Convert to YYYY-MM-DD format

        $birthDate = new DateTime($birthdate);
        $currentDate = new DateTime();

        $age = $currentDate->diff($birthDate)->y;

        return $age;
    }
    private function updateUsers($userId, $data)
    {

        $this->Register->id = $userId;
        if ($this->Register->save($data)) {
            return true;
        }
    }

    private function updateProfile($userId, $data)
    {

        $result = false;
        $this->Account->id = $userId;
        if ($this->Account->save($data)) {
            $result = true;
        }
        return $result;
    }

    private function insertProfile($data)
    {
        $this->Account->create(); //create a model 
        $this->Account->set($data);

        if ($this->Account->validates() && $this->User->validates()) {
            return $this->Account->save($data);
        } else {
            $this->Session->setFlash('Error saving user.');
        }
    }


    // private function insertUser($data)
    // {
    //     $this->Register->create(); //create a model 
    //     $this->Account->set($data);

    //     if ($this->Account->validates()) {
    //         $this->Account->save($data);
    //     }
    // }
}
