<?php

/**
 * SessionController
 *
 * Allows to authenticate users
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Sign Up/Sign In');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            $this->tag->setDefault('email', 'admin@eattendance.com');
            $this->tag->setDefault('password', 'sprytechies');
        }
        //echo sha1('sprytechies');die();
    }

    /**
     * Register an authenticated user into session data
     *
     * @param Users $user
     */
    private function _registerSession(User $user)
    {        
        $this->session->set('auth', array(
            'id' => $user->iduser,
            'username' => $user->username,
            'type' => $user->type
        ));
    }

    /**
     * This action authenticate and logs an user into the application
     *change password from sha1($password) to $password till admin dashboard 
     *create
     */
    public function startAction(){
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');          
            $user =User::findFirst(array( "(email = :email: OR username = :email:) 
                AND password = :password: AND status=1",'bind' => array(
                    'email'    => $email,'password' => sha1($password)))
            );
            if ($user != false) {
                $this->_registerSession($user);
                DataLogger::login('info', " \n\n User login successfully \n Username/Email = {$user->email} \n ");
                $this->flash->success('Welcome ' . $user->username);
                return $this->response->redirect('dashboard/index');               
            } 
            DataLogger::login('error', " \n\n User login error \n Username/Email = {$email} \n password = {$password} ");
            $this->flash->error('Wrong email/password');


        }
        return $this->dispatcher->forward(array('controller'=>'session','action'=>'index'));
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction(){          
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        $this->view->disable();
        return $this->response->redirect('index/index');      
    }
}
