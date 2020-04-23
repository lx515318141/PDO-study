# MySQL POD对象

## 大纲

1.singleton  
2.PDO与DB  
3.singleton获取PDO  
4.PDE实现DB增删改查  
5.PDE异常处理Exception  
6.PDE预处理prepare  
7.PDE事物处理transaction  
8.学生管理实例  

## 1.singleton

singleton中文名称为单利模式，是一种构造类的设计模式。其目的是为了在全局获取这个类的对象时总是能获取到唯一的对象，而不是每次实例化都创建出新的对象的一种类结构。  
特别是在DB操作中，DB连接这种对象就必须是通过单例模式来实现的。  
```
class DBConnectionSingleton{
    private static $con = mull;         // 通过私有+静态声明单例对象
    // function__construct(){}
    public static function getcon() {
        if(!self::$con){                // 通过静态执行一次的特点保证对象唯一性
            self::$con = new self();
        }
        return self::$con;
    }
}
$con1 = DBConnectionSingleton::getcon();
$con2 = DBConnectionSingleton::getcon();
```

## 2.PDO与DB

描述：PDO即PHP数据对象(PHP data Object)。  
      PDO可被视为是一个工具，而这个工具为PHP访问数据库定义了一个轻量级的一致接口。实现PDO接口的每个数据库驱动可以公开具体数据库的特性作为标准扩展功能。
语法：$pdo = new PDO("DB名:host=主机名;dbname=DB名","DB账号","DB密码");  
注意：  
(1)利用PDO扩展自身并不能实现任何数据库功能，必须使用一个具体数据库的PDO驱动来访问数据库服务。  
(2)PDO提供了一个【数据访问】抽象层，这意味着不管使用哪种数据库，都可以用相同的函数(方法)来查询和获取数据。  
(3)PDO不提供数据库抽象层，他不会重写SQL，也不会模拟缺失的特性。如果需要的话，应该使用一个成熟的抽象层。  
(4)从PDO 5.1爱上附带了PDO，在PDO 5.0中是作为一个PECL扩展使用。PDO需要PHP 5核心的新特性，因此不能在较早版本的PHP上运行。  
总结：  
PDO就像是一把枪，而是用那种数据库就好比是选择不同的子弹。不管子弹有怎样的特性，击发的方法总没有偏差，都是开枪而已。  
补充：在连接DB的时候，并不是每一次的连接都能成功。因此我们必须设置一个"保险"来帮助我们检测连接的情况，这个东西就是try...catch机制。  
```
try{
    $pdo = new PDO("mysql:host=localhost;dbname=lixdb","root","");
}catch(PDOException $e){
    echo "错误";
    echo $e->getMessage();
}
```
在整个try...catch结构中，try部分是可能会出现异常的代码。  
而当代码执行的过当中一旦try部分的代码真的发生了异常，那么会立即将这个异常抛出，并执行catch部分的代码。  
catch部分的形参$e就是用来接收抛出的异常的。  
可以这样认为：上述结果是获取PDO时的一个固定结构！

## 3.singleton获取PDO

在说这部分内容之前，我们应该先确定我们能够独立的写出singleton和获取PDO的代码，然后我们用一个问题因此这部分内容：  
假设有小A和小B两个人，这两个人都在使用PDO来访问DB。这时：  
(1)小A在通过PDO访问DB，并删除其中的所有数据。  
(2)小B在通过PDO访问DB，并查询其中的某条数据。  
如果没有办法确定小A和小B谁先访问DB，谁后访问DB，那么会产生怎样的结果？

## 4.PDO实现DB增删改查

上面提到过，pdo是一种【数据访问】层的抽象，因此本质上来讲在面对同一种DB进行操作的时候，pdo的操作和php本身直接操作没有区别。
```
require_once 'PDOSingleton.php';
$pdo=PDOSingleton::getpdo();        // 通过单例方法获取全局pdo单例对象
$pdo->exec('set names utf8');       // exec()方法是pdo对象的执行方法，相当于php中的query()方法。
$sql = "insert into friendslist values('美女',222,222,2000001)";
// ...
if($pdo->exect($sql)){
    echo "success";
}else{
    echo "error";
}
```