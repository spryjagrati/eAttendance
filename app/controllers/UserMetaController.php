<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class UserMetaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for user_meta
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "UserMeta", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "iduser_meta";

        $user_meta = UserMeta::find($parameters);
        if (count($user_meta) == 0) {
            $this->flash->notice("The search did not find any user_meta");

            return $this->dispatcher->forward(array(
                "controller" => "user_meta",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $user_meta,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a user_meta
     *
     * @param string $iduser_meta
     */
    public function editAction($iduser_meta)
    {

        if (!$this->request->isPost()) {

            $user_meta = UserMeta::findFirstByiduser_meta($iduser_meta);
            if (!$user_meta) {
                $this->flash->error("user_meta was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "user_meta",
                    "action" => "index"
                ));
            }

            $this->view->iduser_meta = $user_meta->iduser_meta;

            $this->tag->setDefault("iduser_meta", $user_meta->iduser_meta);
            $this->tag->setDefault("iduser", $user_meta->iduser);
            $this->tag->setDefault("first_name", $user_meta->first_name);
            $this->tag->setDefault("last_name", $user_meta->last_name);
            $this->tag->setDefault("designation", $user_meta->designation);
            $this->tag->setDefault("dob", $user_meta->dob);
            $this->tag->setDefault("phone", $user_meta->phone);
            $this->tag->setDefault("alt_phone", $user_meta->alt_phone);
            $this->tag->setDefault("landline", $user_meta->landline);
            $this->tag->setDefault("email", $user_meta->email);
            $this->tag->setDefault("alt_email", $user_meta->alt_email);
            $this->tag->setDefault("current_address", $user_meta->current_address);
            $this->tag->setDefault("permanent_address", $user_meta->permanent_address);
            $this->tag->setDefault("communication_address", $user_meta->communication_address);
            $this->tag->setDefault("landlord_detail", $user_meta->landlord_detail);
            $this->tag->setDefault("father_name", $user_meta->father_name);
            $this->tag->setDefault("father_phone", $user_meta->father_phone);
            $this->tag->setDefault("mother_name", $user_meta->mother_name);
            $this->tag->setDefault("mother_phone", $user_meta->mother_phone);
            $this->tag->setDefault("pan", $user_meta->pan);
            $this->tag->setDefault("bank", $user_meta->bank);
            $this->tag->setDefault("branch", $user_meta->branch);
            $this->tag->setDefault("account_number", $user_meta->account_number);
            $this->tag->setDefault("micr_code", $user_meta->micr_code);
            $this->tag->setDefault("ifsc", $user_meta->ifsc);
            $this->tag->setDefault("created_by", $user_meta->created_by);
            $this->tag->setDefault("updated_by", $user_meta->updated_by);
            $this->tag->setDefault("created_on", $user_meta->created_on);
            $this->tag->setDefault("updated_on", $user_meta->updated_on);
            
        }
    }

    /**
     * Creates a new user_meta
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "user_meta",
                "action" => "index"
            ));
        }
        $usermetalog = serialize($_POST);
        $user_meta = new UserMeta();
        $user_meta->iduser = $this->request->getPost("iduser");
        $user_meta->first_name = $this->request->getPost("first_name");
        $user_meta->last_name = $this->request->getPost("last_name");
        $user_meta->designation = $this->request->getPost("designation");
        $user_meta->dob = $this->request->getPost("dob");
        $user_meta->phone = $this->request->getPost("phone");
        $user_meta->alt_phone = $this->request->getPost("alt_phone");
        $user_meta->landline = $this->request->getPost("landline");
        $user_meta->email = $this->request->getPost("email", "email");
        $user_meta->alt_email = $this->request->getPost("alt_email");
        $user_meta->current_address = $this->request->getPost("current_address");
        $user_meta->permanent_address = $this->request->getPost("permanent_address");
        $user_meta->communication_address = $this->request->getPost("communication_address");
        $user_meta->landlord_detail = $this->request->getPost("landlord_detail");
        $user_meta->father_name = $this->request->getPost("father_name");
        $user_meta->father_phone = $this->request->getPost("father_phone");
        $user_meta->mother_name = $this->request->getPost("mother_name");
        $user_meta->mother_phone = $this->request->getPost("mother_phone");
        $user_meta->pan = $this->request->getPost("pan");
        $user_meta->bank = $this->request->getPost("bank");
        $user_meta->branch = $this->request->getPost("branch");
        $user_meta->account_number = $this->request->getPost("account_number");
        $user_meta->micr_code = $this->request->getPost("micr_code");
        $user_meta->ifsc = $this->request->getPost("ifsc");
        $user_meta->created_by = $this->request->getPost("created_by");
        $user_meta->updated_by = $this->request->getPost("updated_by");
        $user_meta->created_on = $this->request->getPost("created_on");
        $user_meta->updated_on = $this->request->getPost("updated_on");
        

        if (!$user_meta->save()) {
            DataLogger::usermeta('error', "\n\n UserMeta not create \n {$usermetalog} \n\n");
            foreach ($user_meta->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "user_meta",
                "action" => "new"
            ));
        }

        $this->flash->success("user_meta was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "user_meta",
            "action" => "index"
        ));

    }

    /**
     * Saves a user_meta edited
     *
     */
    public function saveAction()
    {

        
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "user_meta",
                "action" => "index"
            ));
        }

        $iduser_meta = $this->request->getPost("iduser_meta");

        $user_meta = UserMeta::findFirstByiduser_meta($iduser_meta);
        if (!$user_meta) {
            $this->flash->error("user_meta does not exist " . $iduser_meta);

            return $this->dispatcher->forward(array(
                "controller" => "user_meta",
                "action" => "index"
            ));
        }
        $usermetalog = serialize($_POST);
        $user_meta->iduser = $this->request->getPost("iduser");
        $user_meta->first_name = $this->request->getPost("first_name");
        $user_meta->last_name = $this->request->getPost("last_name");
        $user_meta->designation = $this->request->getPost("designation");
        $user_meta->dob = $this->request->getPost("dob");
        $user_meta->phone = $this->request->getPost("phone");
        $user_meta->alt_phone = $this->request->getPost("alt_phone");
        $user_meta->landline = $this->request->getPost("landline");
        $user_meta->email = $this->request->getPost("email", "email");
        $user_meta->alt_email = $this->request->getPost("alt_email");
        $user_meta->current_address = $this->request->getPost("current_address");
        $user_meta->permanent_address = $this->request->getPost("permanent_address");
        $user_meta->communication_address = $this->request->getPost("communication_address");
        $user_meta->landlord_detail = $this->request->getPost("landlord_detail");
        $user_meta->father_name = $this->request->getPost("father_name");
        $user_meta->father_phone = $this->request->getPost("father_phone");
        $user_meta->mother_name = $this->request->getPost("mother_name");
        $user_meta->mother_phone = $this->request->getPost("mother_phone");
        $user_meta->pan = $this->request->getPost("pan");
        $user_meta->bank = $this->request->getPost("bank");
        $user_meta->branch = $this->request->getPost("branch");
        $user_meta->account_number = $this->request->getPost("account_number");
        $user_meta->micr_code = $this->request->getPost("micr_code");
        $user_meta->ifsc = $this->request->getPost("ifsc");
        $user_meta->created_by = $this->request->getPost("created_by");
        $user_meta->updated_by = $this->request->getPost("updated_by");
        $user_meta->created_on = $this->request->getPost("created_on");
        $user_meta->updated_on = $this->request->getPost("updated_on");
        

        if (!$user_meta->save()) {
            DataLogger::usermeta('error', "\n\n UserMeta not update \n {$usermetalog} \n\n");
            foreach ($user_meta->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "user_meta",
                "action" => "edit",
                "params" => array($user_meta->iduser_meta)
            ));
        }

        $this->flash->success("user_meta was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "user_meta",
            "action" => "index"
        ));

    }

    /**
     * Deletes a user_meta
     *
     * @param string $iduser_meta
     */
    public function deleteAction($iduser_meta)
    {

        $user_meta = UserMeta::findFirstByiduser_meta($iduser_meta);
        if (!$user_meta) {
            $this->flash->error("user_meta was not found");

            return $this->dispatcher->forward(array(
                "controller" => "user_meta",
                "action" => "index"
            ));
        }

        if (!$user_meta->delete()) {

            foreach ($user_meta->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "user_meta",
                "action" => "search"
            ));
        }

        $this->flash->success("user_meta was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "user_meta",
            "action" => "index"
        ));
    }

}
