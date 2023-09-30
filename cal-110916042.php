<?php
    error_reporting(E_ERROR); 
    ini_set("display_errors","Off");
?>
<!--
    姓名 : 楊宗翰
    學號 : 110916042
    操作說明 :
        1.機算機輸入數字 (第一個運算元)
        2.直到按下運算子 
        3.輸入數字(第二個運算元)
        4.按下等號，輸出"結果"，一定要按下等號才會輸出結果，不能連續按運算元
        5.若沒有清除，而是按下運算子，"結果"會取代第一運算元，即可繼續運算
        6.按下 "+/-"可切換正負號
    自評分數 :
        1.不用清除就可以做下一輪運算
        2.支援浮點數，支援到小數第六位，超過會自動四捨五入
        3.有新增倒數、平方、開根號計算
        4.按"CE"指清出當前輸入數字，不會清除先前按下的第一個運算元或運算子

        評分標準都有符合! 老師可以給我100分嗎 QAQ


-->
<HTML>
<HEAD><TITLE>cal-110916042</TITLE>
</HEAD>
<style>
    table {
        background-color:#8e8e90;
        width: 400px;
        height: 500px;
        margin: auto;
        border: 1px solid black;
    }
    
</style>

<BODY>
<!--宣告變數函式-->
<?php
    $total_num ="";
    $temp_opr ="";
    $temp_eql = "";
    $temp_num1 = 0.0;
    $temp_num2 = 0.0;
    $used_point = true;
?>
<!--將上一輪的變數儲存 -->
<?php
if(isset($_POST["La_totalNumber"])) $total_num = $_POST["La_totalNumber"];
if(isset($_POST["La_tempOpr"])) $temp_opr = $_POST["La_tempOpr"];
if(isset($_POST["La_tempEql"])) $temp_eql = $_POST["La_tempEql"];
if(isset($_POST["La_tempNum1"])) $temp_num1 = $_POST["La_tempNum1"];
if(isset($_POST["La_tempNum2"])) $temp_num2 = $_POST["La_tempNum2"];
if(isset($_POST["La_used_point"])) $used_point = $_POST["La_used_point"];
?>

<!--計算機運算-->
<?php

    if(isset($_POST["Btn"]) || isset($_POST["Opr"]) || isset($_POST["Eql"])) {
        //讀取按鈕
        $Btn = $_POST["Btn"];
        $Opr = $_POST["Opr"];
        $Eql = $_POST["Eql"];

        if($Btn == "C"){ //清除全部
            $Btn = "";
            $Opr = "";
            $total_num = "";
            $temp_num1 = 0.0;
            $temp_num2 = 0.0; 
            $used_point = true;
        }else if($Btn == "CE"){ //清除當前那輪的數字
            $total_num = "";
            if($temp_num1 != 0.0){
                $temp_num2 = 0.0;
                $used_point = true;
            }
        }else if($Btn == "Del"){//刪除最後一個字元
            $total_num = substr($total_num , 0 , -1); 
        }else if($Opr == "."){ //加上小數點
            if($used_point){    //判斷是否有按過小數點
                $total_num = "$total_num".".";
                $used_point = false;
            }
        }else if($Opr == "x^1/2"){ //開根號運算
            $sqrt_num = floatval($total_num);
            $sqrt_num = sqrt($sqrt_num);
            $total_num = strval($sqrt_num);
            $sqrt_num = 0.0;
            $temp_opr = $Opr;
        }
        else if($Opr == "1/x"){ //倒數運算
            $temp_num1 = floatval($total_num);
            $temp_num1 = 1.0 / $temp_num1;
            $total_num = strval($temp_num1);
            $temp_num1 = 0.0;
            $temp_opr = $Opr;
        }else if($Opr == "x^2"){ //平方運算
            $temp_num1 = floatval($total_num);
            $temp_num1 = $temp_num1 * $temp_num1;
            $total_num = strval($temp_num1);
            $temp_num1 = 0.0;
            $temp_opr = $Opr;
        }else if($Opr == "+/-"){ //切換正負號
            $temp_num1 = floatval($total_num);
            $temp_num1 = $temp_num1*-1;
            $total_num = strval($temp_num1);
            $temp_num1 = 0.0;
        }else if($Opr === "+" || $Opr === "-" || $Opr == "/" || $Opr == "*" || $Eql == "="){   //判斷+-*/
            if($temp_num1 == 0.0){  //使用兩個暫存數字進行+-*/
                $temp_num1 = floatval($total_num); //存入第一個運算元
                $temp_opr = $Opr;   //存入運算子
                $used_point = true;
            }
            if($temp_opr === "+"  && $Eql === "="){
                $temp_num2 = round($temp_num1 + floatval($total_num) , 6);  //計算小數到第六位，超過會自動四捨五入
                $temp_eql = $Eql;
                $Opr = "";
                $Eql ="";
                $temp_num1 = 0.0;
                }
                else if($temp_opr === "-" && $Eql === "="){
                $temp_num2 = round($temp_num1 - floatval($total_num) , 6);
                $temp_eql = $Eql;
                $Opr = "";
                $Eql ="";
                $temp_num1 = 0.0;
                }
                else if($temp_opr === "*" && $Eql === "="){
                $temp_num2 = round($temp_num1 * floatval($total_num) , 6);
                $temp_eql = $Eql;
                $Opr = "";
                $Eql ="";
                $temp_num1 = 0.0;
                }
                else if($temp_opr === "/" && $Eql === "="){
                $temp_num2 = round($temp_num1 / floatval($total_num) , 6);
                $temp_eql = $Eql;
                $Opr = "";
                $Eql ="";
                $temp_num1 = 0.0;
                }
                $total_num = "";
        }else{ $total_num = $total_num.$Btn;}
    }
?>

<!--計算機設計-->
<form action="cal-110916042.php" method="post">
    
<table>
    <tr>
        <td align="center" colspan="4" bgcolor="#bd8c7d" width="100%"  height="120px"> 
            <div style="width:60% ; height:60% ; background-color:#d1bfa7; padding-top:20px" >   
            <!--輸出數字-->
            <font  size="5" face="monospace" >
            <?php
                
                if($temp_eql == "="){
                    echo $temp_num2;
                    $temp_eql = "";
                    $total_num = strval($temp_num2);
                    $temp_num2 = 0.0;   
                }else if($temp_opr == "x^2"){
                    echo $total_num;
                    $temp_opr = "";
                }else if($temp_opr == "x^1/2"){
                    echo $total_num;
                    $temp_opr = "";
                }else if($temp_opr == "1/x"){
                    echo $total_num;
                    $temp_opr = "";
                }
                else{
                    echo $total_num;
                }
                
            ?>  
            </div>
        </td>
    </tr>

    <tr align="center" bgcolor=#49494b>
        <td ><input  type="submit"  value="Del" name=Btn style="width:100%;height:100% ; background-color:#f9fbba;">    </td>
        <td ><input  type="submit"  value="CE" name=Btn style="width:100%;height:100% ; background-color:#f9fbba;">    </td>
        <td colspan = 2><input  type="submit"  value="C" name=Btn style="width:100%;height:100% ; background-color:#f9fbba;">    </td>

    </tr>
    <tr align="center" bgcolor=#49494b>
        <td ><input  type="submit"  value="1/x" name=Opr style="width:100%;height:100% ; background-color:#f9fbba;">    </td>
        <td ><input  type="submit"  value="x^1/2" name=Opr style="width:100%;height:100% ; background-color:#f9fbba;">    </td>
        <td ><input  type="submit"  value="x^2" name=Opr style="width:100%;height:100% ; background-color:#f9fbba;">    </td>
        <td ><input  type="submit"  value="/" name=Opr style="width:100%;height:100%; background-color:#f9fbba;">    </td>

    </tr>    

    <tr align="center" bgcolor=#49494b>
        <td>    <input  type="submit" value="7" name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="8" name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="9" name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="+" name=Opr style="width:100%;height:100% ; background-color:#f9fbba;"> </td>
    </tr>

    <tr align="center" bgcolor=#49494b>
        <td>    <input  type="submit" value="4"  name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="5"  name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="6"  name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="-"  name=Opr style="width:100%;height:100% ; background-color:#f9fbba;"> </td>
    </tr>

    <tr align="center" bgcolor=#49494b>
        <td>    <input  type="submit" value="1" name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="2" name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="3" name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="*" name=Opr style="width:100%;height:100% ; background-color:#f9fbba;"> </td>
    </tr>

    <tr align="center" bgcolor=#49494b>
        <td>    <input  type="submit" value="+/-"  name=Opr style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="0"  name=Btn style="width:100%;height:100%">  </td>
        <td>    <input  type="submit" value="."  name=Opr style="width:100%;height:100%">      </td>
        <td>    <input  type="submit" value="="  name=Eql style="width:100%;height:100% ; background-color:#f9fbba;"> </td>
    </tr>

    <!-- 把結果傳回下一輪的自己，下次才讀取的到 -->
    <input type="hidden" name="La_totalNumber" value="<?php echo $total_num ?>">
    <input type="hidden" name="La_tempOpr" value="<?php echo $temp_opr ?>">
    <input type="hidden" name="La_tempEql" value="<?php echo $temp_eql ?>">
    <input type="hidden" name="La_tempNum1" value="<?php echo $temp_num1 ?>">
    <input type="hidden" name="La_tempNum2" value="<?php echo $temp_num2 ?>"> 
    <input type="hidden" name="La_used_point" value="<?php echo $used_point ?>"> 

</table>
</form>

</BODY>
</HTML>
