<?php 
//Database class
Class Database{

    //properties 
    private $con;

    //Constructor
    function __construct(){

        //object con for connect
       $this->con = $this->connect();

    }

    //method for database connect
    private function connect(){

        $string = "mysql:host=localhost;dbname=mychat_db";
        //PDO
        try{


            $connection = new PDO($string, DBUSER, DBPASS);
            return $connection;

        }catch(PDOException $e){

            echo $e->getMessage();
            die;
        }

        return false;
    }

    //method for write in database
    public function write($query, $data_array = []){

         
        $con = $this->connect();
        $statement = $con->prepare($query);

      
        $check = $statement->execute($data_array);

  
        if($check){

            return true;
        }
        return false;
    }

       //read from database
       public function read($query, $data_array = []){

         
        $con = $this->connect();
        $statement = $con->prepare($query);

      
        $check = $statement->execute($data_array);

  
        if($check){

            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result) > 0){

                return $result;
            }
            return false;
        }
        return false;
    }

    //method for get user
    public function get_user($userid){

        //connect
        $con = $this->connect();
        $arr['userid'] = $userid;
        //query
        $query = "select * from usersss where userid = :userid limit 1";

        $statement = $con->prepare($query);

        $check = $statement->execute($arr);

  
        if($check){

            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result) > 0){

                return $result[0];
            }
            return false;
        }
        return false;
    }

    //method for generating id
    public function generate_id($max){

        $rand = "";
        $rand_count = rand(4,$max);
        for($i=0; $i < $rand_count; $i++){

            $r = rand(0,9);
            $rand .= $r;
        }

        return $rand;
    }
}




?>