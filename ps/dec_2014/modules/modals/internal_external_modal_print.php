<div class="modal hide" id="myModalprint<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Select below the type of Evaluation'); ?>
  </div>
  <div class="modal-body">
    
      <select name='internal_external'>
				<?php
				if($internal_lock_status==1 && $internal_allot==1) {
					echo "<option value='I'>Internal</option>";
				}
				if($external_lock_status==1 && $external_allot==1) {
					echo "<option value='E'>External</option>";
				}
				?>
			</select>
      <p><button type="submit" class="btn btn-mini btn-danger">Go</button></p>
   
  </div>
</div>