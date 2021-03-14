
    //variable and function for message sounds  
    var sent_audio = new Audio("sounds/message_sent.mp3");
    var received_audio = new Audio("sounds/message_received.mp3")
    
    //global variable for curent chat user and seen or received
    var CURRENT_CHAT_USER = "";
    var SEEN_STATUS = false;


    function _(element){

      return document.getElementById(element);
    
}

//contacts
var label_contacts = _("label_contacts");
label_contacts.addEventListener("click", get_contacts);

//activate get chats function
var label_chats = _("label_chats");
label_chats.addEventListener("click", get_chats);

//settings
var label_settings = _("label_settings");
label_settings.addEventListener("click", get_settings);

//Logout button
var logout = _("logout");
logout.addEventListener("click", logout_user);

function get_data(find,type){


    var xml = new XMLHttpRequest();

    //Animated loader
    var loader_holder = _("loader_holder");
    loader_holder.className = "loader_on";

    xml.onload = function (){

        if(xml.readyState == 4 || xml.status == 200){

            loader_holder.className = "loader_off";
            handle_result(xml.responseText, type);
        }
    }

    var data = {};
    data.find = find;
    data.data_type = type;
    data = JSON.stringify(data);

    xml.open("POST", "api.php", true);
    xml.send(data);
}
//Send information result and type
function handle_result(result, type){
    if(result.trim() != ""){

    //right pannel for chat
    var inner_right_pannel = _("inner_right_pannel");
    //style for chat 
    inner_right_pannel.style.overflow = "visible";

    var obj = JSON.parse(result);
    if(typeof(obj.logged_in) != "undefined" && !obj.logged_in){

        window.location = "login.php";
    
    }else{
        //through the switch we check if the properties exist

        //save names and email addresses within the app
        switch(obj.data_type){
            
            //data comes back for username, email and image
            case "user_info":
            var username = _("username");
            var email = _("email");
            var profile_image = _("profile_image");

            username.innerHTML = obj.username;
            email.innerHTML = obj.email;
            profile_image.src = obj.image;

            break;
            
            //contacts data comes back and message from contact page
            case "contacts":

                var inner_left_pannel = _("inner_left_pannel");

                //style for chat
                inner_right_pannel.style.overflow = "hidden";
                //message for inner left pannel
                inner_left_pannel.innerHTML = obj.message;

                break;
                //chats_refresh data comes back and message from contact page
                case "chats_refresh": 
                SEEN_STATUS = false;
                var messages_holder = _("messages_holder");
                    messages_holder.innerHTML = obj.messages;

                    //so right here we are checking to see if this is property, actually exist
                    if(typeof obj.new_message != 'undefined'){

                        //if true, then the sound for message will start
                        if(obj.new_message){
                            received_audio.play();

                    //function for set time        
                    setTimeout(function(){
                        messages_holder.scrollTo(0,messages_holder.scrollHeight);
                        var message_text = _("message_text");
                        //The focus () method is used to give focus to an element (if it can be focused).
                        message_text.focus();
                },100);
                        }
                    }

                   

                break;
                
                
                //send message data comes back and message from contact page
                 case "send_message":


                 //message sounds  
                sent_audio.play();
                
                //chats data comes back and message from contact page
                case "chats": 

                SEEN_STATUS = false;
                var inner_left_pannel = _("inner_left_pannel");

                inner_left_pannel.innerHTML = obj.user;
                inner_right_pannel.innerHTML = obj.messages;

                var messages_holder = _("messages_holder");
                //The setTimeout() method calls a function or evaluates an expression after a specified number of milliseconds. Tip: 1000 ms = 1 second. Tip: The function is only executed once. If you need to repeat execution, use the setInterval() method.
                setTimeout(function(){
                    messages_holder.scrollTo(0,messages_holder.scrollHeight);
                    var message_text = _("message_text");
                    //The focus () method is used to give focus to an element (if it can be focused).
                    message_text.focus();
                },100);

                //so right here we are checking to see if this is property, actually exist
                if(typeof obj.new_message != 'undefined'){

                //if true, then the sound for message will start
                if(obj.new_message){
                    received_audio.play();
                    }
                }
                break;

                 


                //settings data comes back and message from contact page
                case "settings": 
                var inner_left_pannel = _("inner_left_pannel");

                inner_left_pannel.innerHTML = obj.message;
                break;

                //send image data comes back and message from contact page
                case "send_image":
                    alert(obj.message);

                break;

                //save_Settings data comes back and message from contact page
                case "save_settings": 

                //alert message
                alert(obj.message);
                //user info
                get_data({},"user_info");
                //change male or female pichture
                get_settings(true);

                break;

                
        }
    }
    }
}
//Function for logout
function logout_user(){

    //Answer alert for logout
    var answer = confirm("Are you sure you want log out??");
    if(answer){
        get_data({},"logout");
    }
    //Get data for logout
    get_data({},"logout");
}
//get data for user information
get_data({},"user_info");

get_data({},"contacts");

var radio_contacts = _("radio_contacts");
radio_contacts.checked = true;

//function for get contacts
function get_contacts(e){

    get_data({},"contacts");

}

//function for get chats
function get_chats(e){
    
    get_data({},"chats");

}

//function for get settings
function get_settings(e){
    
    get_data({},"settings");

}

//function for send message
function send_message(e){
    
    var message_text = _("message_text");
    if(message_text.value.trim() == ""){

        alert("please type something to send");
        return;
    }
    
    //get data is function use to data from api
    get_data({
        message:message_text.value.trim(),
        userid :CURRENT_CHAT_USER

    },"send_message");
    

}
//function for send message press key enter
function enter_pressed(e){
    if(event.keyCode == 13){
        //function for send message
        send_message(e);
    }

    SEEN_STATUS = true;

}
//we read some messages every five seconds
//The setInterval() method calls a function or evaluates an expression at specified intervals (in milliseconds).
setInterval(function(){

    var radio_chat = _("radio_chat");
    var radio_contacts = _("radio_chat");

     //global variable
    if(CURRENT_CHAT_USER != "" && radio_chat.checked){

    //function for get data current chat user and seen
    get_data({
        userid:CURRENT_CHAT_USER, 
        seen:SEEN_STATUS
        },"chats_refresh");

    }

     if(radio_contacts.checked){

        //function for get data current chat user and seen
        get_data({},"contacts");

}

}, 5000);

//function for seen status
function set_seen(e){

    SEEN_STATUS = true;

}   

//function for icons delete message 
function delete_message(e){

        //if we confirm ask the following question
        if(confirm("Are you sure you want delete this message??")){
            
            //msgid is message id, take id from message
            var msgid = e.target.getAttribute("msgid");
            get_data({
                    rowid:msgid
                    },"delete_message");

            //function for get data current chat user and seen
            get_data({
                userid:CURRENT_CHAT_USER, 
                seen:SEEN_STATUS
                },"chats_refresh");

        }
}

//function for delete thread
function delete_thread(e){

//if we confirm ask the following question
if(confirm("Are you sure you want delete this whole thread??")){
    
    //userid is user id, take id from user
    get_data({
            userid:CURRENT_CHAT_USER, 
            },"delete_thread");

    //function for get data current chat user and seen
    get_data({
        userid:CURRENT_CHAT_USER, 
        seen:SEEN_STATUS
        },"chats_refresh");

}
}








function collect_data() {

    var save_settings_button = _("save_settings_button");
    save_settings_button.disabled = true;
    save_settings_button.value = "Loading...Please wait..";


     var myform = _("myform");
     var inputs = myform.getElementsByTagName("INPUT");

    var data = {};
     for(var i = inputs.length - 1; i >= 0; i--){

        var key = inputs[i].name;

        switch(key){

            case "username":
                data.username = inputs[i].value;
                break;

            case "email":
                data.email = inputs[i].value;
                break;

            case "gender":

            if(inputs[i].checked){
                data.gender = inputs[i].value;
            }
                break;
            case "password":
                data.password = inputs[i].value;
                break;
            case "password2":
                data.password2 = inputs[i].value;
                break;
        }
     }

  send_data(data, "save_settings");
  

}

function send_data(data, type){

    var xml = new XMLHttpRequest();

    xml.onload = function(){

       if(xml.readyState == 4 || xml.status == 200){

        handle_result(xml.responseText); 
        var save_settings_button = _("save_settings_button");
        save_settings_button.disabled = false;
        save_settings_button.value = "Signup";
       } 
    }
       data.data_type = type;
       var data_string = JSON.stringify(data);

       xml.open("POST", "api.php", true);
       
       xml.send(data_string);
        
}

//function for upload profile image
function upload_profile_image(files){

     //variable for files and object
     var filename = files[0].name;
    var ext_start = filename.lastIndexOf(".");
    var ext = filename.substr(ext_start + 1,3);

    //if this is true
    if(!(ext == "jpg" || ext == "JPG")){
        //give my message
        alert("This file type is not allowed");
        return;
    }

    //getting the button
    var change_image_button = _("change_image_button");
    change_image_button.disabled = true;
    //Changing to upload image
    change_image_button.innerHTML = "Uploading Image...";

    //create form object
    var myform = new FormData();

    var xml = new XMLHttpRequest();

    xml.onload = function(){

   if(xml.readyState == 4 || xml.status == 200){

    //alert(xml.responseText); 
    //user info
    get_data({},"user_info");
    //change male or female pichture
    get_settings(true);
    change_image_button.disabled = false;
    change_image_button.innerHTML = "Change Image";
   } 
}
    //append list to my form
   myform.append('file',files[0]);
   myform.append('data_type', "change_profile_image");

   //sending uploader.php style
   xml.open("POST", "uploader.php", true);
   //sending the form
   xml.send(myform);
    

}

//function for drag and drop upload pichture
function handle_drag_and_drop(e){

    if(e.type == "dragover"){

        e.preventDefault();
        e.target.className = "dragging";
    
    }else if(e.type == "dragleave"){

        e.target.className = "";

    }else if(e.type == "drop"){

        e.preventDefault();
        e.target.className = "";

        upload_profile_image(e.dataTransfer.files);
    }else{

        e.target.className = "";

    }
}

//function for start with user chat
function start_chat(e){

    //get attribute user id
    var userid = e.target.getAttribute("userid");
    if(e.target.id == ""){
        userid = e.target.parentNode.getAttribute("userid");

    }

    //global variable
    CURRENT_CHAT_USER = userid;

    var radio_chat = _("radio_chat");
    radio_chat.checked = true;  
    //function for get data
    get_data({userid:CURRENT_CHAT_USER},"chats");
}

//function for send image
function send_image(files){

    //variable for files and object
    var filename = files[0].name;
    var ext_start = filename.lastIndexOf(".");
    var ext = filename.substr(ext_start + 1,3);

    //if this is true
    if(!(ext == "jpg" || ext == "JPG")){
        //give my message
        alert("This file type is not allowed");
        return;
    }
    
   
   //create form object
   var myform = new FormData();

    //create xml
    var xml = new XMLHttpRequest();

    xml.onload = function(){

    if(xml.readyState == 4 || xml.status == 200){

    handle_result(xml.responseText, "send_message"); 
    get_data({
        userid:CURRENT_CHAT_USER,
        seen:SEEN_STATUS
    }, "chats_refresh");
    } 
    }
    //append list to my form
    myform.append('file',files[0]);
    myform.append('data_type', "send_image");
    myform.append('userid', CURRENT_CHAT_USER);

    //sending uploader.php style
    xml.open("POST", "uploader.php", true);
    //sending the form
    xml.send(myform);

}

//function for close 
function close_image(e){

    e.target.className = "image_off";
}

//function for close open image
function image_show(e){

var image = e.target.src;
var image_viewer = _("image_viewer");

image_viewer.innerHTML = "<img src='"+image+"' style='width:100%;' />";
image_viewer.className = "image_on";
}