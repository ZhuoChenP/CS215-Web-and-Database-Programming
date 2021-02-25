<?php
session_start();
if ($_SESSION['questionid']==0) {
    header("Location: Main Page.php");
    exit();
}
else{
    $db = new mysqli("localhost", "chen222z", "Gelanzi", "chen222z");
    if ($db->connect_error)
        {
            die ("Connection failed: " . $db->connect_error);
        }
        $qid=$_SESSION['questionid'];
$q1="SELECT Users.user_name, Users.user_image, Question.question FROM  Users,Question
WHERE Question.uid  = Users.uid AND Question.qid=$qid";
$r1=$db->query($q1);
$row1 = $r1->fetch_assoc();
$q2="SELECT answer,aid FROM  Question,Answer
WHERE Question.qid=Answer.qid AND Answer.qid=$qid;";
$r2=$db->query($q2);
$r3=$db->query($q2);


$recent_dt="";        
while($row3=$r3->fetch_assoc())
{       
    $aid=$row3[aid];
  $q4="SELECT vid,Vote.aid, vote_time from Vote,Answer where Vote.aid=Answer.aid AND Vote.aid=$aid order by vote_time DESC;";
  $r4=$db->query($q4);
  $compart_dt=$r4->fetch_assoc();
    if($compart_dt["vote_time"]>$recent_dt)
    {$recent_dt=$compart_dt["vote_time"];}
}
}
?>




<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!-- <meta charset = "utf-8"> -->
<head>
    <title>Vote Page</title>
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
     </body>
        <div class="left"></div>
        <div class="right"></div>


        <div  class="container_vote">
            <h2 class="page_name">Vote Page</h2>
            <div class="main">
                <p class="active_polls">The most recent active polls</p>
                <p><?=$_Questionid?></p>
                    <div class="subcontainer">
                        <div class="border">
                              <p class="title">Title for the poll</p>
                        </div>
                    <p class="poll_event"><?=$row1["question"]?></p>
                    <div class="PA" id="change">
                    <p  class="ima">
                    <div id="piechart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <form method="post" id="showchart" action="Poll Vote Page.php">
                        
                            <label for="Answers">Please vote for your opinion:</label>
                                <br>
                                <div id="list">
                                <?php
                                    while($row2=$r2->fetch_assoc())
                                    {
                                    ?>

                                <input type="radio"  name="vote" value="<?=$row2["aid"]?>" class="helper">
                                        
                                <label><?=$row2["answer"]?></label><br>

                            <?php       
                                    }
                                ?>
                                </div>
                            <br> 
                            <input type="submit" value="Submit" />
                          </form>
                                </p>
                    </div>
                    <div id="login_vote">
                        <form id="Login">
                            <table>
                                <tr><td><P>The creater of this poll is:</P></td></tr>
                                
                                <tr><td><img src="<?=$row1["user_image"]?>" alt="Avatar" class="avatar"></td></tr> 
                                <tr><td>Username: <?=$row1["user_name"]?></td></tr>             
                           </table>
                          </form> 
                    </div>
                   </div>
             </div>
        </div>
    <div class="footer" id=""></div>
</div>    
<script type="text/javascript" src="autoshows.js"></script>
</body>
</html>

