<?php
/*<!--===============================================
   Name   : index.php
   Purpose: class and functions that work on database
   Author : Omotola,Alexa and Ron
 ================================================-->*/
// creates database class
class Database{
    var $db;
 //functions that constructs new database object and creates table
    public function __construct($dbname,$keyword){
        $dsn = 'mysql:host=localhost;dbname='.$dbname;
        $username ='root';
        $password='';
        //checks if database exists and creates table
        try{
            $this->db=new PDO($dsn,$username,$password);
                                 $table = "
                use ".$dbname." ;
                create table `". "$keyword"."` (
                id VARCHAR(30) NOT NULL,
                date DateTime,
                from_user_id INT,
                from_user_name VARCHAR(30),
                to_user_id INT,
                to_user_name VARCHAR(30),
                geo VARCHAR(30),
                profile_image_url VARCHAR(200),
                text VARCHAR(150),
                PRIMARY KEY(id,date,from_user_id));";
                                 
                //executes sql statements
                    $this->db->exec($table);
                    
                    
                    //creates database if it doesnt exist and creates tables
        }catch(PDOException $e){
            echo '<br>The <b>'.$dbname.'<b> database does not exist. Creating it now...<br>';
            try{
             $this->db=new PDO('mysql:host=localhost',$username,$password);   
 
            $sql = "create database " .$dbname." ;
                use ". $dbname." ;
                create table `"."$keyword"."` (
                id VARCHAR(30) NOT NULL,
                date DateTime,
                from_user_id INT,
                from_user_name VARCHAR(30),
                to_user_id INT,
                to_user_name VARCHAR(30),
                geo VARCHAR(30),
                profile_image_url VARCHAR(200),
                text VARCHAR(150),
                PRIMARY KEY(id,date,from_user_id));";
            
            //executes sql statements
                
                    $this->db->exec($sql);
                        echo 'Done!<br>';
        
}
catch(PDOException $e){
    echo $e-> getMessage();
    exit();
}
}
}
//function that closes the database connection
public function close(){
    try{
        $this->db = null;
    }catch (PDOException $e){
        echo $e->getMessage()."Exit!";
        exit();
}
}
// function inserts tweets into database
public function insertTweets($tweets,$keyword){
    $sql ="INSERT INTO `"."$keyword"."` 
        (id,date,from_user_id,from_user_name,profile_image_url,text)
        VALUES(:id,:date,:from_user_id,:from_user_name,:profile_image_url,:text)";
            try{
        $x=$this->db->prepare($sql);
        foreach($tweets as $t){
            $parameters= array(
                ':id' => $t->id,
                ':date' => date('Y-m-d H:i:s', strtotime($t->date)),
                'from_user_id'=>$t->from_user_id,
                'from_user_name'=>$t->from_user_name,
                'profile_image_url'=>$t->profile_image_url,
                'text'=>$t->text
                
            );
            $x->execute($parameters);
        }
        echo "<br/> insert successful";
            }catch(PDOException $e){
                die('insert attempt failed: '. $e->getMessage());
            }
}
//function that searches database and prints result in html table
public function search($query){
    try{
        $x=$this->db->prepare($query);
        $x->execute();
}catch (PDOException $e){
    die('Query failed: '. $e->getMessage());
}
echo '<table border = 1>';
$heading = true;
while (($row = $x->fetch(PDO::FETCH_ASSOC))){
    echo '<tr>';
    if ($heading){
        $keys = array_keys($row);
        foreach($keys as $k){
            echo '<th>'.$k.'</th>';
        }
        echo '</tr><tr>';
        $heading=false;
    }
    foreach($row as $r=>$v){
        echo '<td>'.$v.'</td>';
        
    }
    echo '</tr>';
}
}
//function tat clears sql table
public function clearTable($keyword){
    try{
        $x=$this->db->prepare('TRUNCATE TABLE '."$keyword");
        $x->execute();
}catch (PDOException $e){
    die('Attempt failed: '.$e->getMessage());
 
}
}
public function relationships($keyword,$keyword2){
    $sql = "SELECT * FROM `". $keyword.
//            " INNER JOIN ". $keyword2 .
//            " r ON r.id = ".$keyword.".id".
//            " INNER JOIN ". $keyword2 .
//            " t ON t.date = ".$keyword.".date".
//            " INNER JOIN ". $keyword2 .
//            " s ON s.from_user_id = ".$keyword.".from_user_id".
//            " INNER JOIN ". $keyword2 .
//            " d ON d.from_user_name = ".$keyword.".from_user_name".
//            " INNER JOIN ". $keyword2 .
//            " y ON y.to_user_id = ".$keyword.".to_user_id".
//            " INNER JOIN ". $keyword2 .
//            " u ON u.to_user_name = ".$keyword.".to_user_name".
//            " INNER JOIN ". $keyword2 .
//            " i ON i.geo = ".$keyword.".geo".
//            " INNER JOIN ". $keyword2 .
//            " m ON m.profile_image_url = ".$keyword.".profile_image_url".
            "` INNER JOIN `". $keyword2 .
            "` n ON n.text = `".$keyword."`.text";
    try{
        $x=$this->db->prepare($sql);
        var_dump($x);
        $x->execute();
}catch (PDOException $e){
    die('Query failed: '. $e->getMessage());
}
echo '<table border = 1>';
$heading = true;
while (($row = $x->fetch(PDO::FETCH_ASSOC))){
    echo '<tr>';
    if ($heading){
        $keys = array_keys($row);
        foreach($keys as $k){
            echo '<th>'.$k.'</th>';
        }
        echo '</tr><tr>';
        $heading=false;
    }
    foreach($row as $r=>$v){
        echo '<td>'.$v.'</td>';
        
    }
    echo '</tr>';
}
}
}

?>
