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
    <div>
    <h2 class="sub-header">
    <?php if ($type == 1 || $type == 2) { ?>
    Users Documents
    <?php } else { ?>
    My Documents
    <?php } ?>      
    <small id="header_btn">
      <?php echo $this->tag->linkTo(array('document/new', '<i class="icon-ok icon-white"></i> Add new Document', 'class' => 'btn btn-primary btn-large btn-success')); ?>
    </small>
    </h2>
    </div>         
    <div class="table-responsive">             
      <?php $v21489050431iterated = false; ?><?php $v21489050431iterator = $page->items; $v21489050431incr = 0; $v21489050431loop = new stdClass(); $v21489050431loop->length = count($v21489050431iterator); $v21489050431loop->index = 1; $v21489050431loop->index0 = 1; $v21489050431loop->revindex = $v21489050431loop->length; $v21489050431loop->revindex0 = $v21489050431loop->length - 1; ?><?php foreach ($v21489050431iterator as $atten) { ?><?php $v21489050431loop->first = ($v21489050431incr == 0); $v21489050431loop->index = $v21489050431incr + 1; $v21489050431loop->index0 = $v21489050431incr; $v21489050431loop->revindex = $v21489050431loop->length - $v21489050431incr; $v21489050431loop->revindex0 = $v21489050431loop->length - ($v21489050431incr + 1); $v21489050431loop->last = ($v21489050431incr == ($v21489050431loop->length - 1)); ?><?php $v21489050431iterated = true; ?>
      <?php if ($v21489050431loop->first) { ?>
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
      <?php } ?>
        <tr>      
        <td> <?php echo $atten->username; ?> </td>
        <td> <?php echo $atten->document->title; ?> </td>
        <td> <?php echo $atten->document->description; ?> </td>
        <td> <?php echo $atten->document->taken_date; ?> </td>
        <td> <?php echo $atten->document->given_date; ?> </td>
        <td width="7%">
        <?php echo $this->tag->linkTo(array('document/edit/' . $atten->document->iddocument, '<i class="glyphicon glyphicon-edit"></i> Edit', 'class' => 'btn btn-default')); ?>
        </td>
        <td width="7%">
        <?php echo $this->tag->linkTo(array('document/delete/' . $atten->document->iddocument, '<i class="glyphicon glyphicon-remove"></i> Delete', 'class' => 'btn btn-default')); ?>
        </td>
        </tr>                  
      <?php if ($v21489050431loop->last) { ?>
        <tr>
        <td colspan="12" align="right">
        <div class="btn-group">
        <?php echo $this->tag->linkTo(array('document/index', '<i class="icon-fast-backward"></i> First', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('document/index?page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('document/index?page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('document/index?page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn')); ?>
        <span class="help-inline"><?php echo $page->current; ?> of <?php echo $page->total_pages; ?></span>
        </div>
        </td>
        </tr>                          
        </tbody>
      </table>
      <?php } ?>
      <?php $v21489050431incr++; } if (!$v21489050431iterated) { ?>
      No Document is recorded
    <?php } ?>
    </div>
  </div>
</div>

<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>