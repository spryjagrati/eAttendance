{{ assets.outputCss('headercss')}}
{{ assets.outputCss('mainpagecss') }}
{{ assets.outputCss('datepickercss') }}

<div class="container-fluid">
<div class="row">
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  {{ flash.output() }}
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
    {{ end_form() }}
  </div>                                  
  <h2 class="sub-header"> 
  
  Users Leave Allocation
 
  <small id="header_btn">
     <input type="button" class='btn btn-primary btn-large btn-success' id='adjust' value="Adjust Leaves">
     </input>
  </small>
  </h2> 
  <div class="table-responsive">
    {% set counter = 0 %}
    {% for atten in page.items %}
      {% if loop.first %}
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
      {% endif %}
        <tr>
        <td> {{atten.username }} </td>
        <td> {{atten.attendance.cdate}} </td>
        <td> {{atten.attendance.in_time}} </td>
        <td> {{atten.attendance.out_time }} </td>
        
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
        <td> {{atten.attendance.remark}} </td>
        <td> {{atten.attendance.idapplication}} </td>          
       
        <td width="7%">
        <?php echo Phalcon\Tag::checkField(array("leave",
        "id"=> $atten['attendance']->idattendance ,"class"=>"leave" ,
        "value"=>$atten['attendance']->iduser)); ?>
        </td>     
        </tr>
      {% if loop.last %}
        <tr>
        <td colspan="12" align="right">
        <div class="btn-group">
        {{ link_to(parentUrl, '<i class="icon-fast-backward"></i> First', "class": "btn") }}
        {{ link_to(parentUrl ~"page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
        {{ link_to( parentUrl ~"page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
        {{ link_to(parentUrl ~"page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
        <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
        </div>
        </td>
        </tr>
        </tbody>
        </table>
      {% endif %}
      {% else %}
      No Leaves is recorded
    {% endfor %}
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
             



{{ assets.outputJs('footerjs') }}
{{ assets.outputJs('mainpagejs') }}
{{ assets.outputJs('datepickerjs')}}
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