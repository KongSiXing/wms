<?php
include("conn/conn.php");
include("inc/func.php");
$username=$_POST[username];
$userpwd=md5($_POST[userpwd]);
//$yz=$_POST[yz];
//$num=$_POST[num];

class chkinput{
   var $name;
   var $pwd;

   function chkinput($x,$y){
     $this->name=$x;
     $this->pwd=$y;
    }

   function checkinput(){
     include("conn/conn.php");
     $sql=mysql_query("select * from tb_admin where name='".$this->name."'",$conn);
     $info=mysql_fetch_array($sql);
     if($info==false){
          echo "<script language='javascript'>alert('不存在此用户！');history.back();</script>";
          exit;
       }
      else{
	      if($info[state]==0){
			   echo "<script language='javascript'>alert('该用户已经被冻结！');history.back();</script>";
               exit;
			}
          
          if($info[pwd]==$this->pwd)
            {  
			   session_start();
	           $_SESSION[username]=$info[name];
			   //session_register("producelist");
			  // $producelist="";
			  // session_register("quatity");
			   // $quatity="";
			    w_log($_POST[action],$_SESSION[username]);
               header("location:main.php");
               exit;
            }
          else {
             echo "<script language='javascript'>alert('密码输入错误！');history.back();</script>";
             exit;
           }

      }    
   }
 }

    $obj=new chkinput(trim($username),trim($userpwd));
    $obj->checkinput();
?>