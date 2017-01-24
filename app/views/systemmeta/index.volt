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
      <h2 class="page-header">System Settings
      <small id="header_btn">
        {{ link_to('systemmeta/new','<i class="icon-ok icon-white"></i> Add new Setting', 'class': 'btn btn-primary btn-large btn-success') }}
      </small>
      </h2>          
      <div class="table-responsive">
        {% set counter = 0 %}
        {% for atten in page.items %}
          {% if loop.first %}
          <table class="table table-striped">
            <thead>
              <tr>
             
              <th> Meta Name </th>
              <th> Meta Value </th>
              <tr>
            </thead>
          <tbody>
          {% endif %}
              <tr>
              
              <td> {{atten.meta_name}} </td>
              <td> {{ atten.meta_value }} </td>
              <td width="7%">
              {{ link_to("systemmeta/edit/"~atten.idsystem_meta,'<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}
              </td>
             
              </tr>             
          {% if loop.last %}
              <tr>
              <td colspan="12" align="right">
              <div class="btn-group">
                {{ link_to("systemmeta/index", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                {{ link_to("systemmeta/index?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                {{ link_to("systemmeta/index?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                {{ link_to("systemmeta/index?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
              </div>
              </td>
              </tr>
              </tbody>
            </table>
          {% endif %}
          {% else %}
            No Syetem meta is recorded
      {% endfor %}
        </div>
      </div>
    </div>
  </div>
</div>
{{ assets.outputJs('footerjs') }}
{{ assets.outputJs('mainpagejs') }}
