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
        <?php echo $this->elements->getMenu(); ?>
    </div>
</nav>
 <?php echo $this->getContent(); ?>

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
      <li><?php echo $this->tag->linkTo(array('user/index', 'Users')); ?></li>
      <li><?php echo $this->tag->linkTo(array('document/index', 'Users Documents')); ?></li>
      <li><?php echo $this->tag->linkTo(array('education/index', 'Users Education')); ?></li>
      <li><?php echo $this->tag->linkTo(array('experience/index', 'Users Experience')); ?></li>
    </ul>
    </li>
  </ul>        
  <ul class="nav nav-sidebar">
    <li class="active">
    <?php echo $this->tag->linkTo(array('attendance/index', '<i span class="sr-only"></i>Attendance')); ?>
    </li>
  </ul>
  <ul class="nav nav-sidebar" id="submenu">
    <li class="active">
    <a href="javascript:void(0)" id="submenu-a"> Leave 
      <i class="fa fa-angle-left pull-right"></i>
    </a>         
    <ul class="nav nav-sidebar-menu">
      <li><?php echo $this->tag->linkTo(array('application/index', 'Leave Management')); ?></li>
      <li><?php echo $this->tag->linkTo(array('attendance/leaveAllocation', 'Leave Allocation')); ?></li>    
    </ul>
    </li>
  </ul> 
  <ul class="nav nav-sidebar">
    <li class="active">
    <?php echo $this->tag->linkTo(array('systemmeta/index', '<i span class="sr-only"></i>System Settings')); ?>
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
        <li><?php echo $this->tag->linkTo(array('document/index', 'My Documents')); ?></li>
        <li><?php echo $this->tag->linkTo(array('education/index', 'My Education')); ?></li>
        <li><?php echo $this->tag->linkTo(array('experience/index', 'My Experience')); ?></li>
        </ul>
        </li>
      </ul>
      <ul class="nav nav-sidebar">
        <li class="active">
        <?php echo $this->tag->linkTo(array('attendance/index', '<i span class="sr-only"></i> My Attendance')); ?>
        </li>
      </ul>
      <ul class="nav nav-sidebar">
        <li class="active">
        <?php echo $this->tag->linkTo(array('application/index', '<i span class="sr-only"></i>My Leave Report')); ?>
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