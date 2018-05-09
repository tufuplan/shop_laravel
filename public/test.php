<?php
$time = '2018-09-20 02:36:46';
$time1 = '2018-09';
$year =  date('Y', strtotime($time));
$month = date('m',strtotime($time))+1;
$day = date('d',strtotime($time));
   $str = date('Y-m-d',strtotime($time1));

   $currentmonth = date('Y-m',time());//当月一号;要得到下月一号

//https://www.zybuluo.com/flyok666/note/1117718
$resutlt = date("Y-m",strtotime("+1 month"));
   var_dump($resutlt);







//
//var_dump($year,$month,$day);
