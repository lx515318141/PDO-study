<?php
    echo '<pre>';
    // 第一类异常，数据库连接异常，这种异常通常通过try...catch捕获
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=lixdb','root','');
        // 第二类异常的第二种处理方法
        // 当操作数据库发生异常的时候，弹出警报，但是程序的执行不会中断。
        // $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

        // 第二类异常的第二种处理方法
        // 当操作数据库发生异常的时候，进行中断。
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo '连接错误信息为：'.$e->getMessage();
    }
    $pdo->exec('set names utf8');
    $sql = "update userinfo1 set username='zhangsan',password='333333' where username='zhangsan'";
    if($pdo->exec($sql)){
        echo 'success';
    }else{
        echo 'error';
        // 第二类异常的第一种处理方法（系统提供的errorCode和errorInfo方法实现）,用处不大
        // echo $pdo->errorCode();
        // echo $pdo->errorInfo();
        
    }
?>