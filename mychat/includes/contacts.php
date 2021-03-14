<?php 
$myid = $_SESSION['userid'];
//sql for users in table
$sql = "select * from usersss where userid != '$myid' limit 10";

//User images html and css animations in contacts
$myusers = $DB->read($sql, []);

$mydata = 
'
<style>
    @keyframes appear{

        0%{
            opacity:0;
            transform: translateY(50px);
        }
        100%{
            opacity:1;
            transform: translateY(0px);
        }
    }

    #contact{
        
        cursor: pointer;
        transition: all .5s cubic-bezier(0.68, -2, 0.265, 1.55);
    }

    #contact:hover{
        transform: scale(1.1);
    }
</style>
<div style="text-align:center; animation: appear 1.5s ease;">';
   
//Finds whether a variable is an array
if(is_array($myusers)){

    //check for new message
    $msgs = array();
    $me = $_SESSION['userid'];
    $query = "select * from messages where receiver = '$me' && received = 0";
    //read from database
    $mymgs = $DB->read($query, []);

    if(is_array($mymgs)){

        foreach($mymgs as $row2){   

            $sender = $row2->sender;

            if(isset($msgs[$sender])){
            $msgs[$sender]++;
            }else{
                $msgs[$sender] = 1;
            }
        }

    }

    

    //provides an easy way to iterate over arrays.
    foreach($myusers as $row){   

    //selection by gender, if it is female then user_female will load, and if it is male then user_male

    $image = ($row->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
    if(file_exists($row->image)){
        $image = $row->image;
    }

    
    //image , username under image , info is information of users and start chat function for start chat
    $mydata .= "
        <div id='contact' style='position:relative;' userid='$row->userid' onclick='start_chat(event)'>
            <img src='$image'>
            <br>$row->username";

            if(count($msgs) > 0 && isset($msgs[$row->userid])){
                
                $mydata .= " <div style='width: 20px; height: 20px; border-radius: 50%; background-color:orange; color: #fff; position: absolute; left:0px; top:0px;' >".$msgs[$row->userid]."</div>";


            }
            $mydata .= "
            </div>";
        }
}
$mydata .= '
 </div>';

//Result and data type selection
//$result = $result[0];
$info->message = $mydata;
$info->data_type = "contacts";
echo json_encode($info);

die;

//Error message for contacts
 $info->message = "No contacts were found";
 $info->data_type = "error";
 echo json_encode($info);

?>
