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

## 5.PDO异常处理Exception

异常处理Exception是指在try...catch是发生异常时的处理手段，通常异常处理都是直接抛出提醒即可。而设置提醒的手段有三种设置方式：  

(1)默认模式：  
主要依赖于系统提供的errorCode和errorInfo方法实现  
(2)警报模式：  
为pdo设置setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);  
(3)中断模式：  
为pdo设置setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  

小贴士：需要说明的是异常处理并不是三种模式必须有一种显式的去表现出来，哪怕一种都不主动写出也不会认为是违法。只不过主动实现异常处理能够在异常发生的时候给与我们更好的提示，因此推荐如果允许的情况下尽可能的添加异常处理模块代码。  

ps：exception指的是在执行db操作的时候发生的异常，例如sql语句异常或语法错误。而如果是db链接发生的错误则不会走本异常处理，而是直接由pdo输出连接失败。

## 6.PDO预处理prepare

预处理语句prepare是pdo提供的一种db操作方式。其语言逻辑与正常的pdo访问相同。但区别在于prepare语句允许用户在【设置sql语句】与【执行sql语句】之间部分进行惨的注入与提取操作，而不是像正常的pdo访问一样之间将参数写死。  

(1)prepare()方法和execute()方法  
(2)bindValue()方法  
(3)bindColumn()方法  

正常pdo直接访问： 设置sql语句 -> 执行sql语句
预处理访问： 设置sql语句 -> 预处理sql语句 -> 处理sql中参数 -> 执行sql语句

### (1).prepare()方法和execute()方法

描述：  
a.prepare()方法为预处理sql语句的方法，能够让pdo预先处理【半成品的】sql语句，并生成一个PDOStatementObject类型的结果。  
b.execute()方法是提供给PDOSO类型对象去执行的【成品】sql语句的方法，并生成一个PDOStatementObject类型的结果。  
说明：  
a.交由pdo去prepare预处理的【半成品】sql语句，使用？问号作为占位符，表示待传参的参数。  
b.prepare预处理必须只能处理【半成品】sql语句，如果是完整则需要使用exec方法执行。  
c.execute()方法允许一个数组作为参数，将参数代入到预处理的sql语句中，并且会将结果存放到PDOSO对象中。  
d.PDOS对象在预处理的不同阶段有着不同的含义！！不可混淆，必须根据上下文判断。  
语法：  
```
$sql="insert into friendslist values(?,?,?,?)";
$pdoso=$pdo->prepare($sql);
echo $pdoso->execute(array("lilei","male",99,12580));
```

### (2).bindValue()方法 

描述：bindValue()方法是提供给pdo预处理之后得到的PDOSO对象使用的方法，用来给【半成品】的sql语句进行传值。  
语法：`$pdoso->bindValue(index,value);`  
说明：
(1)第一个参数表sql语句中的第几个参数传值,即第几个问号，且不是从0开始。第一个就写1，以此类推。  
(2)第二个参数表示给sql语句中的对应参数传的具体的值。  
(3)bindValue()一次绑定一个参数，如果有多个则需要调用多次。  
例子：  
```
$sql = "insert info userinfo values(?,?)";
$pdoso = $pdo->prepare($sql);
$pdoso->execute();
$pdoso->bindValue(1,'xiaobao');
$pdoso->bindColumn(2,'999999');
echo $pdoso->execute();
```

### (3).bindColumn()方法 

描述：bindColumn()方法允许将执行结果的一系列数据绑定到一个指定对象上，本方法需要在execute()方法执行结束后在执行。  
语法：`$pdoso->bindColumn(index,指定变量);`
说明：  
(1)第一个参数表示结果中的第几列数据。第一列就写1，以此类推。  
(2)第二个参数表示数据要赋值给那个变量，随便一个变量即可。  
(3)bindColumn()方法一次绑定一列给变量，如需绑定多个，则执行多次即可。  
例子：  
```
$sql = "select * from userinfo";
$pdoso = $pdo->prepare($sql);
$pdoso->execute();
$pdoso->bindColumn(1,$username);
$pdoso->bindColumn(2,$password);
while($row = $pdoso->fetch(PDO::FETCH_COLUMN)){
    echo "{$username}"."----"."$password"."<br>";
}
```

## 7.PDO事务处理transaction

事务：多个时间组成的结构。  
事件：事件实际上就是预处理语言执行的execute语句。  
注意：  
(1)整个事务操作必须放到try...catch中，这是因为我们并不能保证执行的事件一定成功。而对于整个事务而言，任何一个事件的失败都会导致catch的触发，而catch触发就意味着必须将之前做出的所有的操作的必须还原。  
回滚操作：`$pdo->rollBack()`
(2)操作语言必须在事务开启之后执行，在事务提交之前停止。  
开启事务：`$pdo->beginTransaction();`
关闭事务：`$pdo->commit();`
(3)中文处理方案(避免乱码)：  
读取：`$pdo->query("set names utf8");`
插入：`$pdo->exec("set names utf8");`