<?php
    echo '<pre>';
    class richestMan{
        // 创建单例类中的唯一单例对象
        private static $richestPeople = null;
        // 创建单例方法，用来获取在全局中唯一的单例对象
        public static function findRichestMan(){
            if(!self::$richestPeople){
                // self相当于this，表示当前类本身，即richsetMan
                self::$richestPeople = new self();
                self::$richestPeople->pname = '最富有的人';
            }
            return self::$richestPeople;
        }
        // 公有属性，当前对象创建的时候，用来证明对象的身份。
        public $pname = '';
    }
    $richestMan1 = richestMan::findRichestMan();
    $richestMan2 = richestMan::findRichestMan();
    print_r($richestMan1);
    print_r($richestMan2);
?>