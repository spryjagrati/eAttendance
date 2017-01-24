<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ExperienceController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction(){
        $this->persistent->parameters = null;
         if($_SESSION['auth']){$type = $this->session->get('auth')['type'];}
        $this->view->type =$type;
        if($type == 1 || $type == 2 ){
            if ($this->request->isPost()) {
                $query = Criteria::formInput($this->di, "Experience", $_POST);
                $this->persistent->parameters = $query->getParams();
            }else { $numberPage = $this->request->getQuery("page", "int");   
            }           
            $parameter = $this->persistent->searchParams;
            $query = new Query("SELECT Experience.*, User.username FROM Experience join
            User ON (Experience.iduser = User.iduser)", $this->getDI());
            $atten = $query->execute();
        }else{
            $type=$this->session->get('auth')['type'];
            $this->view->type = $type;
            if ($this->request->isPost()) {
                $query = Criteria::formInput($this->di, "Experience", $_POST);
                $this->persistent->parameters = $query->getParams();
            } else { $numberPage = $this->request->getQuery("page", "int");   
            }        
            $parameter = $this->persistent->searchParams;
            $id=$this->session->get('auth')['id'];
            $query = new Query("SELECT Experience.*, User.username FROM 
            Experience JOIN User ON (Experience.iduser = User.iduser) 
            WHERE Experience.iduser = $id", $this->getDI());
            $atten = $query->execute();
        }
        if(!is_array($parameter)){
            $parameter = array();
            $paginator=new Paginator(array(
                "data" => $atten,"limit" => 10,"page" => $numberPage));
            $page = $paginator->getPaginate();
            $this->view->page=$page;
        }else{
            $this->dispatcher->forward(array(
            'controller' => 'experience','action' => 'index'));
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
            $user = User::Find(array("status = '1'"));                
            $this->view->user = $user; 
        }else{
            $id = $this->session->get('auth')['id'];
            $this->view->iduser = $user->iduser;
            $this->tag->setDefault("iduser", $id);
        }        
    }

    /**
     * Edits a experience
     *
     * @param string $idexperience
     */
    public function editAction($idexperience)
    {
        $type = $this->session->get('auth')['type'];
        $this->view->type =$type;
        if (!$this->request->isPost()) {
            $experience = Experience::findFirstByidexperience($idexperience);
            if (!$experience) {
                $this->flash->error("Experience was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "experience","action" => "index"));
            }
            $this->view->idexperience = $experience->idexperience;
            $this->tag->setDefault("idexperience", $experience->idexperience);
            $this->tag->setDefault("iduser", $experience->iduser);
            $this->tag->setDefault("title", $experience->title);
            $this->tag->setDefault("description", $experience->description);
            $this->tag->setDefault("from_date", $experience->from_date);
            $this->tag->setDefault("to_date", $experience->to_date);
            $this->tag->setDefault("company", $experience->company);
            $this->tag->setDefault("company_address", $experience->company_address);
            $this->tag->setDefault("company_ctc", $experience->company_ctc);            
        }
    }

    /**
     * Creates a new experience
     */
    public function createAction(){
        $type= $this->session->get('auth')['type'];
        $id= $this->session->get('auth')['id'];
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "experience","action" => "index"));
        }
        if($type == 1 || $type ==2){
            $u = $_POST['user'];
            if(!empty($u)){ $iduser = $u['iduser'];}
            else{$iduser = $this->request->getPost("iduser");}
        }else{$iduser = $id;
        } 
        $experiencelog = serialize($_POST);      
        $experience = new Experience();
        $experience->iduser = $iduser;
        $experience->title = $this->request->getPost("title");
        $experience->description = $this->request->getPost("description");
        $experience->from_date = $this->request->getPost("from_date");
        $experience->to_date = $this->request->getPost("to_date");
        $experience->company = $this->request->getPost("company");
        $experience->company_address = $this->request->getPost("company_address");
        $experience->company_ctc = $this->request->getPost("company_ctc");
        $experience->created_on = $this->request->getPost("created_on");
        $experience->updated_on = $this->request->getPost("updated_on");
        $experience->created_by = $this->request->getPost("created_by");
        $experience->updated_by = $this->request->getPost("updated_by");
        if (!$experience->save()) {
            DataLogger::experience('error', "\n\n experience not create \n {$experiencelog} \n\n");
            foreach ($experience->getMessages() as $message) {
                $this->flash->error($message);
            }$this->view->disable();
            if($type == 1 || $type ==2){
              return $this->response->redirect("user/edit/".$iduser);
            }else{
              return $this->response->redirect("experience/new");
            }             
        }else{
            $this->flash->success("Experience created successfully"); 
            $this->view->disable();
            if($type == 1 || $type ==2){
                $id = $experience->iduser; 
                return $this->response->redirect($this->request->getHTTPReferer());
                //return $this->response->redirect("user/edit/".$iduser); 
            }else{
                return $this->response->redirect("experience/index");
            }
        } 
    }

    /**
     * Saves a experience edited
     *
     */
    public function saveAction(){
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "experience","action" => "index"));
        }
        $idexperience = $this->request->getPost("idexperience");
        $experience = Experience::findFirstByidexperience($idexperience);
        $experiencelog = serialize($_POST);
        if (!$experience) {
            DataLogger::experience('error', "\n\n experience not exist \n {$experiencelog} \n\n");
            $this->flash->error("experience does not exist " . $idexperience);
            return $this->dispatcher->forward(array(
                "controller" => "experience","action" => "index"));
        }
        $experience->iduser = $this->request->getPost("iduser");
        $experience->title = $this->request->getPost("title");
        $experience->description = $this->request->getPost("description");
        $experience->from_date = $this->request->getPost("from_date");
        $experience->to_date = $this->request->getPost("to_date");
        $experience->company = $this->request->getPost("company");
        $experience->company_address = $this->request->getPost("company_address");
        $experience->company_ctc = $this->request->getPost("company_ctc");
        $experience->updated_on = $this->request->getPost("updated_on");
        $experience->created_by = $this->request->getPost("created_by");
        $experience->updated_by = $this->request->getPost("updated_by");                
        if (!$experience->save()) {
             DataLogger::experience('error', "\n\n experience not update \n {$experiencelog} \n\n");
            foreach ($experience->getMessages() as $message) {
                $this->flash->error($message);
            } 
            return $this->response->redirect("experience/edit/".$idexperience);         
        }else{
            $this->flash->success("Experience was updated successfully");
            return $this->response->redirect("experience/index"); 
        }      
    }

    /**
     * Deletes a experience
     *
     * @param string $idexperience
     */
    public function deleteAction($idexperience)
    {
        $experience = Experience::findFirstByidexperience($idexperience);
        if (!$experience) {
            $this->flash->error("experience was not found");
            return $this->dispatcher->forward(array(
                "controller" => "experience", "action" => "index"));
        }
        if (!$experience->delete()) {
            foreach ($experience->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("experience/index");
        }else{            
            $this->flash->success("Experience was deleted successfully");
            return $this->response->redirect("experience/index"); 
        }       
    }
}
