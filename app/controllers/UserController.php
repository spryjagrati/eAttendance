<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\Model as Paginator;


class UserController extends ControllerBase
{
    public function initialize(){
        $this->tag->setTitle('Users List');
        parent::initialize();
    }
    /**
     * Shows the index action
     */
    public function indexAction(){
        if($_SESSION['auth']){
            $type = $this->session->get('auth')['type'];
        }       
        $this->view->type = $type;
        $numberPage = $this->request->getQuery("page", "int");         
        if($type == 1 || $type == 2){    /* check for admin and manager*/         
        $parameter = $this->persistent->searchParams;
        $query = new Query("SELECT User.* , Profile.* FROM User LEFT JOIN Profile 
                ON (User.iduser = Profile.iduser) ", $this->getDI());
        $atten = $query->execute();
            if(!is_array($parameter)){
                $parameter = array();            
                $paginator=new Paginator(array(
                    "data" => $atten,"limit" => 10,"page" => $numberPage));
                $page = $paginator->getPaginate();
                $this->view->page=$page;
            }else{
                $this->dispatcher->forward(array(
                    'controller' => 'user','action' => 'index'));
            }
        }else{
            return $this->dispatcher->forward(array(
               "controller" => "dashboard","action" => "index"));               
        }
    }

  
    /**
     * Creates a new user
     */
    public function createAction(){
        if (!$this->request->isPost()) {
        return $this->dispatcher->forward(array(
            "controller" => "user","action" => "index"));
        }
        $u = $_POST['user']; 
        $datalog = serialize($u);    
        $user = new User();       
        $user->email =$u['email'];
        $user->username = $u['username'];
        $user->password = sha1($u['password']);         
        $user->type = $u['type']; 
        $user->status = $u['status'];        
        if (!$user->save()) {
            foreach ($user->getMessages() as $message){
                $this->flash->error($message);
            }
            DataLogger::user('error', " \n\n User login error \n {$datalog} \n  ");
            $this->flash->success("user not created"); 
            return $this->response->redirect("user/new");
        }else{ //send email when user is created    
            $email = $u['email'];
            $username = $u['username'];
            $mail_confirm = new EmailConfirmations();
            $mail = $mail_confirm->afterCreate($email,$username);
            $file = "/home/sprytechies/www/eattendance/mail/mail.log";      
            $obj = json_decode($mail,TRUE);         
            $myString = "Email_id : "."\n\n\n".$email."\n".
            "Date   : ". date("Y/m/d")."\n".
            "Time   : ". date("h:i:sa")."\n".
            "Name of Mail : ".$obj['name']."\n".
            "Email From : ".$obj['from']."\n".
            "Email To : ".$obj['to'][0]."\n".
            "Subject : ".$obj['subject']."\n\n".
            "Url :".$obj['param']['confirmUrl']."\n\n".
            "body :".$obj['body']."\n\n";                   
            file_put_contents($file, $myString, FILE_APPEND);          
            $this->flash->success("user was created successfully"); 
            $this->createProfile($user);/* user profile create when user info is saved */            
        } 

    }

    public function createProfile($user){
            $profile =$_POST['profile'];
            $datalog = serialize($profile); 
            $userlog = serialize($user); 
            $user_meta = new Profile(); 
            $user_meta->validation($_POST);
            $user_meta->iduser =$user->iduser;        
            $user_meta->first_name = $profile['first_name'];
            $user_meta->last_name = $profile['last_name'];
            $user_meta->designation = $profile['designation'];
            $user_meta->dob = $profile['dob'];
            $user_meta->phone = $profile['phone'];
            $user_meta->alt_phone = $profile['alt_phone'];
            $user_meta->landline = $profile['landline'];
            $user_meta->email = $profile['email'];
            $user_meta->alt_email = $profile['alt_email'];
            $user_meta->current_address = $profile['current_address'];
            $user_meta->permanent_address = $profile['permanent_address'];
            $user_meta->communication_address = $profile['communication_address'];
            $user_meta->landlord_detail = $profile['landlord_detail'];
            $user_meta->father_name = $profile['father_name'];
            $user_meta->father_phone = $profile['father_phone'];
            $user_meta->mother_name = $profile['mother_name'];
            $user_meta->mother_phone = $profile['mother_phone'];
            $user_meta->pan = $profile['pan'];
            $user_meta->bank = $profile['bank'];
            $user_meta->branch = $profile['branch'];
            $user_meta->account_number = $profile['account_number'];
            $user_meta->micr_code = $profile['micr_code'];
            $user_meta->ifsc =$profile['ifsc'];
            if($user_meta->save() ){//echo "user_meta save";die();
                $this->flash->success("user profile created successfully");
                $this->view->disable();
                return $this->response->redirect("user/index");
            }else{
                DataLogger::user('error', "\n\n User create \n {$userlog} \n\n User Profile error \n {$datalog} \n  ");
                foreach ($user_meta->getMessages() as $message) {
                $this->flash->error($message);
                }
                $this->flash->error("user profile not created");
                return $this->response->redirect("user/edit/".$user->iduser);
            }            
    }

/**
     * Saves a user edited
     *
     */
    public function saveAction(){  
    
        if (!$this->request->isPost()){return $this->dispatcher->forward(array
            ("controller" => "user","action" => "index"));
        }else{
            $u = $_POST['user']; 
            $userlog = serialize($u);  
            $iduser =$u['iduser'];   
            $user=User::findFirst($iduser); /*check user exist or not*/ 

            if(!$user){ 
                DataLogger::user('error', "\n\n User not found \n {$userlog} ");
                $this->flash->error("user does not exist ");
                return $this->dispatcher->forward(array("controller" => "user",
                    "action" => "index"));
            }
            $user->iduser = $u['iduser'];   
            $user->email =$u['email'];
            $user->username = $u['username'];
            $user->password = sha1($u['password']);         
            $user->type = $u['type']; 
            $user->status = $u['status']; 
            $p = $_POST['profile'];
            $profilelog = serialize($p);  
            if(!empty($p['iduser_meta'])){
                $id_meta = $p['iduser_meta'];
                $iduser_meta=Profile::findFirst($id_meta);
                 $iduser_meta->iduser_meta = $p['iduser_meta'];
            }else{
                 $iduser_meta = new Profile(); 
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
                    return $this->response->redirect("user/index");
                }else{
                    DataLogger::user('error', "\n\n User update Save action \n {$userlog} \n\n User Profile error \n {$profilelog} \n  ");
                    foreach ($iduser_meta->getMessages() as $message) {
                    $this->flash->error($message);}
                    $this->flash->error("User profile not updated successfully");
                    $this->view->disable();
                    return $this->response->redirect("user/index");
                }
            }else{

                DataLogger::user('error', "\n\n User update Save action \n {$userlog} \n\n ");
                foreach ($user->getMessages() as $message) {$this->flash->error($message);}
                $this->flash->error("User info not updated successfully");
                $this->view->disable();
                return $this->response->redirect("user/index");
            }  
        }  
    }

    public function findAction(){
        $type =$this->session->get('auth')['type'];
        $this->view->type = $type; 
    }

    public function newAction()
    {
        $this->persistent->parameters = null;
        $type =$this->session->get('auth')['type'];
        $this->view->type = $type; 
    }

    /**
     * Edits a user
     *
     * @param string $iduser
     */
    /**
     * Searches for user
     */
    public function editAction($iduser)
    {
        $type =$this->session->get('auth')['type'];
        $this->view->type = $type; 
        if (!$this->request->isPost()) {        
            $user = User::findFirst($iduser);
            if (!$user) {
            $this->flash->error("user was not found");
            $this->view->disable();
            return $this->response->redirect('user/index');              
            }                
            $this->view->iduser = $iduser; 
            $experience = Experience::findByiduser($iduser);
            $this->view->experience = $experience;
            $this->view->iduser = $iduser; 
            $education = Education::findByiduser($iduser);
            $this->view->education = $education;
            $this->tag->setDefault("user[iduser]", $user->iduser);
            $this->tag->setDefault("profile[iduser]", $user->iduser);
            $this->tag->setDefault("user[email]", $user->email);
            $this->tag->setDefault("user[username]", $user->username);
            $this->tag->setDefault("user[password]", $user->password);
            $this->tag->setDefault("user[type]",$user->type);         
            $this->view->status = $user->status; 
            $this->editProfile($iduser); //set default value using function
      }  
    }

    public function editProfile($id){
        $user_meta = Profile::findFirstByiduser($id); 
        /*if(empty($user_meta)){
            $user = User::find($id);
            $user_meta = $this->createProfile($user);
        }*/
        //echo"<pre>";print_r($id);die();//update profile             
        /*if (!$user_meta) {
            $this->flash->error("user_meta was not found");
            return $this->dispatcher->forward(array("controller" => "profile",
                "action" => "edit"));
        }  */      
        $this->view->iduser_meta = $user_meta->iduser_meta;    
        $this->tag->setDefault("profile[iduser_meta]", $user_meta->iduser_meta?$user_meta->iduser_meta:'');
        $this->tag->setDefault("profile[iduser]", $user_meta->iduser?$user_meta->iduser:$id);
        $this->tag->setDefault("profile[first_name]", $user_meta->first_name?$user_meta->first_name:'');
        $this->tag->setDefault("profile[last_name]", $user_meta->last_name?$user_meta->last_name:'');
        $this->tag->setDefault("profile[designation]", $user_meta->designation?$user_meta->designation:'');
        $this->tag->setDefault("profile[dob]", $user_meta->dob?$user_meta->dob:'');
        $this->tag->setDefault("profile[phone]", $user_meta->phone?$user_meta->phone:'');
        $this->tag->setDefault("profile[alt_phone]", $user_meta->alt_phone?$user_meta->alt_phone:'');
        $this->tag->setDefault("profile[landline]", $user_meta->landline?$user_meta->landline:'');
        $this->tag->setDefault("profile[email]", $user_meta->email?$user_meta->email:'');
        $this->tag->setDefault("profile[alt_email]", $user_meta->alt_email?$user_meta->alt_email:'');
        $this->tag->setDefault("profile[current_address]", $user_meta->current_address?$user_meta->current_address:'');
        $this->tag->setDefault("profile[permanent_address]", $user_meta->permanent_address?$user_meta->permanent_address:'');
        $this->tag->setDefault("profile[communication_address]", $user_meta->communication_address?$user_meta->communication_address:'');
        $this->tag->setDefault("profile[landlord_detail]", $user_meta->landlord_detail?$user_meta->landlord_detail:'');
        $this->tag->setDefault("profile[father_name]", $user_meta->father_name?$user_meta->father_name:'');
        $this->tag->setDefault("profile[father_phone]", $user_meta->father_phone?$user_meta->father_phone:'');
        $this->tag->setDefault("profile[mother_name]", $user_meta->mother_name?$user_meta->mother_name:'');
        $this->tag->setDefault("profile[mother_phone]", $user_meta->mother_phone?$user_meta->mother_phone:'');
        $this->tag->setDefault("profile[pan]", $user_meta->pan?$user_meta->pan:'');
        $this->tag->setDefault("profile[bank]", $user_meta->bank?$user_meta->bank:'');
        $this->tag->setDefault("profile[branch]", $user_meta->branch?$user_meta->branch:'');
        $this->tag->setDefault("profile[account_number]", $user_meta->account_number?$user_meta->account_number:'');
        $this->tag->setDefault("profile[micr_code]", $user_meta->micr_code?$user_meta->micr_code:'');
        $this->tag->setDefault("profile[ifsc]", $user_meta->ifsc?$user_meta->ifsc:'');              
    }
 

    /**
     * Deletes a user
     *
     * @param string $iduser
     */
    public function deleteAction($iduser)
    {
        $profile = Profile::findByiduser($iduser);
        if($profile->delete()){
          $application = Application::findByiduser($iduser);
            if($application -> delete()){
                $attendance = Attendance::findByiduser($iduser);
                if($attendance->delete()){
                    $document = Document::findByiduser($iduser);
                    if($document->delete()){
                        $education = Education::findByiduser($iduser);
                        if($education->delete()){
                            $experience = Experience::findByiduser($iduser);
                            if($experience->delete()){
                                 $user = User::findByiduser($iduser);
                                 if($user->delete()){
                                    $this->flash->success("User Deleted successfully");
                                    $this->view->disable();
                                    return $this->response->redirect("user/index"); 
                                 }else{
                                    $this->flash->success("Error in deleting user");
                                    $this->view->disable();
                                    return $this->response->redirect("user/index"); 
                                 }
                            }
                        }
                    }
                }
            }
        }
    }

      public function createExcelAction($iduser){
        if($iduser == ''){
            $query = new Query("SELECT User.* , Profile.* FROM User LEFT JOIN Profile 
            ON (User.iduser = Profile.iduser) ", $this->getDI());
            $atten = $query->execute();
        }else{
            $query = new Query("SELECT User.* , Profile.* FROM User LEFT JOIN Profile 
            ON (User.iduser = Profile.iduser)
            WHERE User.iduser = $iduser ", $this->getDI());
            $atten = $query->execute();
        }
        $objPHPExcel = new PHPExcel();      
        $objPHPExcel->getProperties()->setCreator("eAttendance")
                    ->setLastModifiedBy("Sprytechies")
                    ->setTitle("Employees_list")
                    ->setSubject("Employees_list")
                    ->setDescription("Employees_list")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Excel export file");           
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Email')
                    ->setCellValue('B1', 'User Name')
                    ->setCellValue('C1', 'Password')
                    ->setCellValue('D1', 'Type')
                    ->setCellValue('E1', "Status")
                    ->setCellValue('F1', "First Name")
                    ->setCellValue('G1', "Last Name")
                    ->setCellValue('H1', "Designation")
                    ->setCellValue('I1', "DOB")
                    ->setCellValue('J1', "Phone")
                    ->setCellValue('K1', "Alternate Phone")
                    ->setCellValue('L1', "landline")
                    ->setCellValue('M1', "Email")
                    ->setCellValue('N1', "Alternate Email")
                    ->setCellValue('O1', "Current Address")
                    ->setCellValue('P1', "Permanent Address")
                    ->setCellValue('Q1', "Communication Address")
                    ->setCellValue('R1', "LandLord Detail")
                    ->setCellValue('S1', "Father Name")
                    ->setCellValue('T1', "Father Phone")
                    ->setCellValue('U1', "Mother Name")
                    ->setCellValue('V1', "Mother Phone")
                    ->setCellValue('W1', "Pan")
                    ->setCellValue('X1', "Bank")
                    ->setCellValue('Y1', "Branch")
                    ->setCellValue('Z1', "Account Number")
                    ->setCellValue('AA1', "MICR Code")
                    ->setCellValue('AB1', "IFSC");        
        $i = 2 ; 
        foreach($atten as $key => $value){
            $t = $value->user->type;
            if($t == 1){
                $t ='Admin';
            }elseif($t == 2){
                $t = 'Manager';
            }else{
                $t = 'Employee';
            }

            $status = $value->user->status;
            if($status){
                $status = 'Active';
            }else{
                $status = 'Inactive';
            }


        $objPHPExcel->setActiveSheetIndex(0)   
                    ->setCellValue('A'.$i,$value->user->iduser)
                    ->setCellValue('B'.$i,$value->user->username)
                    ->setCellValue('C'.$i,$value->user->password)
                    ->setCellValue('D'.$i,$t)
                    ->setCellValue('E'.$i,$status)
                    ->setCellValue('F'.$i,$value->profile->first_name)
                    ->setCellValue('G'.$i,$value->profile->last_name)
                    ->setCellValue('H'.$i,$value->profile->designation)
                    ->setCellValue('I'.$i,$value->profile->dob)
                    ->setCellValue('J'.$i,$value->profile->phone)
                    ->setCellValue('K'.$i,$value->profile->alt_phone)
                    ->setCellValue('L'.$i,$value->profile->landline)
                    ->setCellValue('M'.$i,$value->profile->email)
                    ->setCellValue('N'.$i,$value->profile->alt_email)
                    ->setCellValue('O'.$i,$value->profile->current_address)
                    ->setCellValue('P'.$i,$value->profile->permanent_address)
                    ->setCellValue('Q'.$i,$value->profile->communication_address)
                    ->setCellValue('R'.$i,$value->profile->landlord_detail)
                    ->setCellValue('S'.$i,$value->profile->father_name)
                    ->setCellValue('T'.$i,$value->profile->father_phone)
                    ->setCellValue('U'.$i,$value->profile->mother_name)
                    ->setCellValue('V'.$i,$value->profile->mother_phone)
                    ->setCellValue('W'.$i,$value->profile->pan)
                    ->setCellValue('X'.$i,$value->profile->bank)
                    ->setCellValue('Y'.$i,$value->profile->branch)
                    ->setCellValue('Z'.$i,$value->profile->account_number)
                    ->setCellValue('AA'.$i,$value->profile->micr_code)
                    ->setCellValue('AB'.$i,$value->profile->ifsc);
                 $i++;
        }
        for($col = 'A'; $col !== 'AC'; $col++) {
            $objPHPExcel->getActiveSheet()
                        ->getColumnDimension($col)
                        ->setAutoSize(true);
            $objPHPExcel->getDefaultStyle($col)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getDefaultStyle($col)
                        ->getAlignment()
                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } 
        $i = 1;
        for($col = 'A'; $col !== 'AC'; $col++) {
            $objPHPExcel->getActiveSheet()->getStyle($col.$i)->getFont()->setBold(true);
        }    
        $objPHPExcel->setActiveSheetIndex(0);                     
        $objPHPExcel->getActiveSheet()->setTitle('Employees_worksheet');
        header('Content-Type: application/xlsx');
        $filename = "EmployeesReport_".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel , "Excel2007");
        $objWriter->save('php://output');  
        return false;     
    }








}