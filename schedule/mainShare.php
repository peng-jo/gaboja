<?php 
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";

    $title  = $_POST['title'];
    $desc   = $_POST['desc'];
    $gps    = $_POST['gps'];
    $myMemberID = $_SESSION['myMemberID'];
    $regTime = time();
    $sql = "INSERT INTO gPlan(myMemberID, planTitle, planContent, planGps, regTime) VALUES({$myMemberID}, '{$title}', '{$desc}', '{$gps}', '{$regTime}')";
    $result = $connect -> query($sql);

    if($result){
        $sql2 = "INSERT INTO gPlanBoard(myMemberID,planTitle,planContent,planGps,boardView,boardLike,boardDislike,regTime ) VALUES ({$myMemberID}, '{$title}', '{$desc}','{$gps}','0','0','0','{$regTime}')";
        $result2 = $connect-> query($sql2);
        if($result2){
            echo "<script>alert('일정 공유가 완료 되었습니다.')</script>";
            echo "<script> window.location = '../board/commBoard.php';</script>";
        } else {
            echo "쿼리실패2";
        }
        
    } else {
        echo "쿼리실패";
    }

?>