<?php
session_start();

if(isset($_SESSION["email"]))
{
    $db = new mysqli("localhost", "chen222z", "Gelanzi", "chen222z");
if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    $uid=$_SESSION['uid'];
    $q="SELECT user_name, user_image FROM  Users
    WHERE uid=$uid;";
$r=$db->query($q);
$row = $r->fetch_assoc();


$error_answer="";
$error_question="";
$error_opendate="";
$error_close="";
$validate= 1;
if (isset($_POST["submitted"]) && $_POST["submitted"])
{
            $x=1;
            $Question=$_POST["question"];
            $opendate=$_POST["Opendate"];
            $closedate=$_POST["Closedate"];
            if(strlen($Question)>100||strlen($Question)==0)
            {$error_question="* The Question can not be more than 100 and must be more than 0 characters.";
                $validate=0;}
            else{
                $q1="INSERT INTO Question  (uid,question,opendate,closedate,created_dt)
                VALUES ($uid, '$Question','$opendate','$closedate',NOW());";
                $r1=$db->query($q1);
            }

            if(strlen($opendate)=="")
            {$error_opendate="* Please enter validate Opendate and time";}
            if(strlen($closedate)=="")
            {$error_close="* Please enter validate Closedate and time";}

            
            while($_POST["a".$x]!="")
            {
                $Answer=$_POST["a".$x];
                if(strlen($Answer)>50)
                {
                    $error_answer="* The Answer can not be more than 50 characters";
                    $validate=0;
                }
                else{
                    $q2="SELECT qid from Question where  question= '$Question';";
                    $r2=$db->query($q2);
                    $row2=$r2->fetch_assoc();
                    $qid_temp=$row2[qid];
                    $q3="INSERT INTO Answer  (qid,answer)
                VALUES ($qid_temp, '$Answer');";
                $r3=$db->query($q3);
                }

                $x=$x+1;
            }
            if($validate==1)
            {
            header("Location: Poll Management Page.php"); 
            }      

}

    }

else{
    header("Location: Main Page.php");
    $db->close();
    exit();

}



?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!-- <meta charset = "utf-8"> -->
<head>
    <title>Creation Page</title>
    <link rel="stylesheet" type="text/css" href="style.css" /> 
</head>
<body>
    <header><h1><a href="Main Page.php">Online Polls</a></h1>
 </header>
 <nav>
    <ul>
        <li class="hover-effect"><a href="Main Page.php">Main</a></li>
        <li>|</li>
      <li class="hover-effect"><a href="Sign-up Page.php">Sign up</a></li>
      <li>|</li>
      <li class="hover-effect"><a href="Poll Creation Page.php">Creation</a></li>
      <li>|</li>
      <li class="hover-effect"><a href="Poll Management Page.php">Management</a></li>
      <li>|</li>

    </ul>
    </nav>
     <script type="text/javascript" src="validate.js"></script>
     
     <div  class="sub_container">
        <div class="left"></div>
        <div class="right"></div>
        
        <h2 class="page_name" id="page_name_sub">Creation</h2>
        <div class="form" id="login_case">
            <form id="Login">
                <table>
                    <tr><td><img src="<?=$row["user_image"]?>" alt="Avatar" class="avatar"></td></tr> 
                    <tr><td>Username: <?=$row["user_name"]?></td></tr>             
               </table>
              </form> 
        </div>
        <div class="form_sub">
            <form id="creation" action="Poll Creation Page.php"  method="post">
            <input type="hidden" name="submitted" value="1"/>
                <table>
                <tr><td></td><td><label id="opendate_msg" class="ero_msg"><?=$error_opendate?></label></td></tr><tr>    
                    <tr><td>Open Date: </td><td><input type="datetime-local" id="Opendate" name="Opendate"></td></tr>
                    <tr><td></td><td><label id="closedate_msg" class="ero_msg"><?=$error_close?></label></td></tr><tr> 
                    <tr><td>Close Date: </td><td><input type="datetime-local" id="Closedate" name="Closedate"></td></tr>

                <tr><td></td><td><label id="question_msg" class="ero_msg"><?=$error_question?></label></td></tr><tr> 
                  <tr><td>Enter Poll Question: </td><td> <textarea type="text" name="question"  rows="5" cols="30" id="Question" ></textarea><span name="dynamic_question" id="dynamic_question">0 out of 100 charateries</span></td></tr>

                  <tr><td></td><td><label id="a1_msg" class="ero_msg"><?=$error_answer?></label></td></tr><tr> 
                  <tr><td>Possible Answer1: </td><td> <input type="text" name="a1" size="30" id="a1" /><span name="dynamic_a1" id="dynamic_a1">0 out of 50 charateries</span></td></tr>

                  <tr><td></td><td><label id="a2_msg" class="ero_msg"></label></td></tr><tr>
                  <tr><td>Possible Answer2: </td><td> <input type="text" name="a2" size="30" id="a2"/><span name="dynamic_a2" id="dynamic_a2">0 out of 50 charateries</span></td></tr>  

                  <tr><td></td><td><label id="a3_msg" class="ero_msg"></label></td></tr><tr>
                  <tr><td>Possible Answer3: </td><td> <input type="text" name="a3" size="30" id="a3"/><span name="dynamic_a3" id="dynamic_a3">0 out of 50 charateries</span></td></tr> 

                  <tr><td></td><td><label id="a4_msg" class="ero_msg"></label></td></tr><tr> 
                  <tr><td>Possible Answer4: </td><td> <input type="text" name="a4" size="30" id="a4"/><span name="dynamic_a4" id="dynamic_a4">0 out of 50 charateries</span></td></tr> 

                  <tr><td></td><td><label id="a5_msg" class="ero_msg"></label></td></tr><tr> 
                  <tr><td>Possible Answer5: </td><td> <input type="text" name="a5" size="30" id="a5"/><span name="dynamic_a5" id="dynamic_a5">0 out of 50 charateries</span></td></tr>  
                  
               </table>
               <p><input type="submit" name="SignUp" value="SignUp" />
                <input type="reset" name="Reset" value="Reset" /></p>
              </form>
        </div>
        <div  class="footer" id="footersub"></div>
        </div>
        <script type = "text/javascript"  src = "regiester.js" ></script>
    </body>
</html>

