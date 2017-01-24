<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DocumentController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {       
        $this->persistent->parameters = null; //check for users type    
        if($_SESSION['auth']){$type = $this->session->get('auth')['type'];}      
        $this->view->type =$type;
        if($this->request->isPost()) {
            $query = Criteria::formInput($this->di, "Document", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {$numberPage = $this->request->getQuery("page", "int");   
        }   
        $parameter = $this->persistent->searchParams;        
        if($type == 1 || $type == 2 ){ //page redirect according to users type                      
            $query = new Query("SELECT Document.*, User.username FROM Document JOIN User 
                WHERE (Document.iduser = User.iduser)",$this->getDI());
            $atten = $query->execute(); 
        }else{
            $id= $this->session->get('auth')['id'];       
            $query = new Query("SELECT Document.*,User.username FROM Document JOIN User 
            ON Document.iduser = User.iduser WHERE Document.iduser = $id",$this->getDI());
            $atten = $query->execute(); 
        }
        if(!is_array($parameter)){
            $parameter = array();              
            $paginator=new Paginator(array(
                "data" => $atten, "limit" => 10,"page" => $numberPage));
            $page = $paginator->getPaginate();
            $this->view->page=$page;
        }else{
            $this->dispatcher->forward(array(
            'controller' => 'document','action' => 'index'));
        }       
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {    
        $type = $this->session->get('auth')['type'];
        $this->view->type = $type;
       if( $type == 1 || $type == 2 ){
            $user = User::Find(array(" status = '1'" ));                     
            $this->view->user = $user; 
        }else{
            $id = $this->session->get('auth')['id'];
            $this->view->iduser = $user->iduser;
            $this->tag->setDefault("iduser", $id);
        }
    }

    /**
     * Edits a document
     *
     * @param string $iddocument
     */
    public function editAction($iddocument)
    {
        $type = $this->session->get('auth')['type'];
        $this->view->type =$type;
        if (!$this->request->isPost()) {
            $document = Document::findFirstByiddocument($iddocument);
            if (!$document) {
                $this->flash->error("Document was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "document","action" => "index"));
            }
            $this->view->iddocument = $document->iddocument;
            $this->tag->setDefault("iddocument", $document->iddocument);
            $this->tag->setDefault("iduser", $document->iduser);
            $this->tag->setDefault("title", $document->title);
            $this->tag->setDefault("description", $document->description);
            $this->tag->setDefault("taken_date", $document->taken_date);
            $this->tag->setDefault("given_date", $document->given_date);            
        }
    }

    /**
     * Creates a new document
     */
    public function createAction()
    {
       
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "document","action" => "index"));
        }
        $documnetlog = serialize($_POST);
        $document = new Document();
        $document->iduser = $this->request->getPost("iduser");
        $document->title = $this->request->getPost("title");
        $document->description = $this->request->getPost("description");
        $document->taken_date = $this->request->getPost("taken_date");
        $document->given_date = $this->request->getPost("given_date");
        $document->created_by = $this->request->getPost("created_by");
        $document->updated_by = $this->request->getPost("updated_by");
        $document->created_on = $this->request->getPost("created_on");
        $document->updated_on = $this->request->getPost("updated_on");
        if (!$document->save()) {
            DataLogger::document('error', "\n\n User document create  \n {$documnetlog} \n\n "); 
            foreach ($document->getMessages() as $message) {
             $this->flash->error($message);
            }return $this->dispatcher->forward(array(
                "controller" => "document", "action" => "new"));
        }else{      
            $this->flash->success("Document was created successfully");
            return $this->response->redirect("document/index"); 
        }  
    }

    /**
     * Saves a document edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
            "controller" => "document","action" => "index"));
        }
        $iddocument = $this->request->getPost("iddocument");
        $document = Document::findFirstByiddocument($iddocument);  
        $documnetlog = serialize($_POST);    
        if (!$document) {
             DataLogger::document('error', "\n\n document not found \n {$documnetlog} \n\n ");
            $this->flash->error("Document does not exist " . $iddocument);
            return $this->dispatcher->forward(array(
                "controller" => "document","action" => "index"));
        }  
        $document->iduser = $this->request->getPost("iduser");
        $document->title = $this->request->getPost("title");
        $document->description = $this->request->getPost("description");
        $document->taken_date = $this->request->getPost("taken_date");
        $document->given_date = $this->request->getPost("given_date");
        $document->created_by = $this->request->getPost("created_by");
        $document->updated_by = $this->request->getPost("updated_by");
        $document->updated_on = $this->request->getPost("updated_on");
        if (!$document->save()) {
            DataLogger::document('error', "\n\n Document not update \n {$documnetlog} \n\n ");
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "document","action" => "edit",
                "params" => array($document->iddocument)
            ));
        }else{
             
            $this->flash->success("Document was updated successfully");
            return $this->response->redirect("document/index"); 
        } 
    }

    /**
     * Deletes a document
     *
     * @param string $iddocument
     */
    public function deleteAction($iddocument)
    {
        $document = Document::findFirstByiddocument($iddocument);
        if (!$document) {
            $this->flash->error("Document was not found");
            return $this->dispatcher->forward(array(
                "controller" => "document","action" => "index"));
        }
        if (!$document->delete()) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);}
            return $this->dispatcher->forward(array(
                "controller" => "document","action" => "search"));
        }else{
            $this->flash->success("Document was deleted successfully");
            return $this->response->redirect("document/index"); 
        } 
    }
}
