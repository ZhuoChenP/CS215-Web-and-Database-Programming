<?php
$target_dir="uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$validate=1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$target_path=$target_path.basename($_FILES['fileToUpload']["name"]);
$dirname="http://www2.cs.uregina.ca/~chen222z/CS215Assignment6/uploads/";

$error_img="";
$error_user="";
$error_pass="";
$error_passr="";
$error_email="";
if (isset($_POST["submitted"]) && $_POST["submitted"])
{

    $username=$_POST["uname"];
    $email=$_POST["emil_sign"];

    $db = new mysqli("localhost", "chen222z", "Gelanzi", "chen222z");
            if ($db->connect_error)
            {
                die ("Connection failed: " . $db->connect_error);
            }

            $q1 = "SELECT * FROM Users WHERE email = '$email'";
            $r1 = $db->query($q1);
            if($r1->num_rows > 0)
            {
                $validate = 0;
                $error_email="The email has already regiestered";
            }
            else{
    

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $error_img= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $validate=0;
            } 
          
    

            $user_sign_v = preg_match("/^[a-zA-Z]+?$/",$username); 
            if($user_sign_v!=1){
            $error_user="* No spaces or other non-word characters Allowed.";
            $validate=0;
            }
            else
            {
            $error_user="";
            }


            $password=$_POST["pswd_sign"];
            $password_sign_v = preg_match("/^(\S*\W+\S*)$/",$password); 
            if($password_sign_v!=1||strlen($password)!=8)
            {$error_pass="* 8 characters long, at least one non-letter character";
                $validate=0;
            }
            else{$error_pass="";}


            
            $email_sign_v = preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/",$email);
            if($email_sign_v!=1)
            {$error_email="* Email address empty or wrong format."  ."<br />". "&nbsp   (Example: username@somewhere.sth.)";
                $validate=0;}
            else{$error_email="";}

            $c_password=$_POST["pswdr"];
            if($c_password!=$password||$c_password=="")
            {$error_passr="* Password and Confirm Password has to be matched";
                $validate=0;
            }
            else{$error_passr="";}
        }

            if($validate==1)
            { 
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                
                $q2="INSERT INTO Users (email,user_name,password,user_image)
                VALUES ('$email', '$username','$password','$dirname$target_path')";
                $r2=$db->query($q2);
        }
        if($r2==1){
            header("Location: Main Page.php");
            $db->close();
            exit();
        }
            else{

                $db->close();  
            }
}


?>




<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!-- <meta charset = "utf-8"> -->
<head>
    <title>Sign Up Page</title>
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
        
        <h2 class="page_name" >Sign Up Page</h2>
        <div class="form_sub">
            <form id="SignUp" action="Sign-up Page.php"  method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="submitted" value="1"/>
                <table>
                    <tr><td></td><td><label id="emil_sign_msg" class="ero_msg"><?=$error_email?></label></td></tr><tr>  
                  <tr><td>Email: </td><td> <input type="text" name="emil_sign" id="email_sign" size="30" /></td></tr>
                  <tr><td></td><td><label id="user_sign_msg" class="ero_msg"><?=$error_user?></label></td></tr>
 <tr>  
                  <tr><td>Username: </td><td> <input type="text" name="uname" size="30" id="user_sign" /></td></tr>
                  <tr><td></td><td><label id="pswd_sign_msg" class="ero_msg"><?=$error_pass?></label></td></tr>
 <tr>  
                  <tr><td>Password: </td><td> <input type="password" name="pswd_sign" id="password_sign" size="30" /></td></tr> 
                  <tr><td></td><td><label id="pswdr_sign_msg" class="ero_msg"><?=$error_passr?></label></td></tr>
 <tr>       
                  <tr><td>Confirm Password: </td><td> <input type="password" name="pswdr" size="30" id="pswdr_sign" /></td></tr>  
                  <tr><td></td><td><label id="img_sign_msg" class="ero_msg"><?=$error_img?></label></td></tr>
 <tr>  
                  <tr><td>Select image:</td><td> <input type="file" id="img" name="fileToUpload"  ></td></tr>  
               </table>

               <p><input type="submit" value="Sign up"/>
                <input type="reset" name="Reset" value="Reset" /></p>
              </form>
        </div>
        <div  class="footer" id="footersub"></div>
        
        <script type = "text/javascript"  src = "regiester.js" ></script>
    </body>
</html>

