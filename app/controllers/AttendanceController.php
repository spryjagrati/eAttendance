<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AttendanceController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction(){
        $this->persistent->parameters = null;
        if($_SESSION['auth']){ $type = $this->session->get('auth')['type'];}
        $this->view->type = $type;
        $numberPage = $this->request->getQuery("page", "int");  
        if($type == 1 || $type == 2 ){   /*check type admin or manager*/          
            if (isset($_GET['user_list'])){    
                $from = $_GET['from']; $to = $_GET['to'];$user_id = $_GET['user_list'];           
                if($from == ''){ $from = date('Y/m/1');}
                else{ $from = $from; }
                if($to == ''){ $to = date('Y/m/d'); }
                else{$to = $_GET['to'];}  
                if($user_id == 0){
                    $query = new Query("SELECT User.iduser, User.username, Attendance.* 
                    FROM User JOIN Attendance ON (User.iduser = Attendance.iduser) WHERE
                    (Attendance.cdate BETWEEN '$from' AND '$to')AND (User.status = 1)",
                    $this->getDI());  $atten = $query->execute();    
                }else{
                    $query = new Query("SELECT User.iduser, User.username, Attendance.*                         
                    FROM User JOIN Attendance ON (User.iduser = Attendance.iduser) WHERE
                    (Attendance.iduser = $user_id) AND (Attendance.cdate BETWEEN '$from' 
                    AND '$to') AND (User.status = 1 )",$this->getDI());
                    $atten = $query->execute();   
                }
            }else{
                $from = date('Y-m-01'); $to = date('Y-m-t');                 
                $query = new Query("SELECT Attendance.*, User.username FROM Attendance 
                JOIN User WHERE (Attendance.iduser = User.iduser) AND (User.status = 1) 
                AND (cdate BETWEEN '$from' AND '$to')",$this->getDI());
                $atten = $query->execute();
            }
            $parameter = $this->persistent->searchParams;
        }else{/* for employee and other users*/
            $from = ''; $to ='';
            if (isset($_GET['from'])){    
                $from = $_GET['from'];  $to = $_GET['to'];    
            }
            if($from == ''){ $from = date('Y/m/1'); }
            else{  $from = $_GET['from'];}
            if($to == ''){$to = date('Y/m/d');}
            else{$to = $_GET['to'];}             
            $parameter = $this->persistent->searchParams;
            $id=$this->session->get('auth')['id'];
            $query = new Query("SELECT Attendance.*, User.username FROM Attendance JOIN 
            User ON Attendance.iduser = User.iduser WHERE Attendance.iduser = $id
            AND (Attendance.cdate BETWEEN '$from' AND '$to') ", $this->getDI());
            $atten = $query->execute();                
        }

        if(!is_array($parameter)){
            $parameter = array();
            $paginator=new Paginator(array("data" => $atten,"limit" => 10,
                "page" => $numberPage));
            $page = $paginator->getPaginate();
            $parent=$this->request->getUri();         
        if($type == 1 || $type == 2 ){  
            if (isset($_GET['from']) && isset($_GET['to']) && isset($_GET['user_list'])){ 
                $this->view->parentUrl='attendance/index?from='.urlencode($_GET['from'] ).'&to='.urlencode($_GET['to'] ).'&user_list='.$_GET['user_list'].'&'; 
                $this->view->extractUrl='attendance/createExcel?from='.urlencode($_GET['from'] ).
                '&to='.urlencode($_GET['to'] ).'&user_list='.$_GET['user_list'].'&'; 
            }else{
                $this->view->parentUrl='attendance/index?';
                $this->view->extractUrl='attendance/createExcel';   
            }
        }else{
            if (isset($_GET['from']) && isset($_GET['to'])){ 
                $this->view->parentUrl='attendance/index?from='.urlencode($_GET['from'] ).'&to='.urlencode($_GET['to'] ).'&user_list='.$_GET['user_list'].'&'; 
                $this->view->extractUrl='attendance/createExcel?from='.urlencode($_GET['from'] ).
                '&to='.urlencode($_GET['to'] ).'&user_list='.$id.'&'; 
            }

        } $this->view->page=$page;               
        }else{
            $this->dispatcher->forward(array(
                'controller' => 'attendance','action' => 'index'));
        }
    }

     public function createExcelAction(){          
        $user_id=$_GET['user_list'];$from=$_GET['from'];$to=$_GET['to'];
        if($from == ''){$from = date('Y/m/1'); }
        else{$from = $_GET['from']; }
        if($to == ''){$to = date('Y/m/d'); }
        else{$to = $_GET['to']; }
        if($user_id == ''){$user_id = 0; }
        else{ $user_id = $user_id; }
        if($user_id == 0){
            $query = new Query("SELECT User.iduser,User.username, Attendance.* FROM User
            JOIN Attendance ON (User.iduser = Attendance.iduser) WHERE 
            (Attendance.cdate BETWEEN '$from' AND '$to')AND (User.status = 1)",
            $this->getDI()); $atten = $query->execute();
        }else{
            $query = new Query("SELECT User.iduser,User.username, Attendance.* FROM User
            JOIN Attendance ON (User.iduser = Attendance.iduser) WHERE 
            (Attendance.iduser = $user_id) AND (Attendance.cdate BETWEEN '$from' AND 
            '$to')AND (User.status = 1 )",$this->getDI()); $atten = $query->execute();   
        } 
        $objPHPExcel = new PHPExcel();      
        $objPHPExcel->getProperties()->setCreator("eAttendance")
                    ->setLastModifiedBy("Sprytechies")
                    ->setTitle("Attendance")
                    ->setSubject("Attendance")
                    ->setDescription("Attendance")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Excel export file");           
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'UserName')
                    ->setCellValue('B1', 'Date')
                    ->setCellValue('C1', 'In Time')
                    ->setCellValue('D1', 'Out Time')
                    ->setCellValue('E1', "Type")
                    ->setCellValue('F1', "Remark")
                    ->setCellValue('G1', "Id Application");
        $i = 2 ;
        foreach($atten as $key => $value){
            $typecheck=$value->attendance->type;
            if($typecheck == '-1'){ $typecheck = 'invalid';
            }else{if($typecheck == 1){ $typecheck = 'present';}
                  else{ $typecheck = 'absent';}
            }
            $objPHPExcel->setActiveSheetIndex(0)   
                    ->setCellValue('A'.$i,$value->username)
                    ->setCellValue('B'.$i,$value->attendance->cdate)
                    ->setCellValue('C'.$i,$value->attendance->in_time)
                    ->setCellValue('D'.$i,$value->attendance->out_time)
                    ->setCellValue('E'.$i,$typecheck)
                    ->setCellValue('F'.$i,$value->attendance->remark) 
                    ->setCellValue('G'.$i,$value->attendance->idapplication);
            $i++;
        }
        for($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()
                        ->getColumnDimension($col)
                        ->setAutoSize(true);
            $objPHPExcel->getDefaultStyle($col)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $i = 1;
        for($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()->getStyle($col.$i)->getFont()->setBold(true);
        }
        $objPHPExcel->setActiveSheetIndex(0);                     
        $objPHPExcel->getActiveSheet()->setTitle('Attendance_worksheet');
        header('Content-Type: application/xlsx');
        $filename = "AttendanceReport_".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel , "Excel2007");
        $objWriter->save('php://output');  
        return false;  //$this->createExcel($atten);               
    }

    public function createExcel($atten){
        
    }

    public function leaveAllocationAction(){
        $numberPage = $this->request->getQuery("page", "int"); 
        $parameter = $this->persistent->searchParams;
        if (isset($_GET['user_list'])){    
            $from = $_GET['from'];  $to = $_GET['to'];  $user_id = $_GET['user_list'];
            if($from == ''){ $from = date('Y/m/1');}
            else{ $from = $from; }
            if($to == ''){ $to = date('Y/m/d'); }
            else{$to = $_GET['to'];}  
            if($user_id == 0){
                $query = new Query("SELECT User.iduser,User.username, Attendance.* FROM User
                JOIN Attendance ON (User.iduser = Attendance.iduser) WHERE 
                (Attendance.cdate BETWEEN '$from' AND '$to')AND (User.status = 1)",
                $this->getDI()); $atten = $query->execute();
            }else{
                $query = new Query("SELECT User.iduser, User.username, Attendance.* FROM 
                User JOIN Attendance ON (User.iduser = Attendance.iduser) WHERE
                (Attendance.iduser = $user_id) AND (Attendance.cdate BETWEEN '$from' AND
                '$to') AND (User.status = 1 )",$this->getDI());$atten = $query->execute();   
            }           
        }else{
            $from = date('Y-m-01'); $to = date('Y-m-t');                   
            $query = new Query("SELECT Attendance.*, User.username FROM Attendance JOIN 
            User WHERE (Attendance.iduser = User.iduser) AND (User.status = 1)
            AND (cdate BETWEEN '$from' AND '$to') ",$this->getDI());
            $atten = $query->execute();
        }
            if(!is_array($parameter)){
            $parameter = array();
            $paginator=new Paginator(array("data" => $atten,"limit" => 10,
                "page" => $numberPage));
            $page = $paginator->getPaginate();
            $this->view->page=$page; 
            if (isset($_GET['from']) && isset($_GET['to']) && isset($_GET['user_list'])){ 
                $this->view->parentUrl='attendance/leaveAllocation?from='.urlencode($_GET['from'] ).'&to='.urlencode($_GET['to'] ).'&user_list='.$_GET['user_list'].'&'; 
                $this->view->extractUrl='attendance/leaveAllocation?from='.urlencode($_GET['from'] ).
                '&to='.urlencode($_GET['to'] ).'&user_list='.$_GET['user_list'].'&'; 
            } else{
                $this->view->parentUrl='attendance/leaveAllocation?';
                $this->view->extractUrl='leaveAllocation/createExcel';   
            }  
        }
    }

    public function adjustLeaveAction(){
        $data = $_POST['data']; $field='';              
        foreach($data as $key){
            $u = new Query("SELECT cdate,iduser,type FROM Attendance WHERE 
            idattendance = $key ",$this->getDI()) ;  
            $r =  $u ->execute();
            $t = $r[0]["type"];
            switch($t){
                case '-1' :$t='Unmarked'; break;
                case '0' : $t='Absent'; break;
                case '1' : $t='Present'; break;
                case '2' : $t='PL'; break;
                case '3' : $t='CL'; break;
                case '4' : $t='SL'; break;
                case '5' : $t='Halfday'; break;
                case '6' : $t='Sunday'; break;
                case '7' : $t='Holiday'; break;
                case '8' : $t='2nd Saturday'; break;
                case '9' : $t='4th Saturday'; break;
            }
            $output[] = $this->countLeave($r[0]["iduser"]);
            $field .='<div class="form-group">';
            $field .='<label for="date">Dates</label>';
            $field .='<input type="text" name="date[]" class="form-control" readonly="readonly" value="'.$r[0]["cdate"].'"></input>';
            $field .='</div>';
            $field .='<div class="form-group">';
            $field .='<label for="date">Current Type</label>';
            $field .='<input type="text" class="form-control" readonly="readonly" value="'.$t.'"></input>';
            $field .='</div>';
            $field .='<p>';
            $field .='Remaining PL='.$output[0][0].', CL='.$output[0][1].', SL='.$output[0][2].'';
            $field .='</p>';
            $field .='<div class="form-group">';
            $field .='<label for="date">Type</label>';
            $field .='<select name="type[]" class="form-control">';
            $field .='<option value="-1">Unmarked</option>';
            $field .='<option value="0">Absent</option>';
            $field .='<option value="1">Present</option>';
            $field .='<option value="2">PL</option>';
            $field .='<option value="3">CL</option>';
            $field .='<option value="4">SL</option>';
            $field .='<option value="5">Halfday</option>';
            $field .='<option value="6">Sunday</option>';
            $field .='<option value="7">Holiday</option>';
            $field .='<option value="8">2nd Saturday</option>';
            $field .='<option value="9">4th Saturday</option>';
            $field .='</select>';
            $field .='</div>';
            $field .='<input type="hidden" class="form-control" name="idattendance[]" value="'.$key.'"></input><br>';           
        }
        $field .='<button type="submit" class="btn btn-default">Submit</button>' ;        
        echo $field; exit();    
    }

    public function countLeave($id){
        $query_pl = Systemmeta::Find();
        foreach ($query_pl as $key => $value) {
            $result = Application::Find(array("type='".$value->idsystem_meta."' And 
                iduser='".$id."'"));  $count_a = array();
            foreach($result as $key){          
                $date1=strtotime($key->from_date); $date2=strtotime($key->to_date);                            
                $time = $date2- $date1;              
                $diff = floor($time/60/60/24)+1;              
                $count_a[] = $diff ;
                $type=$key->type;             
            }      
            $find1 = Attendance::Find(array("type='".$value->idsystem_meta."' And 
                iduser='".$id."'"));
            $diff1 = count($find1);       
            $count_a[] = $diff1 ;
            $count = array_sum($count_a);
            $total= $value->meta_value;            
            if( $total >= $count){ $left = $total - $count; }
            else{ $left = 0; $panalty = $count - $total;}        
            $a[$value->meta_name]=$left;           
        }        
        $left_pl = $a['PL']; $left_cl = $a['CL']; $left_sl = $a['SL'];             
        return array($left_pl,$left_cl,$left_sl);
    }

    public function updateLeaveAction(){
      if ($this->request->isPost()) {    
        $date = $_POST['date']; 
        $type = $_POST['type'];
        $data = $_POST['idattendance'];
        $i=0 ;      
        foreach($data as $key){
            $query = new Query("UPDATE Attendance SET type=$type[$i] 
            WHERE idattendance = $key",
            $this->getDI()
            );
            $atten = $query->execute();
            $i++; 
        }
        $this->flash->success("Leave adjust successfully");
        return $this->response->redirect("attendance/leaveAllocation");
     }        
    }

    //filter according to date and users
    public function filterAction(){
        $type = $this->session->get('auth')['type'];
        $this->view->type =$type;
        $cdate = date('Y-m-d');
        //get users list
        $u =User::Find(array("columns" => "iduser , username"));
        echo"<pre>";print_r($u);die();
        $from = $_POST['from']; $to = $_POST['to']; 
        $numberPage = $this->request->getQuery("page", "int");  
        foreach($r as $key){          
            $id=$key->iduser;  //check presense of users in Attendance table 
            $atten_r = new Query("SELECT Attendance.* FROM Attendance WHERE 
            Attendance.iduser = $id AND (Attendance.cdate BETWEEN '$from' AND '$to')",
            $this->getDI()) ;
            $atten = $atten_r->execute();   
            if(!empty($atten[0])){            
            $paginator=new Paginator(array("data" => $atten,"limit" => 10,
                "page" => $numberPage));
            $page = $paginator->getPaginate();
            $this->view->page=$page;           
            }          
        }    
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {     
        $query = new Query("SELECT User.* FROM User 
        WHERE (User.status = 1)", $this->getDI());
        $user = $query->execute();                 
        $this->view->user = $user; 
        $type =$this->session->get('auth')['type'];
        $this->view->type = $type; 
    }

    /**
     * Edits a attendance
     *
     * @param string $idattendance
     */
    public function editAction($idattendance){
        $type = $this->session->get('auth')['type'];
        $this->view->type = $type; 
        if (!$this->request->isPost()) {
        $attendance = Attendance::findFirstByidattendance($idattendance);
        if (!$attendance) {
            $this->flash->error("Attendance was not found");
            return $this->dispatcher->forward(array(
                "controller" => "attendance","action" => "index"));
        }
        $this->view->idattendance = $attendance->idattendance;
        $this->tag->setDefault("idattendance", $attendance->idattendance);
        $this->tag->setDefault("iduser", $attendance->iduser);
        $this->tag->setDefault("cdate", $attendance->cdate);
        $this->tag->setDefault("in_time", $attendance->in_time);
        $this->tag->setDefault("out_time", $attendance->out_time);   
        $type= $attendance->type;
        $this->tag->setDefault("type", $type);
        $this->tag->setDefault("remark", $attendance->remark);
        $this->tag->setDefault("idapplication", $attendance->idapplication);        
        }
    }

    /**
     * Creates a new attendance
     */
    public function createAction(){
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "attendance","action" => "index"));
        }
        $attendancelog = serialize($_POST);
        $attendance = new Attendance();
        $attendance->idattendance = $this->request->getPost("idattendance");
        $attendance->iduser = $this->request->getPost("iduser");
        $attendance->cdate = $this->request->getPost("cdate");
        $attendance->in_time = $this->request->getPost("in_time");
        $attendance->out_time = $this->request->getPost("out_time");
        $attendance->created_on = $this->request->getPost("created_on");
        $attendance->updated_on = $this->request->getPost("updated_on");
        $attendance->type = $this->request->getPost("type");
        $attendance->remark = $this->request->getPost("remark");
        $attendance->idapplication = $this->request->getPost("idapplication");
        if (!$attendance->save()){
            DataLogger::attendacne('error', "\n\n Attendance not create \n {$attendancelog} \n\n");
            foreach ($attendance->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "attendance","action" => "new"));
        }else{
            $this->flash->success("Attendance was created successfully");
            return $this->response->redirect("attendance/index"); 
        }


    }

    /**
     * Saves a attendance edited
     *
     */
    public function saveAction(){
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "attendance",
                "action" => "index"));
        }
        $idattendance = $this->request->getPost("idattendance");
        $attendance = Attendance::findFirstByidattendance($idattendance);
        $attendancelog = serialize($_POST);       
        if (!$attendance) {
            DataLogger::attendacne('error', "\n\n Attendance not found \n {$attendancelog} \n\n");
            $this->flash->error("attendance does not exist " . $idattendance);
            return $this->dispatcher->forward(array("controller" => "attendance",
                "action" => "index"));
        }
        $attendance->idattendance = $this->request->getPost("idattendance");
        $attendance->iduser = $this->request->getPost("iduser");
        $attendance->cdate = $this->request->getPost("cdate");
        $attendance->in_time = $this->request->getPost("in_time");
        $attendance->out_time = $this->request->getPost("out_time");
        $attendance->updated_on = $this->request->getPost("updated_on");
        $t=$this->request->getPost("type");
        $attendance->type = $t;
        $attendance->remark = $this->request->getPost("remark");
        $attendance->idapplication = $this->request->getPost("idapplication");
        if (!$attendance->save()) {
            DataLogger::attendacne('error', "\n\n Attendance not update \n {$attendancelog} \n\n");
            foreach ($attendance->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array("controller" => "attendance",
                "action" => "edit","params" => array($attendance->idattendance)));
        }else{
            $this->flash->success("Attendance was updated successfully");
            return $this->response->redirect("attendance/index"); 
        } 
    }

    /**
     * Deletes a attendance
     *
     * @param string $idattendance
     */
    public function deleteAction($idattendance){
        $attendance = Attendance::findFirstByidattendance($idattendance);
        if (!$attendance) {
            $this->flash->error("attendance was not found");
            return $this->dispatcher->forward(array("controller" => "attendance",
                "action" => "index"));
        }
        if (!$attendance->delete()) {
            foreach ($attendance->getMessages() as $message) {
                $this->flash->error($message);}
            return $this->dispatcher->forward(array("controller" => "attendance",
                "action" => "search"));
        }else{
            $this->flash->success("Attendance was deleted successfully");
            return $this->response->redirect("attendance/index"); 
        } 
    }
}