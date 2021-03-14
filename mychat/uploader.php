<?php 
//start session
session_start();

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

require_once("classes/autoload.php");
//require Database class
$DB = new Database();

//empty string
$data_type = "";

if(isset($_POST['data_type'])){
    $data_type = $_POST['data_type'];
}

$destination = "";
if(isset($_FILES['file']) && $_FILES['file']['name'] != ""){

    //this is type for jpeg, png images
    $allowed[] = "image/jpeg";
    $allowed[] = "image/png";

    if($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'], $allowed)){

        //destination for upload pictures
        $folder = "uploads/";
        if(!file_exists($folder)){

            mkdir($folder, 0777, true);
        }

        $destination = $folder . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $destination);
        
        //Info, message and data type selection
        $info->message = "Your image was uploaded";
        $info->data_type = $data_type;
        echo json_encode($info);
        
    }
}


if($data_type == "change_profile_image"){

    if($destination != ""){

        //save to database
        $id = $_SESSION['userid'];
        $query = "update usersss set image = '$destination' where userid = '$id' limit 1";
        $DB->write($query,[]);
    }
}else //when mi send image, next is destination
if($data_type == "send_image"){

    //user id is null
    $arr['userid'] = "null";
    if(isset($_POST['userid'])){

    //this is a user invention
    $arr['userid'] = addslashes($_POST['userid']);
    }

   //empty message
    $arr['message'] = "";
    //set a date
    $arr['date'] = date("Y-m-d H:i:s");
    //sender current sign up user
    $arr['sender'] = $_SESSION['userid'];
    //message id random li
    $arr['msgid'] = get_random_string_max(60);
    //destination 
    $arr['file'] = $destination;

    $arr2['sender'] = $_SESSION['userid'];
    $arr2['receiver'] = $arr['userid'];

    //sql to display received and sent messages
    $sql = "select * from messages where (sender = :sender && receiver = :receiver) || (receiver = :sender && sender = :receiver) limit 1";


    //database
    $result2 = $DB->read($sql, $arr2);

    //if loop to find message id 
    if(is_array($result2)){

        $arr['msgid'] = $result2[0]->msgid;

    }
    //query insert into table
    $query = "insert into messages (sender, receiver, message, date, msgid, files) values (:sender, :userid, :message, :date, :msgid, :file)";

    //Save to db
    $DB->write($query, $arr);

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