<?php
/**
  Code By Saurabh
**/

// Debugging mode
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include_once('../../../../includes/dbconfig.php');
/**
  DbModel contains all the database interaction's
*/

class DbModel
{  

   var $message_type; 
   var $section_students;
   var $classes;
   var $sections;
   var $teachers;
   var $school_id;
   var $staff_details;

   var $school_students = array();
   
   function __construct($school_id){
        $this->school_id = $school_id;
        $sql = "select MessageTypeId,MessageType from messagetype where (SchoolId='$school_id' OR SchoolId=0) and StudentTeacher='Student'";
        $res =  $this->exe_query($sql);
        while($row = mysql_fetch_array($res)){
        	$this->message_type[$row["MessageTypeId"]] = $row["MessageType"];
        }     
   }

   function exe_query($sql){
      $res = mysql_query($sql);
      if(!$res) die("Error in sql ".$sql);
      else return $res;
   }

   function school_students(){

      $sql = "select stu.Name as Name,stu.RollNoInClass as Roll,stu.Username as UserName,stu.Password as Password,cls.ClassName as Class,sec.SectionName as Section 
             from students stu,class cls,section sec where stu.ClassId=cls.ClassId and stu.SectionId = sec.SectionId and 
             cls.ClassId = sec.ClassId and stu.SchoolId='$this->school_id'";
	   	$res = $this->exe_query($sql);
   
	   	while($row = mysql_fetch_array($res)){
            $mini_map              = array(); 
            $mini_map["name"]      = $row["Name"];
            $mini_map["roll"]      = $row["Roll"];
            $mini_map["username"]  = $row["UserName"];
            $mini_map["password"]  = $row["Password"];
            $mini_map["class"]     = $row["Class"];
            $mini_map["section"]   = $row["Section"];
            $this->school_students[] = $mini_map;
      }

	   	return $this->school_students;
   }
   
   function teacher_contacts(){
         
         $sql = "select t.Mobile as Contact from teacher t,school s where t.TeacherId!= s.PrincipalTeacherId and t.SchoolId='$this->school_id' and s.SchoolId='$this->school_id'";     
         $res = $this->exe_query($sql);
         while($row = mysql_fetch_array($res)){
          $contacts[]=$row["Contact"];
         }
         return $contacts;
 
   }

   function staff_details(){
       echo "Begin";
       $this->staff_details["teachers"] = $this->teacher_contacts();
       return $this->staff_details;
      // principal
      // corres
      // admin
      // teacher 
   }


   function templates($school_id,$message_type){
   	    $sql = "select TemplateMessage from inbuilt_templates where (SchoolId='$school_id' OR SchoolId=0) and MessageTypeId='$message_type'";
   	    $res = $this->exe_query($sql);

   	    while($row = mysql_fetch_array($res)){
              $template_messages[] = $row["TemplateMessage"];
   	    }
   	    return $template_messages;
    }

    function classes($school_id){
      $sql = "select ClassId,ClassName from class where SchoolId='$school_id'";
      $res = $this->exe_query($sql);
      while($row = mysql_fetch_array($res)){
          $this->classes[$row["ClassId"]] = $row["ClassName"];
      }
      return $this->classes;
    }

    function sections($class_id){
         
         $sql = "select SectionId,SectionName from section where ClassId='$class_id'";
         $res = $this->exe_query($sql);
         while($row = mysql_fetch_array($res)){
          $this->sections[$row["SectionId"]] = $row["SectionName"];
         }
         return $this->sections;
    }

    function section_students($section_id){
         $sql = "select StudentId,Name from students where SectionId='$section_id'";
         $res = $this->exe_query($sql);
         while($row  = mysql_fetch_array($res)){
            $this->section_students[$row["StudentId"]] = $row["Name"];
         }
         return $this->section_students;
    }


    function teachers($class_id){
         $sql ="select ClassTeacherId,Name from section s,teacher t where s.ClassId='$class_id' and t.TeacherId=s.ClassTeacherId";
         $res = $this->exe_query($sql);
         while($row = mysql_fetch_array($res)){
          $this->teachers[$row["ClassTeacherId"]] = $row["Name"];
         }
         return $this->teachers;
    }


}

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
}

/**
  Date Model to handle SmsGroups
*/

class GrpModel
{
  var $groups;

  function __construct($school_id){
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
}

?>