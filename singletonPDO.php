<?php
    class singletonPDO{
        private static $pdo = null;
        public static function getPdo(){
            if(!self::$pdo){
                try{
                    self::$pdo = new PDO('mysql:host=localhost;dbname=lixdb','root','');
                }catch(PDOException $e){
                    echo '错误信息为：'.$e->getMessage();
                }
            }
            return self::$pdo;
        }
    }
?>