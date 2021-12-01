<main id="smain">
    <article class="content-article">
        <section class="schedule">
            <div class="route">
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
                <?php
                    $title = $_GET['title'];
                    $content = $_GET['planContent'];
                    $gps = $_GET['gps'];
                    $planID = $_GET['planID'];
                ?>
                <form method="post">
                
                    <input type="text" name="gps" style="display: none;">
                    <? echo "<textarea name='title' class='wrap title' readonly>{$title}</textarea>" ?>
                    <h3> 소개</h3>
                    <? echo "<textarea name='desc' cols='30' rows='10' class='wrap intro' readonly>{$content}</textarea>" ?>
                    <?
                        if(!$noShow){
                            echo "<input name='planID' style='display:none' value='{$planID}'/>";
                            echo   "<div class='comment-wrap'>";
                            echo        "<span class='comment white'>";
                            echo            "<button class='js__submit' type='submit' formaction='./mainRemove.php'>일정 삭제하기</button>";
                            echo        "</span>";
                            echo        "<span class='comment'>";
                            echo            "<button class='js__submit' type='submit' formaction='./mainShare.php'>일정 공유하기</button>";
                            echo        "</span>";
                            echo    "</div>";
                        }
                    ?>
                </form>
            </div>
        </section>
        <section class="map">
            <div id="map" style="width:100%;height:100%;"></div>
        </section>
    </article>
</main>
<!-- contents -->
<?php
    if(!$noShow){
        echo "<footer>";
            include "../include/footer2.php";
        echo "</footer>";
    }
?>
<!-- footer -->