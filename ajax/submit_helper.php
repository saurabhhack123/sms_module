<?
  /**
  Code By Saurabh
**/

  include_once('../../../../includes/dbconfig.php');
  include_once('../models/SmsModule.php');

  $msg       = $_REQUEST['action'];
  $school_id = $schoolid;
  echo "helo";

  if($msg == "sms_all"){
  	
  	$msg_typ     = $_REQUEST["msg_typ"];
    $msg         = $_REQUEST["msg"];
    $all_teacher = $_REQUEST["all_teacher"];
    $admin       = $_REQUEST["admin"];
    $principal   = $_REQUEST["pricipal"];
    $corres      = $_REQUEST["corres"];
   
    $sms_students    = new SmsStudents($school_id);
    $student_details = $sms_students->get_students();
    // print_r($student_details);
    $staff_details   = $sms_students->staff_details();
    // print_r($staff_details);
    

  }



?>
