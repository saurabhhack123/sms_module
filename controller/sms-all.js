/**
 Controller file which handle Error as well as Updation
*/
$(document).ready(function(){

    var c  = function(msg){
        console.log(msg);
    }
    
    // ErrorHandler class to handle Client Site errors
    
    var ErrorHandler = function(msg_typ,msg){
       this.msg_typ = msg_typ;
       this.msg     = msg;
       
       this.is_class = function(){
        var err = []; 
         if($('#class').val()==0)
            err.push("Please select class");
         
         return err; 
        }
       
       this.is_section = function(){
          var err_sec = [];
          var err = [];
          err = this.is_class();

          
          if(err.length!=0)
              err_sec.push(err);

          if($('#section').val()==0)
             err_sec.push("Please select section");
        
        return err_sec;
       }
       
       this.is_student = function(){
          var err_stu = [];
          var err = [];
          err = this.is_section();

          if(err.length!=0)
            err_stu.push(err);

          if($("#student").val()==0)
            err_stu.push("Please select student");
   
        return err_stu;
       }

       this.is_teacher = function(){
          var err_tcr = [];
          var err = [];
          err = this.is_section();

          if(err.length!=0)
            err_tcr.push(err);

          if($("#teacher").val()==0)
            err_tcr.push("Please select teacher");
   
        return err_tcr;
       }

       this.get_errors = function(cntxt){
       	     var err_text = [];
             var err = [];

             // check space only string or null 

             if(this.msg_typ==0 && cntxt!='group')
             	err_text.push("Please select Message Type.");
             
             if(this.msg_typ==0 && cntxt=='group')
              err_text.push("Please select group");

             if(!/\S/.test(this.msg)) 
             	err_text.push("Please type the Message.");

             if(cntxt=='class'){
                   err = this.is_class();
                   if(err.length!=0)
                       err_text.push(err);
             }

             if(cntxt=='section'){
                err = this.is_section();
                 if(err.length!=0)
                    err_text.push(err);
             }

             if(cntxt=='student'){
              err = this.is_student();
                if(err.length!=0)
                  err_text.push(err);
             }

             if(cntxt=='teacher'){
              err = this.is_teacher();
                if(err.length!=0)
                  err_text.push(err); 
             }

             return err_text;
       }
    }
    

	$("#sms-all").click(function(){
        var  msg_typ   = $("#msg-typ").val();
        var  msg       = $("#message").val();
        var errors     = new ErrorHandler(msg_typ,msg);
        var err_txt    = errors.get_errors();        
        if(err_txt.length!=0){
     
	        var div_err = "";
	        for(var i=0;i<err_txt.length;i++)
	        {   div_err      += "<div class='alert alert-error'>";
                div_err      += "<h4><i class='icon-share-alt icon-white'></i> Warning"+(i+1)+"</h4>";
	            div_err      += err_txt[i];
	            div_err      += "</div>";
	        }
	            c(div_err);
	            // show error to client

	            $('#hidden_tmpl').css('visibility','visible');
         
                $("#msg-tmpl").html("");
                $("#msg-tmpl").append(div_err);
	            return false;
        }else
        {   
        	var all_teacher = $('#all-teacher').is(":checked");
        	var admin       = $('#admin').is(":checked");
        	var principal   = $('#principal').is(":checked");
        	var corres      = $('#corres').is(":checked");
            var action      = "sms_all"; 
            var parameters  = "?msg_typ="+msg_typ+"&msg="+msg+"&all_teacher="+all_teacher+"&admin="+admin+"&principal="+principal+"&corres="+corres+"&action="+action;
        	// animate to show processing...
            var $btn = $("#sms-all");
            $btn.button('loading');
            $("#sms-img").css("-webkit-animation","rotating 2s linear infinite");
            $("#sms-all").after("<img src='img/loader.gif' width='39px' height='42' id='loader'>");
            
        	$.get("ajax/submit_helper.php"+parameters,{},function(data){
                $btn.button('reset');
                $("#sms-img").css("-webkit-animation","none");
                $("#loader").remove();
           });
        }
	});

    $("#sms-class").click(function(){
        var  msg_typ   = $("#msg-typ").val();
        var  msg       = $("#message").val();
        var cls        = $("#class").val();
        var errors     = new ErrorHandler(msg_typ,msg);
        var err_txt    = errors.get_errors('class');        
        if(err_txt.length!=0){
            var div_err = "";
            for(var i=0;i<err_txt.length;i++)
            {   div_err      += "<div class='alert alert-error'>";
                div_err      += "<h4><i class='icon-share-alt icon-white'></i> Warning"+(i+1)+"</h4>";
                div_err      += err_txt[i];
                div_err      += "</div>";
            }

                c(div_err);
                // show error to client
                $('#hidden_tmpl').css('visibility','visible');
                $("#msg-tmpl").html("");
                $("#msg-tmpl").append(div_err);
                return false;
        }else
        {   
            var tch_inchrg  = $('#tch-incharge').is(":checked");
            var admin       = $('#admin').is(":checked");
            var principal   = $('#principal').is(":checked");
            var corres      = $('#corres').is(":checked");
            var cls_teacher = $('#cls-tch').is(":checked");
            

            var action      = "sms_class"; 
            var parameters  = "?msg_typ="+msg_typ+"&msg="+msg+"&tch_inchrg="+tch_inchrg+"&admin="+admin+"&principal="+principal+"&cls_teacher="+cls_teacher+"&corres="+corres+"&class="+cls+"&action="+action;
            // animate to show processing...
            var $btn = $("#sms-class");
            $btn.button('loading');
            $("#sms-img").css("-webkit-animation","rotating 2s linear infinite");
            $("#sms-class").after("<img src='img/loader.gif' width='39px' height='42' id='loader'>");
            
            $.get("ajax/submit_helper.php"+parameters,{},function(data){
                $btn.button('reset');
                $("#sms-img").css("-webkit-animation","none");
                $("#loader").remove();
        
           });
        }
    });
    
   $("#sms-section").click(function(){
        var  msg_typ   = $("#msg-typ").val();
        var  msg       = $("#message").val();
        var cls        = $("#class").val();
        var sec        = $("#section").val();
        var errors     = new ErrorHandler(msg_typ,msg);
        var err_txt    = errors.get_errors('section');        
        if(err_txt.length!=0){
            var div_err = "";
            for(var i=0;i<err_txt.length;i++)
            {   div_err      += "<div class='alert alert-error'>";
                div_err      += "<h4><i class='icon-share-alt icon-white'></i> Warning"+(i+1)+"</h4>";
                div_err      += err_txt[i];
                div_err      += "</div>";
            }

                c(div_err);
                // show error to client
                $('#hidden_tmpl').css('visibility','visible');
                $("#msg-tmpl").html("");
                $("#msg-tmpl").append(div_err);
                return false;
        }else
        {   
            var tch_inchrg  = $('#tch-incharge').is(":checked");
            var admin       = $('#admin').is(":checked");
            var principal   = $('#principal').is(":checked");
            var corres      = $('#corres').is(":checked");
            var cls_teacher = $('#cls-tch').is(":checked");
            

            var action      = "sms_section"; 
            var parameters  = "?msg_typ="+msg_typ+"&msg="+msg+"&tch_inchrg="+tch_inchrg+"&admin="+admin+"&principal="+principal+"&cls_teacher="+cls_teacher+"&corres="+corres+"&class="+cls+"&section="+sec+"&action="+action;
            // animate to show processing...
            var $btn = $("#sms-section");
            $btn.button('loading');
            $("#sms-img").css("-webkit-animation","rotating 2s linear infinite");
            $("#sms-section").after("<img src='img/loader.gif' width='39px' height='42' id='loader'>");
            
            $.get("ajax/submit_helper.php"+parameters,{},function(data){
                $btn.button('reset');
                $("#sms-img").css("-webkit-animation","none");
                $("#loader").remove();
        
           });
        }
    });
    
    $("#sms-student").click(function(){
        var  msg_typ   = $("#msg-typ").val();
        var  msg       = $("#message").val();
        var cls        = $("#class").val();
        var sec        = $("#section").val();
        var stu        = $("#student").val();
        var errors     = new ErrorHandler(msg_typ,msg);
        var err_txt    = errors.get_errors('student');        
        if(err_txt.length!=0){
            var div_err = "";
            for(var i=0;i<err_txt.length;i++)
            {   div_err      += "<div class='alert alert-error'>";
                div_err      += "<h4><i class='icon-share-alt icon-white'></i> Warning"+(i+1)+"</h4>";
                div_err      += err_txt[i];
                div_err      += "</div>";
            }

                c(div_err);
                // show error to client
                $('#hidden_tmpl').css('visibility','visible');
                $("#msg-tmpl").html("");
                $("#msg-tmpl").append(div_err);
                return false;
        }else
        {   
            var tch_inchrg  = $('#tch-incharge').is(":checked");
            var admin       = $('#admin').is(":checked");
            var principal   = $('#principal').is(":checked");
            var corres      = $('#corres').is(":checked");
            var cls_teacher = $('#cls-tch').is(":checked");
            

            var action      = "sms_student"; 
            var parameters  = "?msg_typ="+msg_typ+"&msg="+msg+"&tch_inchrg="+tch_inchrg+"&admin="+admin+"&principal="+principal+"&cls_teacher="+cls_teacher+"&corres="+corres+"&class="+cls+"&section="+sec+"&student="+stu+"&action="+action;
            // animate to show processing...
            var $btn = $("#sms-student");
            $btn.button('loading');
            $("#sms-img").css("-webkit-animation","rotating 2s linear infinite");
            $("#sms-student").after("<img src='img/loader.gif' width='39px' height='42' id='loader'>");
            
            $.get("ajax/submit_helper.php"+parameters,{},function(data){
                $btn.button('reset');
                $("#sms-img").css("-webkit-animation","none");
                $("#loader").remove();
        
           });
        }
    });

    $("#sms-teacher").click(function(){
        var  msg_typ   = $("#msg-typ").val();
        var  msg       = $("#message").val();
        var cls        = $("#class").val();
        var sec        = $("#section").val();
        var teacher    = $("#teacher").val();

        var errors     = new ErrorHandler(msg_typ,msg);
        var err_txt    = errors.get_errors('teacher');        
        if(err_txt.length!=0){
            var div_err = "";
            for(var i=0;i<err_txt.length;i++)
            {   div_err      += "<div class='alert alert-error'>";
                div_err      += "<h4><i class='icon-share-alt icon-white'></i> Warning"+(i+1)+"</h4>";
                div_err      += err_txt[i];
                div_err      += "</div>";
            }

                c(div_err);
                // show error to client
                $('#hidden_tmpl').css('visibility','visible');
                $("#msg-tmpl").html("");
                $("#msg-tmpl").append(div_err);
                return false;
        }else
        {   
            var admin       = $('#admin').is(":checked");
            var principal   = $('#principal').is(":checked");
            var corres      = $('#corres').is(":checked");

            

            var action      = "sms_teacher"; 
            var parameters  = "?msg_typ="+msg_typ+"&msg="+msg+"&admin="+admin+"&principal="+principal+"&corres="+corres+"&class="+cls+"&section="+sec+"&teacher="+teacher+"&action="+action;
            // animate to show processing...
            var $btn = $("#sms-teacher");
            $btn.button('loading');
            $("#sms-img").css("-webkit-animation","rotating 2s linear infinite");
            $("#sms-teacher").after("<img src='img/loader.gif' width='39px' height='42' id='loader'>");
            
            $.get("ajax/submit_helper.php"+parameters,{},function(data){
                $btn.button('reset');
                $("#sms-img").css("-webkit-animation","none");
                $("#loader").remove();
        
           });
        }
    });


    $("#sms-group").click(function(){
        var  group     = $("#msg-typ").val(); // group
        var  msg       = $("#message").val();
        var errors     = new ErrorHandler(group,msg);
        var err_txt    = errors.get_errors('group');        
        if(err_txt.length!=0){
            var div_err = "";
            for(var i=0;i<err_txt.length;i++)
            {   div_err      += "<div class='alert alert-error'>";
                div_err      += "<h4><i class='icon-share-alt icon-white'></i> Warning"+(i+1)+"</h4>";
                div_err      += err_txt[i];
                div_err      += "</div>";
            }

                c(div_err);
                // show error to client
                $('#hidden_tmpl').css('visibility','visible');
                $("#msg-tmpl").html("");
                $("#msg-tmpl").append(div_err);
                return false;
        }else
        {   
            var all_teacher = $('#all-teacher').is(":checked");
            var admin       = $('#admin').is(":checked");
            var principal   = $('#principal').is(":checked");
            var corres      = $('#corres').is(":checked");
            var action      = "sms_group"; 
            var parameters  = "?group="+group+"&msg="+msg+"&all_teacher="+all_teacher+"&admin="+admin+"&principal="+principal+"&corres="+corres+"&action="+action;
            // animate to show processing...
            var $btn = $("#sms-group");
            $btn.button('loading');
            $("#sms-img").css("-webkit-animation","rotating 2s linear infinite");
            $("#sms-group").after("<img src='img/loader.gif' width='39px' height='42' id='loader'>");
            
            $.get("ajax/submit_helper.php"+parameters,{},function(data){
                $btn.button('reset');
                $("#sms-img").css("-webkit-animation","none");
                $("#loader").remove();
        
           });
        }
    });
    


   
   
});
