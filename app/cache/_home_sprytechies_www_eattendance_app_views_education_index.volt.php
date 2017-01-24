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
    Users Education
    <?php } else { ?>
    My Education
    <?php } ?>
    <small id="header_btn">
    <?php echo $this->tag->linkTo(array('education/new', '<i class="icon-ok icon-white"></i> Add new Education', 'class' => 'btn btn-primary btn-large btn-success')); ?>
    </small>
    </h2>
    <div class="table-responsive">
    <?php $counter = 0; ?>
    <?php $v36000436961iterated = false; ?><?php $v36000436961iterator = $page->items; $v36000436961incr = 0; $v36000436961loop = new stdClass(); $v36000436961loop->length = count($v36000436961iterator); $v36000436961loop->index = 1; $v36000436961loop->index0 = 1; $v36000436961loop->revindex = $v36000436961loop->length; $v36000436961loop->revindex0 = $v36000436961loop->length - 1; ?><?php foreach ($v36000436961iterator as $atten) { ?><?php $v36000436961loop->first = ($v36000436961incr == 0); $v36000436961loop->index = $v36000436961incr + 1; $v36000436961loop->index0 = $v36000436961incr; $v36000436961loop->revindex = $v36000436961loop->length - $v36000436961incr; $v36000436961loop->revindex0 = $v36000436961loop->length - ($v36000436961incr + 1); $v36000436961loop->last = ($v36000436961incr == ($v36000436961loop->length - 1)); ?><?php $v36000436961iterated = true; ?>
    <?php if ($v36000436961loop->first) { ?>
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
        <?php } ?>
        <tr>                 
        <td> <?php echo $atten->username; ?> </td>
        <td> <?php echo $atten->education->title; ?> </td>
        <td> <?php echo $atten->education->description; ?> </td>
        <td> <?php echo $atten->education->from_date; ?> </td>
        <td> <?php echo $atten->education->to_date; ?> </td>
        <td> <?php echo $atten->education->college; ?> </td>
        <td> <?php echo $atten->education->grade; ?> </td>
        <td> <?php echo $atten->education->stream; ?> </td>       
        <td width="7%">
        <?php echo $this->tag->linkTo(array('education/edit/' . $atten->education->ideducation, '<i class="glyphicon glyphicon-edit"></i> Edit', 'class' => 'btn btn-default')); ?>
        </td>
        <?php if ($type == 1 || $type == 2) { ?>
        <td width="7%">
        <?php echo $this->tag->linkTo(array('education/delete/' . $atten->education->ideducation, '<i class="glyphicon glyphicon-remove"></i> Delete', 'class' => 'btn btn-default')); ?>
        </td>
        <?php } ?>
        </tr>          
      <?php if ($v36000436961loop->last) { ?>
        <tr>
        <td colspan="12" align="right">
        <div class="btn-group">
        <?php echo $this->tag->linkTo(array('education/index', '<i class="icon-fast-backward"></i> First', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('education/index?page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('education/index?page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('education/index?page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn')); ?>
        <span class="help-inline"><?php echo $page->current; ?> of <?php echo $page->total_pages; ?></span>
        </div>
         </td>
        </tr>
        </tbody>
      </table>
      <?php } ?>
      <?php $v36000436961incr++; } if (!$v36000436961iterated) { ?>
        No Education is recorded
      <?php } ?>
    </div>
  </div>
</div>

<?php echo $this->assets->outputCss('headercss'); ?>
<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputCss('mainpagecss'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>