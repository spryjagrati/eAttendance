<?php echo $this->assets->outputCss('headercss'); ?>
<?php echo $this->assets->outputCss('mainpagecss'); ?>

<div class="container-fluid">
  <div class="row">       
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo $this->flash->output(); ?>
      <div class="row placeholders">
      <div class="col-xs-6 col-sm-3 placeholder"></div>
      <div class="col-xs-6 col-sm-3 placeholder"></div>
      <div class="col-xs-6 col-sm-3 placeholder"></div>
      <div class="col-xs-6 col-sm-3 placeholder"></div>
      </div>       
      <h2 class="sub-header">
      <?php if ($type == 1 || $type == 2) { ?>
      Users Experience
      <?php } else { ?>
      My Experience
      <?php } ?>
      <small id="header_btn">              
      <?php echo $this->tag->linkTo(array('experience/new', '<i class="icon-ok icon-white"></i> Add new Experience', 'class' => 'btn btn-primary btn-large btn-success')); ?>                 
      </small>              
      </h2>         
      <div class="table-responsive">
        <?php $counter = 0; ?>
        <?php $v13981304281iterated = false; ?><?php $v13981304281iterator = $page->items; $v13981304281incr = 0; $v13981304281loop = new stdClass(); $v13981304281loop->length = count($v13981304281iterator); $v13981304281loop->index = 1; $v13981304281loop->index0 = 1; $v13981304281loop->revindex = $v13981304281loop->length; $v13981304281loop->revindex0 = $v13981304281loop->length - 1; ?><?php foreach ($v13981304281iterator as $atten) { ?><?php $v13981304281loop->first = ($v13981304281incr == 0); $v13981304281loop->index = $v13981304281incr + 1; $v13981304281loop->index0 = $v13981304281incr; $v13981304281loop->revindex = $v13981304281loop->length - $v13981304281incr; $v13981304281loop->revindex0 = $v13981304281loop->length - ($v13981304281incr + 1); $v13981304281loop->last = ($v13981304281incr == ($v13981304281loop->length - 1)); ?><?php $v13981304281iterated = true; ?>
        <?php if ($v13981304281loop->first) { ?>
          <table class="table table-striped">
            <thead>
              <tr>
              <?php if ($type == 1 || $type == 2) { ?>
              <th> Id Experience</th>
              <?php } ?>
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
            <?php } ?>
              <tr>
            <?php if ($type == 1 || $type == 2) { ?>
              <td> <?php echo $atten->experience->idexperience; ?> </td>
            <?php } ?>
              <td> <?php echo $atten->username; ?> </td>
              <td> <?php echo $atten->experience->title; ?> </td>
              <td> <?php echo $atten->experience->description; ?> </td>
              <td> <?php echo $atten->experience->from_date; ?> </td>
              <td> <?php echo $atten->experience->to_date; ?> </td>
              <td> <?php echo $atten->experience->company; ?> </td>
              <td> <?php echo $atten->experience->company_address; ?> </td>
              <td> <?php echo $atten->experience->company_ctc; ?> </td>                  
              <td width="7%">
              <?php echo $this->tag->linkTo(array('experience/edit/' . $atten->experience->idexperience, '<i class="glyphicon glyphicon-edit"></i> Edit', 'class' => 'btn btn-default')); ?>
              </td>

              <?php if ($type == 1 || $type == 2) { ?>
              <td width="7%">
              <?php echo $this->tag->linkTo(array('experience/delete/' . $atten->experience->idexperience, '<i class="glyphicon glyphicon-remove"></i> Delete', 'class' => 'btn btn-default')); ?>
              </td>  
               <?php } ?>  
              
                            
              </tr>            
            <?php if ($v13981304281loop->last) { ?>
              <tr>
              <td colspan="12" align="right">
              <div class="btn-group">
              <?php echo $this->tag->linkTo(array('experience/index', '<i class="icon-fast-backward"></i> First', 'class' => 'btn')); ?>
              <?php echo $this->tag->linkTo(array('experience/index?page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn')); ?>
              <?php echo $this->tag->linkTo(array('experience/index?page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn')); ?>
              <?php echo $this->tag->linkTo(array('experience/index?page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn')); ?>
              <span class="help-inline"><?php echo $page->current; ?> of <?php echo $page->total_pages; ?></span>
              </div>
              </td>
              </tr>
            </tbody>
          </table>
            <?php } ?>
            <?php $v13981304281incr++; } if (!$v13981304281iterated) { ?>
               No Experience is recorded
          <?php } ?>
        </div>
      </div>
    </div>
<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>