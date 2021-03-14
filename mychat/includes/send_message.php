<?php 
//user id is null
$arr['userid'] = "null";
if(isset($DATA_OBJ->find->userid)){

//this is a user invention
$arr['userid'] = $DATA_OBJ->find->userid;
}

//sql for users
$sql = "select * from usersss where userid = :userid limit 1";


//database
$result = $DB->read($sql, $arr);

//if loop to find the user
if(is_array($result)){

    $arr['message'] = $DATA_OBJ->find->message;
    $arr['date'] = date("Y-m-d H:i:s");
    $arr['sender'] = $_SESSION['userid'];
    $arr['msgid'] = get_random_string_max(60);

    $arr2['sender'] = $_SESSION['userid'];
    $arr2['receiver'] = $arr['userid'];

    //sql to display received and sent messages
    $sql = "select * from messages where (sender = :sender && receiver = :receiver) || (receiver = :sender && sender = :receiver) limit 1";


    //database
    $result2 = $DB->read($sql, $arr2);

    //if loop to find the user
    if(is_array($result2)){

        $arr['msgid'] = $result2[0]->msgid;

    }
    //query insert into table
    $query = "insert into messages (sender, receiver, message, date,msgid) values (:sender, :userid, :message, :date, :msgid)";

    //Save to db
    $DB->write($query, $arr);

    //user found
    $row = $result[0];

    //selection by gender, if it is female then user_female will load, and if it is male then user_male

    $image = ($row->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
    if(file_exists($row->image)){
        $image = $row->image;
    }

    $row->image = $image;
    //Result and data type selection
       //image , username under image , info is information of users and start chat function for start chat
       $mydata = "Now Chatting with:<br>
        
       <div id='active_contact'>
           <img src='$image'>
           $row->username
       </div>";

       $messages = "
    <div id='messages_holder_parent' style=' height: 630px;'>
    <div id='messages_holder' style='height: 480px;  overflow-y:scroll;' >";
    //read from db
    $a['msgid'] = $arr['msgid'];

    //sql for messages
    $sql = "select * from messages where msgid = :msgid order by id desc limit 10";

    //database
    $result2 = $DB->read($sql, $a);

    //this is the if loop display of the message on the screen
    if(is_array($result2)){

        //Return an array with elements in reverse order
        $result2 = array_reverse($result2);
        foreach($result2 as $data){
            //the message contains a sender

            $myuser = $DB->get_user($data->sender);
            if($_SESSION['userid'] == $data->sender){
            //right message
            $messages .= message_right($data, $myuser);
            }else{
                $messages .= message_left($data, $myuser);

            }
          
        }

    }    

    //function in the variable message controls
    $messages .=  message_controls ();

    //information for my data
    $info->user = $mydata;

    //information for messages 
    $info->messages = $messages;

    //data type
    $info->data_type = "send_message";
    echo json_encode($info);

    }else{

    //user not found
    //Error message for contacts
    $info->message = "That contact was not found";
    $info->data_type = "send_message";
    echo json_encode($info);

}

//whatever number we put here will be converted to a string random car(generate random string)
function get_random_string_max($length){

    //this is a constant up to number 9 and words
    $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $text = "";

    $length = rand(4, $length);


    for($i=0; $i<$length; $i++){

        $random = rand(0,61);

        $text .= $array[$random];
    }

    return $text;
}




?>
