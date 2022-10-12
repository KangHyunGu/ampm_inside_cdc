<section class="section_right">
   <div class="fixed">
      <!-- inc_login.php 로그인 영역 -->
      <?php include(G5_PATH.'/inc/_inc_login.php'); ?>

      <!-- 질문답변 인기순/최신순 8개 -->
      <div class="main_qna">
         <div class="title_box">
            <h3>질문답변</h3>
            <a href="<? G5_URL ?>/bbs/board.php?bo_table=qna" class="qna_more">더보기 <span>></span></a>
            <div class="main_tab">
               <ul class="main_tab_nav">
                  <li class="tab_link active" data-tab="tab-5">인기순</li>
                  <li class="tab_link" data-tab="tab-6">최신순</li>
               </ul>
            </div>
         </div>
         <div class="main_tab_con">
            <!-- 인기순 -->
            <div id="tab-5" class="tab_content active">
                <?php echo latest_popular("pop_qna", 'qna', 8, 23, 1, 'wr_hit desc', 'Y');?>
            </div>
            <!-- 최신순-->
            <div id="tab-6" class="tab_content">
                <?php echo latest("list_qna", 'qna', 8, 23);?>
            </div>
         </div>
      </div>

      <!-- 레퍼런스 인기순/최신순 3개-->
      <div class="main_reference">
         <div class="ref_tab_area">
            <div class="main_tab2">
               <ul class="main_tab_nav2">
                  <li class="tab_link active" data-tab="tab-7">인기 레퍼런스</li>
                  <li class="tab_link" data-tab="tab-8">최신 레퍼런스</li>
               </ul>
            </div>
            <!-- 인기순-->
            <div id="tab-7" class="tab_content active">
               <?php echo latest_popular('pop_reference', 'reference', 3, 14, 1, 'wr_hit desc', 'Y');?>
            </div>
            <!-- 최신순 -->
            <div id="tab-8" class="tab_content">
               <?php echo latest('list_reference', 'reference', 3, 14);?>
               </ul>
            </div>
         </div>
      </div>
      <div class="ref_banner">
         <a href="<? G5_URL ?>/bbs/board.php?bo_table=reference">
            <img src="<? G5_URL ?>/images/min_banner.jpg" alt="레퍼런스 더보기">
         </a>
      </div>
   </div>
</section>