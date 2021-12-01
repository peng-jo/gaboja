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
        echo "<script>alert('데이터 일정 입력이 완료 되었습니다.')</script>";
        echo "<script> window.location = '../pages/boardMain.php';</script>";
    } else {
        echo "에러발생 - 관리자에게 문의하시기 바랍니다.";
    }

?>