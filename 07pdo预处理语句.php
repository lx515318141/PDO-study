<?php
    echo '<pre>';

    // prepare和execute()方法
    // require_once 'singletonPDO.php';
    // $pdo = singletonPDO::getPdo();
    // $pdo->exec('set names utf8');
    // // 半成品sql语句，只能由prepare进行预处理
    // $sql = 'insert into userinfo values(?,?)';
    // $pdoso = $pdo->prepare($sql);
    // // 将半成品通过execute方法传入参数，变成成品
    // $result = $pdoso->execute(['xiaohui','123456']);
    // var_dump($pdoso);
    // var_dump($result);

    // bindValue()方法
    require_once 'singletonPDO.php';
    $pdo = singletonPDO::getPdo();
    $pdo->exec('set names utf8');
    $sql = 'insert into userinfo values(?,?)';
    $pdoso = $pdo->prepare($sql);
    // bindValue()应该在prepare和execute方法之间，对sql语句中的？传值
    // 提供了一种更加灵活的编辑sql语句的方法
    $pdoso->bindValue(1,'xiaobai');
    $pdoso->bindValue(2,'999999');
    // 如果execute不传参，仅代表执行作用
    $result = $pdoso->execute();
    var_dump($result);
    
    // bindColumn()方法
    // require_once 'singletonPDO.php';
    // $pdo = singletonPDO::getPdo();
    // $pdo->exec('set names utf8');
    // $sql = 'select * from userinfo where 1';
    // $pdoso = $pdo->prepare($sql);
    // $pdoso->execute();
    // // 将结果中的内容绑定到变量上
    // $pdoso->bindColumn(1,$uname);
    // $pdoso->bindColumn(2,$upass);
    // $info=[];
    // // $pdoso->fetch(PDO::FETCH_COLUMN) 作用：遍历结果中的每一条数据，直到最后一条为止
    // for($i=0;$row=$pdoso->fetch(PDO::FETCH_COLUMN);$i++){
    //     $info[$i] = array('username'=>$uname,'password'=>$upass);
    // }
    // print_r($info);

    
?>