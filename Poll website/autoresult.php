<?php
     
     
    
    $q = $_GET['q'];

    $db = new mysqli("localhost", "chen222z", "Gelanzi", "chen222z");
    
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
    }

    $q5="SELECT Question.uid from Question where qid=$q;";
    $r5=$db->query($q5);
    $row5=$r5->fetch_assoc();

    $q1="SELECT   Question.qid,Question.last_vote_dt FROM   
    Question,   Users WHERE   Question.uid = Users.uid   And Question.uid = $row5[uid] order by created_dt DESC;";
    $r1=$db->query($q1);



    $response=array();

    $q4="SELECT Question.qid,answer,aid FROM  Question,Answer
    WHERE Question.qid=Answer.qid AND Answer.qid=$q;";
    $r4=$db->query($q4);

    while($row1=$r1->fetch_assoc())
          {
            $response[]=$row1;
          }

      while($row4=$r4->fetch_assoc()){
        $q3="SELECT count(*) as total ,Vote.aid from Vote where aid=$row4[aid];";
        $r3=$db->query($q3);
        $row3=$r3->fetch_assoc();
        $response[]=$row4;
        $response[]=$row3;
      }
    

$JSON_response=json_encode($response);
echo $JSON_response;

    $db->close();

?>