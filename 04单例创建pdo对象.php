<?php
    // 避免引入重复，使用require_once，不管后面重复多少次，只进行这一次引入操作
    require_once 'singletonPDO.php';
    $pdo1 = singletonPDO::getPdo();
    print_r($pdo1);
?>