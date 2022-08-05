<?php
if (G5_IS_MOBILE) {	//모바일인 경우
?>

<footer id="m_footer">
    <div class="wrap">
        <div class="ft-link">
            <span>회사명. (주)에이엠피엠글로벌</span>
            <span>대표. 김종규</span><br>
            <span>주소. 서울특별시 금천구 가산디지털1로 171, <br>가산 SK V1센터 1001~18호</span>
            <span>FAX. 0505-842-112~4, 0505-840-1122~4</span><br>
            <span>사업자등록번호. 105-86-67746</span><br>
            <span>통신판매업신고번호. 제 2020-서울금천-2858호</span>

            <p>Copyright © 2019 AMPM Global. All rights reserved.</p>
        </div>
        
    </div>
</footer>


<?php
}else{	//PC인 경우
?>

<footer id="footer">
    <div class="wrap">
       
        <div class="ft-link">
            <span>회사명. (주)에이엠피엠글로벌</span>
            <span>대표. 김종규</span><br>
            <span>주소. 서울특별시 금천구 가산디지털1로 171, 가산 SK V1센터 1001~18호</span>
            <span>FAX. 0505-842-112~4, 0505-840-1122~4</span><br>
            <span>사업자등록번호. 105-86-67746</span>
            <span>통신판매업신고번호. 제 2020-서울금천-2858호</span>

            <p>Copyright © 2019 AMPM Global. All rights reserved.</p>
        </div>
        
        <div class="ft-site">
            <p>관련사이트</p>
            <div class="site">
                <a href="<?=G5_URL?>/main.php/<?=$teamLinkPara?>" target="_blank">
                    에이엠피엠글로벌 <i class="fas fa-external-link-alt"></i>
                </a>
                <a href="http://studio.ampm.co.kr/" target="_blank">
                    라이브 스튜디오 <i class="fas fa-external-link-alt"></i>
                </a>
                <a href="http://portfolio.ampm.kr/" target="_blank">
                    디자인 포트폴리오 <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

<?php
}
?>