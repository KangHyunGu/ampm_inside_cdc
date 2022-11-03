<button @click="cdcModalClose" class="close-cdc">&times;</button>
<div class="cdc-title">CDC 업로드</div>
<div class="q-pa-md">
    <div class="q-gutter-y-20">
        <q-btn-toggle v-model="toggleVal" spread no-caps toggle-color="purple" color="white" @click="toggleBtn" text-color="black" :options="curOptions"></q-btn-toggle>
    </div>

    <hr class="split" />

    <div class="tbl_frm01 tbl_wrap" style="max-height: 600px; overflow: auto;" v-if="curList">
        <table>
            <tbody>
                <!-- 주제 -->
                <tr>
                    <th style="text-align:center;"><label for="">주제</label></th>
                    <td class="row">
                        <span>
                            <h1>{{curList.bo_subject}}</h1>
                        </span>
                    </td>
                </tr>
                <!-- //주제 -->

                <!-- 제목 -->
                <tr v-if="isCdcTitleView">
                    <th style="text-align:center;"><label for="">제목</label></th>
                    <td class="row">
                        <div class="col-md-11 text-h6" id="wr_cdc_title">
                            <span ref="wr_cdc_title">{{curList.wr_cdc_title}}</span>
                        </div>
                        <div class="col-md-1">
                            <q-btn @click="copy('wr_cdc_title', '제목')" push class="col-right" color="white" text-color="primary" size="sm" round icon="content_copy">
                                <q-tooltip>제목 Copy</q-tooltip>
                            </q-btn>
                        </div>
                    </td>
                </tr>
                <!-- //제목 -->

                <!-- 내용 -->
                <tr v-if="isCdcContentView">
                    <th style="text-align: center;"><label for="">내용</label></th>
                    <td class="row">
                        <div id="wr_cdc_content" class="col-md-11 bo_v_con">
                            <div v-html="curList.wr_cdc_content"></div>
                        </div>
                        <div class="col-md-1">
                            <q-btn @click="copy('wr_cdc_content', '컨텐츠 본문')" class="col-right" push color="white" text-color="primary" size="sm" round icon="content_copy">
                                <q-tooltip>내용 Copy</q-tooltip>
                            </q-btn>
                        </div>
                    </td>
                </tr>
                <!-- //내용 -->

                <!-- 이미지 -->
                <tr v-if="isCdcImgView">
                    <th style="text-align: center;"><label for="">이미지</label></th>
                    <td>
                        <q-carousel v-model="slide" transition-prev="slide-right" transition-next="slide-left" swipeable animated control-color="primary" navigation padding arrows infinite :fullscreen="fullscreen" height="300px" class="bg-grey-1 shadow-2 rounded-borders">
                            <q-carousel-slide v-for="(fileInfo, index) in curImgInfos" :key="index" :name="index + 1" class="column no-wrap">

                                <div class="row fit justify-start items-center q-gutter-xs q-col-gutter no-wrap">
                                    <q-img :ratio="1" fit="contain" class="full-width full-height" :src="fileInfo.imgSrc" />
                                </div>
                            </q-carousel-slide>
                            <template v-slot:control>
                                <!-- <q-carousel-control position="bottom-right">
                                        <q-btn push round dense color="white" text-color="primary" :icon="imgFullscreen ? 'fullscreen_exit' : 'fullscreen'" @click="imgFullscreen = true" />
                                    </q-carousel-control> -->
                            </template>
                        </q-carousel>
                        <hr class="split" />
                        <q-btn @click="allDownload" class="q-pa-md full-width">
                            이미지 전체 다운로드
                            <q-icon left size="sm" name="file_download" />
                        </q-btn>
                        <hr class="split" />
                        <div class="q-gutter-sm row items-center">
                            <q-img v-for="(fileInfo, index) in curImgInfos" :src="fileInfo.imgSrc" outlined spinner-color="primary" spinner-size="82px" :ratio="16/9" width="100px" height="100px" fit="contain" style="border: 2px solid black;">
                                <q-btn push color="white" class="absolute-bottom-right all-pointer-events" text-color="primary" size="sm" round icon="file_download" @click.stop="imgDownload(fileInfo.imgSrc, fileInfo.source)">
                                    <q-tooltip>{{fileInfo.source}} 다운로드</q-tooltip>
                                </q-btn>
                                <div class="absolute-top text-center" style="padding:0px">
                                    {{fileInfo.source}}
                                </div>
                            </q-img>
                        </div>
                    </td>
                </tr>
                <!-- //이미지 -->

                <!-- 썸네일 -->
                <tr v-if="isCdcThumNailView">
                    <th style="text-align: center;"><label for="">썸네일</label></th>
                    <td class="row">
                        <q-img :src="curThumNailImg.imgSrc" outlined ref="file" spinner-color="primary" spinner-size="82px" :ratio="16/9" width="100%" height="200px" fit="contain" style="border: 2px solid black;">
                            <q-btn push color="white" class="absolute-bottom-right all-pointer-events" text-color="primary" size="sm" round icon="file_download" @click.stop="imgDownload(curThumNailImg.imgSrc, curThumNailImg.source)">
                                <q-tooltip>{{curThumNailImg.source}} 다운로드</q-tooltip>
                            </q-btn>
                            <div class="absolute-top text-center" style="padding:0px">
                                {{curThumNailImg.source}}
                            </div>
                        </q-img>
                    </td>
                </tr>
                <!-- //썸네일 -->
                <!-- CTA 배너 -->
                <tr v-if="isCdcCtaImgView">
                    <th style="text-align: center;"><label for="">CTA 배너</label></th>
                    <td class="row">
                        <q-img :src="curCtaImg.imgSrc" outlined spinner-color="primary" spinner-size="82px" :ratio="16/9" width="100%" height="200px" fit="contain" @click="clickToAction" style="border: 2px solid black;">
                            <q-btn push color="white" class="absolute-bottom-right all-pointer-events" text-color="primary" size="sm" round icon="file_download" @click.stop="imgDownload(curCtaImg.imgSrc, curCtaImg.source)">
                                <q-tooltip>{{curCtaImg.source}} 다운로드</q-tooltip>
                            </q-btn>
                            <div class="absolute-top text-center" style="padding:0px">
                                {{curCtaImg.source}}
                            </div>
                        </q-img>

                        <div class="col-md-11">
                            <span>클릭 링크 :
                                <a :href="curList.wr_cat_link" target="blank">{{curList.wr_cat_link}}</a>
                            </span>
                        </div>
                        <div class="col-md-1">
                            <q-btn @click="copy('wr_cat_link', '클릭링크')" class="col-right" push color="white" text-color="primary" size="10px" round icon="content_copy">
                                <q-tooltip>클릭링크 Copy</q-tooltip>
                            </q-btn>
                        </div>
                    </td>
                </tr>
                <!-- //CTA배너 -->

                <!-- 동영상(10 ~ 15초) -->
                <tr v-if="isCdcVideoView">
                    <th style="text-align: center;"><label for="">동영상</label></th>
                    <td>
                        <div v-if="curList.wr_video_link">
                            <q-video :ratio="16/9" :src="enableVideo(curList.wr_video_link)" referrerpolicy="no-referrer">
                            </q-video>
                            <div class="q-py-md row">
                                <div class="col-md-11">
                                    <span>동영상 링크 :
                                        <a :href="curList.wr_video_link" target="blank">{{curList.wr_video_link}}</a>
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <q-btn @click="copy('wr_video_link', '유튜브 동영상 링크')" class="col-right" push color="white" text-color="primary" size="10px" round icon="content_copy">
                                        <q-tooltip>동영상 링크 Copy</q-tooltip>
                                    </q-btn>
                                </div>
                            </div>
                        </div>

                        <q-field class="q-py-md" v-if="curVideoInfos[0] && curVideoInfos[0].file" filled square>
                            <template v-slot:control>
                                <div class="self-center full-width no-outline" tabindex="0">
                                    <h3>첨부파일</h3>
                                    <!-- @click="imgDownload(curVideoInfos[0].src, curVideoInfos[0].source)" -->
                                    <div class="row">
                                        <div class="col-11">
                                            <span>· {{curVideoInfos[0].source}}</span>
                                        </div>
                                        <div class="col-1">
                                            <q-btn push color="white" class="absolute-bottom-right all-pointer-events" text-color="primary" size="sm" round icon="file_download" @click.stop="imgDownload(curVideoInfos[0].src, curVideoInfos[0].source)">
                                                <q-tooltip>{{curVideoInfos[0].source}}} 다운로드</q-tooltip>
                                            </q-btn>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </q-field>
                    </td>
                </tr>
                <!-- //동영상 -->

                <!-- 유튜브동영상 -->
                <tr v-if="isCdcYoutubeView">
                    <th style="text-align: center;"><label for="">유튜브 동영상</label></th>
                    <td>
                        <div v-if="curList.wr_youtube_link">
                            <q-video :ratio="16/9" :src="enableVideo(curList.wr_youtube_link)" referrerpolicy="no-referrer">
                            </q-video>
                            <div class="row">
                                <div class="col-md-11">
                                    <span>유튜브 동영상 링크 :
                                        <a :href="curList.wr_youtube_link" target="blank">{{curList.wr_youtube_link}}</a>
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <q-btn @click="copy('wr_youtube_link', '유튜브 동영상 링크')" class="col-right" push color="white" text-color="primary" size="10px" round icon="content_copy">
                                        <q-tooltip>유튜브 동영상 링크 Copy</q-tooltip>
                                    </q-btn>
                                </div>
                            </div>
                        </div>

                        <q-field class="q-py-md" v-if="curVideoInfos[1] && curVideoInfos[1].file" filled square :dense="dense">
                            <template v-slot:control>
                                <div class="self-center full-width no-outline" tabindex="0">
                                    <h3>첨부파일</h3>
                                    <a @click="imgDownload(curVideoInfos[1].src, curVideoInfos[0].source)">· {{curVideoInfos[1].source}}</a>
                                </div>
                            </template>
                        </q-field>
                    </td>
                </tr>
                <!-- //유튜브동영상 -->

                <!-- 해시태그-->
                <tr v-if="isCdcHashTagView">
                    <th style="text-align: center;"><label for="">해시태그</label></th>
                    <td class="row">
                        <div class="col-md-11">
                            <q-chip v-for="(hashTag, index) in curHashTags" :key="hashTag" class="ml-2" size="md" label="#">
                                {{hashTag}}
                            </q-chip>
                        </div>
                        <div class="col-md-1">
                            <q-btn @click="copy('wr_hashTag', '해시태그')" push class="col-right" color="white" text-color="primary" size="10px" round icon="content_copy">
                                <q-tooltip>해시태그 Copy</q-tooltip>
                            </q-btn>
                        </div>
                    </td>
                </tr>
                <!-- //해시태그-->

                <!-- 유튜브 태그-->
                <tr v-if="isCdcYoutubeTagView">
                    <th style="text-align: center;"><label for="">유튜브 태그</label></th>
                    <td class="row">
                        <div class="col-md-11">
                            <q-chip v-for="(ytag, index) in curYoutubeTags" :key="ytag" class="ml-2" size="md" label="#">
                                {{ytag}}
                            </q-chip>
                        </div>
                        <div class="col-md-1">
                            <q-btn @click="copy('wr_ytag', '유튜브 태그')" class="col-right" push color="white" text-color="primary" size="10px" round icon="content_copy">
                                <q-tooltip>유튜브 태그 Copy</q-tooltip>
                            </q-btn>
                        </div>
                    </td>
                </tr>
                <!-- //유튜브 태그-->
                <!-- 재생목록-->
                <tr v-if="isCdcPlayListView">
                    <th style="text-align: center;"><label for="">재생목록</label></th>
                    <td class="row">
                        <div class="col-md-11" style="max-width: 570px; overflow-x:auto;">
                            <a :href="curList.wr_playlist_link" target="blank">
                                {{curList.wr_playlist_link}}
                            </a>
                        </div>
                        <div class="col-md-1">
                            <q-btn @click="copy('wr_playlist_link', '재생목록')" class="col-right" push color="white" text-color="primary" size="10px" round icon="content_copy">
                                <q-tooltip>재생목록 Copy</q-tooltip>
                            </q-btn>
                        </div>
                    </td>
                </tr>
                <!-- //재생목록-->
            </tbody>
        </table>
    </div>
</div>