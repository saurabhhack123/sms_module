<?
  /**
  Code By Saurabh
**/

  include_once('../../../../includes/dbconfig.php');
  include_once('../models/SmsModule.php');

  $msg       = $_REQUEST['action'];
  $school_id = $schoolid;

  if($msg == "sms_all"){
  	
  	$msg_typ     = $_REQUEST["msg_typ"];
    $msg         = $_REQUEST["msg"];
    $all_teacher = $_REQUEST["all_teacher"];
    $admin       = $_REQUEST["admin"];
    $principal   = $_REQUEST["principal"];
    $corres      = $_REQUEST["corres"];
   
    $sms_students    = new SmsStudents($school_id);
    $student_details = $sms_students->get_students();
    $staff_details   = $sms_students->staff_details();
  
    $sms_students->send_sms_all($student_details,$msg);
    $sms_students->send_sms_to_staff($msg,$staff_details,$all_teacher,$admin,$principal,$corres);
    $sms_students->update_noticeboard($msg); 
    
  }

  if($msg == "sms_class"){
    $msg_typ     = $_REQUEST["msg_typ"];
    $msg         = $_REQUEST["msg"];
    $tch_inchrg  = $_REQUEST["tch_inchrg"];
    $admin       = $_REQUEST["admin"];
    $principal   = $_REQUEST["principal"];
    $corres      = $_REQUEST["corres"];
    $cls_tchr    = $_REQUEST["cls_teacher"];
    $class_id    = $_REQUEST["class"];
    
    $sms_class   = new SmsClass($schoolid);
    $student_details = $sms_class->class_students($class_id);
    $staff_details   = $sms_class->get_staff_details($class_id);
    $classes         = $sms_class->classes();
    $sms_class->send_sms_all($student_details,$msg);
    $sms_class->send_sms_to_class_staff($msg,$staff_details,$tch_inchrg,$admin,$principal,$corres,$cls_tchr);
    $sms_class->update_noticeboard($msg,$classes["$class_id"]); 

  }
  
  if($msg == "sms_section"){

    $msg_typ     = $_REQUEST["msg_typ"];
    $msg         = $_REQUEST["msg"];
    $tch_inchrg  = $_REQUEST["tch_inchrg"];
    $admin       = $_REQUEST["admin"];
    $principal   = $_REQUEST["principal"];
    $corres      = $_REQUEST["corres"];
    $cls_tchr    = $_REQUEST["cls_teacher"];
    $class_id    = $_REQUEST["class"];
    $section_id  = $_REQUEST["section"];
    
    
    $sms_section = new SmsSection($school_id);
    $classes     = $sms_section->classes();
    $sections    = $sms_section->sections($class_id);
    $student_details = $sms_section->section_students($section_id);
    $staff_details   = $sms_section->get_staff_details($class_id,$section_id);
    $sms_section->send_sms_all($student_details,$msg);
    $sms_section->send_sms_to_class_staff($msg,$staff_details,$tch_inchrg,$admin,$principal,$corres,$cls_tchr);
    $sms_section->update_noticeboard($msg,$classes["$class_id"],$sections["$section_id"]);

  }
  
  if($msg == "sms_student"){
    
    $msg_typ     = $_REQUEST["msg_typ"];
    $msg         = $_REQUEST["msg"];
    $tch_inchrg  = $_REQUEST["tch_inchrg"];
    $admin       = $_REQUEST["admin"];
    $principal   = $_REQUEST["principal"];
    $corres      = $_REQUEST["corres"];
    $cls_tchr    = $_REQUEST["cls_teacher"];
    $class_id    = $_REQUEST["class"];
    $section_id  = $_REQUEST["section"];
    $student_id  = $_REQUEST["student"];

    $sms_student = new SmsStudent($school_id);
    $classes     = $sms_student->classes();
    $sections    = $sms_student->sections($class_id);
    $students    = $sms_student->section_students($section_id);

    $student_detail = $sms_student->student_info($student_id);
    $staff_details  = $sms_student->get_staff_details($class_id,$section_id);
    $sms_student->send_sms_all($student_details,$msg);
    $sms_student->send_sms_to_class_staff($msg,$staff_details,$tch_inchrg,$admin,$principal,$corres,$cls_tchr);
    $sms_student->update_noticeboard($msg,$classes["$class_id"],$sections["$section_id"],$students["$student_id"]);

  } 

  if($msg == "sms_teacher"){

    $msg_typ     = $_REQUEST["msg_typ"];
    $msg         = $_REQUEST["msg"];
    $admin       = $_REQUEST["admin"];
    $principal   = $_REQUEST["principal"];
    $corres      = $_REQUEST["corres"];
    $class_id    = $_REQUEST["class"];
    $section_id  = $_REQUEST["section"];
    $teacher_id  = $_REQUEST["teacher"];

    $sms_teacher = new SmsTeachers($school_id);
    $classes     = $sms_teacher->classes();
    $sections    = $sms_teacher->sections($class_id);
    $teachers    = $sms_teacher->teachers($class_id);

    $staff_details   = $sms_teacher->get_staff_details();
    $teacher_details = $sms_teacher->teacher_details($teacher_id);
    $sms_teacher->send_sms_teacher($teacher_details,$msg);
    $sms_teacher->send_sms_to_staff($msg,$staff_details,0,$admin,$principal,$corres);
    $sms_teacher->update_noticeboard($msg,$classes["$class_id"],$sections["$section_id"],$teachers["$teacher_id"]);

  }

  if($msg == "sms_group"){

    $group       = $_REQUEST["group"];
    $msg         = $_REQUEST["msg"];
    $all_teacher = $_REQUEST["all_teacher"];
    $admin       = $_REQUEST["admin"];
    $principal   = $_REQUEST["principal"];
    $corres      = $_REQUEST["corres"];
    
    $to_Send = "Sms Sent to:"; 

    if($all_teacher) $to_Send.=" all_teacher, ";
    if($admin) $to_Send.=" school_admin, ";
    if($principal) $to_Send.=" principal, ";
    if($corres) $to_Send.="correspondent";

    $sms_group  = new SmsGroup($school_id);
    $group_map = $sms_group->groups;

    $staff_details = $sms_group->get_staff_details();
    $sms_group->send_sms_group($group,$msg);
    $sms_group->send_sms_to_staff($msg,$staff_details,$all_teacher,$admin,$principal,$corres);
    $sms_group->update_noticeboard($msg,$group_map["$group"],$to_Send); 
  
  }



?>
