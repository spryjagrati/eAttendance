<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class SystemMetaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for system_meta
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "SystemMeta", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "idsystem_meta";

        $system_meta = SystemMeta::find($parameters);
        if (count($system_meta) == 0) {
            $this->flash->notice("The search did not find any system_meta");

            return $this->dispatcher->forward(array(
                "controller" => "system_meta",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $system_meta,
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
     * Edits a system_meta
     *
     * @param string $idsystem_meta
     */
    public function editAction($idsystem_meta)
    {

        if (!$this->request->isPost()) {

            $system_meta = SystemMeta::findFirstByidsystem_meta($idsystem_meta);
            if (!$system_meta) {
                $this->flash->error("system_meta was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "system_meta",
                    "action" => "index"
                ));
            }

            $this->view->idsystem_meta = $system_meta->idsystem_meta;

            $this->tag->setDefault("idsystem_meta", $system_meta->idsystem_meta);
            $this->tag->setDefault("meta_name", $system_meta->meta_name);
            $this->tag->setDefault("meta_value", $system_meta->meta_value);
            
        }
    }

    /**
     * Creates a new system_meta
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "system_meta",
                "action" => "index"
            ));
        }

        $system_meta = new SystemMeta();

        $system_meta->meta_name = $this->request->getPost("meta_name");
        $system_meta->meta_value = $this->request->getPost("meta_value");
        

        if (!$system_meta->save()) {
            foreach ($system_meta->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "system_meta",
                "action" => "new"
            ));
        }

        $this->flash->success("system_meta was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "system_meta",
            "action" => "index"
        ));

    }

    /**
     * Saves a system_meta edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "system_meta",
                "action" => "index"
            ));
        }

        $idsystem_meta = $this->request->getPost("idsystem_meta");

        $system_meta = SystemMeta::findFirstByidsystem_meta($idsystem_meta);
        if (!$system_meta) {
            $this->flash->error("system_meta does not exist " . $idsystem_meta);

            return $this->dispatcher->forward(array(
                "controller" => "system_meta",
                "action" => "index"
            ));
        }

        $system_meta->meta_name = $this->request->getPost("meta_name");
        $system_meta->meta_value = $this->request->getPost("meta_value");
        

        if (!$system_meta->save()) {

            foreach ($system_meta->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "system_meta",
                "action" => "edit",
                "params" => array($system_meta->idsystem_meta)
            ));
        }

        $this->flash->success("system_meta was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "system_meta",
            "action" => "index"
        ));

    }

    /**
     * Deletes a system_meta
     *
     * @param string $idsystem_meta
     */
    public function deleteAction($idsystem_meta)
    {

        $system_meta = SystemMeta::findFirstByidsystem_meta($idsystem_meta);
        if (!$system_meta) {
            $this->flash->error("system_meta was not found");

            return $this->dispatcher->forward(array(
                "controller" => "system_meta",
                "action" => "index"
            ));
        }

        if (!$system_meta->delete()) {

            foreach ($system_meta->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "system_meta",
                "action" => "search"
            ));
        }

        $this->flash->success("system_meta was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "system_meta",
            "action" => "index"
        ));
    }

}
