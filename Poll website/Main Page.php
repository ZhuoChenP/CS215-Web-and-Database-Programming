<?php


$db = new mysqli("localhost", "chen222z", "Gelanzi", "chen222z");
if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
$validate = 1;
$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
$reg_Pswd = "/^(\S*)?$/";

$email = "";

$error_pass="";
$error_email="";


if($_POST["question_id"])
{
    session_start();
$_SESSION['questionid']=$_POST["question_id"];
header("Location: Poll Vote Page.php");
$db->close();
exit();
}
else if($_POST["result_id"])
{
    session_start();
    $_SESSION['result_id']=$_POST["result_id"];
    header("Location: Poll Results Page.php");
    $db->close();
}

else if (isset($_POST["submitted"]) && $_POST["submitted"])
{
$email = trim($_POST["email"]);
$password = trim($_POST["pswd"]);
    $q1="select * from Users where email = '$email'";
    $r1 = $db->query($q1);
    $row = $r1->fetch_assoc();
    if($r1->num_rows != 1)
    {$validate=0;
        $error_email="* Please enter valid email.";
    }
    else
    { 
        if($row["password"] != $password)
        {
            $error_pass="* Please enter valid password.";
            $validate=0;}

        else{
        $emailMatch = preg_match($reg_Email, $email);
            if($email == null || $email == "" || $emailMatch == 0)
            {
                $validate = 0;
                $error_email="* Email address empty or wrong format."  ."<br />". "&nbsp   (Example: username@somewhere.sth.)";
            }
        
        $pswdLen = strlen($password);
        $passwordMatch = preg_match($reg_Pswd, $password);
            if($passwordMatch == 0)
            {
                $validate = 0;
                $error_pass="* Please enter valid password";
            }
        }
    }
    if($validate==1)
    {
        session_start();
        $_SESSION["email"]=$_POST["email"];
        $_SESSION["pswd"]=$_POST["pswd"];
        $_SESSION["uid"]=$row[uid];
        header("Location: Poll Management Page.php");
        $db->close();
        exit();
    }
}
?>




<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!-- <meta charset = "utf-8"> -->
<head>
    <title>Main Page</title>
    <link rel="stylesheet" type="text/css" href="style.css" /> 
    <script type="text/javascript" src="validate.js"></script> 
    
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
<div  class="container">
    <h2 class="page_name">Main Page</h2>

    <div class="left"></div>
    <div class="right"></div>
    
    <div class="form">
        <form  method="post" action="Main Page.php">
        <input type="hidden" name="submitted" value="1"/>
            <table>
                <tr><td></td><td><label id="email_msg" class="ero_msg"><?=$error_email?></label></td></tr>
 <tr>  
                <tr><td>Email: </td><td> <input type="text" name="email" id="email"  size="30" /></td></tr>  
                <tr><td></td><td><label id="pswd_msg" class="ero_msg"><?=$error_pass?></label></td></tr>
                <tr>           
              <tr><td>Password: </td><td> <input type="password" name="pswd" id="pswd" size="30" /></td></tr>
           </table>
           <p><input type="submit" value="Login" name="login">
            <a href='Sign-up Page.php'><button type="button" value="Sign-up" name="Sign-up">Sign-up</button></a></p>
          </form>
    </div>

          <div class="main" name="main" id="main">
          <p class="active_polls">The most recent active polls</p>
              <?php
                        $q2="SELECT qid, question,opendate,created_dt FROM Question  order by created_dt DESC LIMIT 5;";
                        $q3="SELECT Answer.qid,Answer.aid,Answer.answer FROM  Answer,Question WHERE Question.qid  = Answer.qid;";
                        $result_question=$db->query($q2);
                        

            $previous_Question="";
            while($row=$result_question->fetch_assoc()){
                if($previous_Question!=$rwo["question"]){

                    $previous_Question=$rwo["question"];
                }
                ?>
           
           <div class="subcontainer" id="subid<?=$row["qid"]?>" >
                        <div class="border">
                                <p class="title" id="titleid<?=$row["qid"]?>"> Poll Created date:<?=$row["created_dt"]?></p>
                            </div>
                            <p class="poll_event" id="poll_event_id<?=$row["qid"]?>"><?=$row["question"]?></p>
                            <ol class="PA">
                            <?php 
                            $result_answer=$db->query($q3);
                            while($answer_r=$result_answer->fetch_assoc())
                            {
                                if($answer_r["qid"]==$row{"qid"}){
                          
                            ?>
                            <li><?=$answer_r["answer"]?></li>
                        <?php 
                                }
                        }
                        ?>
                        <span class="spanFormat"><form method="post" action="Main Page.php"><input type="hidden" name="question_id" value="<?=$row["qid"]?>" />
                        <input type="submit" value="Vote" name="Vote" /></form></span>
                
                        <span class="spanFormat"><form method="post" action="Main Page.php"><input type="hidden" name="result_id" value="<?=$row["qid"]?>" />
                            <input type="submit" value="Results" name="Results" /></form></span>
                       
            </ol>
        </div>

           <?php
            }
           ?>
           </div>
        <div class="footer"></div>
    </div>    
    <script type = "text/javascript"  src = "regiester.js" ></script>
    <script type = "text/javascript"  src = "update.js" ></script>
</body>
</html>

        