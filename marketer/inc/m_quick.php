<div id="m_quick">
    <button type="button" class="btn-1 popup-btn" data-toggle="modal" data-target="#Modal1"><i class="fas fa-comment-alt"></i></button>
</div>

<div id="m_quick_open">
    <div class="black">
    </div>
    <ul class="icon">
         <li>
           <a href="tel:<?=G5_PHONENUMBER?>"><span>전화상담</span><img src="<?=G5_MARKETER_URL?>/images/quick_icon2.png" alt=""></a>
         </li>
         <li>
            <a href="/ae-<?=$utm_member?>/estimate/<?php if($team_code){ echo "&team_code=".$team_code; }?>"><span>문의하기</span><img src="<?=G5_MARKETER_URL?>/images/quick_icon3.png" alt=""></a>
         </li>
    </ul>
    <div class="close">
        <img src="<?=G5_URL?>/images/quick_icon4.png" alt="">
    </div>
</div>

<script>
   $('#m_quick').click(function(){
      $('#m_quick_open').addClass('on');
         $(this).addClass('on');
   });

   $('#m_quick_open .close').click(function(){
      $('#m_quick_open').removeClass('on');
      $('#m_quick').removeClass('on');
   });
</script>