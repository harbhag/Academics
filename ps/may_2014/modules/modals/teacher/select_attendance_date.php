<div class="modal hide" id="select_attendance_date">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Select below the Date.'); ?>
  </div>
  <div class="modal-body">
    
     <form action='' method='post'>
    <fieldset>
      <div id="legend" class="">
        <legend class="">Daily Attendance Record</legend>
      </div>
    <div class="control-group">
			<label class="control-label">Date</label>
		 <div class="input-append date" id="dp<?php echo rand(); ?>" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				<input class="span2" size="16" type="text" name="attendance_date" value="<?php echo date('Y-m-d'); ?>" readonly>
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>
        
       <input type='hidden' name='teacher_view_daily_attendance_record' />
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger">Proceed</button>
            </div>
      </form>

    </fieldset>

					
   
  </div>
</div>
