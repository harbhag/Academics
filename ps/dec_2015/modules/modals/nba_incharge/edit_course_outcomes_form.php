<div class="modal hide" id="edit_course_outcomes_form<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Edit below Detail.'); ?>
  </div>
  <div class="modal-body">

<?
$program_cos_result = mysql_query("Select * from program_cos where backup='0' and id='".$row_pcos_2['id']."' ; ");
$program_cos_result_3 = mysql_query("Select distinct co_statement from program_cos where backup='0'and scheme_code='".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and subject_code='".$_POST['subject_code']."' ; ");
$program_outcomes_result = mysql_query("Select * from program_outcomes where  branch_code='".$_POST['branch_code']."'  ; ");
$row_pcos_1 = mysql_fetch_assoc($program_cos_result);
?>

<fieldset>
	<form action='' method='post'>  
    <div class="control-group">
		<script type = "text/javascript">
		function fillvalue(F) {
		F.co_statement.value = F.co_statement_p.value;
		}
		</script>
			<label class="control-label">CO Number </label>
			<select name='co_number' id='co_number' class='input-medium' readonly>
         <?		echo "<option value='".$row_pcos_1['co_number']."'>".$row_pcos_1['co_number']."</option>";?>
						
			</select>

			
			
			<!--<label class="control-label">CO Statements (Previous)</label>
			<select name='co_statement_p' id='co_statement_p' class='input-xxlarge' onchange='fillvalue(this.form)'>
			<option value=''>--</option>
			<?
		#	while($row_pcos = mysql_fetch_assoc($program_cos_result_3)) 
			#{
			#	echo " <option value='".$row_pcos['co_statement']."'>".$row_pcos['co_statement']."</option>";
			#}
			#?>
			</select>-->

			<label class="control-label">CO Statment (New)</label>
			<? echo "<textarea  name='co_statement' id='co_statement' class='input-xxlarge' readonly>".$row_pcos_1['co_statement']."</textarea>"; ?>
			
			<label class="control-label">Correlation with PO(Program Outcomes) </label>
					<select name='correlation_po' id='correlation_po' class='input-medium'>
         <?	echo "<option value='".$row_pcos_1['correlation_po']."'>".$row_pcos_1['correlation_po']."</option>";?>
						<option value='H'>H</option>
						<option value='M'>M</option>
						<option value='L'>L</option>			
				</select>
			
			
			<label class="control-label">Program Outcomes </label>
			<select name='program_outcome_id' id='program_outcome_id' class='input-xxlarge'>
			<?
			echo "<option value='".$row_po_id['id']."'>".$row_po_id['po_num'].": ".$row_po_id['po_statement']."</option>";
			while($row_po = mysql_fetch_assoc($program_outcomes_result)) 
			{
				echo " <option value='".$row_po['id']."'>".$row_po['po_num'].": ".$row_po['po_statement']."</option>";
			}
			?>
			</select>
			
			
			
			<input type='hidden' name='edit_course_outcomes_submit' value='edit_course_outcomes_submit'/>
			<? echo " <input type='hidden' name='course_code' value='".$row_sm['course_code']."' />
				<input type='hidden' name='m_code' value='".$row_sm['m_code']."' />
				<input type='hidden' name='semester' value='".$row_sm['semester']."' />
				<input type='hidden' name='branch_code' value='".$_POST['branch_code']."' />
				<input type='hidden' name='program_cos_id' value='".$row_pcos_2['id']."' />
				<input type='hidden' name='revision' value='".$row_pcos_2['revision']."' />
				<input type='hidden' name='scheme_code' value='".$_POST['scheme_code']."' />
				<input type='hidden' name='subject_code' value='".$_POST['subject_code']."' />";?>
				
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger">Proceed</button>
            </div>
      </form>

    </fieldset>
  </div>
</div>
