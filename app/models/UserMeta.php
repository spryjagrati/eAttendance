<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class UserMeta extends \Phalcon\Mvc\Model
{

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
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('iduser', 'User', 'iduser', array('alias' => 'User'));
    }

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
