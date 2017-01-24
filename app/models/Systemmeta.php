<?php

class Systemmeta extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idsystem_meta;

    /**
     *
     * @var string
     */
    public $meta_name;

    /**
     *
     * @var string
     */
    public $meta_value;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'system_meta';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SystemMeta[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SystemMeta
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
