{{ assets.outputCss('headercss')}}
{{ assets.outputCss('mainpagecss') }}
{{ assets.outputCss('countupcss') }}

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">      
    {{ flash.output() }}
    {% if type == 2 %}          
    <div class="row-fluid" id="dashboard_timer">           
      <h2 class="page-header">Dashboard   
        <input type="hidden" id='totalhour' class="totalhour" size="10"   value={{ total_hours }}>  
        <input type="hidden" id='clockDisplay' class="clockStyle" size="10"  placeholder="Start Timer" value={{ sec }}>
        </input>
        <div class="span6" id='header_btn'>
        <div class="timer" style="float:left"> 
        <span class="hour">{{ hours}}</span>:<span class="minute">{{ mins }}</span>:<span class="second">{{ second }}</span>
        </div>
        <button onClick="timer.start(1000)" id='start_btn' class= 'btn btn-primary btn-large btn-success'>Start Timer</button>     
        <button onClick="timer.stop()" id='stop_btn' class= 'btn btn-primary btn-large btn-success hide'>Stop Timer</button>
        </div>
      </h2>
    </div>
    {% else %}
      <h2 class="page-header">Dashboard </h2>
    {% endif %}
    {% if type == 2 %}
      <div class="row placeholders">
        <div class="col-xs-6 col-sm-2 placeholder">     
          <h4>Total Present</h4>
          <span class="text-muted"> 
              {{ present }}
          </span>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">     
          <h4>Total Absent</h4>
          <span class="text-muted">
            {{ absent }}
          </span>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">      
          <h4>Total Leaves Left</h4>
          <span class="text-muted">
             PL = {{ left_pl }}, CL = {{ left_cl }}, SL = {{ left_sl}}
          </span>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">      
          <h4>UnMarked</h4>
          <span class="text-muted">
            {{ unmarked }}
          </span>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">       
            <h4>Today's Working Hours</h4>
            <span class="text-muted" id="text-muted" >
                00:00:00
            </span>
        </div>
       </div>
    {% else %}
        <div class="row placeholders">
      <div class="col-xs-6 col-sm-3 placeholder">     
        <h4>Total Present</h4>
        <span class="text-muted"> 
            {{ present }}
        </span>
      </div>
      <div class="col-xs-6 col-sm-3 placeholder">     
        <h4>Total Absent</h4>
        <span class="text-muted">
          {{ absent }}
        </span>
      </div>
      <div class="col-xs-6 col-sm-3 placeholder">      
        <h4>Total Leaves Left</h4>
        <span class="text-muted">
           PL = {{ left_pl }}, CL = {{ left_cl }}, SL = {{ left_sl}}
        </span>
      </div>
      <div class="col-xs-6 col-sm-3 placeholder">      
        <h4>UnMarked</h4>
        <span class="text-muted">
          {{ unmarked }}
        </span>
      </div>
     </div>
    {% endif %}
   
    <h2 class="sub-header">Today's Individual Attendance</h2>    
      <div class="table-responsive">
      {% set counter = 0 %}
      {% for atten in page.items %}
      {% if loop.first %}
        <table class="table table-striped">
        <thead>
        <tr>
        <th> Id User</th>
        <th> User Name </th>
        <th> Status </th>
        <th> Date </th>
        <tr>
        </thead>
        <tbody>
      {% endif %}
        <tr>
        <td> {{atten.iduser}} </td>
        <td> {{atten.username}} </td>         
        {% if atten.type is null %}
          {% set s = '--' %}
        {% elseif atten.type == 1 %}
           {% set s = 'Present' %}
        {% elseif atten.type == 0 %}
           {% set s = 'Absent' %}
        {% endif %}
        <td> {{ s }} </td>
        <td> {{ today_date }}           
        </tr>             
        {% if loop.last %}
        <tr>
        <td colspan="12" align="right">
        <div class="btn-group">
        {{ link_to("dashboard/index", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
        {{ link_to("dashboard/index?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
        {{ link_to("dashboard/index?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
        {{ link_to("dashboard/index?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
        <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
        </div>
        </td>
        </tr>
      </tbody>
      </table>
      {% endif %}
      {% else %}
      No User is recorded
    {% endfor %}
    </div>
    </div>
  </div>
</div>
{{ assets.outputJs('footerjs') }}
{{ assets.outputJs('mainpagejs') }}
{{ assets.outputJs('countupjs') }}