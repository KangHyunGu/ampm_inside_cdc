<div class="marketer-profile">
    <!-- 마케터 이미지 -->
    <div class="mkt-img">
        <?=$mb_images?>
    </div>

    <!-- 마케터 팀, 이름 -->
    <div class="mkt-name">
        <h3 class="main-color"><?=$mb_team?>팀</h3>
        <div class="name">
            <p class="ae"><?=$mb['mb_name'] ?></p>
            <div class="eng"><?=$mb['mb_ename'] ?></div>
        </div>
    <div>

    <!--자격증 있을경우 노출-->
    <?php if($mb['mb_license']){ ?>
        <div class="mkt-license">
            <ul>
            <?php
                //보유자격증
                $arrLicense = explode('|',$mb['mb_license']);

                foreach($arrLicense as $key=>$val)  
                {
                    unset($arrLicense[$key]);  

                    $License_newKey = $val;
                    $arrLicense[$License_newKey] = $val;

                    switch ($License_newKey) {
                        case '검색광고마케터1급': $license_img = "license-naver"; break;
                        case 'GAIQ구글애널리틱스': $license_img = "license-google"; break;
                        case '페이스북 블루프린트(FCBP)': $license_img = "license-facebook"; break;
                        case '마케터자격이수': $license_img = "license"; break;
                        default : $license_img = "license"; break;
                    }

                    echo '<li><img src="'.G5_MARKETER_URL.'/images/'.$license_img.'.png">'.$arrLicense[$License_newKey].'</li>';
                    
                    $i++;  
                }
            ?>
            </ul>
        </div>
    <?php } ?>
</div>