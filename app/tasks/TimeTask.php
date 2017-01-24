<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;

class TimeTask extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
       echo "\nThis is the Time task and the default action \n";
    }
     public function createAction()
    { 
        echo "\n";
        echo "Script Run on : ".date('Y-m-d H:i:s')."\n\n";
       
        $cdate = date('Y-m-d');  // insert out time and stop timer
        $query = new Query("SELECT * FROM Attendance WHERE cdate = '$cdate'",
            $this->getDI());
        $result = $query->execute();
        foreach ($result as $key ) {
            $in = $key->in_time;
            $out = $key->out_time;
            $id = $key->idattendance;
            if( $in != null && $out == null){
                $q = new Query("UPDATE Attendance SET out_time = '18:15:00'
                        WHERE idattendance = :id: ",$this->getDI() );
                $a = $q->execute(array("id" => $id));                
            }
        }
        echo "Insert out time and stop timer "."\n";
        
        //insert data for unmarked user
        /*$query_user = new Query("SELECT iduser FROM User",
                $this->getDI());
        $user_id = $query_user->execute();*/
        //$cdate = date('Y-m-d');
        $user_id =User::Find(array("columns" => "iduser"));   
        $query = new Query("SELECT meta_value FROM Systemmeta   
                WHERE (meta_name LIKE '2016_official_leave_%')
                AND meta_value = '$cdate'  ",$this->getDI());
        $atten = $query->execute();
   
        $weekDay = date('w', strtotime($cdate));
        if($weekDay == 0){
            $type = 6;
        }else{
            if(!empty($atten[0]->meta_value)){
                $type = 7;
            }else{
                $type = -1;
            } 
        }
    
        foreach ($user_id as $key) {
            $iduser = $key->iduser;
            $q = new Query("SELECT * FROM Attendance WHERE iduser = $iduser AND 
                cdate ='$cdate'", $this->getDI());
            $a = $q->execute();
            if(empty($a[0])){
                $attendance = new Attendance();
                $attendance->iduser = $iduser;
                $attendance->cdate = $cdate;
                $attendance->in_time = '00:00:00';
                $attendance->out_time = '00:00:00';
                $attendance->type = $type;
                $attendance->save();
                echo "inserted row"."\n";
            }                     
        }
        echo "Mark official leaves"."\n";
        echo "\n";
        echo "Script Ends on : ".date('Y-m-d H:i:s')."\n";   
    }
}