<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">             
      {{ flash.output() }}        
      <div class="row placeholders">
        <div class="col-xs-6 col-sm-3 placeholder">
        </div>
        <div class="col-xs-6 col-sm-3 placeholder">  
        </div>
        <div class="col-xs-6 col-sm-3 placeholder">
        </div>

        <div class="col-xs-6 col-sm-3 placeholder">                     
        </div>
      </div>
      <h2 class="sub-header">Users
      <small id="header_btn">
        {{ link_to('user/new','<i class="icon-ok icon-white"></i> Add new User', 'class': 'btn btn-primary btn-large btn-success') }}
        {% if type == 1 OR type == 2 %}
        {{ link_to('user/createExcel/'~'','<i class="icon-ok icon-white"></i> Extract', 'class': 'btn btn-primary btn-large btn-success') }}
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
              <th> Email </th>
              <th> User Name </th>
              <th> Password </th>
              <th> Type </th>
              <th> Status </th>
              <th> First Name</th>
              <th> Last Name</th>
              <th> Designation</th>
              <th> DOB </th>
              <th> Phone </th>
              <th> Alternate Phone</th>
              <th> LandLine</th>
              <th> Email </th>
              <th> Alternate Email</th>
              <th> Current Address</th>
              <th> Parmanent Address</th>
              <th> Communication Address </th>
              <th> LandLord Detail</th>
              <th> Father Name</th>
              <th> Father Phone</th>
              <th> Mother Name</th>
              <th> Mother Phone</th>
              <th> Pan </th>
              <th> Bank </th>
              <th> Branch</th>
              <th> Account Number</th>
              <th> MICR Code</th>
              <th> IFSC</th>                      
              <tr>
            </thead>
            <tbody>
          {% endif %}
              <tr>
              <td> {{atten.user.email}} </td>
              <td> {{atten.user.username}} </td>
              <td> {{atten.user.password}} </td>
              {% if atten.user.type == 1 %}
                {% set t = 'admin' %}
              {% elseif atten.user.type == 2 %}
                {% set t = 'manager' %}
              {% elseif atten.user.type == 3 %}
                {% set t = 'employee' %}
              {% endif %}
              <td> {{ t }} </td>
              {% if atten.user.status == 1 %}
                {% set status = 'active' %}
              {% else %}
                {% set status = 'inactive' %}
              {% endif %}
              <td> {{ status }} </td>
              <td> {{ atten.profile.first_name }} </td>
              <td> {{ atten.profile.last_name }} </td>
              <td> {{ atten.profile.designation }} </td>
              <td> {{ atten.profile.dob }} </td>
              <td> {{ atten.profile.phone }} </td>
              <td> {{ atten.profile.alt_phone}} </td>
              <td> {{ atten.profile.landline}} </td>
              <td> {{ atten.profile.email }} </td>
              <td> {{ atten.profile.alt_email }} </td>
              <td> {{ atten.profile.current_address }} </td>
              <td> {{ atten.profile.permanent_address}} </td>
              <td> {{ atten.profile.communication_address}} </td>
              <td> {{ atten.profile.landlord_detail }} </td>
              <td> {{ atten.profile.father_name }} </td>
              <td> {{ atten.profile.father_phone  }} </td>
              <td> {{ atten.profile.mother_name  }} </td>
              <td> {{ atten.profile.mother_phone }} </td>
              <td> {{ atten.profile.pan }} </td>
              <td> {{ atten.profile.bank }} </td>
              <td> {{ atten.profile.branch }} </td>
              <td> {{ atten.profile.account_number }} </td>
              <td> {{atten.profile.micr_code }} </td>
              <td> {{ atten.profile.ifsc}} </td>
              <td width="7%">
                {{ link_to("user/edit/"~atten.user.iduser,'<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}
              </td>
              <td width="7%">
                {{ link_to("user/delete/"~atten.user.iduser,'<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}
              </td>
              <td width="7%">
                {{ link_to("user/createExcel/"~atten.user.iduser,'<i class="glyphicon glyphicon-download-alt"></i> Extract', "class": "btn btn-default") }}
              </td>
              </tr>            
              {% if loop.last %}
              <tr>
              <td colspan="30" align="right">
              <div class="btn-group">
              {{ link_to("user/index", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
              {{ link_to("user/index?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
              {{ link_to("user/index?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
              {{ link_to("user/index?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
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

{{assets.outputCss('headercss')}}
{{ assets.outputJs('footerjs') }}
{{ assets.outputCss('mainpagecss') }}
{{ assets.outputJs('mainpagejs') }}
