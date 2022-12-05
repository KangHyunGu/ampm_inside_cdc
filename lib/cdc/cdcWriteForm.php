    <!-- 이미지 -->
    <tr v-show="isImageForm">
        <th scope="row">
            <span style="color: red;" v-if="required.indexOf('cdc_files[]') != -1"> * </span>
            <label for="">이미지</label>
        </th>
        <td>
            <q-field :model-value="bf_file" ref="images" :rules="mandatory('cdc_files[]', '이미지')" :reactive-rules="true">
                <template v-slot:control>
                    <div class="q-gutter-md row items-start full-width">
                        <imageform v-for="i in 10" :key="i" v-model="bf_file[i - 1]" :bf_file="bf_file[i - 1]" :add_icon_size="'60px'" @remove="removeImageFile" style="height:100px;">
                        </imageform>
                    </div>
                </template>
            </q-field>
        </td>
    </tr>

    <!-- 썸네일 -->
    <tr v-show="isThumNail">
        <th scope="row"><label for="">썸네일</label></th>
        <td>
            <imageform v-model="bf_file[10]" :bf_file="bf_file[10]" :add_icon_size="'150px'" @remove="removeImageFile" style="width:50%; height:300px;"/>
        </td>
    </tr>

    <!-- CTA 배너 -->
    <tr v-show="isCtaVanner">
        <th scope="row"><label for="">CTA배너</label></th>
        <td>
            <imageform v-model="bf_file[11]" :bf_file="bf_file[11]" :add_icon_size="'150px'" @remove="removeImageFile" style="width:50%; height:300px;">
            </imageform>
            <div v-if="bf_file[11]" class="q-gutter-md row items-start">
                <q-input name="wr_cat_link" class="q-input" style="margin-top:20px;" outlined v-model="form.cdc.wr_cat_link" label="클릭 링크를 입력해주세요" dense size="90">
                </q-input>
            </div>
        </td>
    </tr>

    <!-- 동영상 15 ~ 60 -->
    <tr v-if="isShortVideo">
        <th scope="row">동영상(15~60초)</th>
        <td>
            <inputvideo 
                v-model="form.cdc.wr_video_link" ref="inputvideo" 
                :bf_file="bf_file[12]" @uploader-video="uploaderVideo($event, 'bf_file', 12)" 
                :isMode="<?php echo $w == 'u' ?>" :file_info="videoFileInfos[0]" @file_state_video="uploadingFileControl" 
                style="width:50%; height:300px;"/>
        </td>
    </tr>

    <!-- 유튜브 동영상 -->
    <tr style="max-height:250px;" v-if="isYoutubeVideo">
        <th scope="row">
            <span style="color: red;" v-if="required.indexOf('wr_youtube_link') != -1"> * </span>
            유튜브 동영상
        </th>
        <td>
            <inputvideo 
                :clcd="'youtube'"       
                ref="inputvideoYoutube" 
                v-model="form.cdc.wr_youtube_link" 
                :bf_file="bf_file[13]" 
                :isMode="<?php echo $w == 'u' ?>" 
                :file_info="videoFileInfos[1]" 
                @uploader-video="uploaderVideo($event, 'bf_file', 13)" 
                @file_state_video="uploadingFileControl"/>
        </td>
    </tr>

    <!-- 해시태그(최대 30개) 개선사항 요청(2022.12.05)-->
    <tr v-if="isHashTags">
        <th scope="row">해시태그</th>
        <td>
            <div class="q-gutter-md">
                <div class="row items-start">
                    <q-select label="해시태그(해시태그 구분시 Enter키를 이용해주시기 바랍니다.)" v-model="hashs" use-input use-chips outlined multiple hide-dropdown-icon input-debounce="0" @new-value="addHashTags" dense size="90" />
                </div>
            </div>
        </td>
    </tr>

    <!-- 유튜브 태그 -->
    <tr v-if="isYtag">
        <th scope="row">
            <span style="color: red;" v-if="required.indexOf('wr_ytag') != -1"> * </span>
            유튜브 태그
        </th>
        <td>
            <div class="q-gutter-md row items-start" style="width:100%;">
                <q-select label="유튜브 태그(해시태그 구분시 Enter키를 이용해주시기 바랍니다.)" :rules="mandatory('wr_ytag', '유튜브 태그')" :lazy-rules="true" v-model="ytags" use-input use-chips outlined multiple hide-dropdown-icon input-debounce="0" @new-value="addYtags" dense size="90" />
            </div>
        </td>
    </tr>

    <!-- 재생목록 -->
    <tr v-if="isYoutubeVideo">
        <th scope="row">재생목록</th>
        <td>
            <div class="q-gutter-md row items-start">
                <q-input name="wr_playlist_link" outlined v-model="form.cdc.wr_playlist_link" label="영상재생목록 URL링크 입력하세요" dense size="90">
                </q-input>
            </div>
        </td>
    </tr>