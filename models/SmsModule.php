<?php
/**
  Code By Saurabh
**/

// Debugging mode
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include_once('../../../../includes/dbconfig.php');
include_once('DbModel.php');

/**
  SmsModule Model inherit DbModel
  Single level inheritance
*/

class SmsModule extends DbModel
{
	    
	function __construct($school_id)
	{   
		parent::__construct($school_id);

	}  

	function get_message_type(){
   	  return $this->message_type; 
    }

  function get_templates($school_id,$message_type){
       $template_messages = $this->templates($school_id,$message_type);
       return $template_messages;
    }   
}

/**
  SmsStudents Model inherit SmsModule
  Multi level inheritance
*/

class SmsStudents extends SmsModule
{
   var $students;
   var $school_id;

   function __construct($school_id){
   	  $this->school_id = $school_id;
   	  parent::__construct($school_id);
   }
    
   function get_students(){
       $this->students = $this->school_students();
       return $this->students;
   }

   function get_staff_details(){
       $staff_info = $this->staff_details();
       return $staff_info;
   }
  
  function update_noticeboard($description1){
     $description1 = mysql_real_escape_string($description1);
     $title = "New message for All students";
     $type  = "EntireSchool";
     $description2="Message has been sent to all students of the school";
     $this->notice_board($title,$type,$description1,$description2);     
  }
}

/**
  SmsClass Model inherit SmsModule
  Multi level inheritance
*/

class SmsClass extends SmsModule
{
   var $students;
   var $school_id;
   var $classes;

   function __construct($school_id){
      $this->school_id = $school_id;
      parent::__construct($school_id);
   }
    
   function get_classes(){
       $this->classes = $this->classes($this->school_id);
       return $this->classes;
   }

   function class_students($class_id){
       $students_details = $this->get_class_students($class_id);
       return $students_details;
   }
   
   function get_staff_details($class_id){
       $staff_info["principal"]   = $this->pricipal_contact();
       $staff_info["corres"]      = $this->corres_contact();
       $staff_info["admin"]       = $this->admin_contact();
       $staff_info["cls-tcrs"]    = $this->class_tchrs_contacts($class_id);
       $staff_info["tch_inchrge"] = $this->teacher_incharge($class_id);
       return $staff_info;
   }

  function update_noticeboard($description1,$class){
     $description1 = mysql_real_escape_string($description1);
     $title = "New message for students of class: ".$class;
     $type  = "AllSections";
     $description2="Message has been sent to all students of ".$class;
     $this->notice_board($title,$type,$description1,$description2);     
  }
}

/**
  SmsSection Model inherit SmsModule
  Multi level inheritance
*/

class SmsSection extends SmsModule
{
   var $students;
   var $school_id;
   var $classes;
   var $sections;

   function __construct($school_id){
      $this->school_id = $school_id;
      parent::__construct($school_id);
   }
    
   function get_classes(){
       $this->classes = $this->classes($this->school_id);
       return $this->classes;
   }

   function get_sections($class_id){
       $this->sections = $this->sections($class_id);
       return $this->sections;
   }

   function section_students($section_id){
       $student_details = $this->get_section_students($section_id);
       return $student_details;
   }

  function get_staff_details($class_id,$section_id){
       $staff_info["principal"]   = $this->pricipal_contact();
       $staff_info["corres"]      = $this->corres_contact();
       $staff_info["admin"]       = $this->admin_contact();
       $staff_info["cls-tcrs"]    = $this->class_tchr_contacts($section_id);
       $staff_info["tch_inchrge"] = $this->teacher_incharge($class_id);
       return $staff_info;
   }

  function update_noticeboard($description1,$class,$section){
     $description1 = mysql_real_escape_string($description1);
     $title = "New message for students of class: $class-$section";
     $type  = "Sections";
     $description2="Message has been sent to all students of $class-$section";
     $this->notice_board($title,$type,$description1,$description2);     
  }
}

/**
  SmsStudent Model inherit SmsModule
  Multi level inheritance
*/

class SmsStudent extends SmsModule
{    
  var $school_id;
  var $classes;
  var $sections;
  var $students;

  function __construct($school_id){
      $this->school_id = $school_id;
      parent::__construct($school_id);
  }
    
  function get_classes(){
       $this->classes = $this->classes($this->school_id);
       return $this->classes;
  }

   function get_sections($class_id){
       $this->sections = $this->sections($class_id);
       return $this->sections;
   }
   
  function get_students($section_id){
    $this->students = $this->section_students($section_id);
    return $this->students;
  } 

  function student_info($student_id){
    $student = $this->student_details($student_id);
    return $student;
  }

  function get_staff_details($class_id,$section_id){
       $staff_info["principal"]   = $this->pricipal_contact();
       $staff_info["corres"]      = $this->corres_contact();
       $staff_info["admin"]       = $this->admin_contact();
       $staff_info["cls-tcrs"]    = $this->class_tchr_contacts($section_id);
       $staff_info["tch_inchrge"] = $this->teacher_incharge($class_id);
       return $staff_info;
   } 
  
  function update_noticeboard($description1,$class,$section,$student){
     $description1 = mysql_real_escape_string($description1);
     $title = "New message for $student of class: $class-$section";
     $type  = "Section";
     $description2="Message has been sent to $student of $class-$section";
     $this->notice_board($title,$type,$description1,$description2);     
  } 
}
/**
   SmsTeachers Model inherit DbModel
*/

class SmsTeachers extends DbModel
{
  var $school_id;
  var $teachers;

  function __construct($school_id){
    $this->school_id = $school_id;
    parent::__construct($school_id);
  }

  function get_teachers($class_id){
      $this->teachers = $this->teachers($class_id);
      return $this->teachers;
  }

  function get_staff_details(){
    $staff_details = $this->staff_details();
    return $staff_details;
  }

  function teacher_details($teacher_id){
     $sql = "select TeacherId,Mobile,Name,Username,Password from teacher where TeacherId='$teacher_id'";
     $res = $this->exe_query($sql);
     $row = mysql_fetch_array($res);
     $details["TeacherId"] = $row["TeacherId"];
     $details["Mobile"]    = $row["Mobile"];
     $details["Name"]      = $row["Name"];
     $details["Username"]  = $row["Username"];
     $details["Password"]  = $row["Password"];
     
     return $details; 
  }
  
  function tchr_format_msg($msg,$name,$username,$password){
        $message = str_replace("<CLASS>",$name,$msg);
        $message = str_replace("<SECTION>",$username,$message);
        $message = str_replace("<ROLLNO>",$password,$message);
        return $message;
  }

  function send_sms_teacher($teacher_details,$msg){
         $format_msg = $this->tchr_format_msg($msg,$teacher_details["Name"],$teacher_details["Username"],$teacher_details["Password"]);
         $role = "teacher";
         $this->sms_queue($teacher_details["TeacherId"],$role,$teacher_details["Mobile"],$format_msg);
  }

  function update_noticeboard($description1,$class,$section,$teacher){
     $description1 = mysql_real_escape_string($description1);
     $title = "New message for Teacher $teacher of class: $class-$section";
     $type  = "Section";
     $description2="Message has been sent to $teacher of $class-$section";
     $this->notice_board($title,$type,$description1,$description2);     
  } 
}

/**
  Date Model to handle SmsGroups
*/

class GrpModel extends SmsModule
{
  var $groups;

  function __construct($school_id){
    $this->school_id = $school_id;
    $sql = "select GroupId,GroupName from smsgroups where SchoolId='$school_id'";
    $res =  $this->exe_query($sql);
    while($row=mysql_fetch_array($res)){
      $this->groups[$row["GroupId"]] = $row["GroupName"];
    }
    return $this->groups;
  } 

  function exe_query($sql){
      $res = mysql_query($sql);
      if(!$res) die("Error in sql ".$sql);
      else return $res;
   }

  function sms_group($group_id,$msg){
      $sql = "select StudentIds,PhoneNumbers from  smsgroups where SchoolId='$this->school_id' and GroupId='$group_id'";
      $res = $this->exe_query($sql);
      $row = mysql_fetch_array($res);
      $contacts = explode(",",$row["PhoneNumbers"]);
      $student_ids = explode(",",$row["StudentIds"]);
      
      foreach ($student_ids as $user_id) {
          $sql = "select Mobile1 from students where StudentId='$user_id'";
          $res = $this->exe_query($sql);
          $row = mysql_fetch_array($res);
          $ph  = $row["Mobile1"];
          if(mysql_num_rows($res)>0)
          {
             $role = "student";
             if($ph!="")
                $this->sms_queue($user_id,$role,$ph,$msg);
          }else{
            $role = "teacher";
            $sql  = "select TeacherId,Mobile from teacher where TeacherId='$user_id'";
            $res  =  $this->exe_query($sql);
            $row  = mysql_fetch_array($res);
            $ph   = $row["Mobile"];
            
            if($ph!="")
              $this->sms_queue($user_id,$role,$ph,$msg);
          }
      }
   }

   function notice($title,$type,$description){

          $sql = "insert into noticeboard(SchoolId,Title,Description,Type,NoticeType,IDs,CreatedBy,CreatedByID)
          values('$this->school_id','$title','$description','$type','sms',-1,'SchoolAdmin',-1)";

          $this->exe_query($sql);
   }
}

/**
  Model inheriting GrpModel
*/
class SmsGroup extends GrpModel
{

  function __construct($school_id){
    $this->school_id = $school_id;
    parent::__construct($school_id);
  }
  
  function get_groups(){
       return $this->groups;
  }

  function get_staff_details(){
       $staff_info = $this->staff_details();
       return $staff_info;
   } 

  function send_sms_group($group,$msg){
      $this->sms_group($group,$msg);
  } 
  
  function update_noticeboard($msg,$group,$description){
     $description = mysql_real_escape_string($description);
     $title       = "Group Sms:$group:$msg".mysql_real_escape_string($title);
     $type  = "Group";
     $this->notice($title,$type,$description);     
  }  

}

?>