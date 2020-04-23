<?php
    echo '<pre>';
    // mysql
    // $con = mysqli_connect('localhost','root','','lixdb');
    // if($con){
    //     mysqli_query($con,'set names utf8');
    //     mysqli_query($con,'set character_set_client utf8');
    //     mysqli_query($con,'set charact_set_result utf8');
    //     $sql = 'select * from userinfo where 1';
    //     $result = $con->query($sql);
    //     if($result->num_rows > 0){
    //         $info = [];
    //         for($i=0;$row=$result->fetch_assoc();$i++){
    //             $info[$i] = $row;
    //         }
    //         return $info;
    //     }
    // }else{
    //     echo '连接失败!';
    // }
    

    // pdo连接数据库
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=lixdb','root','');
        print_r($pdo);
    }catch(PDOException $err){
        echo '出现错误信息：'.$err->getMessage();
    }
    
?>