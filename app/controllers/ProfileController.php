<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Model\Query;

class ProfileController extends ControllerBase
{
    public function initialize(){
        $this->tag->setTitle('profile List');
        parent::initialize();
    }
    /**
     * Index action
     */
    public function indexAction()
    {
        $type = $this->session->get('auth')['type'];
        $this->view->type = $type;
		$id = $this->session->get('auth')['id'];        
        $user = User::findFirstByiduser($id);            
        if (!$user) { // user update info
            $this->flash->error("User was not found");
            return $this->response->redirect("index/index");
        } 
        $this->view->iduser = $user->iduser;
        $this->tag->setDefault("user[iduser]", $user->iduser?$user->iduser:'');
        $this->tag->setDefault("email", $user->email?$user->email:'');
        $this->tag->setDefault("user[username]", $user->username?$user->username:'');
        $this->tag->setDefault("user[password]", $user->password?$user->password:'');
        $t= $user->type;
        switch ($t) {
            case '1': $type="Admin";break;
            case '2': $type="Manager";break;
            case '3': $type="Employee";break;    
        }
        $this->tag->setDefault("type", $type?$type:'');
        $s= $user->status;
        if($s = 1){
            $status= "active";
        }else{
            $status = "inactive";
        }
        $this->tag->setDefault("status", $status?$status:''); 

       $user_meta = Profile::findFirstByiduser($id);//update profile  
       //echo "<pre>";print_r($user_meta);die();           
       /* if (!$user_meta) {
            $this->flash->error("user_meta was not found");
            return $this->response->redirect("user/edit/".$id);
        } */
                
        $this->view->iduser_meta = $user_meta->iduser_meta;    
        $this->tag->setDefault("user_meta[iduser_meta]", $user_meta->iduser_meta?$user_meta->iduser_meta:'');
        $this->tag->setDefault("user_meta[iduser]", $user_meta->iduser?$user_meta->iduser:$id);
        $this->tag->setDefault("user_meta[first_name]", $user_meta->first_name?$user_meta->first_name:'');
        $this->tag->setDefault("user_meta[last_name]", $user_meta->last_name?$user_meta->last_name:'');
        $this->tag->setDefault("user_meta[designation]", $user_meta->designation?$user_meta->designation:'');
        $this->tag->setDefault("user_meta[dob]", $user_meta->dob?$user_meta->dob:'');
        $this->tag->setDefault("user_meta[phone]", $user_meta->phone?$user_meta->phone:'');
        $this->tag->setDefault("user_meta[alt_phone]",$user_meta->alt_phone?$user_meta->alt_phone:'');
        $this->tag->setDefault("user_meta[landline]",  $user_meta->landline?$user_meta->landline:'');
        $this->tag->setDefault("user_meta[email]", $user_meta->email?$user_meta->email:'');
        $this->tag->setDefault("user_meta[alt_email]", $user_meta->alt_email?$user_meta->alt_email:'');
        $this->tag->setDefault("user_meta[current_address]", $user_meta->current_address?$user_meta->current_address:'');
        $this->tag->setDefault("user_meta[permanent_address]", $user_meta->permanent_address?$user_meta->permanent_address:'');
        $this->tag->setDefault("user_meta[communication_address]", $user_meta->communication_address?$user_meta->communication_address:'');
        $this->tag->setDefault("user_meta[landlord_detail]", $user_meta->landlord_detail?$user_meta->landlord_detail:'');
        $this->tag->setDefault("user_meta[father_name]", $user_meta->father_name?$user_meta->father_name:'');
        $this->tag->setDefault("user_meta[father_phone]", $user_meta->father_phone?$user_meta->father_phone:'');
        $this->tag->setDefault("user_meta[mother_name]", $user_meta->mother_name?$user_meta->mother_name:'');
        $this->tag->setDefault("user_meta[mother_phone]", $user_meta->mother_phone?$user_meta->mother_phone:'');
        $this->tag->setDefault("user_meta[pan]", $user_meta->pan?$user_meta->pan:'');
        $this->tag->setDefault("user_meta[bank]", $user_meta->bank?$user_meta->bank:'');
        $this->tag->setDefault("user_meta[branch]",  $user_meta->branch?$user_meta->branch:'');
        $this->tag->setDefault("user_meta[account_number]", $user_meta->account_number?$user_meta->account_number:'');
        $this->tag->setDefault("user_meta[micr_code]",$user_meta->micr_code?$user_meta->micr_code:'');
        $this->tag->setDefault("user_meta[ifsc]", $user_meta->ifsc?$user_meta->ifsc:'');
    }

     public function saveAction()
    {
        if (!$this->request->isPost()){
            return $this->dispatcher->forward(array(
                "controller" => "profile","action" => "new"));
        }
        $u = $_POST['user'];     
        $iduser =$u['iduser'];                                          
        /*if (!$iduser_meta) {   /*check user_meta exist or not 
            $this->flash->error("Profile does not exist " . $user_meta);
            return $this->dispatcher->forward(array(
                "controller" => "profile","action" => "index"));
        } */
        /*check user exist or not*/
         $user=User::findFirst($iduser);  
         if(!$user){
            
            $this->flash->error("user does not exist ");
            return $this->response->redirect("user/new");
        }   
        $user->iduser = $u['iduser'];
        $user->username = $u['username'];
        $user->password = sha1($u['password']);
        
        $p = $_POST['user_meta'];
        $iduser_meta = $p['iduser_meta'];
        if(!$iduser_meta){
            $iduser_meta = new Profile();
        }else{
            $iduser_meta = Profile::findFirst($iduser_meta);
        }
        $iduser_meta->iduser = $p['iduser'];
        $iduser_meta->first_name = $p['first_name'];
        $iduser_meta->last_name = $p['last_name'];
        $iduser_meta->designation = $p['designation'];
        $iduser_meta->dob = $p['dob'];
        $iduser_meta->phone = $p['phone'];
        $iduser_meta->alt_phone = $p['alt_phone'];
        $iduser_meta->landline = $p['landline'];
        $iduser_meta->email = $p['email'];
        $iduser_meta->alt_email = $p['alt_email'];
        $iduser_meta->current_address = $p['current_address'];
        $iduser_meta->permanent_address = $p['permanent_address'];
        $iduser_meta->communication_address = $p['communication_address'];
        $iduser_meta->landlord_detail = $p['landlord_detail'];
        $iduser_meta->father_name = $p['father_name'];
        $iduser_meta->father_phone = $p['father_phone'];
        $iduser_meta->mother_name = $p['mother_name'];
        $iduser_meta->mother_phone = $p['mother_phone'];
        $iduser_meta->pan = $p['pan'];
        $iduser_meta->bank = $p['bank'];
        $iduser_meta->branch = $p['branch'];
        $iduser_meta->account_number = $p['account_number'];
        $iduser_meta->micr_code = $p['micr_code'];
        $iduser_meta->ifsc = $p['ifsc'];
        if($user->save()){
            $this->flash->success("User info updated successfully");
            if($iduser_meta->save()){
                $this->flash->success("User profile updated successfully");
                $this->view->disable();
                return $this->response->redirect("profile/index");
            }else{
                foreach ($iduser_meta->getMessages() as $message) {
                $this->flash->error($message);
                }
                $this->flash->error("User profile not updated successfully");
                $this->view->disable();
                return $this->response->redirect("profile/index");
            }
        }else{
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }
            $this->flash->error("User info not updated successfully");
            $this->view->disable();
            return $this->response->redirect("profile/index");
        }   
    }

    public function createAction()
    {
	   if (!$this->request->isPost()) {
	      	return $this->dispatcher->forward(array(
	           "controller" => "profile","action" => "index" ));
	    }
        $type = $this->session->get('auth')['type'];
        $this->view->type=$type;         
        $user_meta = new Profile();       
        $user = Profile::findFirstByiduser($id);
        if($user){
            $this->flash->error("User Profile already exist...!! Update Profile ");
            return $this->dispatcher->forward(array(
               "controller" => "profile","action" => "index"));   
        }
        $profilelog = serialize($_POST);
        $user_meta->iduser =$this->request->getPost("iduser") ;        
        $user_meta->first_name = $this->request->getPost("first_name");
        $user_meta->last_name = $this->request->getPost("last_name");
        $user_meta->designation = $this->request->getPost("designation");
        $user_meta->dob = $this->request->getPost("dob");
        $user_meta->phone = $this->request->getPost("phone");
        $user_meta->alt_phone = $this->request->getPost("alt_phone");
        $user_meta->landline = $this->request->getPost("landline");
        $user_meta->email = $this->request->getPost("email", "email");
        $user_meta->alt_email = $this->request->getPost("alt_email");
        $user_meta->current_address = $this->request->getPost("current_address");
        $user_meta->permanent_address = $this->request->getPost("permanent_address");
        $user_meta->communication_address = $this->request->getPost("communication_address");
        $user_meta->landlord_detail = $this->request->getPost("landlord_detail");
        $user_meta->father_name = $this->request->getPost("father_name");
        $user_meta->father_phone = $this->request->getPost("father_phone");
        $user_meta->mother_name = $this->request->getPost("mother_name");
        $user_meta->mother_phone = $this->request->getPost("mother_phone");
        $user_meta->pan = $this->request->getPost("pan");
        $user_meta->bank = $this->request->getPost("bank");
        $user_meta->branch = $this->request->getPost("branch");
        $user_meta->account_number = $this->request->getPost("account_number");
        $user_meta->micr_code = $this->request->getPost("micr_code");
        $user_meta->ifsc = $this->request->getPost("ifsc");
        $user_meta->created_by = $this->request->getPost("created_by");
        $user_meta->updated_by = $this->request->getPost("updated_by");
        $user_meta->created_on = $this->request->getPost("created_on");
        $user_meta->updated_on = $this->request->getPost("updated_on");
        if (!$user_meta->save()) {
            DataLogger::profile('error', "\n\n Profile not create \n {$profilelog} \n\n ");
            foreach ($user_meta->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "profile", "action" => "index"));
        }
        $this->flash->success("User profile created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "profile","action" => "index"
        ));
        $this->views->disabled();
    }  
}