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
						<i class="icon-folder-close"></i>Control Panel<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">			
					
				<? 
				if($_SESSION['username']=='up_chairman')
				{?>
				<li>
				<form method="POST" action="" accept-charset="UTF-8">  
				<input type='hidden' name='upload_notice' value='upload_notice' />
				<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i>Upload Notice</button>
				</form>
				</li>				
				<li>
				<form method="POST" action="" accept-charset="UTF-8">  
				<input type='hidden' name='faq_upload' value='faq_upload' />
				<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i>Upload FAQ</button>
				</form>
				</li>				
				<? }?>
							
				</ul>
				</div>
				 <ul class='nav'><li class="divider-vertical"></li></ul>
				 
				<div class="btn-group pull-left">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>Document<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">			
					<? 
					
					if(($_SESSION['username']!='up_member1') and ($_SESSION['username']!='up_member2') )
					{?>
					<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='upload_document' value='upload_document' />
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i>Upload</button>
						</form>
						</li>		
					<? }?>		
					<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='view_documents' value='view_documents' />
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i>View </button>
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

			<div class="btn-group pull-left">
              <form action='' method='post'>
                  <input type='hidden' name='faq_display' value='in' />
                  <button type='submit' class='btn' ><i class="icon-file icon-reverse"></i>FAQ</button>
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
