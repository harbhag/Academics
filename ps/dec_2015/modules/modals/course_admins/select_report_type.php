<div class="modal hide" id="select_report_type">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Summary Report'); ?>
  </div>
  <div class="modal-body">
    
     <form action='' method='post'>
    <fieldset>
      <div id="legend" class="">
        <legend class="">Report Type</legend>
      </div>
    <div class="control-group">
			<label class="control-label">Select Report Type</label>
		<select name='attendance_report_type' >
			<option value='Aggregate'>Aggregate Attandance</option>
			<option value='Daily'>Daily Attandance</option>
			</select>
        
       <input type='hidden' name='generate_attendance_report_form' />
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger">Proceed</button>
            </div>
      </form>

    </fieldset>

					
   
  </div>
</div>
