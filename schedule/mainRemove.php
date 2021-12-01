<?php 
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";

    $planID  = $_POST['planID'];

    $myMemberID = $_SESSION['myMemberID'];


    
    $sqlCheck = "SELECT myMemberID FROM gPlan WHERE myPlanID = {$planID}";
    $result = $connect -> query($sqlCheck);
    $result = $result -> fetch_array(MYSQLI_ASSOC);
    if( $myMemberID == $result['myMemberID'] ){
        $sql = "DELETE FROM gPlan WHERE myPlanID = {$planID}";
        $result = $connect -> query($sql);
        echo "<script>alert('일정 삭제가 완료 되었습니다.')</script>";
        echo "<script> location.href = '../information/informationMain.php'</script>";
    } else {
        echo "<script>alert('해당 사용자가 아닙니다.')</script>";
        echo "<script> location.href = '../information/informationMain.php'</script>";
    }


?>