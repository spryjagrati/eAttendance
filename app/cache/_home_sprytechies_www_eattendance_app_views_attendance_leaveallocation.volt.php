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
    <?php echo Phalcon\Tag::form(array('attendance/leaveAllocation', 'method' => 'get','id' => 'form')); ?>
    <label for="from">From:</label>    
    <?php echo Phalcon\Tag::textField(array("from", "id"=>"from" , "value"=>$_GET['from'] )); ?>
    <label for="to">To:</label>
    <?php echo Phalcon\Tag::textField(array("to", "id"=>"to","value"=>$_GET['to'])); ?>
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
    <?php 
    echo Phalcon\Tag::submitButton(array("Filter","id"=>"filter1"));?>                
    <?php echo $this->tag->endForm(); ?>
  </div>                                  
  <h2 class="sub-header"> 
  
  Users Leave Allocation
 
  <small id="header_btn">
     <input type="button" class='btn btn-primary btn-large btn-success' id='adjust' value="Adjust Leaves">
     </input>
  </small>
  </h2> 
  <div class="table-responsive">
    <?php $counter = 0; ?>
    <?php $v39981145021iterated = false; ?><?php $v39981145021iterator = $page->items; $v39981145021incr = 0; $v39981145021loop = new stdClass(); $v39981145021loop->length = count($v39981145021iterator); $v39981145021loop->index = 1; $v39981145021loop->index0 = 1; $v39981145021loop->revindex = $v39981145021loop->length; $v39981145021loop->revindex0 = $v39981145021loop->length - 1; ?><?php foreach ($v39981145021iterator as $atten) { ?><?php $v39981145021loop->first = ($v39981145021incr == 0); $v39981145021loop->index = $v39981145021incr + 1; $v39981145021loop->index0 = $v39981145021incr; $v39981145021loop->revindex = $v39981145021loop->length - $v39981145021incr; $v39981145021loop->revindex0 = $v39981145021loop->length - ($v39981145021incr + 1); $v39981145021loop->last = ($v39981145021incr == ($v39981145021loop->length - 1)); ?><?php $v39981145021iterated = true; ?>
      <?php if ($v39981145021loop->first) { ?>
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
          case '5'  : $t = '2nd Saturday'; break;
          case '5'  : $t = '4th Saturday'; break;
        } 
        ?>
        <td> <?php echo $t; ?> </td>
        <td> <?php echo $atten->attendance->remark; ?> </td>
        <td> <?php echo $atten->attendance->idapplication; ?> </td>          
       
        <td width="7%">
        <?php echo Phalcon\Tag::checkField(array("leave",
        "id"=> $atten['attendance']->idattendance ,"class"=>"leave" ,
        "value"=>$atten['attendance']->iduser)); ?>
        </td>     
        </tr>
      <?php if ($v39981145021loop->last) { ?>
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
      <?php $v39981145021incr++; } if (!$v39981145021iterated) { ?>
      No Leaves is recorded
    <?php } ?>
  </div>              
</div>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#leavechange" data-whatever="@fat" id="leave">test</button>

<div class="modal fade" id="leavechange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <h4 class="modal-title" id="exampleModalLabel">Assign Leaves</h4>
      </div>
      <div class="modal-body"> 
        <form method="post" name='form' id="formExperience" class="validateform" action="/eattendance/attendance/updateLeave">
        <?php $this->flash->output(); ?> 
         
      </div>
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
  
    $('#adjust').click(function(){     
        var user = $("input[type='checkbox'].leave:checked").map(function(){ 
          return this.value; 
        }).get();
        Array.prototype.allValuesSame = function() {
          for(var i = 1; i < user.length; i++)
          {
              if(user[i] !== user[0])
                  return false;
          }
          return true;
        }
        var same = user.allValuesSame();
        if(same == true){
          var category = $("input[type='checkbox'].leave:checked").map(function(){ 
            return this.id; 
          }).get();
          $.ajax({
            type :'POST',
            url : 'adjustLeave',
            data : {data : category},
            datatype :'json',
            success : function(response){           
              $('#leavechange .modal-body form').html(response);
              $( "#leave" ).trigger( "click" );
            }
          });
        }else{
          alert('Select only 1 user type');
        }
    });
    
  });
</script>