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
   
       this.get_errors = function(){
             var err_text = [];
             c(this.msg);
             if(this.msg_typ==0)
                err_text.push("Please select Message Type.");
             if(this.msg=="") 
                err_text.push("Please type the Message.");

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
            var pricipal    = $('#pricipal').is(":checked");
            var corres      = $('#corres').is(":checked");
            var action      = "sms_all"; 
            var parameters  = "?msg_typ="+msg_typ+"&msg="+msg+"&all_teacher="+all_teacher+"&admin="+admin+"&pricipal="+pricipal+"&corres="+corres+"&action="+action;
            // animate to show processing...
            var $btn = $("#sms-all");
            $btn.button('loading');
            $("#sms-img").css("-webkit-animation","rotating 2s linear infinite");
            
            $.get("ajax/submit_helper.php"+parameters,{},function(data){
                $btn.button('reset');
                $("#sms-img").css("-webkit-animation","none")
        
           });
        }
    });
});
