<?php 
//if userid is not set
$arr['userid'] = "null";

//sending to row id
if(isset($DATA_OBJ->find->userid)){

//this is a row invention
$arr['userid'] = $DATA_OBJ->find->userid;
}

//read from db
$arr['sender'] = $_SESSION['userid'];
$arr['receiver'] = $arr['userid'];

 //sql to display received, sent messages and delete
 $sql = "select * from messages where (sender = :sender && receiver = :receiver) || (receiver = :sender && sender = :receiver)";
//database
$result = $DB->read($sql, $arr);

if(is_array($result)){

    foreach($result as $row){
        
   
    
        //if is Equal to sender
        if($_SESSION['userid'] == $row->sender){

            //sql for update message sender
            $sql = "update messages set deleted_sender = 1 where id = '$row->id' limit 1";

            //write in database
            $DB->write($sql);

        }

        //if this is equal to receive
        if($_SESSION['userid'] == $row->receiver){

                //sql for update message receiver
                $sql = "update messages set deleted_receiver = 1 where id = '$row->id' limit 1";

                //write in database
                $DB->write($sql);
        } 
    }
}







?>
