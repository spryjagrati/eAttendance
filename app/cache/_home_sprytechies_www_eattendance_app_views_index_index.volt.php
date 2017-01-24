<?php echo $this->assets->outputCss('headercss'); ?>

<div class="container">
<?php echo $this->flash->output(); ?>
<div class="jumbotron">
    <h1>Welcome to eAttendance</h1>
    <p>eAttendance is an online service providing facility of taking attendance for free.</p>  
</div>
<div class="row">
    <div class="col-md-4">
        <h2>Manage Users Online</h2>
        <p>Add as many users as required and management them online. </p>
    </div>
    <div class="col-md-4">
        <h2>Dashboards And Reports</h2>
        <p>Separate Dashboard for admin and users. Export reports whenever necessary.</p>
    </div>
    <div class="col-md-4">
        <h2>Online Attendance</h2>
        <p>Daily log attendance for every user.</p>
    </div>
</div>
</div>
<?php echo $this->assets->outputJs('footerjs'); ?>

<script type="text/javascript">
jQuery(document).ready(function(){
        $('.col-sm-3 col-md-2 sidebar').css('display', 'none');
});
</script>