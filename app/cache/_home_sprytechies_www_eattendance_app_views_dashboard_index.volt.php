<?php echo $this->assets->outputCss('headercss'); ?>
<?php echo $this->assets->outputCss('mainpagecss'); ?>
<?php echo $this->assets->outputCss('countupcss'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">      
    <?php echo $this->flash->output(); ?>
    <?php if ($type == 2) { ?>          
    <div class="row-fluid" id="dashboard_timer">           
      <h2 class="page-header">Dashboard   
        <input type="hidden" id='totalhour' class="totalhour" size="10"   value=<?php echo $total_hours; ?>>  
        <input type="hidden" id='clockDisplay' class="clockStyle" size="10"  placeholder="Start Timer" value=<?php echo $sec; ?>>
        </input>
        <div class="span6" id='header_btn'>
        <div class="timer" style="float:left"> 
        <span class="hour"><?php echo $hours; ?></span>:<span class="minute"><?php echo $mins; ?></span>:<span class="second"><?php echo $second; ?></span>
        </div>
        <button onClick="timer.start(1000)" id='start_btn' class= 'btn btn-primary btn-large btn-success'>Start Timer</button>     
        <button onClick="timer.stop()" id='stop_btn' class= 'btn btn-primary btn-large btn-success hide'>Stop Timer</button>
        </div>
      </h2>
    </div>
    <?php } else { ?>
      <h2 class="page-header">Dashboard </h2>
    <?php } ?>
    <?php if ($type == 2) { ?>
      <div class="row placeholders">
        <div class="col-xs-6 col-sm-2 placeholder">     
          <h4>Total Present</h4>
          <span class="text-muted"> 
              <?php echo $present; ?>
          </span>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">     
          <h4>Total Absent</h4>
          <span class="text-muted">
            <?php echo $absent; ?>
          </span>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">      
          <h4>Total Leaves Left</h4>
          <span class="text-muted">
             PL = <?php echo $left_pl; ?>, CL = <?php echo $left_cl; ?>, SL = <?php echo $left_sl; ?>
          </span>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">      
          <h4>UnMarked</h4>
          <span class="text-muted">
            <?php echo $unmarked; ?>
          </span>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">       
            <h4>Today's Working Hours</h4>
            <span class="text-muted" id="text-muted" >
                00:00:00
            </span>
        </div>
       </div>
    <?php } else { ?>
        <div class="row placeholders">
      <div class="col-xs-6 col-sm-3 placeholder">     
        <h4>Total Present</h4>
        <span class="text-muted"> 
            <?php echo $present; ?>
        </span>
      </div>
      <div class="col-xs-6 col-sm-3 placeholder">     
        <h4>Total Absent</h4>
        <span class="text-muted">
          <?php echo $absent; ?>
        </span>
      </div>
      <div class="col-xs-6 col-sm-3 placeholder">      
        <h4>Total Leaves Left</h4>
        <span class="text-muted">
           PL = <?php echo $left_pl; ?>, CL = <?php echo $left_cl; ?>, SL = <?php echo $left_sl; ?>
        </span>
      </div>
      <div class="col-xs-6 col-sm-3 placeholder">      
        <h4>UnMarked</h4>
        <span class="text-muted">
          <?php echo $unmarked; ?>
        </span>
      </div>
     </div>
    <?php } ?>
   
    <h2 class="sub-header">Today's Individual Attendance</h2>    
      <div class="table-responsive">
      <?php $counter = 0; ?>
      <?php $v9632920601iterated = false; ?><?php $v9632920601iterator = $page->items; $v9632920601incr = 0; $v9632920601loop = new stdClass(); $v9632920601loop->length = count($v9632920601iterator); $v9632920601loop->index = 1; $v9632920601loop->index0 = 1; $v9632920601loop->revindex = $v9632920601loop->length; $v9632920601loop->revindex0 = $v9632920601loop->length - 1; ?><?php foreach ($v9632920601iterator as $atten) { ?><?php $v9632920601loop->first = ($v9632920601incr == 0); $v9632920601loop->index = $v9632920601incr + 1; $v9632920601loop->index0 = $v9632920601incr; $v9632920601loop->revindex = $v9632920601loop->length - $v9632920601incr; $v9632920601loop->revindex0 = $v9632920601loop->length - ($v9632920601incr + 1); $v9632920601loop->last = ($v9632920601incr == ($v9632920601loop->length - 1)); ?><?php $v9632920601iterated = true; ?>
      <?php if ($v9632920601loop->first) { ?>
        <table class="table table-striped">
        <thead>
        <tr>
        <th> Id User</th>
        <th> User Name </th>
        <th> Status </th>
        <th> Date </th>
        <tr>
        </thead>
        <tbody>
      <?php } ?>
        <tr>
        <td> <?php echo $atten->iduser; ?> </td>
        <td> <?php echo $atten->username; ?> </td>         
        <?php if ($atten->type == null) { ?>
          <?php $s = '--'; ?>
        <?php } elseif ($atten->type == 1) { ?>
           <?php $s = 'Present'; ?>
        <?php } elseif ($atten->type == 0) { ?>
           <?php $s = 'Absent'; ?>
        <?php } ?>
        <td> <?php echo $s; ?> </td>
        <td> <?php echo $today_date; ?>           
        </tr>             
        <?php if ($v9632920601loop->last) { ?>
        <tr>
        <td colspan="12" align="right">
        <div class="btn-group">
        <?php echo $this->tag->linkTo(array('dashboard/index', '<i class="icon-fast-backward"></i> First', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('dashboard/index?page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('dashboard/index?page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn')); ?>
        <?php echo $this->tag->linkTo(array('dashboard/index?page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn')); ?>
        <span class="help-inline"><?php echo $page->current; ?> of <?php echo $page->total_pages; ?></span>
        </div>
        </td>
        </tr>
      </tbody>
      </table>
      <?php } ?>
      <?php $v9632920601incr++; } if (!$v9632920601iterated) { ?>
      No User is recorded
    <?php } ?>
    </div>
    </div>
  </div>
</div>
<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>
<?php echo $this->assets->outputJs('countupjs'); ?>