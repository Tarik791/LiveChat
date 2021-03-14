<?php 
//if userid is not set
$arr['userid'] = "null";

//sending to user id
if(isset($DATA_OBJ->find->userid)){

//this is a user invention
$arr['userid'] = $DATA_OBJ->find->userid;
}

//variable for refresh
$refresh = false;
//variable for seen
$seen = false;
//if the chat loop refreshes
if($DATA_OBJ->data_type == "chats_refresh"){
    $refresh = true;
    $seen = $DATA_OBJ->find->seen;
}
//sql for users
$sql = "select * from usersss where userid = :userid limit 1";

//database
$result = $DB->read($sql, $arr);

//if loop to find the user
if(is_array($result)){

    //user found
    $row = $result[0];

    //selection by gender, if it is female then user_female will load, and if it is male then user_male

    $image = ($row->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
    if(file_exists($row->image)){
        $image = $row->image;
    }

    $row->image = $image;

    //empty string
    $mydata = "";

    //if not refresh
    if(!$refresh){
    //Result and data type selection
       //image , username under image , info is information of users and start chat function for start chat
       $mydata = "Now Chatting with:<br>
    
       <div id='active_contact'>
           <img src='$image'>
           $row->username
       </div>";
}

    //empty string
    $messages = "";
    $new_message = false;
   //if not refresh
   if(!$refresh){
       $messages = " 
    <div id='messages_holder_parent' onclick='set_seen(event)' style=' height: 630px;'>
    <div id='messages_holder' style='height: 480px;  overflow-y:scroll;' >";
   }
     //read from db
     $a['sender'] = $_SESSION['userid'];
     $a['receiver'] = $arr['userid'];
     //sql to display received, sent messages and delete
    $sql = "select * from messages where (sender = :sender && receiver = :receiver && deleted_sender = 0) || (receiver = :sender && sender = :receiver && deleted_receiver = 0) order by id desc limit 10";
 
     //read from database
     $result2 = $DB->read($sql, $a);
 
     //this is the if loop display of the message on the screen
     if(is_array($result2)){
 
         //Return an array with elements in reverse order
         $result2 = array_reverse($result2);
         foreach($result2 as $data){

             //the message contains a sender
             $myuser = $DB->get_user($data->sender);

            //check for new message
            if($data->receiver == $_SESSION['userid'] && $data->received == 0){

                $new_message = true;
            }

            //if loops for seen feature 
             if($data->receiver == $_SESSION['userid'] && $data->received == 1 && $seen == true){

                //update for seen 
                $DB->write("update messages set seen = 1 where id = '$data->id' limit 1");

             }
               //if loops for seen / received feature 
               if($data->receiver == $_SESSION['userid']){

                //update for seen / received 
                $DB->write("update messages set received = 1 where id = '$data->id' limit 1");

             }
             if($_SESSION['userid'] == $data->sender){
             //right message
             $messages .= message_right($data, $myuser);
             }else{
                 $messages .= message_left($data, $myuser);
 
             }
           
         }
 
     }    
    //if not refresh
    if(!$refresh){

    //function in the variable message controls
    $messages .= message_controls();
}
    //information for my data
    $info->user = $mydata;

    //information for messages 
    $info->messages = $messages;

    //property for new message
    $info->new_message = $new_message;

    //data type
    $info->data_type = "chats";

    //if  refresh
    if($refresh){

    //data type
    $info->data_type = "chats_refresh";

    


}
    echo json_encode($info);

    }else{

    //read from db
    $a['userid'] = $_SESSION['userid'];

    //sql to chat page display received and sent messages
   $sql = "select * from messages where (sender = :userid || receiver = :userid) group by msgid order by id desc limit 10";

    //database
    $result2 = $DB->read($sql, $a);

    $mydata = "Previews Chats:<br>";
    //this is the if loop display of the message on the screen
    if(is_array($result2)){

        //Return an array with elements in reverse order
        $result2 = array_reverse($result2);
        foreach($result2 as $data){
            //the message contains a sender

            //variable for sender other user 
            $other_user = $data->sender;

            //if this is true then I will receive
            if($data->sender == $_SESSION['userid']){

                $other_user = $data->receiver;

            }
            $myuser = $DB->get_user($other_user);

             
            //displayed images of female and male in chat page
                $image = ($myuser->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
                if(file_exists($myuser->image)){
                    $image = $myuser->image;
                }

           //Result and data type selection
            //image , username under image , info is information of users and start chat function for start chat
            $mydata .= "
            <div id='active_contact' userid='$myuser->userid' onclick='start_chat(event)' style='cursor:pointer;>
                <img src='$image'>
                $myuser->username<br>
                <span style='font-size:11px;'>'$data->message'</span>
            </div>";
            }
          
        }

        
    //information for my data
    $info->user = $mydata;

    //information for messages 
    $info->messages = "";
    
    //data type
    $info->data_type = "chats";

    echo json_encode($info);
}






?>
