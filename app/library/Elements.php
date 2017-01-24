<?php

use Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Component
{
    private $_headerMenu = array(
    'navbar-left' => array(
        'index' => array(
            'caption' => 'Home',
            'action' => 'index'
        ),
    ),           
    'navbar-right' => array(    
        'dashboard' => array(
            'caption' => 'Dashboard',
            'action' => 'index'
            ),
        'attendance' => array(
            'caption' => 'Attendance',
            'action' => 'index'
        ),
        'application' => array(
            'caption' => 'Leaves',
            'action' => 'index'
        ),

        'profile' => array(
            'caption' => 'Profile',
            'action' => 'index'
        ),

        'session' => array(
            'caption' => 'Log In',
            'action' => 'index'
        ),
    )
    );
    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu()
    {
        $auth = $this->session->get('auth');
        $type = $this->session->get('auth')['type'];
        if ($auth) {
            $this->_headerMenu['navbar-right']['session'] = array(
                'caption' => 'Log Out',
                'action' => 'end'
            );
        } else{ 
            unset($this->_headerMenu['navbar-right']['attendance']);
            unset($this->_headerMenu['navbar-right']['application']);
            unset($this->_headerMenu['navbar-right']['dashboard']);
            unset($this->_headerMenu['navbar-right']['profile']);            
        }
        if($type >= 3 ){
            unset($this->_headerMenu['navbar-right']['attendance']);
            unset($this->_headerMenu['navbar-right']['application']);
        }        
        $controllerName = $this->view->getControllerName();
        foreach ($this->_headerMenu as $position => $menu) { 
            if(empty($menu['sub'])){            
                echo '<div class="nav-collapse">';
                echo '<ul class="nav navbar-nav ', $position, '">';
                foreach ($menu as $controller => $option) {
                    if(!empty($option['sub'])){
                    echo '<li class="dropdown">';
                    echo '<a href='.$controller .'/'/*.$option['action']*/.
                    'class="dropdown-toggle" data-toggle="dropdown" role="button"
                     aria-haspopup="true" aria-expanded="false">';
                    echo $option['caption'].'<span class="caret"></span></a>';                  
                    echo '<ul class="dropdown-menu">';
                        
                    foreach ($option['sub'] as $posi => $lol) {  
                        if ($controllerName == $posi) {
                                echo '<li class="active">';
                        }else {
                                echo '<li>';
                        } 
                        echo $this->tag->linkTo($posi.'/'.$lol['action'], 
                             $lol['caption']);
                        echo '</li>';                               
                    } 
                    echo '</ul>';
                    echo '</li>';                           
                    }else{
                        if ($controllerName == $controller) {
                            echo '<li class="active">';
                        }else {
                            echo '<li>';
                        }                
                        echo $this->tag->linkTo($controller . '/' 
                            . $option['action'], 
                            $option['caption']);
                        echo '</li>';
                        echo '</li>';
                    }
                }        
            }             
            echo '</ul>';
            echo '</div>';
        }
    }    
}





    /*private $_headerMenu = array(
        'navbar-left' => array(
            'index' => array(
                'caption' => 'Home',
                'action' => 'index'
        ),
        'dashboard' => array(
            'caption' => 'Dashboard',            
            'sub' =>array(
                'user' => array(
                    'controller' => 'user',
                    'caption' => 'Users',
                    'action' => 'index'
                ),
                'dashboard' => array(
                    'controller' => 'dashboard',
                    'caption' => 'Admin Dashboard',
                    'action' => 'index'
                ),

            ),
        ),
            
            'attendance' => array(
                'caption' => 'Attendance',
                'action' => 'index'
            ),
            'user_leaves' => array(
                'caption' => 'Leave Management',
                'action' => 'index'
            ),
            'reports' => array(
                'caption' => 'Reports',
                'action' => 'index'
            ),
            'settings' => array(
                'caption' => 'System Settings',
                'action' => 'index'
            ),
        ),
        'navbar-right' => array(
            'session' => array(
                'caption' => 'Log In',
                'action' => 'index'
            ),
        )
    );*/
   

    