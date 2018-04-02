$(document).ready(function(){

   $('.dropdown-toggle').dropdown();
   $("[data-toggle='tooltip']").tooltip();
   $("[data-toggle='tooltip-right']").tooltip({placement : 'right'});
});

function confirm_action(action_text) {

  var r = confirm(action_text);
  
  if(r) {
    return true;
  }
  else {
    return false;
  }
  
}

function empty_username(field_name,msg) {

  var r = document.getElementById(field_name).value;
  
  if(r==='') {
	alert(msg);
    return false;
  }
  else {
    return true;
  }
  
}


function disable_field(field_name) {
	
	document.getElementById(field_name).disabled=true;
}

function enable_field(field_name) {
	document.getElementById(field_name).disabled=false;
}

function disable_branch(course_code) {

	if(course_code!='1' && course_code!='2') {
		document.getElementById('branch_code').disabled=true;
	}
	else {
		document.getElementById('branch_code').disabled=false;
	}
}


function compare_dates(str) {
	
	var firstValue = document.getElementById("start_date"+str).value.split('-');
	var secondValue = document.getElementById("end_date"+str).value.split('-');
	

 var start_date=new Date();
 start_date.setFullYear(firstValue[0],(firstValue[1] - 1 ),firstValue[2]);

 var end_date=new Date();
 end_date.setFullYear(secondValue[0],(secondValue[1] - 1 ),secondValue[2]);     

  if (start_date > end_date)
  {
   alert("Start Date  cannot be greater than End Date");
   return false;
  }
 else
  {
    return true;
  }
}

function question_marks_sum()
{
	var count = document.getElementById('total_count').value;
	var num_iqs = document.getElementById('num_iqs').value;
	
	for(var i=1;i<=count-1;i++) 
	{
		obtained_marks =0;
		for(var x=1;x<=num_iqs;x++) 
		{
			var question_id = document.getElementById('q'+i+''+x);
			obtained_marks += parseFloat(question_id.value);
		}
		document.getElementById('obtained_marks'+i).value =  Math.round(obtained_marks);
	}
	
}

function disable_field1(field_name1,field_name2,field_name3,field_name4,field_name5,field_name6,field_name7,field_name8,chk_id) {
	
	if(document.getElementById(chk_id).checked===true) {
		document.getElementById(field_name1).value="";
		document.getElementById(field_name1).disabled=true;
		document.getElementById(field_name2).value="";
		document.getElementById(field_name2).disabled=true;
		document.getElementById(field_name3).value="";
		document.getElementById(field_name3).disabled=true;
		document.getElementById(field_name4).value="";
		document.getElementById(field_name4).disabled=true;
		document.getElementById(field_name5).value="";
		document.getElementById(field_name5).disabled=true;
		document.getElementById(field_name6).value="";
		document.getElementById(field_name6).disabled=true;
		document.getElementById(field_name7).value="";
		document.getElementById(field_name7).disabled=true;
		document.getElementById(field_name8).value="";
		document.getElementById(field_name8).disabled=true;
	}
	else {
		document.getElementById(field_name1).disabled=false;
		document.getElementById(field_name2).disabled=false;
		document.getElementById(field_name3).disabled=false;
		document.getElementById(field_name4).disabled=false;
		document.getElementById(field_name5).disabled=false;
		document.getElementById(field_name6).disabled=false;
		document.getElementById(field_name7).disabled=false;
		document.getElementById(field_name8).disabled=false;
	}
}

/*
function disable_field1(chk_id)
{
	var count = document.getElementById('total_count').value;
	var num_iqs = document.getElementById('num_iqs').value;
	if(document.getElementById(chk_id).checked==true)
	{
		for(var i=1;i<=count-1;i++) 
		{
			for(var x=1;x<=num_iqs;x++) 
			{	
				document.getElementById('q'+i+''+x).value="";
				document.getElementById('q'+i+''+x).disabled=true;
			}
		}
	}
	else
	{
		for(var i=1;i<=count-1;i++) 
		{
			for(var x=1;x<=num_iqs;x++) 
			{
				document.getElementById('q'+i+''+x).disabled=false;
			}
			
		}
	}
}
*/

function disable_group(str) {
	if(str=='T') {
		document.getElementById('sgroup').disabled=true;
	}
	else {
		document.getElementById('sgroup').disabled=false;
	}
}


function attendance_details(str_count) {
	
	present_count = 0;
	absent_count = 0;
	period_no = document.getElementById('attendance_period').value;
	subject_title = document.getElementById('subject_title').value;
	topics_covered = document.getElementById('topics_covered').value;
	
	for(i=1;i<=str_count-1;i++) {
		if(document.getElementById('attendancep'+i).checked===true) {
			present_count++;
		}
		if(document.getElementById('attendancea'+i).checked===true) {
			absent_count++;
		}
		
	}
	
	var r = confirm('Do you want to continue?'+'\n\nSubject = '+ subject_title+'\nPeriod No. = '+period_no+'\nTotal Present = '+present_count+ '\nTotal Absent = '+absent_count+ '\nTopics Covered = '+topics_covered);
	
	if(r) {
		return true;
	}
	else {
		return false;
	}
}
