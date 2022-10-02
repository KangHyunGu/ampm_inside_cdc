<?php
// E-mail 수정시 인증 메일 (회원님께 발송)
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<?php
$content = '
<!doctype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>임시 비밀번호 발급 메일</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin:0; padding: 0;">

<table border="0" cellpadding="0" cellspacing="0" width="650" align="center" style="font-family: \'Apple SD Gothic Neo\', \'Malgun Gothic\', \'맑은 고딕\', sans-serif; background: #fff; margin: 50px auto; border: 1px solid #eee; border-collapse: collapse;">
    <tbody>
        <tr>
            <td align="center" style="text-align: left;">
                <table border="0" cellpadding="0" cellspacing="0" width="650" style="padding: 40px 40px 0 40px;">
                    <tbody>
                        <tr>
                            <td style="width: 100%; padding-bottom: 15px; border-bottom: 1px solid #ddd">
                                <a href="http://inside.ampm.co.kr/" target="_blank" style="display: block; width: 220px; height: 36px;" width="220" height="36">
                                    <img src="https://postfiles.pstatic.net/MjAyMjA5MDdfMjQ3/MDAxNjYyNTI1OTQ0ODgw.Veo8PSG6zaBqIj9r3lTP6MXLfQP0cUmn1cNvxFoxll4g.K3ayUv-WrYi89IpNUcJSXNYgcYrxfaW1vFWFbt4prBEg.PNG.ampmglobal/logo.png?type=w966" />
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="650" style="padding: 0 40px;">
                    <tbody>
                        <tr>
                            <td height="60"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 28px; letter-spacing: -2.5px; color: #000; font-weight: 700;">
                                임시 비밀번호 발급 안내
                            </td>
                        </tr>
                        <tr>
                            <td height="40"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; line-height: 24px; letter-spacing: -1.5px; color: #000;">
                                안녕하세요. <span style="font-weight: 700;">{회원이름}</span> 회원님!<br/>
                                요청하신 임시 비밀번호가 발급되었습니다.<br/>
                                아래 비밀번호 변경 버튼 클릭 후 새로운 비밀번호로 변경 바랍니다.<br/>
                            </td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                        </tr>
                        <tr>
                           <td>
                               <table border="0" cellpadding="0" cellspacing="0" width="650" align="center" style="font-family: \'Apple SD Gothic Neo\', \'Malgun Gothic\', \'맑은 고딕\', sans-serif; background: #fff; border-collapse: collapse;">
                                 <tbody>
                                    <tr>
                                       <td width="120" height="30" style="font-size: 16px; letter-spacing: -1.5px; color: #000;">
                                          아이디
                                       </td>
                                       <td style="font-size: 16px; font-weight: 700; letter-spacing: -1.5px; color: #000;">
                                          {회원아이디}
                                       </td>
                                    </tr>
                                    <tr>
                                       <td width="120" height="30" style="font-size: 16px; letter-spacing: -1.5px; color: #000;">
                                          임시 비밀번호
                                       </td>
                                       <td style="font-size: 16px; font-weight: 700; letter-spacing: -1.5px; color: #f8295e;">
                                          {비밀번호}
                                       </td>
                                    </tr>
                                 </tbody>
                               </table>
                           </td>
                       </tr>
                       <tr>
                        <td height="40"></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{비밀번호변경}" target="_blank" style="display: inline-block; padding: 10px 20px; border-radius: 5px; background: #1acb86; color: #fff; font-size: 18px; text-align: center; text-decoration: none; letter-spacing: -1px; font-weight: 700;">
                                    비밀번호 변경하기
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td height="60"></td>
                        </tr>
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="650" style="padding: 0 40px; background: #f3f3f3;">
                    <tbody>
                        <tr>
                            <td height="40" style="padding:0 !important;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color: #555; font-weight: 600; padding: 0 !important;">
                                <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #555; font-size: 11px; text-align: center; line-height: 14px; border-radius: 100%;">!</span> 유의사항
                            </td>
                        </tr>
                        <tr>
                            <td height="5" style="padding:0 !important;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color: #666; line-height: 20px; padding-top: 10px; letter-spacing: -0.8px; padding:0 !important;">
                                - 본 메일은 마케팅 인사이드 회원님께 보내는 공지성 메일입니다.<br/>
                                - 발신전용으로 회신되지 않으니 궁금하신 사항은 <span style="color: #000; text-decoration: underline;">마케터</span>를 통해 문의하시기 바랍니다.
                            </td>
                        </tr>
                        <tr>
                            <td height="25" style="padding:0 !important;"></td>
                        </tr>
                        <tr>
                            <td height="1" width="100%" style="background:#ddd; padding:0 !important;"></td>
                        </tr>
                        <tr>
                            <td height="15" style="padding:0 !important;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color: #888; line-height: 20px; padding-top: 10px; letter-spacing: -0.8px; padding: 0 !important;">
                                ㈜에이엠피엠글로벌  |  사업자등록번호 : 105-86-67746  |  대표: 김종규<br/>
                                Copyright © <span style="color:#000;">MARKETING INSIDE</span>. All rights reserved.
                            </td>
                        </tr>
                        <tr>
                            <td height="40" style="padding:0 !important;"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

</body>
</html>
';
?>