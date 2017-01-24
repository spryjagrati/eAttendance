<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\Model as Paginator;

class EducationController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        if($_SESSION['auth']){$type = $this->session->get('auth')['type'];}
        $this->view->type =$type;       
        if($type == 1 || $type == 2 ){
            if($this->request->isPost()) {
                $query = Criteria::formInput($this->di, "Education", $_POST);
                $this->persistent->parameters = $query->getParams();
            } else { $numberPage = $this->request->getQuery("page", "int");   
            }           
            $parameter = $this->persistent->searchParams;
            $query = new Query("SELECT Education.*,User.username FROM Education JOIN User 
            WHERE (Education.iduser = User.iduser)",$this->getDI());
            $atten = $query->execute();
        }else{
            $id = $this->session->get('auth')['id'];          
            $this->view->id= $id;
            if ($this->request->isPost()) {
                $query = Criteria::formInput($this->di, "Education", $_POST);
                $this->persistent->parameters = $query->getParams();
            } else{ $numberPage = $this->request->getQuery("page", "int");   
            }           
            $parameter = $this->persistent->searchParams;
            $query = new Query("SELECT Education.*,User.username FROM Education JOIN 
            User ON Education.iduser = User.iduser WHERE Education.iduser = $id",
            $this->getDI()); $atten = $query->execute();
        }
        if(!is_array($parameter)){
            $parameter = array();                
            $paginator=new Paginator(array(
                "data" => $atten,"limit" => 10,"page" => $numberPage));
            $page = $paginator->getPaginate();
            $this->view->page=$page;
            }else{ $this->dispatcher->forward(array(
                'controller' => 'education','action' => 'index'));
            }     
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $type = $this->session->get('auth')['type'];
        $this->view->type =$type;
        if( $type == 1 || $type == 2 ){
            $user = User::Find(array("status = '1'"));                
            $this->view->user = $user; 
        }else{
            $id = $this->session->get('auth')['id'];
            $this->view->iduser = $user->iduser;
            $this->tag->setDefault("iduser", $id);
        }            
    }

    /**
     * Edits a education
     *
     * @param string $ideducation
     */
    public function editAction($ideducation)
    {
        $type =$this->session->get('auth')['type'];
        $this->view->type =$type;
        if (!$this->request->isPost()) {
            $education = Education::findFirstByideducation($ideducation);
            if (!$education) {
                $this->flash->error("education was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "education","action" => "index"));
            }
            $this->view->ideducation = $education->ideducation;
            $this->tag->setDefault("ideducation", $education->ideducation);
            $this->tag->setDefault("iduser", $education->iduser);
            $this->tag->setDefault("title", $education->title);
            $this->tag->setDefault("description", $education->description);
            $this->tag->setDefault("from_date", $education->from_date);
            $this->tag->setDefault("to_date", $education->to_date);
            $this->tag->setDefault("college", $education->college);
            $this->tag->setDefault("grade", $education->grade);
            $this->tag->setDefault("stream", $education->stream);
            $this->tag->setDefault("created_by", $education->created_by);
            $this->tag->setDefault("updated_by", $education->updated_by);
            $this->tag->setDefault("updated_on", $education->updated_on);            
        }
    }

    /**
     * Creates a new education
     */
    public function createAction(){
        $type = $this->session->get('auth')['type'];
        $id = $this->session->get('auth')['id'];
        if (!$this->request->isPost()){ return $this->dispatcher->forward(array(
            "controller" => "education","action" => "index" ));
        }
        if($type == 1 || $type == 2){
            $u = $_POST['user'];
            if(!empty($u)){ $iduser = $u['iduser'];}
            else{ $iduser = $this->request->getPost("iduser");}
        }else{ $iduser = $id; }
        $educationlog= serialize($_POST);
        $education = new Education();
        $education->iduser = $iduser;
        $education->title = $this->request->getPost("title");
        $education->description = $this->request->getPost("description");
        $education->from_date = $this->request->getPost("from_date");
        $education->to_date = $this->request->getPost("to_date");
        $education->college = $this->request->getPost("college");
        $education->grade = $this->request->getPost("grade");
        $education->stream = $this->request->getPost("stream");
        $education->created_by = $this->request->getPost("created_by");
        $education->updated_by = $this->request->getPost("updated_by");
        $education->created_on = $this->request->getPost("created_on");
        $education->updated_on = $this->request->getPost("updated_on");
        if (!$education->save()) {
            DataLogger::education('error', "\n\n education not create \n {$educationlog} \n\n");
            foreach ($education->getMessages() as $message) {
                $this->flash->error($message);}
            $this->view->disable();
            if($type == 1 || $type ==2){
              return $this->response->redirect("user/edit/".$iduser);
            }else{ return $this->response->redirect("education/new");
            }             
        }else{
            $this->flash->success("Education created successfully"); 
            $this->view->disable();
            if($type == 1 || $type ==2){
                $id = $education->iduser; 
                return $this->response->redirect($this->request->getHTTPReferer());
                //return $this->response->redirect("user/edit/".$iduser); 
            }else{ return $this->response->redirect("education/index");
            }
        } 
    }

    /**
     * Saves a education edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "education","action" => "index"));
        }
        $ideducation = $this->request->getPost("ideducation");
        $education = Education::findFirstByideducation($ideducation);
        $educationlog = serialize($_POST);
        if (!$education) {
            DataLogger::education('error', "\n\n education not exist \n {$educationlog} \n\n");
            $this->flash->error("education does not exist " . $ideducation);
            return $this->dispatcher->forward(array(
                "controller" => "education","action" => "index"));
        }
        $education->iduser = $this->request->getPost("iduser");
        $education->title = $this->request->getPost("title");
        $education->description = $this->request->getPost("description");
        $education->from_date = $this->request->getPost("from_date");
        $education->to_date = $this->request->getPost("to_date");
        $education->college = $this->request->getPost("college");
        $education->grade = $this->request->getPost("grade");
        $education->stream = $this->request->getPost("stream");
        $education->created_by = $this->request->getPost("created_by");
        $education->updated_by = $this->request->getPost("updated_by");
        $education->created_on = $this->request->getPost("created_on");
        $education->updated_on = $this->request->getPost("updated_on");
        if (!$education->save()) {
            DataLogger::education('error', "\n\n education not update \n {$educationlog} \n\n");
            foreach ($education->getMessages() as $message) {
                $this->flash->error($message);}
            return $this->response->redirect("education/edit/".$ideducation); 
        }else{
            $this->flash->success("Education was updtaed successfully");
            return $this->response->redirect("education/index"); 
        } 
    }

    /**
     * Deletes a education
     *
     * @param string $ideducation
     */
    public function deleteAction($ideducation)
    {
        $education = Education::findFirstByideducation($ideducation);
        if (!$education) {
            $this->flash->error("education was not found");
            return $this->dispatcher->forward(array(
                "controller" => "education","action" => "index"));
        }
        if (!$education->delete()) {
            foreach ($education->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("education/index"); 
        }
        else{
            $this->flash->success("Education was deleted successfully");
            return $this->response->redirect("education/index"); 
        }         
    }
}
