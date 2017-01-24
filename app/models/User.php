<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Mvc\Model\Validator\InclusionIn;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;
use Phalcon\Mvc\Model\Validator\Numericality as NumericalityValidator;
use Phalcon\Mvc\Model\Behavior\Timestampable;
// /use Phalcon\Mvc\Model\Blameable;
use Phalcon\Mvc\Model\Relation;


class User extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $iduser;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $password_reset_digest;

    /**
     *
     * @var integer
     */
    public $created_by;

    /**
     *
     * @var integer
     */
    public $updated_by;

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
     * Initialize method for model.
     */
    
   
    public function initialize()
    {

        // $this->addBehavior(new Blameable());

         
        $this->hasMany('iduser', 'Application', 'iduser', array('alias' => 'Application', 
                        "foreignKey" => 
                            array("message" => "The part cannot be deleted because 
                                    other Models are using it",
                                    'action' => Relation::ACTION_CASCADE
                            )
                        )
                );
        $this->hasMany('iduser', 'Attendance', 'iduser', array('alias' => 'Attendance'));
        $this->hasMany('iduser', 'Document', 'iduser', array('alias' => 'Document'));
        $this->hasMany('iduser', 'Education', 'iduser', array('alias' => 'Education'));
        $this->hasMany('iduser', 'Experience', 'iduser', array('alias' => 'Experience'));
        $this->hasMany('iduser', 'UserMeta', 'iduser', array('alias' => 'UserMeta'));


       // $this->addBehavior(new Blameable());

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

         //$this->addBehavior(new Blameable());

    }


    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        //echo $this->email;die();
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true
                )
            )
        );

        // email uniqueness
        $this->validate(
            new Uniqueness(
                array(
                    "field"   => "email",
                    "message" => "The Email name must be unique"
            )
        ));

         // username uniqueness
        $this->validate(
            new Uniqueness(
                array(
                    "field"   => "username",
                    "message" => "The UserName must be unique"
            )
        ));

       $this->validate(
            new InclusionIn(
                array(
                    "field"   => "type",
                    "message" => "Type must be: Admin, Manager or Employee",
                    "domain"  => array("1", "2","3","admin","manager","employee")
                )
            )
        );

       $this->validate(
            new StringLengthValidator(
                array(
                    "field" => "password",
                    "min"   => 6,
                    "messageMinimum" => "Password should be 6 char"
                )

            )

        );


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
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
