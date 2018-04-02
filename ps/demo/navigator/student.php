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
						<i class="icon-folder-close"></i> Provisional Result <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">   
						<input type='hidden' name='result_internal_external_practical' value='result_internal_external_practical' />       
						<button type="submit" name="submit" class="btn  btn-danger"><i class="icon-file icon-white"></i>Internal & External Practical</button>
						</form>
						</li>
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<input type='hidden' name='result_theory_external' value='result_theory_external' />           
						<button type="submit" name="submit" class="btn  btn-danger"><i class="icon-file icon-white"></i>Theory External</button>
						</form>
						</li>
					
					</ul>
				</div>
				
				<ul class='nav'><li class="divider-vertical"></li></ul>
				
				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-info-sign"></i>Student Info <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
						<form method="POST" action="http://yahoo.com" accept-charset="UTF-8">          
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-info-sign icon-white"></i> View Info</button>
						</form>
						</li>
					</ul>
				</div>
				
				<ul class='nav'><li class="divider-vertical"></li></ul>
				
				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-flag"></i>Results <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
						<form method="POST" action="http://yahoo.com" accept-charset="UTF-8">          
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i> Internal Theory</button>
						</form>
						</li>
						<li>
						<form method="POST" action="http://yahoo.com" accept-charset="UTF-8">          
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i> External Practical</button>
						</form>
						</li>
						<li>
						<form method="POST" action="http://yahoo.com" accept-charset="UTF-8">          
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i> External Theory</button>
						</form>
						</li>
						<li>
						<form method="POST" action="http://yahoo.com" accept-charset="UTF-8">          
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i> External Practical</button>
						</form>
						</li>
					</ul>
				</div>
				
				<div class="btn-group pull-right">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><?php echo $_SESSION['username']; ?> <span class="caret"></span>
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
