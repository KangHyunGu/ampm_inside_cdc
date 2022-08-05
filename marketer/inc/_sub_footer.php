<?php
if (G5_IS_MOBILE) {	//모바일인 경우
?>

<?php
    //상담신청
    include(G5_MARKETER_PATH.'/inc/m_quick.php');
?>

<footer id="m_sub-footer">
    <div class="wrap">
        <div class="tel">
            <h5>전화문의</h5> 
            <a href="tel:<?=$_MARKETER_TEL?>" alt="전화"><?=$_MARKETER_TEL?></a>
            <p> 평일 09시~18시 (점심시간 12시~13시) <br>토, 일, 공휴일 휴무</p>
        </div>

        <div class="ft-link">
            <span>(주)에이엠피엠글로벌</span><span>김종규</span><br>
            <span>사업자등록번호:105-86-67746</span><br>
            <span>FAX:0505-842-112~4, 0505-840-1122~4</span><br>
            <span>서울특별시 금천구 가산디지털1로 171, <br>가산 SK V1센터 1001~18호</span>
            <span>담당 마케터:<?=$_MARKETER_NAME?></span><br>
            <span>E-mail:<a href="mailto:<?=$_MARKETER_EMAIL ?>" alt="메일"><?=$_MARKETER_EMAIL?></a></span>
        </div>
        
        <div class="ft-copy">
            Copyright © 2022 AMPM Global. All rights reserved.
            
            <!--
            <span>
                <?php
                    if($member['mb_id']){
                ?>
                    <a href="<?=G5_MARKETER_URL?>/adm">[마케터 관리모드]</a>
                    <a href="<?=G5_MARKETER_BBS_URL?>/logout.php?utm_member=<?=$member['mb_id']?>">[마케터 로그아웃]</a>
                    <?php
                    }else{
                ?>
                    <a href="<?=G5_MARKETER_BBS_URL?>/login.php?url=%2Fmarketer%2Fadm&utm_member=<?=$utm_member?>">[마케터 로그인]</a>
                    <?php
                    }
                ?>
            </span>
            -->
        </div>
        
        <!--
        <button type="button" id="top_btn"><img src="<?=G5_MARKETER_URL ?>/images/top.png"></button>
        -->
    </div>
</footer>


<?php
}else{	//PC인 경우
?>

<div id="ft-btn">
    <div class="ft-btn-inner">
        <button type="button" class="btn-1 popup-btn" data-toggle="modal" data-target="#Modal1"><i class="fas fa-comment-alt"></i></button>
        <button type="button" class="btn-2 top-btn"><i class="fas fa-arrow-up"></i></button>
    </div>

    <div id="modal-inquiry">
        <div class="popup-inner">
            <?php
                //상담신청
                include(G5_MARKETER_PATH.'/inc/quick.php');
            ?>
        </div>
    </div>
</div>

<footer id="sub-footer">
    <div class="wrap">
       
        <div class="ft-link">
            <span>회사명. (주)에이엠피엠글로벌</span>
            <span class="none">대표. 김종규</span><br>
            <span>주소. 서울특별시 금천구 가산디지털1로 171, 가산 SK V1센터 1001~18호</span>
            <span class="none">FAX. 0505-842-112~4, 0505-840-1122~4</span><br>
            <span>사업자등록번호. 105-86-67746</span>
            <span>통신판매업신고번호. 제 2020-서울금천-2858호</span>
            <span class="none">담당 마케터. <?=$_MARKETER_NAME?> (<a href="mailto:<?=$_MARKETER_EMAIL ?>" alt="메일"><?=$_MARKETER_EMAIL?></a>)</span>

            <p>
                Copyright © 2019 AMPM Global. All rights reserved.
                <span class="none">
                <?php
                        if($member['mb_id']){
                    ?>
                        <a href="<?=G5_MARKETER_URL?>/adm">[마케터 관리모드]</a>
                        <a href="<?=G5_MARKETER_BBS_URL?>/logout.php?utm_member=<?=$member['mb_id']?>">[마케터 로그아웃]</a>
                        <?php
                        }else{
                    ?>
                        <a href="<?=G5_MARKETER_BBS_URL?>/login.php?url=%2Fmarketer%2Fadm&utm_member=<?=$utm_member?>">[마케터 로그인]</a>
                        <?php
                        }
                    ?>
                </span>
            </p>
        </div>
        
        <div class="ft-site">
            <p>전화문의</p>
            <div class="tel">
                <h2><?=$mb['mb_tel'] ?></h2>
                <p>
                    · 평일 09시~18시 (점심시간 12시~13시)<br>
                    · 주말 및 공휴일 휴무
                </p>
            </div>
        </div>
    </div>
</footer>

<?php
}
?>