<?php
include(CDC_PATH . '/cdc_cdn_include.php');
?>

<div class="q-gutter-md">
  <!-- 주제 별 매체 
    인사이트 : 이미지
    영상교육 : 유튜브 태그
    위와 같은 경우엔 주제 별 매체에 해당되는 필드
  -->
  <div v-if="imgSrcs.length && 
            (bo_table == 'insight' || bo_table == 'insight_cdc')">
       <!-- 이미지(인사이트) -->
      <q-carousel v-model="slide2" transition-prev="slide-right" transition-next="slide-left" swipeable animated control-color="primary" navigation padding arrows infinite :fullscreen="fullscreen" height="300px" class="bg-grey-1 shadow-2 rounded-borders">
        <q-carousel-slide v-for="(imgSrc, index) in imgSrcs" :key="index" :name="index + 1" class="column no-wrap">
          <div class="row fit justify-start items-center q-gutter-xs q-col-gutter no-wrap">
            <q-img :ratio="1" fit="contain" class="full-width full-height" :src="imgSrc" />
          </div>
        </q-carousel-slide>
        <template v-slot:control>
          <q-carousel-control position="bottom-right" :offset="[18, 18]">
            <q-btn push round dense color="white" text-color="primary" :icon="fullscreen ? 'fullscreen_exit' : 'fullscreen'" @click="fullscreen = !fullscreen" />
          </q-carousel-control>
        </template>
      </q-carousel>
      <hr class="split" />
    </div>
    <!-- // 이미지(인사이트) -->

    <!-- 유튜브 태그(영상교육) -->
    <div v-if="wr_ytags.length && bo_table == 'video'">
        <div>
          <q-chip v-for="yTagVal in wr_ytags" :key="yTagVal" size="md" label="#">
            {{yTagVal}}
          </q-chip>
        </div>
        <hr class="split" />
    </div>
    <!-- //유튜브 태그(영상교육) -->
</div>

<div v-if="isViewAuth && cdcControlOptions.length">
  <div class="q-gutter-md">
    <hr class="split q-mb-md" />
        <div class="title_box q-mb-md">
            
        </div>
      <div class="q-pa-md">
       
       <!--  -->
        <div class="q-gutter-y-md">
          <q-btn-toggle
              v-model="cdcControlVal"
              spread
              no-caps
              toggle-color="purple"
              color="white"
              text-color="black"
              :options="cdcControlOptions"
          /> 
        </div>
      </div>
    <div v-if="imgSrcs.length && isImageView">
      <div class="title_box q-mb-md">
        <h3>이미지</h3>
      </div>
      <q-carousel v-model="slide" transition-prev="slide-right" transition-next="slide-left" swipeable animated control-color="primary" navigation padding arrows infinite :fullscreen="fullscreen" height="300px" class="bg-grey-1 shadow-2 rounded-borders">
        <q-carousel-slide v-for="(imgSrc, index) in imgSrcs" :key="index" :name="index + 1" class="column no-wrap">
          <div class="row fit justify-start items-center q-gutter-xs q-col-gutter no-wrap">
            <q-img :ratio="1" fit="contain" class="full-width full-height" :src="imgSrc" />
          </div>
        </q-carousel-slide>


        <template v-slot:control>
          <q-carousel-control position="bottom-right" :offset="[18, 18]">
            <q-btn push round dense color="white" text-color="primary" :icon="fullscreen ? 'fullscreen_exit' : 'fullscreen'" @click="fullscreen = !fullscreen" />
          </q-carousel-control>
        </template>
      </q-carousel>
      <hr class="split" />
    </div>
    <!-- 썸네일 -->
    <div v-if="thumSrc && isYoutubeView">
      <div class="title_box q-mb-md">
        <h3>썸네일</h3>
      </div>
      <div class="row items-start">
        <q-img :src="thumSrc" style="height: 300px;" fit="contain">
        </q-img>
      </div>
      <hr class="split" />
    </div>
    <!-- //썸네일 -->
    <!-- CTA배너 -->
    <div v-if="catSrc && isBlogView_1">
      <div class="title_box q-mb-md">
        <h3>CTA배너</h3>
      </div>
      <div class="row items-start">
        <q-img :src="catSrc" style="width:100%; height: 250px;" fit="contain" @click="clickToAction">
          <q-icon class="absolute all-pointer-events" size="md" name="link" color="primary" style="bottom: 8px; right: 8px">
            <q-tooltip>해당 이미지 클릭시 {{wr_cat_link}}로 이동합니다.</q-tooltip>
          </q-icon>
        </q-img>
      </div>
      <hr class="split" />
    </div>
    <!-- //CTA배너 -->
    <!-- 동영상(15 ~ 60) -->
    <div v-if="(enableVideo(wr_video_link) || video_file_info) && isBlogView_1">
      <div class="title_box q-mb-md">
        <h3>동영상</h3>
      </div>
      <q-video v-if="enableVideo(wr_video_link)" :ratio="16/9" :src="enableVideo(wr_video_link)"></q-video>

      <q-field class="q-py-md" v-if="video_file_info" filled square :dense="dense">
        <template v-slot:control>
          <div class="self-center full-width no-outline" tabindex="0">
            <h3>첨부파일</h3>
            <a href="<?php echo $view['cdc']['file'][12]['href'] . '&clcd=cdc'; ?>">
              <p>· {{skinViews.cdc.file[12].source}}</p>
            </a>
          </div>
        </template>
      </q-field>

      <hr class="split" />
    </div>
    <!-- //동영상(15 ~ 60) -->
    <!-- 유튜브영상 -->
    <div v-if="(enableVideo(wr_youtube_link) || youtube_file_info) && isYoutubeView">
      <div class="title_box q-mb-md">
        <h3>유튜브영상</h3>
      </div>
      <q-video v-if="enableVideo(wr_youtube_link)" :ratio="16/9" :src="enableVideo(wr_youtube_link)"></q-video>

      <q-field class="q-py-md" v-if="youtube_file_info" filled square :dense="dense">
        <template v-slot:control>
          <div class="self-center full-width no-outline" tabindex="0">
            <h3>첨부파일</h3>
            <a href="<?php echo $view['cdc']['file'][13]['href'] . '&clcd=cdc'; ?>">
              <p>· {{skinViews.cdc.file[13].source}}</p>
            </a>
          </div>
        </template>
      </q-field>

      <hr class="split" />
    </div>

    <!-- 재생목록 -->
    <div v-if="wr_playlist_link && isYoutubeView">
      <div class="title_box q-mb-md">
        <h3>재생목록</h3>
      </div>
      <a :href="wr_playlist_link" target="blank">
        {{wr_playlist_link}}
      </a>
      <hr class="split" />
    </div>
    <!-- //재생목록 -->

    <!-- 해시태그(메인, 서브) -->
    <div v-if="hashTagInfos.length && isViewAuth">
      <div class="title_box q-mb-md">
        <h3>해시태그</h3>
      </div>
      <div>
        <q-chip v-for="hashTag in hashTagInfos" :key="hashTag" class="ml-2" size="md" label="#">
          {{hashTag}}
        </q-chip>
        <hr class="split" />
      </div>
    </div>
    <!-- //해시태그(메인, 서브) -->
    <!-- 유튜브 태그 -->
    <div v-if="wr_ytags.length && isYoutubeView">
      <div class="title_box q-mb-md">
        <h3>유튜브태그</h3>
      </div>
      <div>
        <q-chip v-for="yTagVal in wr_ytags" :key="yTagVal" size="md" label="#">
          {{yTagVal}}
        </q-chip>
      </div>
      <hr class="split" />
    </div>
    <!-- //유튜브 태그 -->
  </div>
</div>


