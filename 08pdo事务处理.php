<?php
    require_once 'singletonPDO.php';
    $pdo = singletonPDO::getPdo();
    $pdo->exec('set names utf8');
    try {
        // 开启事务
        $pdo->beginTransaction();
        // $sql="insert into userinfo value(?,?)";
        // $pdoso=$pdo->prepare($sql);
        // $pdoso->execute(['xiaoma','999']);

        // $sql="delete from userinfo where username=?";
        // $pdoso=$pdo->prepare($sql);
        // $pdoso->execute(['xiaohui']);

        $sql="update userinfo set username=?,password=? where username=?";
        $pdoso=$pdo->prepare($sql);
        $pdoso->execute(['lix','111111','lixiang']);
        $pdoso->execute(['xiaozhang','hhhhhh']);
        // 提交事务
        $pdo->commit();
    } catch (PDOException $e) {
        // 事务回滚，单纯使用rollBack可能出现无法实现回滚的情况，需要配合引入文件中的中断操作
        $pdo->rollBack();
        echo "事务处理失败,数据库回滚到事务开始之前的状态，数据不受影响";
    }
?>