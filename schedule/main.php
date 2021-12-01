<?php 
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";
?>
<?php

?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>일정 만들기</title>
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
    <main id="smain">
    <article class="content-article">
        <section class="schedule">
            <h2 class="ir_so">일정 만들기</h2>
            <div class="route">
                <h3>일정 만들기</h3>
                <div class="wrap">
                    <div class="circle-wrap">
                        <div class="circle"></div>
                        <div class="circle"></div>
                        <div class="circle"></div>
                    </div>
                    <table class="ij__js">
                        <tr>
                            <td>일정1</td>
                        </tr>
                        <tr>
                            <td>일정2</td>
                        </tr>
                        <tr>
                            <td>일정3</td>
                        </tr>
                    </table>
                </div>
            </div>
            <h2 class="ir_so">제목 내용쓰기</h2>
            <div class="route">
                <h3>여행 제목</h3>
                <form method="post">
                    <input type="text" name="gps" style="display: none;">
                    <textarea type="text" name="title" class="wrap title" rows="2" placeholder="여행계획의 제목을 적어주세요."></textarea>
                    <h3> 소개</h3>
                    <textarea type="text" name="desc" class="wrap intro" cols="30" rows="10" placeholder="여행계획에 대한 간단한 설명을 적어주세요."></textarea>
                    <div class="comment-wrap">
                        <span class="comment white">
                            <button class="js__submit" type="submit" formaction="./mainSave.php">일정 저장하기</button>
                        </span>
                        <span class="comment">
                            <button class="js__submit" type="submit" formaction="./mainShare.php">일정 공유하기</button>
                        </span>
                    </div>
                </form>

            </div>
        </section>
        <section class="map">
            <div class="overlay">
                <span>클릭하여 검색할 키워드나 주소를 입력하세요</span>
            </div>
            <div id="map" style="width:100%;height:100%;"></div>
        </section>
    </article>
    </main>
    <!-- contents -->
    <footer>
        <?php
            include "../include/footer2.php";
        ?>
    </footer>
    <!-- footer -->
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=743052ac63b739e5aaf4218317bfca12&libraries=services"></script>
    <script type="text/javascript" src="../assets/js/map.js"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        // document.querySelectorAll('.ij__js td').forEach((el, idx)=>{
        //     el.addEventListener("click",()=>{
        //         new daum.Postcode({
        //             oncomplete: function(data) {

        //                 const result = data.buildingName || data.jibunAddress;
        //                 document.querySelectorAll('.ij__js td')[idx].innerHTML = result;
        //             }
        //         }).open();
        //     });
        // });

        // 장소 검색 객체를 생성합니다
        var ps = new kakao.maps.services.Places(); 

        // 키워드로 장소를 검색합니다
        

        document.querySelector(".overlay span").addEventListener("click",()=>{
            new daum.Postcode({
                oncomplete: function(data) {
  
                    // 주소로 좌표를 검색합니다
                    geocoder.addressSearch(data.address, function(result, status) {
                        
                    // marker.setPosition(mouseEvent.latLng);
                    // 정상적으로 검색이 완료됐으면 
                    if (status === kakao.maps.services.Status.OK) {

                        var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

                        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                        map.setCenter(coords);
                        zoomIn()
                    } 
                    });
                }
            }).open();
        });
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
</body>
</html>