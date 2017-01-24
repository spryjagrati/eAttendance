<?php
use Phalcon\Mvc\Model;
class EmailConfirmations extends Model
{
    
 
    /**
     * @var integer
     */
    public $id;
    /**
     * @var integer
     */
    public $iduser;
    public $code;
    /**
     * @var integer
     */
    public $createdAt;
    /**
     * @var integer
     */
    public $modifiedAt;
    public $confirmed;
    /**
     * Before create the user assign a password
     */
    /*public function beforeValidationOnCreate()
    {
        //Timestamp the confirmaton
        $this->createdAt = time();
        //Generate a random confirmation code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));
        //Set status to non-confirmed
        $this->confirmed = 'N';
    }*/
    /**
     * Sets the timestamp before update the confirmation
     */
    /*public function beforeValidationOnUpdate()
    {
        //Timestamp the confirmaton
        $this->modifiedAt = time();
    }*/

    public function initialize()
    {
        $this->belongsTo('iduser', 'User', 'iduser', array(
            'alias' => 'user'
        ));
    }
    /**
     * Send a confirmation e-mail to the user after create the account
     */
    public function afterCreate( $email,$username)
    {

    $output = $this->getDI()->getMail()->send(
            array(
                $email   
            ),
                        
            "Please confirm your email",
            'confirmation',
            array(
                'confirmUrl' => '/confirm/' . '/' . $email
            )
        );    
    return $output;

    }
    
}