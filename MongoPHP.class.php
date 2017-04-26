<?php 
//不支持php7的环境
class MongoPHP{
   protected $config=array();
   protected $db="";
   protected $_table="";
   protected $mongo="";
   protected $dsn="";
   protected $re="";

public function __construct(){
     $this->config=require(dirname(__FILE__)."/config.php");
     if($this->config['user']){
      $this->dsn="mongodb://".$this->config['user'].":".$this->config['password']."@".$this->config['host'].":".$this->config['port'];
    }else{
      $this->dsn="mongodb://".$this->config['host'].":".$this->config['port'];
    }   
     $this->mongo=new MongoClient($this->dsn);
     $this->db=$this->config['db'];
}  

public function table($table){ 
   $mongo=$this->mongo;
   $db=$this->db;
   $this->_table=$this->mongo->$db->$table;
   return $this;
 }

public function find($where=array()){
   $re=$this->_table->find($where);
   return $this->toArray($re);
} 

public function where($w=array(),$field=""){
  $field=$field?explode(",",$field):array();
  $this->re=$this->_table->find($w,$field);
  return $this;
}

public function order($str){
  $sort=explode(" ",$str);
  $order=isset($sort[1])&&$sort[1]=="desc"?-1:1;
  $this->re=$this->re->sort(array($sort[0]=>$order));
  return $this;
}

public function limit($start,$len=0){
  if($start>0&&$len==0){
    $this->re=$this->re->limit($start);
   }else{
    $this->re=$this->re->skip($start)->limit($len);
   }
   return $this;
}

public function select(){
  return $this->toArray($this->re);
}

public function findOne($w=array()){
   $re=$this->_table->findOne($w);
   return $this->toArray($re);
}

public function insert($arr){
  $re=$this->_table->insert($arr);
  return $re;
}

//修改
public function update($w,$arr){
  $options =array(
     "upsert"=>false,//只修改，不添加，true则添加
     "multiple"=>true,//更新所有 
    );
  $re=$this->_table->update($w,array('$set'=>$arr),$options );
  return $re;
}

public function updateOne($w,$arr){
  $options =array(
     "upsert"=>false,//只修改，不添加，true则添加
     "multiple"=>false,//只更新一条纪录 
    );
  $re=$this->_table->update($w,$arr,$options );
  return $re;
}

//删除所有
public function delete($w){
  if(!$w||count($w)==0){return "nowhere";}
  $re=$this->_table->remove($w);
  return $re;
}

public function deleteOne($w){
  if(!$w||count($w)==0){return "nowhere";}
  $re=$this->_table->remove($w,array('justOne'=>true));
  return $re;
}


//返回原生的集合
public function col($table){
   $mongo=$this->mongo;
   $db=$this->db;
   return $this->mongo->$db->$table;
}

public function mongo(){
  return $this->mongo;
}


public function toArray($obj){
  $arr=array();
  foreach($obj as $v){
    $arr[]=$v;
  }
  return $arr;
}

   

}//endclass


function mongo($table){
  $m=new MongoPHP();
  $m->table($table);
  return $m;
}


?>