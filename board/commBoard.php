<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>

    <!-- style -->
    <link rel="stylesheet" href="../assets/css/w3c.css">
    <link rel="stylesheet" href="../assets/css/fonts.css">
    <link rel="stylesheet" href="../assets/css/var.css">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- //style -->
    <style>
        .commWrite {
            display: grid;
            grid-template-columns: repeat(3,380px);
            gap: 50px 30px;
            margin-top: 70px;
        }
        .commWrap {
            border: 1px solid #000;
            display: inline-block;
            border-radius: 5px;
        }
        .commWrap .commThum {
            width: 378px;
            height: 251px;
            vertical-align: top;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .commWrap .commText {
            padding: 15px;
            overflow: hidden;
            border-top: 1px solid #000;
        }
        .commWrap .commText .commUser {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            justify-content: space-between;
        }
        .commWrap .commText .commUser span {
            font-size: 14px;
        }
        .commWrap .commText .commUser .scoreWrap {
            border: 1px solid #ccc;
            border-radius: 3px;
            overflow: hidden;
            padding: 5px;
        }
        .commWrap .commText .commUser .scoreWrap .nowScroe {
            float: left;
            margin-right: 20px;
        }
        .commWrap .commText .commUser .scoreWrap .nowScroe span {
            color: #ADB6BD;
            font-size: 10px;
        }
        .commWrap .commText .commUser .scoreWrap .scoreFace {
            float: left;
        }
        .commWrap .commText .commUser .scoreWrap .scoreFace .temp {
            font-size: 10px;
            margin-right: 5px;
        }
        .commWrap .commText .commUser .scoreWrap .scoreFace .temp2 {
            width: 20px; height: 20px;
        }
        .commWrap .commText .commUser .scoreWrap .w3-light-grey {
            margin-top: 25px;
        }
        .commWrap .commText h4 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .commWrap .commText span {
            font-size: 12px;
        }
        .commWrap .commText ul {
            float: right;
        }
        .commWrap .commText ul li {
            display: inline-block;
            font-size: 12px;
        }
        .commWrap .commText ul li:first-child {
            margin-right: 25px;
        }
        .commWrap .commText ul li:first-child::before {
            content: '';
            display: inline-block;
            background: url(../assets/ico/icon2.svg);
            width: 12px; height: 12px;
            position: absolute;
            margin: 2px 0 0 -14px;
        }
        .commWrap .commText ul li:nth-child(2)::before {
            content: '';
            display: inline-block;
            background: url(../assets/ico/icon1.svg);
            width: 12px; height: 12px;
            position: absolute;
            margin: 1px 0 0 -14px;
        }
        @media(max-width: 800px){
            .commWrite {
                display: grid;
                grid-template-columns: repeat(2,47vw);
                gap: 3vw 2vw;
                margin-top: 10vw;
                justify-content: center;
            }
            .commWrap .commThum {
                width: 45.9vw;
                height: 42vh;
                vertical-align: top;
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
                object-fit: cover;
            }
        }
        @media(max-width: 450px){
            .commWrap .commThum {
                height: 30vh;
            }
        }
    </style>
</head>
<body>
    <div id="skip">
        <a href="#contents">Contents 바로가기</a>
        <a href="#footer">Footer 바로가기</a>
    </div>
    <!-- //skip -->
    <header id="header">
    <?php
        include "../include/header.php";
    ?>
    </header>
    <!-- //header -->
    <main id="contents">
        <section id="mainCont">
            <h2 class="ir_so">메인 컨텐츠</h2>
            <article class="content-article">
                    <div class="boardType">
                        <h3>같이가요 게시판</h3>
                        <p>여행계획을 공유하고 같이갈 친구를 찾아보세요.</p>
                        <div class="board">
                            <div class="board-search">
                                <form action="commBoardSearch.php" name="boardSearch" method="get">
                                    <fieldset>
                                        <legend class="ir_so">게시판 검색 영역</legend>
                                        <input type="text" name="searchKeyword" class="form-search" placeholder="검색어를 입력하세요" aria-label="search" required>
                                        <select name="searchOption" id="searchOption" class="form-select">
                                            <option value="title">제목</option>
                                            <option value="content">지역</option>
                                            <option value="name">글쓴이</option>
                                        </select>
                                        <button type="submit" class="form-btn">검색</button>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="commWrite">
                                <?php
                                    if(isset($_GET['page'])){
                                        $page = (int) $_GET['page'];
                                    } else {
                                        $page = 1;
                                    }
                                    $numView = 9;
                                    $viewLimit = ($numView * $page) - $numView;
                                    // board + member
                                    $postSessions = $_SESSION['myMemberID'];
                                    $sql = "SELECT m.youName, m.image, m.youScore, w.myBoardID, w.planTitle, w.boardView, w.regTime FROM gmember m JOIN gPlanBoard w ON (m.myMemberID = w.myMemberID) ORDER BY myBoardID DESC LIMIT {$viewLimit}, {$numView}";
                                    $result = $connect -> query($sql);

                                    if($result){
                                        $count = $result -> num_rows;
                                        if($count > 0){
                                            for($i=1; $i<=$count; $i++){
                                                $info = $result -> fetch_array(MYSQLI_ASSOC);

                                                $commentSql = "SELECT myCommentID,myMemberID,myBoardID,youText,youLike,youDislike,regTime FROM planComment WHERE myBoardID = {$info['myBoardID']}";
                                                $commentResult = $connect->query($commentSql);
                                                $commentCount = $commentResult -> num_rows;

                                                // $ThumSql = "SELECT image, youScore FROM gmember WHERE myMemberID = {$info['myMemberID']}"; 
                                                // $result3 = $connect -> query($ThumSql);
                                                // $info3 = $result3 -> fetch_array(MYSQLI_ASSOC);

                                                

                                                echo "<div class='commWrap'><a href='commBoardView.php?boardID={$info['myBoardID']}'>";
                                                if( !$info['image'] ){ //프로필 사진을 적용 안했을때 사용할 기본이미지 사진 
                                                    echo "<img class='commThum' src='../assets/img/m0.jpg' alt='썸네일'>";
                                                } else { //프로필 사진을 적용했을때 나오는 사진
                                                    echo "<img class='commThum' src='data:image/jpeg; base64,".base64_encode( $info['image'] )."'/>";
                                                }
                                                echo "<div class='commText'>";
                                                echo "<div class='commUser'>";
                                                echo "<span>".$info['youName']."</span>";
                                                echo "<div class='scoreWrap'>";
                                                echo "<div class='nowScroe'>";
                                                echo "<span>첫온도36.5℃</span>";
                                                echo "</div>";
                                                echo "<div class='scoreFace'>";
                                                echo "<span class='temp'>".number_format($info['youScore'],1)."℃</span>";
                                                echo "<img class='temp2' src='../assets/ico/normal.svg' alt='기본온도아이콘'>";
                                                echo "</div>";
                                                echo "<div class='w3-light-grey'><div class='w3-green temp__js' style='height: 7px; width:".number_format($info['youScore'],1)."%; border-radius: 8px;'></div></div>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "<h4>".$info['planTitle']."</h4>";
                                                echo "<span>".date('Y-m-d', $info['regTime'])."</span>";
                                                echo "<ul>";
                                                echo "<li>".$info['boardView']."</li>";
                                                echo "<li>".$commentCount."</li>";
                                                echo "</ul>";
                                                echo "</div>";
                                                echo "</a></div>";
                                            }
                                        }
                                    }
                                ?>

                                <!-- <div class="commWrap">
                                    <a href="#">
                                        <img class="commThum" src="../assets/img/withContent1.jpg" alt="썸네일1">
                                        <div class="commText">
                                            <div class="commUser">
                                                <span>작성자</span>
                                                <div class="scoreWrap">
                                                    <div class="nowScroe">
                                                        <span>첫온도36.5℃</span>
                                                    </div>
                                                    <div class="scoreFace">
                                                        <span class='temp'>36.5℃</span>
                                                        <img class="temp2" src="../assets/ico/normal.svg" alt="기본온도아이콘">
                                                        <span>36.5℃</span> -->
                                                    <!-- </div>
                                                    <div class="w3-light-grey"><div class='w3-green temp__js' style='height: 7px; width:36.5%; border-radius: 8px;'></div></div> -->
                                                        <!-- <div class="w3-green" style="height:7px;width:36.5%;border-radius: 8px;"></div> -->
                                                    <!-- <div class="scoreBor">
                                                        <div class="w3-green" style="height:24px;width:25%"></div>
                                                    </div> -->
                                                <!-- </div>
                                            </div>
                                            <h4>제목</h4>
                                            <span>작성일자</span>
                                            <ul>
                                                <li>조회수</li>
                                                <li>댓글</li>
                                            </ul>
                                        </div>
                                    </a>
                                </div>  -->
                                    
                            </div>
                            <div class="board-page">
                                <ul>
                                    <?php
                                        $sql = "SELECT count(myBoardID) FROM gPlanBoard";
                                        $result = $connect -> query($sql);
                                        $boardTotalCount = $result -> fetch_array(MYSQLI_ASSOC);
                                        $boardTotalCount = $boardTotalCount['count(myBoardID)'];
                                        // echo "전체 갯수 : " .$boardTotalCount;
                                        // 총 페이지 수
                                        $boardTotalPage = ceil($boardTotalCount/$numView);
                                        // echo "총 페이지 수 : " .$boardTotalPage;
                                        // 1 2 3 4 5 6 7 8 9 10 11
                                        // 현재 페이지를 기준으로 보여주고 싶은 갯수 설정
                                        $pageView = 5;
                                        $startPage = $page - $pageView;
                                        $endPage = $page + $pageView;
                                        // 처음 페이지 초기화
                                        if($startPage < 1) $startPage = 1;
                                        // 마지막 페이지 초기화
                                        if($endPage >= $boardTotalPage) $endPage = $boardTotalPage;
                                        // 처음으로
                                        if($page != 1){
                                            echo "<li><a href='commBoard.php?page=1'>처음으로</a></li>";
                                        }
                                        // 이전 페이지
                                        if($page != 1){
                                            $prevPage = $page -1;
                                            echo "<li><a href='commBoard.php?page={$prevPage}'>이전</a></li>";
                                        }
                                        for($i=$startPage; $i<=$endPage; $i++){
                                            $active = '';
                                            if($i == $page) $active = "active";
                                            echo "<li class='{$active}'><a href='commBoard.php?page={$i}'>{$i}</a></li>";
                                        }
                                        // 다음 페이지
                                        if($page != $endPage){
                                            $nextPage = $page +1;
                                            echo "<li><a href='commBoard.php?page={$nextPage}'>다음</a></li>";
                                        }
                                        // 마지막으로
                                        if($page != $endPage){
                                            echo "<li><a href='commBoard.php?page={$boardTotalPage}'>마지막으로</a></li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
            </article>
        </section>
    </main>
    <!-- //contents -->
    <footer>
        <?php
            include "../include/footer2.php";
        ?>
    </footer>
    <script>
        const temp = document.querySelectorAll('.temp');
        const temp2 = document.querySelectorAll('.temp2');
        const outer = document.querySelectorAll('.w3-green');

        window.onload = function(){
            temp.forEach( (el,index)=>{
                const temper = parseInt(el.innerText.match(/\d+/));
                if( temper > 37){
                    temp2[index].src = "../assets/ico/good.svg"
                    el.style.color = 'red';
                    outer[index].classList.remove('w3-green');
                    outer[index].classList.add('w3-red');
                //37 보다 클때 레드   
                } else if ( temper < 36){
                    //37 보다 클때 36보다 작을때 블루
                    temp2[index].src = "../assets/ico/sad.svg"
                    el.style.color = 'blue';
                    outer[index].classList.remove('w3-green');
                    outer[index].classList.add('w3-blue');
                }
            });
        }
    </script>
    <!-- //footer -->
</body>
</html>