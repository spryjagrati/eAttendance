<?php

use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;
use Phalcon\Mvc\Model\Validator\Numericality as NumericalityValidator;


class Attendance extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idattendance;

    /**
     *
     * @var integer
     */
    public $iduser;

    /**
     *
     * @var string
     */
    public $cdate;

    /**
     *
     * @var string
     */
    public $in_time;

    /**
     *
     * @var string
     */
    public $out_time;

    /**
     *
     * @var string
     */
    public $created_on;

    /**
     *
     * @var string
     */
    public $updated_on;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var string
     */
    public $remark;

    /**
     *
     * @var integer
     */
    public $idapplication;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('iduser', 'User', 'iduser', array('alias' => 'User'));
        $this->addBehavior(
            new Timestampable(
                array(
                    'beforeCreate' => array(
                        'field'  => 'created_on',
                        'format' => 'Y-m-d H:i:sP'
                        
                    )
                )
            )
        );


        $this->addBehavior(
            new Timestampable(
                array(
                    'beforeCreate' => array(
                        'field'  => 'updated_on',
                        'format' => 'Y-m-d H:i:sP'
                    )
                )
            )
        );

        $this->addBehavior(
            new Timestampable(
                array(
                    'beforeUpdate' => array(
                        'field'  => 'updated_on',
                        'format' => 'Y-m-d H:i:sP'
                    )
                )
            )
        );
    }

     public function validation()
    {
        $this->validate(
            new StringLengthValidator(
                array(
                    "field" => "remark",
                    "max"   => 30,
                    "messageMaximum" => "Remark must be less than 30 char"
                    
                    
                )

            )

        );
        /*$this->validate(
            new NumericalityValidator(
                array(
                    "field" => 'idapplication'
                )
            )
        );*/

         if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }





    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'attendance';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Attendance[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Attendance
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
