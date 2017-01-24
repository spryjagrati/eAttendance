<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\Model as Paginator;

class SystemmetaController extends ControllerBase
{
    public function initialize(){
        $this->tag->setTitle('Setting List');
        parent::initialize();
    }
    /**
     * Index action
     */
    public function indexAction(){
        if($_SESSION['auth']){
            $type = $this->session->get('auth')['type'];
        }         
        $this->view->type =$type;
        if($type == 1 || $type == 2){
            $numberPage =1 ;
            if ($this->request->isPost()) {                   
                $query = Criteria::formInput($this->di,"Systemmeta", $_POST);
                $this->persistent->parameters = $query->getParams();
            }else{
                $numberPage = $this->request->getQuery("page", "int");   
            }           
            $parameter = $this->persistent->searchParams;
            $atten = Systemmeta::Find();
            if(!is_array($parameter)){
                $parameter = array();
                $paginator=new Paginator(array(
                    "data" => $atten, "limit" => 10,"page" => $numberPage)
                );
                $page = $paginator->getPaginate();
                $this->view->page=$page;
            }else{
                $this->dispatcher->forward(array(
                    'controller' => 'systemmeta','action' => 'index'
                ));
            }
        }  
    }
    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $type = $this->session->get('auth')['type'];
        $this->view->type =$type;
    }

    /**
     * Edits a system_meta
     *
     * @param string $idsystem_meta
     */
    public function editAction($idsystem_meta){
        $type = $this->session->get('auth')['type'];
        $this->view->type =$type;
        if (!$this->request->isPost()) {
            $system_meta = Systemmeta::findFirstByidsystem_meta($idsystem_meta);
            if (!$system_meta) {
                $this->flash->error("system_meta was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "systemmeta", "action" => "index"));
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
    public function createAction(){
        if (!$this->request->isPost()) {
        return $this->dispatcher->forward(array(
         "controller" => "systemmeta","action" => "index"));
        }
        $system_meta = new Systemmeta();
        $system_meta->meta_name = $this->request->getPost("meta_name");
        $system_meta->meta_value = $this->request->getPost("meta_value");
        if (!$system_meta->save()) {
            foreach ($system_meta->getMessages() as $message){
                $this->flash->error($message);}
            return $this->dispatcher->forward(array(
                "controller" => "systemmeta","action" => "new"));
        }
        $this->flash->success("system_meta was created successfully");
        return $this->response->redirect('systemmeta/index');
    }

    /**
     * Saves a system_meta edited
     *
     */
    public function saveAction(){
        if(!$this->request->isPost()) {
        return $this->dispatcher->forward(array(
            "controller" => "systemmeta","action" => "index"
        ));
        }
        $idsystem_meta = $this->request->getPost("idsystem_meta");
        $system_meta = Systemmeta::findFirstByidsystem_meta($idsystem_meta);
        if (!$system_meta) {
            $this->flash->error("system_meta does not exist " . $idsystem_meta);
            return $this->dispatcher->forward(array(
                "controller" => "systemmeta","action" => "index"
            ));
        }
        $system_meta->meta_name = $this->request->getPost("meta_name");
        $system_meta->meta_value = $this->request->getPost("meta_value");
        if (!$system_meta->save()) {
            foreach ($system_meta->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
            "controller" => "systemmeta","action" => "edit",
                "params" => array($system_meta->idsystem_meta)
            ));
        }
        $this->flash->success("system_meta was updated successfully");
        return $this->response->redirect("systemmeta/index");
    }

    /**
     * Deletes a system_meta
     *
     * @param string $idsystem_meta
     */
    public function deleteAction($idsystem_meta)
    {
        $system_meta = Systemmeta::findFirstByidsystem_meta($idsystem_meta);
        if (!$system_meta) {
            $this->flash->error("system_meta was not found");
            return $this->dispatcher->forward(array(
                "controller" => "systemmeta","action" => "index"
            ));
        }
        if (!$system_meta->delete()) {
            foreach ($system_meta->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "systemmeta","action" => "search"
            ));
        }
        $this->flash->success("system_meta was deleted successfully");
        return $this->response->redirect("systemmeta/index");
    }
}
