<div id="pm_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">

<h3 id="myModalLabel">Important Notices</h3>

</div>
<div class="modal-body">

<?php

//$pm_sql = mysql_query("SELECT * FROM popup_notices WHERE usertype LIKE 'psc' AND valid_till>='".date("Y-m-d")."' AND published='Y' ORDER BY priority DESC") or die(mysql_error());

$pm_a = array();
$count = 1;
if(mysql_num_rows($pm_sql)>0) {
	while($row = mysql_fetch_assoc($pm_sql)) {
		
		if($row['has_attachment']==0) {
			echo  "<p class='".$row['text_color_type']."'><span style='font-weight:bold;font-size:20px'>".$count.".</span>  ".$row['notice_text']."</p>";
		}
		if($row['has_attachment']==1) {
			echo  "<p class='".$row['text_color_type']."'><span style='font-weight:bold;font-size:20px'>".$count.".</span>  ".$row['notice_text']." 
			[<a href='".$row['file_url']."' target='_blank'>".$row['file_link_text']."</a>]</p>";
		}
		$count++;
	} 
}

?>

</div>

<div class="modal-footer">

<button class="btn btn-danger" data-dismiss="modal">OK</button>

</div>
</div>

<script type='text/javascript'>
		$(document).ready(function () {
			$('#pm_modal').modal('show');
		});
</script>