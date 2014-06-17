/**
   File handle all the application UI interaction !
**/
$(document).ready(function(){
      
	  $("*").click(function(){

		$('.td_cls').click(function(){
            var template = $(this).text();
            $("#message").text(template);
            $("#hidden_tmpl").css("visibility","hidden");
            
        });

	  	if(this.id === "help-message" || this.id === "msg-tmpl"){	        
	        return false;
	     }

	    if(this.id === "hidden_help" || this.id === "hidden_tmpl"){	        
          $("#hidden_help").css("visibility","hidden");
	        $("#hidden_tmpl").css("visibility","hidden");

         
	    }
	   });

	    $("#help").click(function() {
	        $('#hidden_help').css('visibility','visible');
        });

      
        $("#ex-tmpl").change(function() {
       
        var is_check = $("#ex-tmpl").is(":checked");
        if(is_check){
       	$('#hidden_tmpl').css('visibility','visible');
             var msg_id     = $("#msg-typ").val();
             var msg        = "fetch templates";
             var parameters="?msg_id="+msg_id+"&action="+msg;

             $.get("ajax/ajax_helper.php"+parameters,{},function(data){
             	 $("#msg-tmpl").html("");
           
                  var html = "<table class='table table-striped templates'>";
                  html+= "<thead><th>Templates</th></thead>";
                  html+= "<tbody>";
                  var object = $.parseJSON(data);

                  for(var i=0;i<object.length;i++){
                  	 html+="<tr>";
                  	 var parse = object[i].split('<').join('&lt;');
                  	 var tmpl  = parse.split('>').join('&gt;');
                     html+="<td class='td_cls'>"+tmpl+"</td>";
                     html+="</tr>";
                  }
                  html+="</tbody>";
                  html+="</table>";
                  console.log(html);
                  $('#ex-tmpl').prop('checked', false);
                  $("#msg-tmpl").append(html);
	             });
                }
        });
       
        $("#message").bind("keyup change focus", function(e) {      
          $(".char-disp input").val($("#message").val().length);
          $(".sms-no input").val(parseInt($("#message").val().length/160)+1);
        })

        $("#class").change(function(){
             var class_id     = $("#class").val();
             var msg        = "fetch sections";
             var parameters="?class_id="+class_id+"&action="+msg;
 
             $("#section option[value!='0']").each(function() {
					    $(this).remove();
			       
             });
             
             $.get("ajax/ajax_helper.php"+parameters,{},function(data){
             	var object = $.parseJSON(data);
             	console.log(object);
                var html = ""; 
                for(var k in object){
                   html+="<option value="+k+">"+object[k]+"</option>";
                }
                $("#section").append(html);
             });
             
             var msg        = "fetch teachers";
             var parameters="?class_id="+class_id+"&action="+msg;

             $.get("ajax/ajax_helper.php"+parameters,{},function(data){
              var object = $.parseJSON(data);
              console.log(object);
                var html = ""; 
                for(var k in object){
                   html+="<option value="+k+">"+object[k]+"</option>";
                }
                $("#teacher").append(html);
             });

        })

        $("#section").change(function(){
             var class_id     = $("#class").val();
             var section_id   = $("#section").val();
             var msg        = "fetch students";
             var parameters="?class_id="+class_id+"&section_id="+section_id+"&action="+msg;
 
             $("#student option[value!='0']").each(function() {
					    $(this).remove();
			       });

             $.get("ajax/ajax_helper.php"+parameters,{},function(data){
             	var object = $.parseJSON(data);
             	console.log(object);
                var html = ""; 
                for(var k in object){
                   html+="<option value="+k+">"+object[k]+"</option>";
                }
                $("#student").append(html);
             });
        })

 })

    