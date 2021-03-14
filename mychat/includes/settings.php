<?php 
//sql select from table
$sql = "select * from usersss where userid = :userid limit 1";

//button for action
$id = $_SESSION['userid'];
$data = $DB->read($sql,['userid'=>$id]);

//empty string
$mydata = "";

//Finds whether a variable is an array
if(is_array($data)){

    $data = $data[0];

    //check if image exists
    $image = ($data->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
    if(file_exists($data->image)){
        $image = $data->image;
    }

//function for sleep 3 seconds
//sleep(3);

//empty string for gender
$gender_male = "";

$gender_female = "";


//depends on which gender the user chooses, it is displayed
if($data->gender == "Male"){
    $gender_male = "checked";

}else{

    $gender_female = "checked";


}
//html and style css for settings
$mydata = '

<style>

@keyframes appear{

    0%{
        opacity:0;
        transform: translateY(50px) rotate(5deg);
        transform-origin: 100% 100%;
    }
    100%{
        opacity:1;
        transform: translateY(0px) rotate(0deg);
        transform-origin: 100% 100%;
    }
}

form{
    text-align:left;
    margin: auto;
    padding: 10px;
    width:100%;
    max-width: 400px;
}

input[type=text], input[type=password], input[type=button]  {
    padding:10px;
    margin:10px;
    width: 200px;
    border-radius: 5px;
    border: solid 1px grey;
}

input[type=button]{

    width:220px;
    padding:10px;
    cursor: pointer;
    background-color: #2b5488;
    color:#fff;
}

input[type=radio]{
    cursor: pointer;
    transform:scale(1.2);
}


#error{
    text-align:center; 
    padding: 0.5em; 
    background-color: #ecaf91; 
    color:#fff; 
    display:none;
}

.dragging{
    border: dashed 2px #aaa;    


}

</style>

    <div id="error" style="">error</div>
    <div style="display:flex; animation: appear 1.5s ease;">
    
    <div>
    <span font-size:11px;>drag and drop an image to change </span><br>
    <img ondragover="handle_drag_and_drop(event)" ondrop="handle_drag_and_drop(event)" ondragleave="handle_drag_and_drop(event)" src="'.$image.'" style="width:200px; height:200px; margin:10px;"/>
    <label for="change_image_input" id="change_image_button" style="background-color:#9b9a80; display:inline-block; padding: 1em; border-radius:5px; cursor:pointer;">
    Change Image
    </label>
    <input type="file" onchange="upload_profile_image(this.files)" value="Change Image" id="change_image_input" style="display:none; "><br>

    </div>
        <form id="myform">
            <input type="text" name="username" placeholder="Username" value="'.$data->username.'"><br>
            <input type="text" name="email" placeholder="Email" value="'.$data->email.'"><br>

            <div style="padding:10px;">
            <br>Gender:<br>
            <input type="radio" value="Male" name="gender" '.$gender_male.'> Male<br>
            <input type="radio" value="Female" name="gender" '.$gender_female.'> Female<br>
            </div>
            <input type="password" name="password" placeholder="Password" value="'.$data->password.'"><br>
            <input type="password" name="password2" placeholder="Retype Password" value="'.$data->password.'"><br>
            <input type="button" value="Save Settings" id="save_settings_button" onclick="collect_data(event)"><br>

        </form>
        </div>

';

//Result and data type selection

$info->message = $mydata;
$info->data_type = "contacts";
echo json_encode($info);


}else{


//Error message for contacts
 $info->message = "No contacts were found";
 $info->data_type = "error";
 echo json_encode($info);

}

?>
