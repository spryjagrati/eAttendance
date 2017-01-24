<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ApplicationController extends ControllerBase
{
    /*** Index action*/
    public function indexAction(){
        /*$this->persistent->parameters = null;
        if($_SESSION['auth']){ $type = $this->session->get('auth')['type'];}
        $this->view->type = $type;
        $numberPage = $this->request->getQuery("page", "int");        
        if($type == 1 || $type == 2){   /* check for admin or manager 
            $from = (isset($_GET['from']))?$_GET['from']:date('Y/m/01');  
            $to = (isset($_GET['to']))?$_GET['to']:date('Y/m/t'); 
           
            $qstra="";
            if (isset($_GET['user_list'])){    
                $user_id = $_GET['user_list'];
                if($user_id != 0) $qstra =" WHERE (Application.iduser = $user_id)";
            } 
           
            echo $from; echo $to;
            $qstr="SELECT Application.*, User.username FROM Application 
            JOIN User ON (Application.iduser = User.iduser) ".$qstra."
            AND (from_date BETWEEN '$from' AND '$to' ) OR (to_date BETWEEN '$from' AND '$to')   
            ";

            echo $qstr;die();
            $query = new Query($qstr,$this->getDI());
            $atten = $query->execute(); 
                echo "<pre>";print_r($qstr);die();           
        }*/
        $this->persistent->parameters = null;
        if($_SESSION['auth']){ $type = $this->session->get('auth')['type'];}
        $this->view->type = $type;
        $numberPage = $this->request->getQuery("page", "int");        
        if($type == 1 || $type == 2){   /* check for admin or manager*/     
            if (isset($_GET['user_list'])){    
                $from = $_GET['from']; $to = $_GET['to'];$user_id = $_GET['user_list'];
                if($from == ''){ $from = date('Y/m/1');}
                else{ $from = $from; }
                if($to == ''){ $to = date('Y/m/d'); }
                else{$to = $to;}  
                if($user_id != 0){
                    $query = new Query("SELECT Application.*, User.username 
                    FROM Application JOIN User WHERE (Application.iduser = User.iduser)
                    AND (Application.iduser = $user_id) AND (from_date BETWEEN '$from' AND
                    '$to' ) OR (to_date BETWEEN '$from' AND '$to') ",$this->getDI());
                    $atten = $query->execute();
                }else{
                    $query = new Query("SELECT Application.*, User.username FROM Application
                    JOIN User WHERE (Application.iduser = User.iduser)AND
                    (from_date BETWEEN '$from' AND '$to' ) OR (to_date BETWEEN '$from' AND '$to') ",$this->getDI());
                    $atten = $query->execute();
                }
            }else{
                $from = date('Y-m-01'); $to = date('Y-m-t');  
                $query = new Query("SELECT Application.*, User.username FROM Application 
                JOIN User WHERE (Application.iduser = User.iduser) 
                AND (from_date AND to_date BETWEEN '$from' AND '$to') ",$this->getDI());
                $atten = $query->execute(); 
            }                   
        }else{  /* check for employee and others*/
            $from = ''; $to ='';
            if (isset($_GET['from'])){    
                $from = $_GET['from'];  $to = $_GET['to'];    
            }
            if($from == ''){ $from = date('Y/m/1'); }
            else{ $from = $_GET['from']; }
            if($to == ''){$to = date('Y/m/t');}
            else{$to = $_GET['to'];}                       
            $parameter = $this->persistent->searchParams;
            $id=$this->session->get('auth')['id'];
            $query = new Query("SELECT Application.*, User.username FROM Application 
            JOIN User ON (Application.iduser = User.iduser) WHERE (Application.iduser = $id)
            AND (from_date BETWEEN '$from' AND '$to' ) OR (to_date BETWEEN '$from' AND '$to')   
            ",$this->getDI());
            $atten = $query->execute();
        }
        if(!is_array($parameter)){
        $parameter = array();
        $paginator=new Paginator(array(
            "data" => $atten,"limit" => 10, "page" => $numberPage));
        $page = $paginator->getPaginate();
        $parent=$this->request->getUri();          
        if($type == 1 || $type == 2 ){  
            if (isset($_GET['from']) && isset($_GET['to']) && isset($_GET['user_list'])){ 
                $this->view->parentUrl='application/index?from='.urlencode($_GET['from'] ).
                '&to='.urlencode($_GET['to'] ).'&user_list='.$_GET['user_list'].'&'; 
                $this->view->extractUrl='application/createExcel?from='.urlencode($_GET['from'] ).
                '&to='.urlencode($_GET['to'] ).'&user_list='.$_GET['user_list'].'&'; 
            } else{
                $this->view->parentUrl='application/index?';
                $this->view->extractUrl='application/createExcel';   
            }
        }else{
            if (isset($_GET['from']) && isset($_GET['to'])){ 
            $this->view->parentUrl='application/index?from='.urlencode($_GET['from'] ).
            '&to='.urlencode($_GET['to'] ).'&user_list='.$_GET['user_list'].'&'; 
            $this->view->extractUrl='application/createExcel?from='.urlencode($_GET['from'] ).
            '&to='.urlencode($_GET['to'] ).'&user_list='.$id.'&'; 
            }
        }  $this->view->page=$page;                                 
        }else{
            $this->dispatcher->forward(array(
            'controller' => 'attendance','action' => 'index'));
        }
    }


    public function leaveAllocationAction(){
        $numberPage = $this->request->getQuery("page", "int"); 
        if (isset($_GET['user_list'])){    
            $from = $_GET['from']; $to = $_GET['to'];$user_id = $_GET['user_list'];
            if($from == ''){ $from = date('Y/m/1');}
            else{ $from = $from; }
            if($to == ''){ $to = date('Y/m/d'); }
            else{$to = $_GET['to'];}  
            if($user_id == 0){
                $query = new Query("SELECT User.iduser, User.username, Attendance.*                         
                FROM User JOIN Attendance ON (User.iduser = Attendance.iduser) WHERE 
                (Attendance.cdate BETWEEN '$from' AND '$to') AND (User.status = 1)",
                $this->getDI());  $atten = $query->execute();    
            }else{
                $query = new Query("SELECT User.iduser, User.username, Attendance.*                         
                FROM User JOIN Attendance ON (User.iduser = Attendance.iduser) 
                WHERE (Attendance.iduser = $user_id) AND 
                (Attendance.cdate BETWEEN '$from' AND '$to') AND (User.status = 1 )",
                $this->getDI()); $atten = $query->execute();           
            }      
        }else{
            $from = date('Y-m-01');$to = date('Y-m-t');                    
            $query = new Query("SELECT Attendance.*, User.username 
            FROM Attendance JOIN User WHERE (Attendance.iduser = User.iduser) 
            AND (User.status = 1) AND (cdate BETWEEN '$from' AND '$to') ",$this->getDI());
            $atten = $query->execute();
        }
        $parameter = $this->persistent->searchParams;
        if(!is_array($parameter)){
            $parameter = array();
            $paginator=new Paginator(array(
                "data" => $atten,"limit" => 10, "page" => $numberPage));
            $page = $paginator->getPaginate();
        }
    }

    public function createExcelAction(){               
        $user_id=$_GET['user_list']; $from=$_GET['from'];$to=$_GET['to'];
        if($from == ''){$from = date('Y/m/1'); }
        else{$from = $from; }
        if($to == ''){$to = date('Y/m/d'); }
        else{$to = $to; }
        if($user_id == ''){$user_id = 0; }
        else{ $user_id = $user_id; }
        if($user_id == 0){
            $query = new Query("SELECT Application.*, User.username 
            FROM Application JOIN User WHERE (Application.iduser = User.iduser)
            AND (from_date AND to_date BETWEEN '$from' AND '$to') ",$this->getDI());
            $atten = $query->execute();           
        }else{
            $query = new Query("SELECT Application.*, User.username 
            FROM Application JOIN User WHERE (Application.iduser = User.iduser)
            AND (Application.iduser = $user_id)
            AND (from_date AND to_date BETWEEN '$from' AND '$to') ",$this->getDI());
            $atten = $query->execute();   
        } 
        $objPHPExcel = new PHPExcel();      
        $objPHPExcel->getProperties()->setCreator("eAttendance")
                    ->setLastModifiedBy("Sprytechies")
                    ->setTitle("Application")
                    ->setSubject("Application")
                    ->setDescription("Application")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Excel export file");           
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'UserName')
                    ->setCellValue('B1', 'From Date')
                    ->setCellValue('C1', 'To Time')
                    ->setCellValue('D1', 'Type')
                    ->setCellValue('E1', "Title")
                    ->setCellValue('F1', "description")
                    ->setCellValue('G1', "Status")
                    ->setCellValue('H1', "Submitted On");
        $i = 2 ;
        foreach($atten as $key => $value){
            $t =$value->application->type;
            if($t == 2){   $t ="PL";}
            elseif($t == 3 ){$t ="CL";}
            else{ $t="SL";}
            $status =$value->application->status;
            if($status == 1){ $status='Pending';}
            elseif($status == 2){ $status='Approved';}
            else{ $status='Rejected';}
            $objPHPExcel->setActiveSheetIndex(0)   
                    ->setCellValue('A'.$i,$value->username)
                    ->setCellValue('B'.$i,$value->application->from_date)
                    ->setCellValue('C'.$i,$value->application->to_date)
                    ->setCellValue('D'.$i,$t)
                    ->setCellValue('E'.$i,$value->application->title)
                    ->setCellValue('F'.$i,$value->application->description) 
                    ->setCellValue('G'.$i,$status)
                    ->setCellValue('H'.$i,$value->application->created_on);
            $i++;
        }
        for($col = 'A'; $col !== 'I'; $col++) {
            $objPHPExcel->getActiveSheet()
                        ->getColumnDimension($col)
                        ->setAutoSize(true);
            $objPHPExcel->getDefaultStyle($col)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $i = 1;
        for($col = 'A'; $col !== 'I'; $col++) {
            $objPHPExcel->getActiveSheet()->getStyle($col.$i)->getFont()->setBold(true);
        } 
        $objPHPExcel->setActiveSheetIndex(0);                     
        $objPHPExcel->getActiveSheet()->setTitle('Application_worksheet');
        header('Content-Type: application/xlsx');
        $filename = "ApplicationReport_".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel , "Excel2007");
        $objWriter->save('php://output');  
        return false;     
    }


    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $id = $this->session->get('auth')['id'];
        $this->view->id =$id;
        $this->tag->setDefault("iduser", $id);
        $type = $this->session->get('auth')['type'];
        $this->view->type=$type;
        $query = new Query("SELECT User.* FROM User 
            WHERE (User.status = 1)", $this->getDI());
        $user = $query->execute();
        $this->view->user = $user;        
        if($type >= 3){   //find Remaining PL, SL, CL,    
        $query_pl = new Query("SELECT Systemmeta.* FROM Systemmeta", $this->getDI());
        $result = $query_pl->execute();
        foreach ($result as $key => $value) {
            $find = new Query("SELECT Application.* FROM Application
            WHERE Application.type = $value->idsystem_meta AND Application.iduser = $id",
            $this->getDI());
            $result = $find->execute();
            foreach($result as $key){
                $date1=strtotime($key->from_date); $date2=strtotime($key->to_date);                              
                $time = $date2- $date1;              
                $diff = floor($time/60/60/24);              
                $count_a[] = $diff ;
                $type=$key->type;              
            }
            $count = array_sum($count_a);
            $total= $value->meta_value;            
            if( $total >= $count){ $left = $total - $count; }
            else{ $left = 0; $panalty = $count - $total; }            
            $a[$value->meta_name]=$left;           
        } 
        $this->view->left_pl = $a['PL']; $this->view->left_cl = $a['CL'];                       
        $this->view->left_sl = $a['SL']; 
        }        
    }
    

    public function findAction(){
        $type =$this->session->get('auth')['type'];
        $this->view->type = $type; 
    }

    /**
     * Edits a application
     *
     * @param string $idapplication
     */
    public function editAction($idapplication)
    {
        $type =$this->session->get('auth')['type'];
        $this->view->type = $type; 
        if (!$this->request->isPost()) {
            $application = Application::findFirstByidapplication($idapplication);
            if (!$application) {

            $this->flash->error("Application was not found");
            return $this->dispatcher->forward(array(
                "controller" => "application","action" => "index" ));
            }
            $id=$this->session->get('auth')['id'];
            $this->view->id = $id;
            $this->view->idapplication = $application->idapplication;
            $this->tag->setDefault("idapplication", $application->idapplication);
            $this->view->iduser = $application->iduser;
            $this->tag->setDefault("iduser", $application->iduser);
            $this->tag->setDefault("from_date", $application->from_date);
            $this->tag->setDefault("to_date", $application->to_date);
            $this->tag->setDefault("type", $application->type);
            $this->tag->setDefault("title", $application->title);
            $this->tag->setDefault("description", $application->description);
            $this->tag->setDefault("status",$application->status);            
        }
    }

    /**
     * Creates a new application
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
        return $this->dispatcher->forward(array(
            "controller" => "application","action" => "index"));
        }
        $applicationlog = serialize($_POST);
        $application = new Application();
        $application->idapplication = $this->request->getPost("idapplication");
        $application->iduser = $this->request->getPost("iduser");
        $application->from_date = $this->request->getPost("from_date");
        $application->to_date = $this->request->getPost("to_date");
        $application->type = $this->request->getPost("type");
        $application->title = $this->request->getPost("title");
        $application->description = $this->request->getPost("description");
        $application->status = $this->request->getPost("status");
        $application->updated_on = $this->request->getPost("updated_on");
        if (!$application->save()) {
            DataLogger::application('error', "\n\n Application not create \n {$applicationlog} \n\n ");
            foreach ($application->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "application", "action" => "new" ));
        }
        else{
            $this->flash->success("Application created successfully");
            return $this->response->redirect("application/index"); 
        } 
    }

    /**
     * Saves a application edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
        return $this->dispatcher->forward(array(
            "controller" => "application","action" => "index"));
        }
        $idapplication = $this->request->getPost("idapplication");
        $application = Application::findFirstByidapplication($idapplication);
        $applicationlog=serialize($_POST);
        if (!$application) {
        DataLogger::application('error', "\n\n Application not found \n {$applicationlog} \n\n ");
        $this->flash->error("Application does not exist " . $idapplication);
        return $this->dispatcher->forward(array(
            "controller" => "application","action" => "index"));
        }
        $application->idapplication = $this->request->getPost("idapplication");
        $application->iduser = $this->request->getPost("iduser");
        $application->from_date = $this->request->getPost("from_date");
        $application->to_date = $this->request->getPost("to_date");      
        $t=$this->request->getPost("type");
       // switch($t){
       // case 'PL' : $type = 2;break;
       // case 'CL': $type = 3;break;
        //case 'SL' : $type = 4;break;                 
        //}
         
        $application->type = $this->request->getPost("type");
        $application->title = $this->request->getPost("title");
        $application->description = $this->request->getPost("description");
        $s=$this->request->getPost("status");           
        switch($s) {
        case 'Pending' : $status = 1;break;
        case 'Approved': $status = 2;break;
        case 'Rejected' : $status = 3 ;break;                
        }
        $application->status = $this->request->getPost("status");      
        $application->updated_on = $this->request->getPost("updated_on");
        if (!$application->save()) {
            DataLogger::application('error', "\n\n Application not update \n {$applicationlog} \n\n ");
            foreach ($application->getMessages() as $message) {
                $this->flash->error($message);
                //echo "<per>";print_r($message)
            }//die();
            return $this->dispatcher->forward(array(
                "controller" => "application","action" => "edit",
                "params" => array($application->idapplication)
            ));
        }else{
            $this->flash->success("Application was updated successfully");
            return $this->response->redirect("application/index"); 
        } 
    }

    /**
     * Deletes a application
     *
     * @param string $idapplication
     */
    public function deleteAction($idapplication)
    {
       $application = Application::findFirstByidapplication($idapplication);
        if (!$application) {
        $this->flash->error("Application was not found");
        return $this->dispatcher->forward(array(
            "controller" => "application", "action" => "index"));
        }
        if (!$application->delete()) {
            foreach ($application->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "application","action" => "search"
            ));
        }else{
            $this->flash->success("Application was deleted successfully");
            return $this->response->redirect("application/index"); 
        }        
    }



    public function typefetchAction(){
        $userid=$_POST['user'];
        $r=User::Find(array("iduser = '".$userid."'"));
        $type= $r[0]->type;
        if($type == 2){
            $id=$this->session->get('auth')['id'];
            $user=$r[0]->iduser;            
            if($user == $id){
                echo 'disable'; exit();    
            }else{
                echo 'enable'; exit();    
            }  
        }else{
                echo 'enable'; exit();    
        }       
    }

    public function leavetypeAction(){ //find Remaining PL, SL, CL,
        $userid=$_POST['user'];      
        $result = Systemmeta::Find();
        foreach ($result as $key => $value) {
            $result=Application::Find(array("type ='".$value->idsystem_meta."' and
                    iduser = '".$userid."'
            "));          
            if(!empty($result)){
                foreach($result as $key){
                    $date1=strtotime($key->from_date);                
                    $date2=strtotime($key->to_date);                     
                    $time = ($date2- $date1)+ 86400;              
                    $diff = floor($time/60/60/24);              
                    $count_a[] = $diff ;
                    $type=$key->type;
                }
                
            }           
            $find1 = Attendance::Find(array("type='".$value->idsystem_meta."' And 
                iduser='".$userid."'"));
            $diff1 = count($find1);
            $count_a[] = $diff1 ;             
            $count = array_sum($count_a);         
            $total= $value->meta_value; 
            
            if( $total >= $count){
                $left = $total - $count; 
            }else{
                $left = 0;
                $panalty = $count - $total;
            }           
            $a[$value->meta_name]=$left; 
            unset($count_a);     
        }   
            $data= array(
                "PL"=> $a['PL'],"CL"=> $a['CL'],"SL"=> $a['SL']
            );
        echo json_encode($data);exit();
    }
}
