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

                    $q1="SELECT   Question.qid,   Question.uid,   Question.question,Question.created_dt,Question.last_vote_dt FROM   Question,   Users WHERE   Question.uid = Users.uid   And Question.uid = $uid order by created_dt DESC;";
                    $r1=$db->query($q1);

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
}



else{header("Location: Main Page.php");}

?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!-- <meta charset = "utf-8"> -->
<head>
    <title>Management Page</title>
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
<div  class="container">
    <h2 class="page_name">Management Page</h2>

    <div class="left"></div>
    <div class="right"></div>

    <div id="login_case">
        <form id="Login">
            <table>
                <tr><td><img src="<?=$row["user_image"]?>" alt="Avatar" class="avatar"></td></tr> 
                                <tr><td>Username: <?=$row["user_name"]?></td></tr>               
           </table>
          </form> 
    </div>

        <div class="main">
                <p class="active_polls">Polls have posted(from most recent)</p>
                    <div class="subcontainer"  id="spefic_contrainer">
                    <?php
                        
                        while($row1 = $r1->fetch_assoc()){
                        $id=$id+1;
                        $qid=$row1[qid];

                        $q4="SELECT answer,aid FROM  Question,Answer
                        WHERE Question.qid=Answer.qid AND Answer.qid=$qid;";
                        $r4=$db->query($q4);


                        $q2="SELECT answer,aid FROM  Question,Answer
                        WHERE Question.qid=Answer.qid AND Answer.qid=$qid;";
                        $r2=$db->query($q2);
                        ?>

                        <div class="border">
                        <p class="title">Title for the poll</p>
                       <p class="title_date" >Created date: <?=$row1["created_dt"]?></p>
                        </div>

                        <p class="poll_event"><?=$row1["question"]?></p>
                        <div  class="PA">
                            <ol>
                            <?php
                        while($row2 = $r2->fetch_assoc()){
                            ?>
                                <li><?=$row2["answer"]?></li>
                                <?php 
                                }
                        ?>
                                <span class="spanFormat"><form method="post" action="Main Page.php"><input type="hidden" name="question_id" value="<?=$qid?>" />
                        <input type="submit" value="Vote" name="Vote" /></form></span>
                
                        <span class="spanFormat"><form method="post" action="Main Page.php"><input type="hidden" name="result_id" value="<?=$qid?>" />
                            <input type="submit" value="Results" name="Results" /></form></span>
                                </ol>
                            
                        <p class="recentvote" id="title_date<?=$row1["qid"]?>">The most recent vote: <span id="span<?=$row1['qid']?>"><?=$row1["last_vote_dt"]?></span></p>
                    </div>

                    <div name="piechart" id="piechart<?=$qid?>"></div>
                    <div>
                       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                           <script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Result', 'Vote per User'],
  <?php
  while($row4=$r4->fetch_assoc()){
      $q3="SELECT count(*) as total from Vote where aid=$row4[aid];";
      $r3=$db->query($q3);
      $row3=$r3->fetch_assoc();
      ?>

  ["<?=$row4['answer']?>", <?=$row3[total]?>],

  <?php
  }
  unset($_SESSION["answer_id"]);
  ?>
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Poll Results', 'width':350, 'height':250};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart<?=$qid?>'));
  chart.draw(data, options);
}
</script>  
                    </div>
                    <?php 
                                }
                        ?> 
        </div>
        <div class="footer"></div>
        <script type = "text/javascript"  src = "autoresult.js" ></script>
    </div>    
</body>
</html>

        