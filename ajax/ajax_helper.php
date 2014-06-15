<?
  /**
  Code By Saurabh
**/

  include_once('../../../../includes/dbconfig.php');
  include_once('../models/SmsModule.php');

  $msg       = $_REQUEST['action'];
  $school_id = $schoolid;

  if($msg=="fetch templates"){
    
    $msg_type   = $_REQUEST["msg_id"];
    $sms_module = new SmsModule($school_id);
    $err_msg    = array('1'=>"There is no template");
    $templates  = $sms_module->get_templates($school_id,$msg_type); 
    if(!empty($templates))
        echo json_encode($templates); 
    else
    	echo json_encode($err_msg);
  }

  if($msg=="fetch sections"){
    
  	$class_id = $_REQUEST["class_id"];
  	$sms_sections = new SmsSection($school_id);
  	echo json_encode($sms_sections->get_sections($class_id));	
  } 

  if($msg=="fetch students"){
  	$class_id   = $_REQUEST["class_id"];
  	$section_id = $_REQUEST["section_id"];

  	$sms_students = new SmsStudent($school_id);
  	echo json_encode($sms_students->get_students($section_id));
  }

  if($msg=="fetch teachers"){
    $class_id = $_REQUEST["class_id"];
    $sms_teachers  = new SmsTeachers($school_id);
    echo json_encode($sms_teachers->get_teachers($class_id));

  }



?>