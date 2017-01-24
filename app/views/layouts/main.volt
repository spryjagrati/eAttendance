<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">eAttendance</a>
        </div>
        {{ elements.getMenu() }}
    </div>
</nav>
 {{ content() }}

 <?php 
 $baseuri = $this->config->application->baseUri;
 $parent=$this->request->getUri();
 $type =$this->session->get('auth')['type']; 
 if($parent !== $baseuri && $parent !== "/eattendance/index/index"){

    if($type == 1 || $type == 2){ 
 ?>
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar" id="submenu">
    <li class="active">
    <a href="javascript:void(0)" id="submenu-a"> Users <i class="fa fa-angle-left pull-right"></i>
    </a>         
    <ul class="nav nav-sidebar-menu">
      <li>{{link_to("user/index", "Users")}}</li>
      <li>{{link_to("document/index", "Users Documents")}}</li>
      <li>{{link_to("education/index", "Users Education")}}</li>
      <li>{{link_to("experience/index", "Users Experience")}}</li>
    </ul>
    </li>
  </ul>        
  <ul class="nav nav-sidebar">
    <li class="active">
    {{ link_to('attendance/index','<i span class="sr-only"></i>Attendance')}}
    </li>
  </ul>
  <ul class="nav nav-sidebar" id="submenu">
    <li class="active">
    <a href="javascript:void(0)" id="submenu-a"> Leave 
      <i class="fa fa-angle-left pull-right"></i>
    </a>         
    <ul class="nav nav-sidebar-menu">
      <li>{{link_to("application/index", "Leave Management")}}</li>
      <li>{{link_to("attendance/leaveAllocation", "Leave Allocation")}}</li>    
    </ul>
    </li>
  </ul> 
  <ul class="nav nav-sidebar">
    <li class="active">
    {{ link_to('systemmeta/index','<i span class="sr-only"></i>System Settings')}}
    </li>
  </ul>
</div>

<?php } else { if($type == 3){ ?>
   <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar" id="submenu">
        <li class="active">
        <a href="javascript:void(0)" id="submenu-a">User
        <i class="fa fa-angle-left pull-right"></i>
        </a>         
        <ul class="nav nav-sidebar-menu">          
        <li>{{link_to("document/index", "My Documents")}}</li>
        <li>{{link_to("education/index", "My Education")}}</li>
        <li>{{link_to("experience/index", "My Experience")}}</li>
        </ul>
        </li>
      </ul>
      <ul class="nav nav-sidebar">
        <li class="active">
        {{ link_to('attendance/index','<i span class="sr-only"></i> My Attendance')}}
        </li>
      </ul>
      <ul class="nav nav-sidebar">
        <li class="active">
        {{ link_to('application/index','<i span class="sr-only"></i>My Leave Report')}}
        </li>
      </ul>
  </div>
<?php  } } }?> 
<hr>    
<div class="navbar-footer" style="text-align:center">
  <footer>
  <p>&copy; Sprytechies 2016</p>
  </footer>
</div>