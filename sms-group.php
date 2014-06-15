<!DOCTYPE html>
<?php
/**
  Code By Saurabh
**/
  include_once('../../../includes/dbconfig.php');
  include_once('models/SmsModule.php');  
?>
<html>
 <head>
	 <title>Sms Module</title>
            <link rel="icon" type="image/x-icon" href="img/favicon.ico" /> 
			<link rel="stylesheet" type="text/css" href="../../../resources/css/bootstrap.css" />
			<link href='http://fonts.googleapis.com/css?family=Life+Savers|Margarine|Sacramento|Fenix' rel='stylesheet' type='text/css'>
			<link rel="stylesheet" type="text/css" href="css/style.css" />
			<script type="text/javascript" src="../../../resources/js/jquery-1.10.1.js"></script>
			<script type="text/javascript" src="../../../resources/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="js/app.js"></script>
			
 </head>

<body>
<!--  application layout starts -->

	<div class="row-fluid head_msg">
	    		<div class="span12">			
	    			 <h2><img src="img/sms.png" width="50px" height="50px"> Interface</h2>
	    			 <div class='bottom_shadow'></div>
	    		</div>
	</div>

    
    <div class="row-fluid navbar">
		  <div class="navbar-inner">
		    <a class="brand" href="../home/index.php" ><i class="icon-home"></i></a>
		    <ul class="nav">
		      <li><a href="index.php">Send Sms to All Students</a></li>
		      <li><a href="sms-class.php">Send Sms to Class </a></li>
		      <li><a href="sms-section.php">Send Sms to Section</a></li>
		      <li><a href="sms-student.php">Send Sms to Student</a></li>
		      <li><a href="sms-teacher.php">Send Sms to Teacher</a></li>
		      <li class="active"><a href="sms-group.php">Send Sms to Groups</a></li>
		    </ul>
		  </div>
	</div> 

<!--  application layout header ends -->

<!--  application layout body  -->
<?
  $sms_group = new SmsGroup($schoolid);
  $groups    = $sms_group->get_groups();
?>
	<div class="row-fluid">
	   <div class="act-box">
              <div class="control-group cg-fix">
				    <div class="controls">
				      <select id="msg-typ">
				        <option value="0">select group</option>
			      	     <?
					       foreach ($groups as $group_id => $group_name) {
					       	 echo "<option value='$group_id'>$group_name</option>";
				         }
				         ?>	
				      </select>
				    </div>
		      </div>
		       <div class="control-group cg-fix">
				    <div class="controls">
				    <label class="checkbox">
					        <i class="icon-pencil"></i> Enter the Message
				     </label>
				     <textarea id="message" max-length=500></textarea>
				     <span class="char-disp">
				       <input type="text" disabled>Characters
				     </span>
				     <span class="sms-no">
				       <input type="text" disabled>No of Sms
				     </span>
				    </div>
		      </div>

  		       <div class="control-group chk-cg-fix">
				     <div class="span3">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to All Teachers
					     </label>
				     </div>
				     <div class="span3">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to School Admin
					     </label>
					 </div>
				     <div class="span3">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to Principal
					     </label>
					 </div>
					 <div class="span3">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to Correspondent
					     </label>
				     </div>
		      </div>
		      <div class="controls btn-sms">
                         <button class="btn btn-primary" type="button">Send Sms to Group</button>
		      </div>
       </div>  
    </div> 

<!--  application layout body ends -->

</body>
</html>