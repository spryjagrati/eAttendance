 <?php

use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;


class Document extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $iddocument;

    /**
     *
     * @var integer
     */
    public $iduser;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $taken_date;

    /**
     *
     * @var string
     */
    public $given_date;

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

     public function validation()
    {
        $this->validate(
            new StringLengthValidator(
                array(
                    "field" => "title",
                    "max"   => 256,
                    "messageMaximum" => "Title must be less than 256 char"                   
                )

            )

        );

        $this->validate(
            new StringLengthValidator(
                array(
                    "field" => "description",
                    "min"   => 1,
                    "messageMinimum" => "Description must be more than 1 char"                  
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
        return 'document';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Document[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Document
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
