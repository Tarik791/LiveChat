<?php
//Start session
session_start();


$DATA_RAW = file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_RAW);


$info = (object)[];
//check if logged in
if(!isset($_SESSION['userid'])){

    //Redirect for login page and signup
    if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type != "login" && $DATA_OBJ->data_type != "signup"){
        
        $info->logged_in = false;
        echo json_encode($info);
        die;
    }
    

}

//just require autoload file 
require_once("classes/autoload.php");

//Calling class database
$DB = new Database();


//Error
$Error = "";
//proccess the data
if(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup")
{

   //Signup
   include("includes/signup.php");
   //User info after registration

}elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "login")
{
    //Login
   include("includes/login.php");

   //Logout
}elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "logout")
{
//include logout file
include("includes/logout.php");

}elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "user_info")
{
     //user info
   include("includes/user_info.php");

   //contacts
}elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "contacts")
{
     //include contacts file
   include("includes/contacts.php");
}

//chats and chat refresh 
elseif(isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "chats" || $DATA_OBJ->data_type == "chats_refresh"))
{
     //include chats file
   include("includes/chats.php");
}

//settings
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "settings")
{
     //include settings file
   include("includes/settings.php");
}

//save_settings
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "save_settings")
{
     //include settings file
   include("includes/save_settings.php");
}

//send message
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "send_message")
{
   //send message
   include("includes/send_message.php");
}

//delete message
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "delete_message")
{
   //delete message
   include("includes/delete_message.php");
}

//delete thread
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "delete_thread")
{
   //delete thread
   include("includes/delete_thread.php");
}


//function for message on left side and html
function message_left($data, $row){

   $image = ($row->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
   if(file_exists($row->image)){
       $image = $row->image;
   }
$a = "
   <div id='message_left'>
      <div></div>
      <img id='prof_img' src='$image'>
      <b>$row->username</b><br>
      $data->message<br>";

      if($data->files != "" && file_exists($data->files)){

         $a .= "<img src='$data->files' style='width:100%;' onclick='image_show(event)' /><br>";
      }
      $a .= "<span style='font-size:11px; color:white;'>".date("jS M Y H:i:s", strtotime($data->date))."</span>

      <img id='trash' src='ui/icons/trash.jpg' onclick='delete_message(event)' msgid='$data->id' />

   </div>";

   return $a;
}

//function form message on right side and html
function message_right($data, $row){

   $image = ($row->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
   if(file_exists($row->image)){
       $image = $row->image;
   }
   
   
$a = "
<div id='message_right'>

<div>";
   //if loops for seen and received true and false and seen icons
if($data->seen){
  $a .= "<img src='ui/images/tick.png' style=''/>";
}elseif($data->received){

   $a .= "<img src='ui/images/tick_grey.png' style=''/>";

}

   $a .= "</div>

      <img id='prof_img' src='$image' style='float:right'>
      <b>$row->username</b><br>
      $data->message<br><br>";

      if($data->files != "" && file_exists($data->files)){

         $a .= "<img src='$data->files' style='width:100%;' onclick='image_show(event)' /><br>";

      }
      $a .= "
      <img src='$data->files' style='width:100%;'/><br>
      <span style='font-size:11px; color:#888;'>".date("jS M Y H:i:s", strtotime($data->date))."</span>

      <img id='trash' src='ui/icons/trash.jpg' onclick='delete_message(event)' msgid='$data->id' />
    
</div>";

return $a;
}




//function form message controls 
function message_controls(){

   return "</div>
   <span onclick='delete_thread(event)' style='color: purple; cursor:pointer;'>Delete this thread</span>
   <div style='display:flex; width: 100%; height: 40px;'>
   <label for='message_file'><img src='ui/icons/clip.png' style='opacity:0.8; width: 30px; margin:5px; cursor:pointer;'></label>
   <input type='file' id='message_file' name='file' style='display:none;' onchange='send_image(this.files)' />
   <input id='message_text' onkeyup='enter_pressed(event)' style='flex:6; border:solid thin #ccc; border-bottom:none; font-size: 14px; padding:4px;'  type='text' placeholder='Type your message'/>
   <input style='flex:1; cursor:pointer;' type='button' value='send' onclick='send_message(event)'/>
   
   </div>
   </div>
   ";
   

}
   


?>
