<?php 
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>일정 보여주기</title>
  <!-- style -->
  <link rel="stylesheet" href="../assets/css/fonts.css">
  <link rel="stylesheet" href="../assets/css/var.css">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>

  </style>
</head>
<body>
    <div id="skip">
        <a href="#contents">컨텐츠 바로가기</a>
        <a href="#footer">푸터 바로가기</a>
    </div>
    <header id="header">
        <?php
            include "../include/header.php";
        ?>
    </header>
    <!-- header -->
    <?php
        include "./show.php";
    ?>
</body>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=743052ac63b739e5aaf4218317bfca12&libraries=services"></script>
<script type="text/javascript" src="../assets/js/map.js"></script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<script> var gps = JSON.parse('<?php echo $gps;?>'); addLine(gps); 
zoomOut();
document.querySelectorAll(".js__submit").forEach((button)=>{
    button.addEventListener("click",(e)=>{
        const ilJungLength = document.querySelectorAll('.ij__js td').length;
        const textLength   = document.querySelector(".title").textLength;
        const introLength  = document.querySelector(".intro").textLength;
        const gps = document.querySelector('input[name=gps]');
        if( ilJungLength !== getInfomration().length ){
            e.preventDefault();
            alert("지도에서 3개의 마커를 선택 해주세요.");
            return false;
        } 
        if( textLength == 0 && introLength == 0 ){
            e.preventDefault();
            alert("여행 제목과 소개 내용을 입력해주세요.");
            return false;
        }
        gps.value = JSON.stringify(getInfomration());      
    });
});
</script>
</html>