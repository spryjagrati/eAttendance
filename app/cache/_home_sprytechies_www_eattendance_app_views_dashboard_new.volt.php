<?php echo $this->assets->outputCss('headercss'); ?>
<?php echo $this->assets->outputCss('mainpagecss'); ?>
<?php echo $this->assets->outputCss('countupcss'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <?php echo $this->flash->output(); ?>
      <div class="row-fluid" id="dashboard_timer">
        <h2 class="page-header">Dashboard 
        <input type="hidden" id='clockDisplay' class="clockStyle" size="10"  placeholder="Start Timer" value=<?php echo $sec; ?>>
        </input>
        <input type="hidden" id='totalhour' class="totalhour" size="10"   value=<?php echo $total_seconds; ?>>
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
            PL = <?php echo $left_pl; ?>, CL =<?php echo $left_cl; ?>, SL =<?php echo $left_sl; ?>
          </span>
          </div>
          <div class="col-xs-6 col-sm-3 placeholder">              
          <h4>Today's Working Hours</h4>
          <span class="text-muted" id="text-muted">
             <?php echo $total_hours; ?>
          </span>
          </div>
        </div>
        <h2 class="sub-header">Attendance List</h2>
          <?php $v38870130701iterated = false; ?><?php $v38870130701iterator = $page->items; $v38870130701incr = 0; $v38870130701loop = new stdClass(); $v38870130701loop->length = count($v38870130701iterator); $v38870130701loop->index = 1; $v38870130701loop->index0 = 1; $v38870130701loop->revindex = $v38870130701loop->length; $v38870130701loop->revindex0 = $v38870130701loop->length - 1; ?><?php foreach ($v38870130701iterator as $atten) { ?><?php $v38870130701loop->first = ($v38870130701incr == 0); $v38870130701loop->index = $v38870130701incr + 1; $v38870130701loop->index0 = $v38870130701incr; $v38870130701loop->revindex = $v38870130701loop->length - $v38870130701incr; $v38870130701loop->revindex0 = $v38870130701loop->length - ($v38870130701incr + 1); $v38870130701loop->last = ($v38870130701incr == ($v38870130701loop->length - 1)); ?><?php $v38870130701iterated = true; ?>
          <?php if ($v38870130701loop->first) { ?>
            <table class="table table-striped">
              <thead>
              <tr>
              <th> User Name </th>
              <th> Date </th>
              <th> In Time </th>
              <th> Out Time </th>
              <th> Status </th>
              <tr>
              </thead>
              <tbody>
          <?php } ?>
              <tr>                    
              <td> <?php echo $atten->username; ?> </td>
              <td> <?php echo $atten->attendance->cdate; ?> </td>
              <td> <?php echo $atten->attendance->in_time; ?> </td>
              <td> <?php echo $atten->attendance->out_time; ?> </td>
              <?php if ($atten->attendance->type == 1) { ?>
                <?php $type = 'Present'; ?>
              <?php } elseif ($atten->attendance->type == -1) { ?>
                <?php $type = 'unmarked'; ?>
              <?php } else { ?>
                <?php $type = 'absent'; ?>
              <?php } ?>
              <td> <?php echo $type; ?> </td>
              </tr>
              <?php if ($v38870130701loop->last) { ?>
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
            <?php $v38870130701incr++; } if (!$v38870130701iterated) { ?>
              No User is recorded
          <?php } ?>
        </div>
     </div>
</div>

<?php echo $this->assets->outputJs('footerjs'); ?>
<?php echo $this->assets->outputJs('mainpagejs'); ?>
<?php echo $this->assets->outputJs('countupjs'); ?>