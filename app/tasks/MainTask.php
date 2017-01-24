<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;


class MainTask extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
       echo "\nThis is the Main task and the default action \n";

        /*$this->console->handle(
            array(
                'task'   => 'main',
                'action' => 'test'
            )
        );*/
    }
    //mark absent 
     public function createAction()
    {

     
        echo "\n";
        echo "Script Run on : ".date('Y-m-d H:i:s')."\n";
        $cdate = date('Y-m-d');

        $query = new Query("SELECT * FROM Application 
            WHERE (status = 2) AND ('$cdate' BETWEEN from_date AND to_date) ",
            $this->getDI()
        );
        $atten = $query->execute(); 
         

        if(!empty($atten[0])){  
            foreach ($atten as $value) {
                $attendance = new Attendance();
                $attendance->iduser = $value->iduser;
                $attendance->cdate = $cdate;
                $attendance->in_time = '00:00:00';
                $attendance->out_time = '00:00:00';
                $attendance->type = 0;
                $attendance->idapplication = $value->idapplication;
                $attendance->save();
            }
            if(!$attendance->save()){
                echo "Error in inserting data.\n";
            }else{
                echo "Data inserted Successfully.\n";
            }
        }else{
            echo "Application is not submitted on today's date.\n";
        }
        
        

      echo "Script Ends on : ".date('Y-m-d H:i:s')."\n";   
    }
}