<?php

$info = (object)[];

 //Signup insert into table
 $data = false;
 $data['userid'] = $_SESSION['userid'];

 //validate username
 $data['username'] = $DATA_OBJ->username;
 if(empty($DATA_OBJ->username)){

     $Error .= "Please enter a valid username . <br>";
 }else{

     if(strlen($DATA_OBJ->username) < 3){
         $Error .= "Username must be at least 3 characters long. <br>";
     }

     if(!preg_match("/^[a-z A-Z]*$/", $DATA_OBJ->username)){
         $Error .= "Please enter a valid username . <br>";
     }
 }

 //validate email
 $data['email'] = $DATA_OBJ->email;
 if(empty($DATA_OBJ->email)){
     $Error .= "Please enter a valid email . <br>";
 }else{
     if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email)){
         $Error .= "Please enter a valid email . <br>";
     }
 }

 //validate gender
 $data['gender'] = isset($DATA_OBJ->gender) ? $DATA_OBJ->gender : null;
 if(empty($DATA_OBJ->gender)){
     $Error .= "Please select a gender . <br>";
 }else{
     if($DATA_OBJ->gender != "Male" && $DATA_OBJ->gender != "Female"){
         $Error .= "Please select a gender . <br>";
     }
 }

 
 $data['password'] = $DATA_OBJ->password;
 $password = $DATA_OBJ->password2;

 //Validate password
 $data['password'] = $DATA_OBJ->password;
 if(empty($DATA_OBJ->password)){

     $Error .= "Please enter a valid password . <br>";
 }else{

     if($DATA_OBJ->password != $DATA_OBJ->password2){
         $Error .= "password must match. <br>";
     }

     if(strlen($DATA_OBJ->password) < 8){
         $Error .= "Password must be at least 8 characters long. <br>";
     }
 }
 


 if($Error == ""){

//update into table
 $query = "update usersss set username=:username, gender=:gender, email=:email, password=:password where userid = :userid limit 1";
 $result = $DB->write($query, $data);

//Message and data type
 if($result){
    
     $info->message = "Your data was saved";
     $info->data_type = "save_settings";
     echo json_encode($info);
     
 }else{
     echo "Your profile was NOT created";
     $info->message = "Your data was NOT saved due to an error";
     $info->data_type = "save_settings";
     echo json_encode($info);
 }
 }else{
     $info->message = $Error;
     $info->data_type = "save_settings";
     echo json_encode($info);
 }

?>