<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{

	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl()
	{
		//$this->session->destroy();
		unset($this->persistent->acl);

		if (!isset($this->persistent->acl)) {

			$acl = new AclList();

			$acl->setDefaultAction(Acl::DENY);
			 
        
			//Register roles
			$roles = array(
				'admins'  => new Role('Admins'),
				'managers'=> new Role('Managers'),
				'users'   => new Role('Employees'),
				'guests'  => new Role('Guests')
			);
			foreach ($roles as $role) {
				$acl -> addRole($role);
			}


			//Private area resources
			$privateResources = array(
				'dashboard' => array('index','new','startTime','stopTime'),
				'user'      => array('index', 'search', 'new', 'edit','find', 'save', 'create', 'delete' ,'find','createExcel'),
				'document'  => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete' , 'find'),
				'education' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete','find'),
				'experience'=> array('index', 'search', 'new', 'edit', 'save', 'create', 'delete','find'),
				'attendance'=> array('index', 'search', 'new', 'edit', 'save', 'create', 'delete','start', 'stop','createExcel','find','filter','leaveAllocation','adjustLeave','updateLeave'),
				'application'=> array('index', 'search', 'new', 'edit', 'save', 'create', 'delete','list','find','typefetch','leavetype','createExcel'),
				'profile'=> array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
				'systemmeta' => array('index','search' ,'new' ,'edit','create','save','delete'),
				'reports' => array('index')
			);

			foreach ($privateResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			
			$adminspecificResources = array(
				'settings' => array('index')
			);

			foreach ($adminspecificResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			$employeespecificResources = array(
				'dashboard' 	 => array('index','new','startTime','stopTime'),
				'attendance'	 => array('index', 'start', 'stop','list','filter'),
				'application'	 => array('index','new','create','edit','save','list','typefetch'),
				'document'		 => array('index','new','edit','save','create'),
				'user' 			 => array('index','edit','emp'),
				'education'		 => array('index','new','edit','save','create'),
				'experience'	 => array('index','new','edit','save','create')
			);

			foreach ($employeespecificResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			//Public area resources
			$publicResources = array(
				'index'    => array('index'),
				'about'    => array('index'),
				'errors'   => array('show401', 'show404', 'show500'),
				'session'  => array('index', 'start', 'end'),
				'profile'  => array('index','new','create','save','edit','update','updateSave'),
				'usermeta'=> array('index','new','create','save','edit'),
				'contact'  => array('index', 'send')
			);
			foreach ($publicResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			//Grant access to public areas to both users and guests
			foreach ($roles as $role) {
				foreach ($publicResources as $resource => $actions) {
					foreach ($actions as $action){
						$acl->allow('Employees', $resource, $action);
						$acl->allow('Managers', $resource, $action);
                		$acl->allow('Admins', $resource, $action);
                		$acl->allow('Guests', $resource, $action);
					}
				}
			}

			//Grant access to private area to role admin and managers
			foreach ($privateResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Admins', $resource, $action);
					$acl->allow('Managers', $resource, $action);
				}
			}

			//Grant access to admin specific resources area to role admin
			foreach ($adminspecificResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Admins', $resource, $action);
				}
			}

			//Grant access to userspecific resources area to role Employees
			foreach ($employeespecificResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Employees', $resource, $action);
				}
			}

			//The acl is stored in session, APC would be useful here too
			$this->persistent->acl = $acl;
		}

		return $this->persistent->acl;
		
	}

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
		
		

		$auth = $this->session->get('auth');

		

		if (!$auth){
			$role = 'Guests';
		}else{
			switch ($auth['type']) {
				case 1:
					$role = 'Admins';
					break;
				case 2:
					$role = 'Managers';
					break;
				case 3:
					$role = 'Employees';
					break;
			}
		}
		
		//$role = 'Admins';
		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();
		$acl = $this->getAcl();
		//echo "<pre>";print_r($acl);die();

		$allowed = $acl->isAllowed($role, $controller, $action);

			

		if($allowed != acl::ALLOW){
			
			$this->flash->error("You don't have access to this module");

			$dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action'     => 'index'
                )
            );
            return false;
		}
	}
}