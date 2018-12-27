使用规范与方法：

1.MySQL表名小写
2.模块名需首字母大写，并在名称后添加Model 如TestModel
3.控制器需首字母大写，并在名称中添加Controller 如TestController
4.视图,test/view.php暂时只支持相对路径。
5.目前仅支持在controller目录与model目录下直接写php文件，不支持扩展文件夹
6.controller中index方法不要传参数。
7.IndexController为默认控制器，index()为默认方法
8.方法与类统一采用小驼峰的命名方式：如testFunction，routerParseFunction
9.控制器中两种调用视图的方法，一：return视图的相对路径 二：render()视图的相对路径,加不加后缀都可以
10.一个model类对应一个表,model名对应表名。如TestModel 对应的表名为test（小写）
11.给视图分配变量有两种方式 1，$this->assign("key","ewfwefw");可以一次性设置多个，在view中使用$key获取值
                          2.$this->render('test/1'，$arr);类似于ci框架 ,用arr中的key去获取value

12.$db = $this->db('ItemCarModel');连接数据库。第一个参数为模型类名，可以是itemcar也可以是itemcarmodel 也可以是itemcarmodel.php大小写不限
第二个参数，默认default（config/database.php）中的数据库名。带上第二个参数的数据库名，可以改变数据库连接

13,默认控制器中只能拥有一个方法--index，以作主页展示，其他的方法写在别的控制器。indexcontroller里面写一个index函数即可

14.功能还在优化中........loading