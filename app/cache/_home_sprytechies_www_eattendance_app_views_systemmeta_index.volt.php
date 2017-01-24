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
      <h2 class="page-header">System Settings
      <small id="header_btn">
        <?php echo $this->tag->linkTo(array('systemmeta/new', '<i class="icon-ok icon-white"></i> Add new Setting', 'class' => 'btn btn-primary btn-large btn-success')); ?>
      </small>
      </h2>          
      <div class="table-responsive">
        <?php $counter = 0; ?>
        <?php $v8937913601iterated = false; ?><?php $v8937913601iterator = $page->items; $v8937913601incr = 0; $v8937913601loop = new stdClass(); $v8937913601loop->length = count($v8937913601iterator); $v8937913601loop->index = 1; $v8937913601loop->index0 = 1; $v8937913601loop->revindex = $v8937913601loop->length; $v8937913601loop->revindex0 = $v8937913601loop->length - 1; ?><?php foreach ($v8937913601iterator as $atten) { ?><?php $v8937913601loop->first = ($v8937913601incr == 0); $v8937913601loop->index = $v8937913601incr + 1; $v8937913601loop->index0 = $v8937913601incr; $v8937913601loop->revindex = $v8937913601loop->length - $v8937913601incr; $v8937913601loop->revindex0 = $v8937913601loop->length - ($v8937913601incr + 1); $v8937913601loop->last = ($v8937913601incr == ($v8937913601loop->length - 1)); ?><?php $v8937913601iterated = true; ?>
          <?php if ($v8937913601loop->first) { ?>
          <table class="table table-striped">
            <thead>
              <tr>
             
              <th> Meta Name </th>
              <th> Meta Value </th>
              <tr>
            </thead>
          <tbody>
          <?php } ?>
              <tr>
              
              <td> <?php echo $atten->meta_name; ?> </td>
              <td> <?php echo $atten->meta_value; ?> </td>
              <td width="7%">
              <?php echo $this->tag->linkTo(array('systemmeta/edit/' . $atten->idsystem_meta, '<i class="glyphicon glyphicon-edit"></i> Edit', 'class' => 'btn btn-default')); ?>
              </td>
             
              </tr>             
          <?php if ($v8937913601loop->last) { ?>
              <tr>
              <td colspan="12" align="right">
              <div class="btn-group">
                <?php echo $this->tag->linkTo(array('systemmeta/index', '<i class="icon-fast-backward"></i> First', 'class' => 'btn')); ?>
                <?php echo $this->tag->linkTo(array('systemmeta/index?page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn')); ?>
                <?php echo $this->tag->linkTo(array('systemmeta/index?page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn')); ?>
                <?php echo $this->tag->linkTo(array('systemmeta/index?page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn')); ?>
                <span class="help-inline"><?php echo $page->current; ?> of <?php echo $page->total_pages; ?></span>
              </div>
              </td>
              </tr>
              </tbody>
            </table>
          <?php } ?>
          <?php $v8937913601incr++; } if (!$v8937913601iterated) { ?>
            No Syetem meta is recorded
      <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>
