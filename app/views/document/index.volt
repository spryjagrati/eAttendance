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
    <div>
    <h2 class="sub-header">
    {% if type == 1 OR type == 2 %}
    Users Documents
    {% else %}
    My Documents
    {% endif %}      
    <small id="header_btn">
      {{ link_to('document/new','<i class="icon-ok icon-white"></i> Add new Document', 'class': 'btn btn-primary btn-large btn-success') }}
    </small>
    </h2>
    </div>         
    <div class="table-responsive">             
      {% for atten in page.items %}
      {% if loop.first %}
        <table class="table table-striped">
        <thead>
          <tr>
          <th> User Name </th>
          <th> Title </th>
          <th> Description </th>
          <th> Submit Date</th>
          <th> Return Date </th>
          <tr>
        </thead>
        <tbody>
      {% endif %}
        <tr>      
        <td> {{atten.username}} </td>
        <td> {{atten.document.title}} </td>
        <td> {{atten.document.description}} </td>
        <td> {{atten.document.taken_date }} </td>
        <td> {{atten.document.given_date}} </td>
        <td width="7%">
        {{ link_to("document/edit/"~atten.document.iddocument,'<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}
        </td>
        <td width="7%">
        {{ link_to("document/delete/"~atten.document.iddocument,'<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}
        </td>
        </tr>                  
      {% if loop.last %}
        <tr>
        <td colspan="12" align="right">
        <div class="btn-group">
        {{ link_to("document/index", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
        {{ link_to("document/index?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
        {{ link_to("document/index?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
        {{ link_to("document/index?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
        <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
        </div>
        </td>
        </tr>                          
        </tbody>
      </table>
      {% endif %}
      {% else %}
      No Document is recorded
    {% endfor %}
    </div>
  </div>
</div>

{{ assets.outputJs('footerjs') }}
{{ assets.outputJs('mainpagejs') }}