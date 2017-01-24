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
    <?php echo Phalcon\Tag::form(array('attendance/index', 'method' => 'get','id' => 'form')); ?>
    <label for="from">From:</label>    
    <?php echo Phalcon\Tag::textField(array("from", "id"=>"from" , "value"=>$_GET['from'] )); ?>
    <label for="to">To:</label>
    <?php echo Phalcon\Tag::textField(array("to", "id"=>"to","value"=>$_GET['to'])); ?>
    {% if type == 1 OR type == 2 %}
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
    {% endif %}
    <?php echo Phalcon\Tag::submitButton(array("Filter", "id"=>"filter1"));?>                
    {{ end_form() }}
  </div>                                  
  <h2 class="sub-header"> 
  {% if type == 1 OR type == 2 %}
  Users Attendance
  {% else %}
  My Attendance
  {% endif %}
    <small id="header_btn">
    {% if type == 1 OR type == 2 %}
    {{ link_to('attendance/new','<i class="icon-ok icon-white"></i> Add new Attendance', 'class': 'btn btn-primary btn-large btn-success') }}
    {{ link_to(extractUrl,'<i class="icon-ok icon-white"></i> Extract', 'class': 'btn btn-primary btn-large btn-success') }}
    {{ link_to('attendance/leaveAllocation','<i class="icon-ok icon-white"></i> Leave Allocation', 'class': 'btn btn-primary btn-large btn-success') }}  
    {% endif %}                      
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
          case '8'  : $t = '2nd Saturday'; break;
          case '9'  : $t = '4th Saturday'; break;
        } 
        ?>
        <td> {{t}} </td>
        <td> {{atten.attendance.remark}} </td>
        <td> {{atten.attendance.idapplication}} </td>          
      {% if type == 1 OR type == 2 %}  
        <td width="7%">
        {{ link_to("attendance/edit/"~atten.attendance.idattendance,'<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}
        </td>
        <td width="7%">
        {{ link_to("attendance/delete/"~atten.attendance.idattendance,'<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}
        </td>
      {% endif %}
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
      No Attendance is recorded
    {% endfor %}
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
});
</script>