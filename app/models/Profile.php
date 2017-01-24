<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;
use Phalcon\Mvc\Model\Validator\Numericality as NumericalityValidator;
use Phalcon\Mvc\Model\Validator\Regex;

class Profile extends \Phalcon\Mvc\Model
{

         /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_meta';
    }

    /**
     *
     * @var integer
     */
    public $iduser_meta;

    /**
     *
     * @var integer
     */
    public $iduser;

    /**
     *
     * @var string
     */
    public $first_name;

    /**
     *
     * @var string
     */
    public $last_name;

    /**
     *
     * @var string
     */
    public $designation;

    /**
     *
     * @var string
     */
    public $dob;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $alt_phone;

    /**
     *
     * @var string
     */
    public $landline;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $alt_email;

    /**
     *
     * @var string
     */
    public $current_address;

    /**
     *
     * @var string
     */
    public $permanent_address;

    /**
     *
     * @var string
     */
    public $communication_address;

    /**
     *
     * @var string
     */
    public $landlord_detail;

    /**
     *
     * @var string
     */
    public $father_name;

    /**
     *
     * @var string
     */
    public $father_phone;

    /**
     *
     * @var string
     */
    public $mother_name;

    /**
     *
     * @var string
     */
    public $mother_phone;

    /**
     *
     * @var string
     */
    public $pan;

    /**
     *
     * @var string
     */
    public $bank;

    /**
     *
     * @var string
     */
    public $branch;

    /**
     *
     * @var string
     */
    public $account_number;

    /**
     *
     * @var string
     */
    public $micr_code;

    /**
     *
     * @var string
     */
    public $ifsc;

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

        /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $p =$_POST['profile'];
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true
                )
            )
        );
        if(!empty($p['alt_email'])){
            $this->validate(
                new Email(
                    array(
                        'field'    => 'alt_email',
                        'required' => false
                    )
                )
            );
        }
        $this->validate(
                new Regex(
                    array(
                        "field" => 'phone',
                        "pattern" => '/^(\+91-|\+91|0)?\d{10}$/',
                        "message" => 'Phone Number is invalid '
                    )
                )
            );
        if(!empty($p['alt_phone'])){
            $this->validate(
                new Regex(
                    array(
                        "field" => 'alt_phone',
                        "pattern" => '/^(\+91-|\+91|0)?\d{10}$/',
                        "message" => 'Alternate Phone Number is invalid '
                    )
                )
            );
        }

        if(!empty($p['landline'])){
            $this->validate(
                new NumericalityValidator(
                    array(
                        "field" => 'landline'
                    )
                )
            );
        }
        $this->validate(
            new NumericalityValidator(
                array(
                    "field" => 'father_phone'
                )
            )
        );
        $this->validate(
                new Regex(
                    array(
                        "field" => 'father_phone',
                        "pattern" => '/^(\+91-|\+91|0)?\d{10}$/',
                        "message" => 'Father Phone Number is invalid '
                    )
                )
            );
        if(!empty($p['mother_phone'])){
            $this->validate(
                new Regex(
                    array(
                        "field" => 'mother_phone',
                        "pattern" => '/^(\+91-|\+91|0)?\d{10}$/',
                        "message" => 'Mother Phone Number is invalid '
                    )
                )
            );
        }
        $this->validate(
            new NumericalityValidator(
                array(
                    "field" => 'account_number'
                )
            )
        ); 
        if ($this->validationHasFailed() == true) {
            return false;
        }
        return true;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserMeta[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserMeta
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
