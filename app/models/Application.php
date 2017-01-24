<?php
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\InclusionIn;
use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;
use Phalcon\Mvc\Model\Relation;

class Application extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idapplication;

    /**
     *
     * @var integer
     */
    public $iduser;

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
    public $type;

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
     * @var integer
     */
    public $status;

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


    public function validation(){

        $this->validate(
            new InclusionIn(
                array(
                    "field"   => "type",
                    "message" => "Type must be: PL, CL or SL",
                    "domain"  => array("2", "3","4","PL","CL","SL")
                )
            )
        );

        $this->validate(
            new InclusionIn(
                array(
                    "field"   => "status",
                    "message" => "Status must be: Pending, Approved or Reject",
                    "domain"  => array("1", "2","3","Pending","Approved","Rejected")
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
            new StringLengthValidator(
                array(
                    "field" => "title",
                    "max"   => 256,
                    "messageMaximum" => "Title must be less than 256 char"
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
        return 'application';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Application[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Application
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
