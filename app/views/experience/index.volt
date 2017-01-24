{{ assets.outputCss('headercss')}}
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
      <h2 class="sub-header">
      {% if type == 1 OR type == 2 %}
      Users Experience
      {% else %}
      My Experience
      {% endif %}
      <small id="header_btn">              
      {{ link_to('experience/new','<i class="icon-ok icon-white"></i> Add new Experience', 'class': 'btn btn-primary btn-large btn-success') }}                 
      </small>              
      </h2>         
      <div class="table-responsive">
        {% set counter = 0 %}
        {% for atten in page.items %}
        {% if loop.first %}
          <table class="table table-striped">
            <thead>
              <tr>
              {% if type == 1 OR type == 2 %}
              <th> Id Experience</th>
              {% endif %}
              <th> User Name </th>              
              <th> Title </th>
              <th> Description </th>
              <th> From Date </th>
              <th> To Date </th>
              <th> Company Name</th>
              <th> Company Address </th>
              <th> Company CTC </th>                        
              <tr>
            </thead>
            <tbody>
            {% endif %}
              <tr>
            {% if type == 1 OR type == 2 %}
              <td> {{atten.experience.idexperience}} </td>
            {% endif %}
              <td> {{atten.username }} </td>
              <td> {{atten.experience.title}} </td>
              <td> {{atten.experience.description}} </td>
              <td> {{atten.experience.from_date }} </td>
              <td> {{atten.experience.to_date}} </td>
              <td> {{atten.experience.company}} </td>
              <td> {{atten.experience.company_address}} </td>
              <td> {{atten.experience.company_ctc}} </td>                  
              <td width="7%">
              {{ link_to("experience/edit/"~atten.experience.idexperience,'<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}
              </td>

              {% if type == 1 OR type == 2 %}
              <td width="7%">
              {{ link_to("experience/delete/"~atten.experience.idexperience,'<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}
              </td>  
               {% endif %}  
              
                            
              </tr>            
            {% if loop.last %}
              <tr>
              <td colspan="12" align="right">
              <div class="btn-group">
              {{ link_to("experience/index", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
              {{ link_to("experience/index?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
              {{ link_to("experience/index?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
              {{ link_to("experience/index?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
              <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
              </div>
              </td>
              </tr>
            </tbody>
          </table>
            {% endif %}
            {% else %}
               No Experience is recorded
          {% endfor %}
        </div>
      </div>
    </div>
{{ assets.outputJs('footerjs') }}
{{ assets.outputJs('mainpagejs') }}