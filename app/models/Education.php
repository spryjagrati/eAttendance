
<?php
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;
use Phalcon\Mvc\Model\Validator\Numericality as NumericalityValidator;


class Education extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $ideducation;

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
    public $from_date;

    /**
     *
     * @var string
     */
    public $to_date;

    /**
     *
     * @var string
     */
    public $college;

    /**
     *
     * @var string
     */
    public $grade;

    /**
     *
     * @var string
     */
    public $stream;

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
                    "max"   => 64,
                    "messageMaximum" => "Title must be less than 64 char"                   
                )

            )

        );

        /*$this->validate(
            new StringLengthValidator(
                array(
                    "field" => "description",
                    "min"   => 1,                 
                    "messageMinimum" => "Description must be more than 1 char"                   
                )

            )

        );*/
        $this->validate(
            new NumericalityValidator(
                array(
                    "field" => 'grade'
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
        return 'education';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Education[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Education
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
