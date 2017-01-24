<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DashboardController extends ControllerBase
{
	public function initialize(){
    $this->tag->setTitle('Users List');
    parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction(){  
        $present = 0; $absent = 0; $invalid =0;  $cdate = date('Y-m-d');
        $id = $this->session->get('auth')['id'];
        $this->view->id = $id;
        if($_SESSION['auth']){ $type = $this->session->get('auth')['type'];}      
        $this->view->type = $type;    
        if($type == 1 || $type == 2){  //page redirect according to users type  
            $this->view->today_date = $cdate;
            $numberPage = $this->request->getQuery("page", "int");
            $parameter = $this->persistent->searchParams;          
            $current_date=date("Y/m/d");
            $query = new Query("SELECT DISTINCT (u.iduser), u.iduser, u.username, a.type                         
                FROM User u LEFT JOIN Attendance a ON u.iduser = a.iduser 
                AND cdate = :cdate:",$this->getDI());
            $atten = $query->execute(array(
                'cdate' => $current_date
            ));  /*count for present and absent employees */        
            foreach ($atten as $key => $value) {                  
                if($value->type == '1'){ $present = $present + 1;}
                elseif($value->type == '0'){ $absent = $absent + 1;}
                else{ $invalid = $invalid + 1;}                   
            }//find remaining PL ,CL,SL
             /* *timer start and stop for manager on page refresh
                *calculate hours of current day when user stop timer before*/
            $this->countLeave($id);           
            if($type == 2){
                $this->startStopTimer($id,$cdate);               
                $this->calculateHours($id,$cdate);
            }            
            $this->view->present = $present; 
            $this->view->absent = $absent;
            $this->view->unmarked = $invalid; 
            if(!is_array($parameter)){
            $parameter = array();             
            $paginator=new Paginator(array(
                "data" => $atten,"limit" => 10,"page" => $numberPage));
            $page = $paginator->getPaginate();            
            $this->view->page=$page;  
            }else{
                $this->dispatcher->forward(array(
                'controller' => 'dashboard','action' => 'index'));
           }
        }else{ return $this->response->redirect('dashboard/new');}             
   }

    public function newAction(){       
        $type = $this->session->get('auth')['type'];
        $id = $this->session->get('auth')['id'];
        $this->view->type = $type;       
        $this->view->id = $id;
        $present = 0; $invalid = 0; $absent = 0;
        $cdate = date('Y-m-d');$from = date('Y-m-01'); $to = date('Y-m-t');
        $numberPage = $this->request->getQuery("page", "int");                    
        $parameter = $this->persistent->searchParams;
        $query = new Query("SELECT Attendance.*, User.username FROM Attendance JOIN User
        ON Attendance.iduser = User.iduser WHERE Attendance.iduser = $id 
        AND (cdate BETWEEN '$from' AND '$to') ",$this->getDI());
        $atten = $query->execute();
         /* calculate total absent and present of current month */
        foreach($atten as $key => $value) { 
          $t = $value['attendance']->type;
          if($t == 1){
            $q = new Query("SELECT distinct cdate FROM Attendance WHERE type = 1 ",
                $this->getDI());
            $a = $q->execute();
            $present = count($a);
          }elseif($t == -1 ){ $invalid = $invalid + 1; }
                else{$absent = $absent + 1;}          
        }$this->view->present = $present; 
        $this->view->absent = $absent;       
        /* *calculate todays no of working hours when user already stop the timer
        *query to show stop button on page refresh or page reload
        *find Remaining PL, SL, CL, */      
        $this->calculateHours($id ,$cdate);        
        $this->startStopTimer($id,$cdate);                
        $this->countLeave($id);
        if(!is_array($parameter)){
            $parameter = array();
            $paginator=new Paginator(array(
                "data" => $atten,"limit" => 10,"page" => $numberPage)); 
            $page = $paginator->getPaginate();           
            $this->view->page=$page;  
        }else{
            $this->dispatcher->forward(array(
                'controller' => 'dashboard','action' => 'new'));
        }               
    }
    
        //find remaining PL,CL,SL
    public function countLeave($id){
        $query_pl = Systemmeta::Find();
        foreach ($query_pl as $key => $value) {
            $result = Application::Find(array("type='".$value->idsystem_meta."' And 
                iduser='".$id."'")); $count_a = array();    
            foreach($result as $key){          
                $date1=strtotime($key->from_date);             
                $date2=strtotime($key->to_date);                  
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
        $this->view->left_pl = $a['PL'];              
        $this->view->left_cl = $a['CL'];           
        $this->view->left_sl = $a['SL'];
    }
      //query to show stop button on page refresh or page reload 
    public function startStopTimer($id ,$cdate){     
        $result = Attendance::Find(array("iduser = '".$id."' and cdate = '".$cdate."'"));
        foreach($result as $key){
            $intime= $key->in_time;
            $outtime = $key->out_time;
        } 
        if($intime != null && $outtime == null ){  
            $sec = strtotime($intime);
            $now = strtotime(date('H:i:s'));
            $this->view->sec = $now - $sec; 
            $tsec= $now - $sec;
            $this->view->hours = sprintf("%02d", ($tsec/3600)%60);
            $this->view->mins = sprintf("%02d", ($tsec/60)%60);
            $this->view->second = sprintf("%02d", $tsec%60);
        }else{
            $this->view->sec=0;
            $this->view->hours = sprintf("%02d", 0);
            $this->view->mins = sprintf("%02d", 0);
            $this->view->second = sprintf("%02d", 0);
        }
    }

    /* calculate Total Hours of current day*/
    public function calculateHours($id , $cdate){
        $r = Attendance::Find(array("iduser = '".$id."' and cdate = '".$cdate."'"));
        $h =0;
        foreach($r as $key){
            if($key->out_time != null){
                $in = strtotime($key->in_time);                        
                $out = strtotime($key->out_time);                        
                $h = $h + ($out - $in);                
            }
        } 
        $hrs= gmdate('H:i:s',$h);
        $this->view->total_hours = $hrs;
        $this->view->total_seconds = $h;
    }

    /* calling from ajax when start timer*/
    public function startTimeAction(){
        $this->view->total_hrs = 0;
        $id = $this->session->get('auth')['id'];
        $in = date('H:i:s');
        $cdate = date('Y-m-d');   
        $attendance = new Attendance();
        $attendance->iduser = $id;
        $attendance->cdate = $cdate;
        $attendance->in_time = $in;
        $attendance->type = 1;
        if($attendance->save()){               
            echo 'disable'; exit();    
        }else{
            echo"<pre>";print_r($attendance->getMessage()); die();  
        }  
    }
     /* calling from ajax when stop timer*/
    public function stopTimeAction(){          
        $id = $this->session->get('auth')['id'];
        $cdate = date('Y-m-d');
        $outtime = date('H:i:s');
        $this->view->sec = 0;    //find idattendance from newly added row         
        $atten = Attendance::Find(array("iduser = '".$id."' and cdate = '".$cdate."'"));
        foreach($atten as $key){
            $idatten= $key->idattendance;
        }  
        $q = new Query("UPDATE Attendance SET out_time = :outtime:
            WHERE idattendance = :id: ",$this->getDI());
        $a = $q->execute(array(
            "outtime" => $outtime,"id" => $idatten ));     
        if($a->success() == true){
            echo 'disable'; exit();
        } else{
            echo 'enable'; exit();
        }      
    }
}
