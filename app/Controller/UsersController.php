<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Crud->mapAction('register', 'Crud.Add');
        $this->Auth->allow('register');
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirectUrl());
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function register() {
        // Whitelist only the desired fields for saving
        $this->Crud->action()->config('saveOptions', [
            'fieldList' => [
                'User' => ['username', 'email', 'password'],
            ]
        ]);

        // Redirect to /users/login after registering
        $this->Crud->action()->config('redirect', [
            'post_add' => [
                'reader' => 'request.data',
                'key' => '_add',
                'url' => [
                    'action' => 'login'
                ],
            ]
        ]);

        // Updates the flash messages to be pertinent to the current user
        $this->Crud->action()->config('messages', [
            'success' => ['text' => '{name} was successfully registered'],
            'error' => ['text' => 'Could not register {name}']
        ]);

        return $this->Crud->execute();
    }

    public function isAuthorized($user = null) {
        if ($this->request->action == 'register') {
            return false;
        }

        return parent::isAuthorized($user);
    }
}