<div class="modal hide" id="unlock_consolidated_report<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php 
    
    show_label('important','Please provide the User ID of the teacher.'); 
    echo "<br/>";
   
    
    ?>
  </div>
  <div class="modal-body">
      
    <fieldset>
      <div id="legend" class="">
        <legend class="">Consolidated Report</legend>
      </div>
    <div class="control-group">
                        
                        

        <label class="control-label">Teacher User ID</label>
        <form action='' method='post'>
                
         <input class="input-xlarge" size="16" type="hidden" name="unlock_consolidated_report_form">
         <input class="input-xlarge" size="16" type="text" name="username" id="username">
         <script>
				var username = new LiveValidation('username',{ validMessage: 'ok', wait: 500});
				username.add(Validate.Presence);

		</script>

       
        
       
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger">Proceed</button>
            </div>
      </form>

    </fieldset>

                                        
   
  </div>
</div>

