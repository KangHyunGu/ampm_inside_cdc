<?php
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/register.lib.php');
?>

<div class="mk-quick_wrap">
    <div id="mk-quick">

        <div class="customer_box">
            <h1>빠른상담 신청하기</h1>

            <form name="frmMain1" id="frmMain1">
                <input type="hidden" name="proc_mode" id="proc_mode1" value="edit">
                <input type="hidden" name="bo_table" value="mkestimate">
                <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
				<input type="hidden" name="utm_member" value="<?php echo $utm_member ?>">
				<input type="hidden" name="wr_9" value="pc">
				<input type="hidden" name="wr_10" value="접수">
				<input type="hidden" name="team_code" value="<?php echo $team_code ?>">

                <ul>
                    <li class="name"><input type="text" name="companyName" id="companyName1" title="성명 또는 회사명" placeholder="성명 또는 회사명을 입력해주세요."></li>
                    <li class="etc">
                        <select name="selltype" id="selltype1">
                        <option value="">:: 광고매체 ::</option>
                        <?=codeToHtml($code_selltype, $selltype, "cbo", "")?>
                        </select>
                    </li>
                    <li class="tel clearfix">
                        <select name="memberHp1" id="memberHp11">
                            <?=codeToHtml($code_phone, $memberHp1, "cbo", "")?>
                        </select>
                        <input name="memberHp2" id="memberHp21" maxlength="4" title="전화번호 앞자리" style="margin:0 2%;">
                        <input name="memberHp3" id="memberHp31" maxlength="4" title="전화번호 뒷자리">
                    </li>

                    <li class="etc">
                        <select name="memberAmount" id="memberAmount1">
                        <option value="">:: 월 예상 광고비 ::</option>
                        <?=codeToHtml($code_monthPrice, $memberAmount, "cbo", "")?>
                        </select>
                    </li>
 <!--
                   <li class="code">
                        <script type="text/javascript" src="<?php echo G5_URL ?>/kcaptcha/md5.js"></script>
                        <script type="text/javascript" src="<?php echo G5_URL ?>/kcaptcha/jquery.kcaptcha.js"></script>
                        <fieldset id="captcha" class="captcha">
                            <legend><label for="writekey">자동등록방지</label></legend>
                            <img id='kcaptcha_image' border='0' style="cursor:pointer;">
                            <input type="text" name="writekey" id="writekey" required class="captcha_box required" size="6" maxlength="6">
                            <span id="captcha_info">자동등록방지 숫자를 순서대로 입력하세요.</span>
                        </fieldset>
                        <?php //echo captcha_html(); ?>
                    </li>
-->
                    <li class="agree">
                        <input type="checkbox" name="agreeSelect" id="agreeSelect1" value="Y">
                        <label>개인정보 수집 및 이용에 동의합니다. <a href="<?=G5_MARKETER_URL?>/inc/personal.php" target="_blank">[보기]</a></label>
                    </li>

                </ul>

                <div class="btn"><a href="javascript:" onclick="execSave1()">신청하기</a></div>
            </form>
        </div>

        <div class="bottom_tel">&#9742; 문의 : <?=$mb['mb_tel'] ?> </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //-------------------------------------------------------------------------------------------------------------------------------
    //	validate_Form()
    //-------------------------------------------------------------------------------------------------------------------------------
    function validate_Form1() {
        var proc_mode = "edit";

        if (isValid_Empty($("#companyName1").val())) {
            alert("성명 또는 회사명을 입력하세요.");
            $("#companyName1").focus();
            return false;
        }

        if (isValid_Empty($("#selltype1").val())) {
            alert("광고매체을 선택하세요.");
            $("#selltype1").focus();
            return false;
        }
       
        // 핸드폰
        if (isValid_Empty($("#memberHp11").val())) {
            alert("연락처 번호를 선택하세요.");
            $("#memberHp11").focus();
            return false;
        }
        if (isValid_Empty($("#memberHp21").val())) {
            alert("연락처 번호를 입력하세요.");
            $("#memberHp21").focus();
            return false;
        }
        if (isValid_Empty($("#memberHp31").val())) {
            alert("연락처 번호를 입력하세요.");
            $("#memberHp31").focus();
            return false;
        }
        var memberHp = $.trim($("#memberHp11").val()) + "-" + $.trim($("#memberHp21").val()) + "-" + $.trim($("#memberHp31").val());
        if (isValid_Phone("", memberHp) == false) {
            alert("번호 형식에 맞지 않습니다.\r\n올바른 연락처 번호를 입력해주세요.");
            return false;
        }

		if (isValid_Empty($("#memberAmount1").val())) {
            alert("월 예상 광고비를 선택하세요.");
            $("#memberAmount1").focus();
            return false;
        }


        /*
		var rdo_selltype = $('input:radio[name="selltype"]:checked').val();
		if ( isValid_Empty(rdo_selltype) )	{
			alert("관심상품을 선택을 선택해 주십시오.");	$("#selltype").focus();	return false;
		}

        //자동등록방지
        if (isValid_Empty($("#writekey").val())) {
            alert("자동등록방지를 입력하세요.");
            $("#writekey").focus();
            return false;
        }

        if (!check_kcaptcha(document.frmMain1.writekey)) {
            return false;
        }
        */

        // 개인정보 취급
        var checkbox_agreeSelect = $(':checkbox[id="agreeSelect1"]:checked').val();

        if (isValid_Empty(checkbox_agreeSelect)) {
            alert("개인정보수집동의 선택하세요.");
            $("#agreeSelect1").focus();
            return false;
        }

        return true;
    }


    //-------------------------------------------------------------------------------------------------------------------------------
    //	저장
    //-------------------------------------------------------------------------------------------------------------------------------
    function execSave1() {
        if (validate_Form1()) {
            //$("#frmMain").attr("target", "ifrBlank");
            $("#frmMain1").attr("enctype", "multipart/form-data");
            $("#frmMain1").attr("action", "<?=G5_MARKETER_URL?>/inc/mkestimate_ok.php");
            $("#frmMain1").attr("method", "post");
            $("#frmMain1").submit();
        }
    }
    //-->

</script>
