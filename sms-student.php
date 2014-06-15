<!DOCTYPE html>
<?php
/**
  Code By Saurabh
**/

  include_once('../../../includes/dbconfig.php');
  include_once('strings/string.php');
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
		      <li>
		      <a href="index.php">Send Sms to All Students</a></li>
		      <li><a href="sms-class.php">Send Sms to Class </a></li>
		      <li><a href="sms-section.php">Send Sms to Section</a></li>
		      <li class="active"><a href="#">Send Sms to Student</a></li>
		      <li><a href="sms-teacher.php">Send Sms to Teacher</a></li>
		      <li><a href="sms-group.php">Send Sms to Groups</a></li>
		      
		    </ul>
		  </div>
	</div> 

<!--  application layout header ends -->

<!--  application layout body  -->
<?
$sms_students = new SmsStudent($schoolid);
$message_type_map = $sms_students->message_type;
$classes          = $sms_students->get_classes();

?>
	<div class="row-fluid">
	   <div class="act-box">
              <div class="control-group fix-stu-head">
				    <div class="controls">
				       <select id="msg-typ">
				        <option value="0">select message type</option>
			             <?
					       foreach ($message_type_map as $type_id => $msg_typ_val) {
					       	 echo "<option value='$type_id'>$msg_typ_val</option>";
				         }
				         ?>		
			      	
				      </select>
                     
  				      <select id="class">
				        <option value="0">select class</option>
				        <?
					       foreach ($classes as $class_id => $class_name) {
					       	 echo "<option value='$class_id'>$class_name</option>";
				          }
				        ?>					      	
				      </select>

				      <select id="section">
				        <option value="0">select section</option>				      	
				      </select>

				      <select id="student">
				        <option value="0">select student</option>			      	
				      </select>

				      <span class="btn-hlp">
				        <button class="btn btn-mini" id="help" type="button"><img src="img/help.png" width="25px" height="50px">Help</button>
				      </span>
				    </div>
		      </div>
		      
		      <div class="control-group cg-fix">
				    <div class="controls">
				     <label class="checkbox">
					        <input type="checkbox" id="ex-tmpl"> Use Existing Template
				     </label>
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

  		       <div class="control-group chk-cg-fix chk-cg-fix-cls">
				     <div class="span3">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to Teacher Incharge
					     </label>
				     </div>
				     <div class="span2">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to School Admin
					     </label>
					 </div>
				     <div class="span2">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to Principal
					     </label>
					 </div>
					 <div class="span3">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to Correspondent
					     </label>
				     </div>
 					 <div class="span2">
					     <label class="checkbox">
						        <input type="checkbox"> Send SMS to ClassTeacher
					     </label>
				     </div>
		      </div>
		      <div class="controls btn-sms">
                         <button class="btn btn-primary" type="button">Send Sms to Selected Students</button>
		      </div>
       </div>  
    </div> 

<!--  application layout body ends -->

<!--  Hidden help layout     -->

<div id='hidden_help'>
	<div id='help-message'>
	    <pre>
	        <p class="text-success text-left"><?=$top_info ?></p>
	    </pre>
	     
		<h6>Example Message to type </h6>
		<pre>
	     	<p class="text-info text-left"><?=$mid_info?></p>
		</pre>

		<h6>Message Sent for N.Raj of X A </h6>
		<pre>
		    <p class="text-info text-left"><?=$bottom_info?></p>
		</pre>  	  
	</div>
</div>

<!--  Hidden template layout     -->

<div id='hidden_tmpl'>
	<div id='msg-tmpl'>
		  
	</div>
</div>



</body>
</html>