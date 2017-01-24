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
    <h2 class="sub-header">
    {% if type == 1 OR type == 2 %}
    Users Education
    {% else %}
    My Education
    {% endif %}
    <small id="header_btn">
    {{ link_to('education/new','<i class="icon-ok icon-white"></i> Add new Education', 'class': 'btn btn-primary btn-large btn-success') }}
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
        <th> Title </th>
        <th> Description </th>
        <th> From date </th>
        <th> To date </th>
        <th> College </th>
        <th> Grade </th>
        <th> Stream </th>
        <tr>
        </thead>
        <tbody>
        {% endif %}
        <tr>                 
        <td> {{ atten.username }} </td>
        <td> {{atten.education.title}} </td>
        <td> {{atten.education.description}} </td>
        <td> {{atten.education.from_date}} </td>
        <td> {{atten.education.to_date}} </td>
        <td> {{atten.education.college}} </td>
        <td> {{atten.education.grade}} </td>
        <td> {{atten.education.stream}} </td>       
        <td width="7%">
        {{ link_to("education/edit/"~atten.education.ideducation,'<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}
        </td>
        {% if type == 1 OR type == 2 %}
        <td width="7%">
        {{ link_to("education/delete/"~atten.education.ideducation,'<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}
        </td>
        {% endif %}
        </tr>          
      {% if loop.last %}
        <tr>
        <td colspan="12" align="right">
        <div class="btn-group">
        {{ link_to("education/index", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
        {{ link_to("education/index?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
        {{ link_to("education/index?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
        {{ link_to("education/index?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
        <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
        </div>
         </td>
        </tr>
        </tbody>
      </table>
      {% endif %}
      {% else %}
        No Education is recorded
      {% endfor %}
    </div>
  </div>
</div>

{{ assets.outputCss('headercss')}}
{{ assets.outputJs('footerjs') }}
{{ assets.outputCss('mainpagecss') }}
{{ assets.outputJs('mainpagejs') }}