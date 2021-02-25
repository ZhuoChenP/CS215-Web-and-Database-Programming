<?php
	
    $db = new mysqli("localhost", "chen222z", "Gelanzi", "chen222z");
    
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
	}

    $response=array();


        $q1="SELECT qid, question,opendate,created_dt FROM Question  order by created_dt DESC LIMIT 5;";
        $r1=$db->query($q1);

        while($row1=$r1->fetch_assoc())
        {
        $response[]=$row1;
        $qid=$row1[qid];
        $q2="SELECT Answer.qid,Answer.aid,Answer.answer FROM  Answer,Question WHERE Question.qid  = Answer.qid AND Answer.qid=$qid;";
        $r2=$db->query($q2);
        while($row2=$r2->fetch_assoc())
        {
            $response[]=$row2;
        }
        }

$JSON_response=json_encode($response);
echo $JSON_response;

    $db->close();
?>