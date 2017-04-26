<?php 
//测试页面
require "./MongoPHP.class.php";

$mongo=new MongoPHP();
//$re=$mongo->table("haha")->insert(array('id'=>33,"name"=>"hjiwjeowfjweof"));
//$re=$mongo->table("haha")->updateOne(array('id'=>55),array('id'=>66,"name"=>"ii8i","age"=>9889));
//$re=$mongo->table("test")->col()->updateOne(array('id'=>22));
//$re=$mongo->table("haha")->col()->insert(array('id'=>2323,"name"=>"rtyrty"));
//$re=mongo("haha")->insert(array("id"=>88888,"name"=>"wpqifwpqifj"));
$re=mongo("haha")->where(array('id'=>456))->order("name")->limit(2,1)->select();
//$re=$mongo->col("haha")->find()->skip(2);
echo "<pre>";
var_dump($re);

// foreach($re as $v){
// 	var_dump($v);
// }




 ?>