<?php echo $this->assets->outputCss('headercss'); ?>
<?php echo $this->assets->outputCss('mainpagecss'); ?>
<?php echo $this->assets->outputCss('datepickercss'); ?>
    
<div class="container-fluid">
<div class="row">
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <?php echo $this->flash->output(); ?>
    <div class="row placeholders">
      <div class="col-xs-6 col-sm-3 placeholder"></div>
      <div class="col-xs-6 col-sm-3 placeholder"></div>
      <div class="col-xs-6 col-sm-3 placeholder"></div>
      <div class="col-xs-6 col-sm-3 placeholder"></div>
    </div>
    <div id="filter">
    <?php echo Phalcon\Tag::form(array('attendance/index', 'method' => 'get','id' => 'form')); ?>
    <label for="from">From:</label>    
    <?php echo Phalcon\Tag::textField(array("from", "id"=>"from" , "value"=>$_GET['from'] )); ?>
    <label for="to">To:</label>
    <?php echo Phalcon\Tag::textField(array("to", "id"=>"to","value"=>$_GET['to'])); ?>
    <?php if ($type == 1 || $type == 2) { ?>
    <?php echo Phalcon\Tag::select(
      array(
        "user_list",
          User::find(),
          "using" => array("iduser", "username"),
          'useEmpty'=> true,
          'emptyText'=> 'All', 
          'emptyValue'=> '0',
          'value'=> $_GET['user_list']
      )); ?>
    <?php } ?>
    <?php echo Phalcon\Tag::submitButton(array("Filter", "id"=>"filter1"));?>                
    <?php echo $this->tag->endForm(); ?>
  </div>                                  
  <h2 class="sub-header"> 
  <?php if ($type == 1 || $type == 2) { ?>
  Users Attendance
  <?php } else { ?>
  My Attendance
  <?php } ?>
    <small id="header_btn">
    <?php if ($type == 1 || $type == 2) { ?>
    <?php echo $this->tag->linkTo(array('attendance/new', '<i class="icon-ok icon-white"></i> Add new Attendance', 'class' => 'btn btn-primary btn-large btn-success')); ?>
    <?php echo $this->tag->linkTo(array($extractUrl, '<i class="icon-ok icon-white"></i> Extract', 'class' => 'btn btn-primary btn-large btn-success')); ?>
    <?php echo $this->tag->linkTo(array('attendance/leaveAllocation', '<i class="icon-ok icon-white"></i> Leave Allocation', 'class' => 'btn btn-primary btn-large btn-success')); ?>  
    <?php } ?>                      
    </small>
  </h2> 
  <div class="table-responsive">
    <?php $counter = 0; ?>
    <?php $v29128708911iterated = false; ?><?php $v29128708911iterator = $page->items; $v29128708911incr = 0; $v29128708911loop = new stdClass(); $v29128708911loop->length = count($v29128708911iterator); $v29128708911loop->index = 1; $v29128708911loop->index0 = 1; $v29128708911loop->revindex = $v29128708911loop->length; $v29128708911loop->revindex0 = $v29128708911loop->length - 1; ?><?php foreach ($v29128708911iterator as $atten) { ?><?php $v29128708911loop->first = ($v29128708911incr == 0); $v29128708911loop->index = $v29128708911incr + 1; $v29128708911loop->index0 = $v29128708911incr; $v29128708911loop->revindex = $v29128708911loop->length - $v29128708911incr; $v29128708911loop->revindex0 = $v29128708911loop->length - ($v29128708911incr + 1); $v29128708911loop->last = ($v29128708911incr == ($v29128708911loop->length - 1)); ?><?php $v29128708911iterated = true; ?>
      <?php if ($v29128708911loop->first) { ?>
        <table class="table table-striped">
        <thead>
        <tr>              
        <th> User Name </th>
        <th> Date</th>
        <th> In Time </th>
        <th> Out Time </th>
        <th> Type </th>
        <th> Remark </th>
        <th> Id Application </th>              
        <tr>
        </thead>
        <tbody>
      <?php } ?>
        <tr>
        <td> <?php echo $atten->username; ?> </td>
        <td> <?php echo $atten->attendance->cdate; ?> </td>
        <td> <?php echo $atten->attendance->in_time; ?> </td>
        <td> <?php echo $atten->attendance->out_time; ?> </td>
        <?php 
          $t = $atten['attendance']->type;
          switch($t){
          case '-1' : $t = 'Unmarked'; break;
          case '0'  : $t = 'Absent'; break;
          case '1'  : $t = 'Present'; break;
          case '2'  : $t = 'PL'; break;
          case '3'  : $t = 'CL'; break;
          case '4'  : $t = 'SL'; break;
          case '5'  : $t = 'Halfday'; break;
          case '6'  : $t = 'Sunday'; break;
          case '7'  : $t = 'Holiday'; break;
          case '8'  : $t = '2nd Saturday'; break;
          case '9'  : $t = '4th Saturday'; break;
        } 
        ?>
        <td> <?php echo $t; ?> </td>
        <td> <?php echo $atten->attendance->remark; ?> </td>
        <td> <?php echo $atten->attendance->idapplication; ?> </td>          
      <?php if ($type == 1 || $type == 2) { ?>  
        <td width="7%">
        <?php echo $this->tag->linkTo(array('attendance/edit/' . $atten->attendance->idattendance, '<i class="glyphicon glyphicon-edit"></i> Edit', 'class' => 'btn btn-default')); ?>
        </td>
        <td width="7%">
        <?php echo $this->tag->linkTo(array('attendance/delete/' . $atten->attendance->idattendance, '<i class="glyphicon glyphicon-remove"></i> Delete', 'class' => 'btn btn-default')); ?>
        </td>
      <?php } ?>
        </tr>
      <?php if ($v29128708911loop->last) { ?>
        <tr>
        <td colspan="12" align="right">
        <div class="btn-group">
        <?php echo $this->tag->linkTo(array($parentUrl, '<i class="icon-fast-backward"></i> First', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array($parentUrl . 'page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array($parentUrl . 'page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array($parentUrl . 'page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn')); ?>
        <span class="help-inline"><?php echo $page->current; ?> of <?php echo $page->total_pages; ?></span>
        </div>
        </td>
        </tr>
        </tbody>
        </table>
      <?php } ?>
      <?php $v29128708911incr++; } if (!$v29128708911iterated) { ?>
      No Attendance is recorded
    <?php } ?>
  </div>              
</div>
</div>

<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>
<?php echo $this->assets->outputJs('datepickerjs'); ?>

<script type="text/javascript">
jQuery(document).ready(function(){
    
    $("#user_list").change(function(){
    $('#form').submit();
    }); 
    $('#from').datepicker({                      
      format : "yyyy/mm/dd",
      autoclose: true
   })
   .on('changeDate', function(selected){
      startDate = new Date(selected.date.valueOf());
      startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
      $('#to').datepicker('setStartDate', startDate);
   });        
  $('#to').datepicker({    
      format : "yyyy/mm/dd",        
  });    
});
</script>