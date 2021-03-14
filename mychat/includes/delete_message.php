<?php 
//if userid is not set
$arr['rowid'] = "null";

//sending to row id
if(isset($DATA_OBJ->find->rowid)){

//this is a row invention
$arr['rowid'] = $DATA_OBJ->find->rowid;
}


//sql for delete message
$sql = "select * from messages where id = :rowid limit 1";
//database
$result = $DB->read($sql, $arr);

if(is_array($result)){

    $row = $result[0];
    
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







?>
