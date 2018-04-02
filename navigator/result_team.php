<div class="navbar">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="" name="top">Home</a>

      <div class="btn-group pull-left">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="icon-folder-close"></i>Control Panel <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">

          <li>
            <form method="POST" action="" accept-charset="UTF-8">  
              <input type='hidden' name='student_exam_form_status' value='student_exam_form_status' />
              <button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Student Exam Form Status</button>
            </form>
          </li>
          
           <li>
			<form method="POST" action="" accept-charset="UTF-8">  
			<input type='hidden' name='scheme_master_list' value='scheme_master_list' />
			<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Scheme Master List</button>
			</form>
			</li>
		
		
			<li>
			<form method="POST" action="" accept-charset="UTF-8">  
			<input type='hidden' name='internal_external_strength' value='internal_external_strength' />
			<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Internal/External Filled Strength</button>
			</form>
			</li>
			<li>
			<form method="POST" action="" accept-charset="UTF-8">  
			<input type='hidden' name='subject_count' value='subject_count' />
			<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Subject Count</button>
			</form>
			</li>
		
			<li>
			<form method="POST" action="" accept-charset="UTF-8">  
			<input type='hidden' name='form_filled_strength' value='form_filled_strength' />
			<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Form Filled Strength (For Gazette Verification)</button>
			</form>
			</li>
      
        

        </ul>
      </div>

    
      <ul class='nav'><li class="divider-vertical"></li></ul>

      <div class="btn-group pull-left">
              <form action='' method='post'>
                  <input type='hidden' name='important_notices' value='in' />
                  <button type='submit' class='btn' ><i class="icon-file icon-reverse"></i>Important Notices</button>
              </form>
          </div>
          
          <ul class='nav'><li class="divider-vertical"></li></ul>

      <div class="btn-group pull-right">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="icon-user"></i><?php echo $_SESSION['fullname']; ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <form method="POST" action="http://ldap.gndec.ac.in" accept-charset="UTF-8" target='_blank'>          
              <button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-wrench icon-white"></i> Change Password</button>
            </form>
          </li>
          <li>
            <form method="POST" action="" accept-charset="UTF-8">
              <input type='hidden' name='logmeout' value='logmeout' />          
              <button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-off icon-white"></i> Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
    <!--/.nav-collapse -->
  </div>
  <!--/.container-fluid -->
</div>
<!--/.navbar-inner -->
</div>
<!--/.navbar -->
