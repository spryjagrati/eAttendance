{{assets.outputCss('headercss')}}
{{assets.outputCss('datepickercss')}}
{{ assets.outputCss('mainpagecss') }}

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
      <div height="100px" width="50px" class="head">
        <div id="filter">
        <?php echo Phalcon\Tag::form(array('application/index', 'method' => 'get', 'id'=>'form')); ?>
        <label for="from">From:</label>
        <?php echo Phalcon\Tag::textField(array("from", "id"=>"from", "value"=>$_GET['from'])); ?>
        <label for="to">To:</label>
        <?php echo Phalcon\Tag::textField(array("to", "id"=>"to", "value"=>$_GET['to'])); ?>
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
              ));
         ?>
         {% endif %}
        <?php echo Phalcon\Tag::submitButton('Filter'); ?>                
        {{ end_form() }}               
        </div>
        </div> 
        <div class="view-button">                
        </div>

        <h2 class="sub-header">
        {% if type == 1 OR type == 2 %}
        Users Leaves
        {% else %}
        My Leaves
        {% endif %}
        <small id="header_btn">
        {{ link_to('application/new','<i class="icon-ok icon-white"></i> Add new Application', 'class': 'btn btn-primary btn-large btn-success', "id":"btn")}}
        {% if type == 1 OR type == 2 %}
        {{ link_to(extractUrl,'<i class="icon-ok icon-white"></i> Extract', 'class': 'btn btn-primary btn-large btn-success') }} 
        {% endif %}
        </small>
        </h2>

        <div class="table-responsive">  
          {% for atten in page.items %}
            {% if loop.first %}
              <table class="table table-striped">
                <thead>
                <tr>                         
                <th> User Name </th>
                <th> From Date </th>
                <th> To Date </th>
                <th> Type </th>
                <th> Title </th>
                <th> Description </th>
                <th> Status </th>
                {% if type == 1 OR type == 2 %}
                <th> Submitted On</th>                        
                {% endif %}
                <tr>
                </thead>
                <tbody>
            {% endif %}
                <tr>                          
                <td> {{atten.username}}</td>
                <td> {{atten.application.from_date}} </td>
                <td> {{atten.application.to_date}} </td>
                {% if atten.application.type == 2 %}
                {% set t = 'PL' %}
                {% elseif atten.application.type == 3 %}
                {% set t = 'CL' %}
                {% elseif atten.application.type == 4 %}
                {% set t = 'SL' %}
                {% endif %}
                <td> {{ t }} </td>
                <td> {{atten.application.title }} </td>
                <td> {{atten.application.description}} </td>
                {% if atten.application.status == 1 %}
                {% set status = 'Pending' %}
                {% elseif atten.application.status == 2 %}
                {% set status = 'Approved' %}
                {% elseif atten.application.status == 3 %}
                {% set status = 'Rejected' %}
                {% endif %}
                <td> {{ status }} </td>
               {% if type == 1 OR type == 2 %}
                <td> {{ atten.application.created_on  }}</td>
                <td width="7%">
                {{ link_to("application/edit/"~atten.application.idapplication,'<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}
                </td>
                <td width="7%">
                {{ link_to("application/delete/"~atten.application.idapplication,'<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}
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
            No Leaves is recorded
          {% endfor %}
      </div>
  </div>
</div>

{{ assets.outputJs('footerjs') }}
{{ assets.outputJs('mainpagejs') }}
{{ assets.outputJs('datepickerjs') }}

<script type="text/javascript">           
  jQuery(document).ready(function($) {
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
    $("#user_list").change(function(){                   
      $('#form').submit();
    });     
});
</script>   