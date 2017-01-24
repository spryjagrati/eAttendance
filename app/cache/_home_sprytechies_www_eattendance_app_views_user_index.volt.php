<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">             
      <?php echo $this->flash->output(); ?>        
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
        <?php echo $this->tag->linkTo(array('user/new', '<i class="icon-ok icon-white"></i> Add new User', 'class' => 'btn btn-primary btn-large btn-success')); ?>
        <?php if ($type == 1 || $type == 2) { ?>
        <?php echo $this->tag->linkTo(array('user/createExcel/' . '', '<i class="icon-ok icon-white"></i> Extract', 'class' => 'btn btn-primary btn-large btn-success')); ?>
        <?php } ?>
      </small>
      </h2>          
      <div class="table-responsive">
        <?php $counter = 0; ?>
        <?php $v26046443391iterated = false; ?><?php $v26046443391iterator = $page->items; $v26046443391incr = 0; $v26046443391loop = new stdClass(); $v26046443391loop->length = count($v26046443391iterator); $v26046443391loop->index = 1; $v26046443391loop->index0 = 1; $v26046443391loop->revindex = $v26046443391loop->length; $v26046443391loop->revindex0 = $v26046443391loop->length - 1; ?><?php foreach ($v26046443391iterator as $atten) { ?><?php $v26046443391loop->first = ($v26046443391incr == 0); $v26046443391loop->index = $v26046443391incr + 1; $v26046443391loop->index0 = $v26046443391incr; $v26046443391loop->revindex = $v26046443391loop->length - $v26046443391incr; $v26046443391loop->revindex0 = $v26046443391loop->length - ($v26046443391incr + 1); $v26046443391loop->last = ($v26046443391incr == ($v26046443391loop->length - 1)); ?><?php $v26046443391iterated = true; ?>
        <?php if ($v26046443391loop->first) { ?>
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
          <?php } ?>
              <tr>
              <td> <?php echo $atten->user->email; ?> </td>
              <td> <?php echo $atten->user->username; ?> </td>
              <td> <?php echo $atten->user->password; ?> </td>
              <?php if ($atten->user->type == 1) { ?>
                <?php $t = 'admin'; ?>
              <?php } elseif ($atten->user->type == 2) { ?>
                <?php $t = 'manager'; ?>
              <?php } elseif ($atten->user->type == 3) { ?>
                <?php $t = 'employee'; ?>
              <?php } ?>
              <td> <?php echo $t; ?> </td>
              <?php if ($atten->user->status == 1) { ?>
                <?php $status = 'active'; ?>
              <?php } else { ?>
                <?php $status = 'inactive'; ?>
              <?php } ?>
              <td> <?php echo $status; ?> </td>
              <td> <?php echo $atten->profile->first_name; ?> </td>
              <td> <?php echo $atten->profile->last_name; ?> </td>
              <td> <?php echo $atten->profile->designation; ?> </td>
              <td> <?php echo $atten->profile->dob; ?> </td>
              <td> <?php echo $atten->profile->phone; ?> </td>
              <td> <?php echo $atten->profile->alt_phone; ?> </td>
              <td> <?php echo $atten->profile->landline; ?> </td>
              <td> <?php echo $atten->profile->email; ?> </td>
              <td> <?php echo $atten->profile->alt_email; ?> </td>
              <td> <?php echo $atten->profile->current_address; ?> </td>
              <td> <?php echo $atten->profile->permanent_address; ?> </td>
              <td> <?php echo $atten->profile->communication_address; ?> </td>
              <td> <?php echo $atten->profile->landlord_detail; ?> </td>
              <td> <?php echo $atten->profile->father_name; ?> </td>
              <td> <?php echo $atten->profile->father_phone; ?> </td>
              <td> <?php echo $atten->profile->mother_name; ?> </td>
              <td> <?php echo $atten->profile->mother_phone; ?> </td>
              <td> <?php echo $atten->profile->pan; ?> </td>
              <td> <?php echo $atten->profile->bank; ?> </td>
              <td> <?php echo $atten->profile->branch; ?> </td>
              <td> <?php echo $atten->profile->account_number; ?> </td>
              <td> <?php echo $atten->profile->micr_code; ?> </td>
              <td> <?php echo $atten->profile->ifsc; ?> </td>
              <td width="7%">
                <?php echo $this->tag->linkTo(array('user/edit/' . $atten->user->iduser, '<i class="glyphicon glyphicon-edit"></i> Edit', 'class' => 'btn btn-default')); ?>
              </td>
              <td width="7%">
                <?php echo $this->tag->linkTo(array('user/delete/' . $atten->user->iduser, '<i class="glyphicon glyphicon-remove"></i> Delete', 'class' => 'btn btn-default')); ?>
              </td>
              <td width="7%">
                <?php echo $this->tag->linkTo(array('user/createExcel/' . $atten->user->iduser, '<i class="glyphicon glyphicon-download-alt"></i> Extract', 'class' => 'btn btn-default')); ?>
              </td>
              </tr>            
              <?php if ($v26046443391loop->last) { ?>
              <tr>
              <td colspan="30" align="right">
              <div class="btn-group">
              <?php echo $this->tag->linkTo(array('user/index', '<i class="icon-fast-backward"></i> First', 'class' => 'btn')); ?>
              <?php echo $this->tag->linkTo(array('user/index?page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn')); ?>
              <?php echo $this->tag->linkTo(array('user/index?page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn')); ?>
              <?php echo $this->tag->linkTo(array('user/index?page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn')); ?>
              <span class="help-inline"><?php echo $page->current; ?> of <?php echo $page->total_pages; ?></span>
              </div>
              </td>
              </tr>
              </tbody>
             </table>
              <?php } ?>
              <?php $v26046443391incr++; } if (!$v26046443391iterated) { ?>
              No User is recorded
          <?php } ?>
        </div>
    </div>
</div>

<?php echo $this->assets->outputCss('headercss'); ?>
<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputCss('mainpagecss'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>
