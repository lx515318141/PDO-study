<?php
    echo '<pre>';
    require_once 'singletonPDO.php';
    $pdo1 = singletonPDO::getPdo();
    // print_r($pdo1);
    $pdo1->exec('set names utf8');
    // 增加
    // $sql = "insert into userinfo value('sue','111111')";
    // 删除
    // $sql = "delete from userinfo where username='xiaohong'";
    // 修改
    // $sql = "update userinfo set username='sue',password='222222' where username='sue'";
    // 查询
    $sql = "select * from userinfo where 1";
    $result = $pdo1->exec($sql);
    print_r($result);
    // 结果显示为0，因为用pdo进行查询的查询信息是不可见的，想要看到查询内容需要结合后面内容

    // if($pdo1->exec($sql)){
    //     echo '操作成功';
    // }else{
    //     echo '操作失败';
    // }
?>