<?php


    $aid = $_GET['aid'];

    $db = new mysqli("localhost", "chen222z", "Gelanzi", "chen222z");
    
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
    }


    if($aid>0)
    {   
        $q1=" INSERT INTO Vote (aid,vote_time)
        VALUES ($aid,NOW());";
        $r1=$db->query($q1);
    }

    $q2="SELECT Answer.qid FROM  Answer
    WHERE aid=$aid;";
    $r1=$db->query($q2);
    $row1=$r1->fetch_assoc();


    $q3="SELECT Question.qid,answer,aid FROM  Question,Answer
    WHERE Question.qid=Answer.qid AND Answer.qid=$row1[qid];";

$q5="UPDATE Question
SET last_vote_dt = NOW()
WHERE qid=$row1[qid];";
$r5=$db->query($q5);

    $r3=$db->query($q3);
    $response=array();
      while($row3=$r3->fetch_assoc()){
        $q4="SELECT count(*) as total ,Vote.aid from Vote where aid=$row3[aid];";
        $r4=$db->query($q4);
        $row4=$r4->fetch_assoc();
        $response[]=$row3;
        $response[]=$row4;
      }

$JSON_response=json_encode($response);
echo $JSON_response;

    $db->close();

?>