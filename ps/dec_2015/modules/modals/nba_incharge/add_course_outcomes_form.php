<div class="modal hide" id="add_course_outcomes_form">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Fill below Detail'); ?>
  </div>
  <div class="modal-body">
<?
$program_cos_result = mysql_query("Select distinct co_statement from program_cos where backup='0' and scheme_code='".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and subject_code='".$_POST['subject_code']."' ; ");
$program_outcomes_result = mysql_query("Select * from program_outcomes where  branch_code='".$_POST['branch_code']."'  ; ");

?>
<script>
function showUser(str, branch_code)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
subject_code = document.getElementById("subject_code").value;
document.getElementById("co_statement").value = '';
//xmlhttp.open("GET","getco_po_statement.php?q="+str+"&subject_code="+subject_code ,true);
xmlhttp.open("GET","getco_po_statement.php?q="+str+"&subject_code="+subject_code+"&branch_code="+branch_code ,true);
xmlhttp.send();
}
</script>

<fieldset>
     <form action='' method='post'>  
    <div class="control-group">
		<script type = "text/javascript">
		function fillvalue(F) {
		F.co_statement.value = F.co_statement_p.value;
		}
		</script>
			<label class="control-label">CO Number </label>
		
					<select name='co_number' id='co_number' onchange="showUser(this.value,<?php echo $_POST['branch_code'];?>)" class='input-large'>
         
						<option value=''>Please select CO number</option>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
					
			</select>
			<div id="txtHint"></div>
			<label class="control-label">CO Statment (New)</label>
					<? echo "<textarea  name='co_statement' id='co_statement' class='input-xxlarge'></textarea>"; ?>
			<label class="control-label">Correlation with PO(Program Outcomes) </label>
		
					<select name='correlation_po' id='correlation_po' class='input-medium'>
         
						<option value='H'>H</option>
						<option value='M'>M</option>
						<option value='L'>L</option>
						
				</select>
			<label class="control-label">Program Outcomes </label>
			<select name='program_outcome_id' id='program_outcome_id' class='input-xxlarge'>
			<?
			while($row_po = mysql_fetch_assoc($program_outcomes_result)) 
			{
				echo " <option value='".$row_po['id']."'>".$row_po['po_num'].": ".$row_po['po_statement']."</option>";
			}
			?>
			</select>
       <input type='hidden' name='add_course_outcomes_submit' value='add_course_outcomes_submit'/>
      <? echo " <input type='hidden' name='semester' value='".$_POST['semester']."' />
				<input type='hidden' name='course_code' value='".$row_sm['course_code']."' />
				<input type='hidden' name='m_code' value='".$row_sm['m_code']."' />
				<input type='hidden' name='branch_code' value='".$_POST['branch_code']."' />
				<input type='hidden' name='scheme_code' value='".$_POST['scheme_code']."' />
				<input type='hidden' id='subject_code' name='subject_code' value='".$_POST['subject_code']."' />";?>
				
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger">Proceed</button>
            </div>
      </form>

    </fieldset>
  </div>
</div>
