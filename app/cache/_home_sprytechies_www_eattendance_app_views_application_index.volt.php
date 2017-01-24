<?php echo $this->assets->outputCss('headercss'); ?>
<?php echo $this->assets->outputCss('datepickercss'); ?>
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
      <div height="100px" width="50px" class="head">
        <div id="filter">
        <?php echo Phalcon\Tag::form(array('application/index', 'method' => 'get', 'id'=>'form')); ?>
        <label for="from">From:</label>
        <?php echo Phalcon\Tag::textField(array("from", "id"=>"from", "value"=>$_GET['from'])); ?>
        <label for="to">To:</label>
        <?php echo Phalcon\Tag::textField(array("to", "id"=>"to", "value"=>$_GET['to'])); ?>
        <?php if ($type == 1 || $type == 2) { ?>
        <?php echo Phalcon\Tag::select(
            array(
              "user_list",
                    User::find(),
                    "using" => array("iduser", "username"),
                    'useEmpty'=> true,
                    'emptyText'=> 'All', 
                    'emptyValue'=> '0',
                    'value'=> $_GET['user_list']
              ));
         ?>
         <?php } ?>
        <?php echo Phalcon\Tag::submitButton('Filter'); ?>                
        <?php echo $this->tag->endForm(); ?>               
        </div>
        </div> 
        <div class="view-button">                
        </div>

        <h2 class="sub-header">
        <?php if ($type == 1 || $type == 2) { ?>
        Users Leaves
        <?php } else { ?>
        My Leaves
        <?php } ?>
        <small id="header_btn">
        <?php echo $this->tag->linkTo(array('application/new', '<i class="icon-ok icon-white"></i> Add new Application', 'class' => 'btn btn-primary btn-large btn-success', 'id' => 'btn')); ?>
        <?php if ($type == 1 || $type == 2) { ?>
        <?php echo $this->tag->linkTo(array($extractUrl, '<i class="icon-ok icon-white"></i> Extract', 'class' => 'btn btn-primary btn-large btn-success')); ?> 
        <?php } ?>
        </small>
        </h2>

        <div class="table-responsive">  
          <?php $v23672479441iterated = false; ?><?php $v23672479441iterator = $page->items; $v23672479441incr = 0; $v23672479441loop = new stdClass(); $v23672479441loop->length = count($v23672479441iterator); $v23672479441loop->index = 1; $v23672479441loop->index0 = 1; $v23672479441loop->revindex = $v23672479441loop->length; $v23672479441loop->revindex0 = $v23672479441loop->length - 1; ?><?php foreach ($v23672479441iterator as $atten) { ?><?php $v23672479441loop->first = ($v23672479441incr == 0); $v23672479441loop->index = $v23672479441incr + 1; $v23672479441loop->index0 = $v23672479441incr; $v23672479441loop->revindex = $v23672479441loop->length - $v23672479441incr; $v23672479441loop->revindex0 = $v23672479441loop->length - ($v23672479441incr + 1); $v23672479441loop->last = ($v23672479441incr == ($v23672479441loop->length - 1)); ?><?php $v23672479441iterated = true; ?>
            <?php if ($v23672479441loop->first) { ?>
              <table class="table table-striped">
                <thead>
                <tr>                         
                <th> User Name </th>
                <th> From Date </th>
                <th> To Date </th>
                <th> Type </th>
                <th> Title </th>
                <th> Description </th>
                <th> Status </th>
                <?php if ($type == 1 || $type == 2) { ?>
                <th> Submitted On</th>                        
                <?php } ?>
                <tr>
                </thead>
                <tbody>
            <?php } ?>
                <tr>                          
                <td> <?php echo $atten->username; ?></td>
                <td> <?php echo $atten->application->from_date; ?> </td>
                <td> <?php echo $atten->application->to_date; ?> </td>
                <?php if ($atten->application->type == 2) { ?>
                <?php $t = 'PL'; ?>
                <?php } elseif ($atten->application->type == 3) { ?>
                <?php $t = 'CL'; ?>
                <?php } elseif ($atten->application->type == 4) { ?>
                <?php $t = 'SL'; ?>
                <?php } ?>
                <td> <?php echo $t; ?> </td>
                <td> <?php echo $atten->application->title; ?> </td>
                <td> <?php echo $atten->application->description; ?> </td>
                <?php if ($atten->application->status == 1) { ?>
                <?php $status = 'Pending'; ?>
                <?php } elseif ($atten->application->status == 2) { ?>
                <?php $status = 'Approved'; ?>
                <?php } elseif ($atten->application->status == 3) { ?>
                <?php $status = 'Rejected'; ?>
                <?php } ?>
                <td> <?php echo $status; ?> </td>
               <?php if ($type == 1 || $type == 2) { ?>
                <td> <?php echo $atten->application->created_on; ?></td>
                <td width="7%">
                <?php echo $this->tag->linkTo(array('application/edit/' . $atten->application->idapplication, '<i class="glyphicon glyphicon-edit"></i> Edit', 'class' => 'btn btn-default')); ?>
                </td>
                <td width="7%">
                <?php echo $this->tag->linkTo(array('application/delete/' . $atten->application->idapplication, '<i class="glyphicon glyphicon-remove"></i> Delete', 'class' => 'btn btn-default')); ?>
                </td>
              <?php } ?>
                </tr>                   
                <?php if ($v23672479441loop->last) { ?>
                <tr>
                <td colspan="12" align="right">
                <div class="btn-group">
                <?php echo $this->tag->linkTo(array($parentUrl, '<i class="icon-fast-backward"></i> First', 'class' => 'btn')); ?>
                <?php echo $this->tag->linkTo(array($parentUrl . 'page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn')); ?>
                <?php echo $this->tag->linkTo(array($parentUrl . 'page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn')); ?>
                <?php echo $this->tag->linkTo(array($parentUrl . 'page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn')); ?>
                <span class="help-inline"><?php echo $page->current; ?> of <?php echo $page->total_pages; ?></span>
                </div>
                </td>
              </tr>
            </tbody>
          </table>
          <?php } ?>
          <?php $v23672479441incr++; } if (!$v23672479441iterated) { ?>
            No Leaves is recorded
          <?php } ?>
      </div>
  </div>
</div>

<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>
<?php echo $this->assets->outputJs('datepickerjs'); ?>

<script type="text/javascript">           
  jQuery(document).ready(function($) {
    $('#from').datepicker({ 
      format : "yyyy/mm/dd",
      autoclose: true
    })
    .on('changeDate', function(selected){
      startDate = new Date(selected.date.valueOf());
      startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
      $('#to').datepicker('setStartDate', startDate);
    });         
    $('#to').datepicker({                  
      format : "yyyy/mm/dd",                        
    }); 
    $("#user_list").change(function(){                   
      $('#form').submit();
    });     
});
</script>   