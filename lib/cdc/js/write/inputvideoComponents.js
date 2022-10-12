//카테고리 Component
const inputVideoComponents = {
    name: 'inputvideo',
    props: {
        modelValue: {
            type: String,
            default: 'test',
        },

        // short(동영상) : youtube(유튜브 동영상)
        clcd : {
            type: String,
            default: 'short'
        },

        video_src : {
            type: String,
            default: '',
        },
        bf_file: {type: File},

        file_info: {type: Object, default: {}},

        // 입력 또는 수정
        isMode : {type: Boolean, default: false}
    },
    data() {
        return {
            linkSrc: '',
            orgSrc: '',
            uploadSrc: '',
            uploaderFile: '',
            isUploadDel: false,
        }
    },
    template:`

    <div class="q-pa-md" v-if="linkSrc != ''"> 
        <q-video
            ref="videoObj"
            :ratio="16/9"
            :src="linkSrc"
            referrerpolicy="no-referrer"
            />
    </div>
        <div class="q-px-md q-py-md row items-start">
            <q-input 
                type="text"
                ref="videoInput"
                class="q-input"
                :name="clcd=='short' ? 'wr_video_link' : 'wr_youtube_link'"
                :model-value="modelValue"
                outlined
                :rules="[Rules.videoRequired(modelValue, uploaderFile, clcd)]"
                :reactive-rules="true"
                @update:model-value="emitValue"
                label="영상링크 입력하세요"
                :dense="true"
                v-model="orgSrc"
                size="100"
            />
            </q-input>
        </div>

        <div class="q-px-md q-py-md row items-start">
                <q-file type="file"
                    outlined 
                    name="cdc_file[]"
                    v-model="uploaderFile"
                    :dense="true" 
                    :rules="[Rules.videoRequired(modelValue, uploaderFile, clcd)]"
                    :reactive-rules="true"
                    label="영상파일 첨부"
                    :dense="true"
                    style="width:100%;"
                    accept="video/*"
                    >
                    <template v-slot:prepend>
                        <q-icon name="attach_file" />
                    </template>
                </q-file>
            </div>
        <div class="q-px-md row items-start" v-if="file_info.source">
           <p :class="isUploadDel ? 'text-strike' : ''">영상 첨부 파일 : {{file_info.source}}({{file_info.size}})</p>
           <q-icon 
                @click="uploadState" 
                :name="isUploadDel ? 'undo' : 'cancel'" 
                :color="isUploadDel ? 'primary' : 'red'"
                style="right: -157px; top: -8px;">
                <q-tooltip>{{isUploadDel ? '삭제 취소' : '영상첨부 파일 삭제'}}</q-tooltip>
            </q-icon>
        </div>
    ` ,
    computed: {
        Rules: () => rules,
    },
    watch: {
        modelValue() {
            this.enableUrlVideo();
        },

        uploaderFile() {
            this.$emit('uploader-video', this.uploaderFile);
        },
        file_info(){
            console.log(this.file_info);
        },
        isMode(){
            console.log(this.isMode);
        }
    },
    mounted(){
        if(this.modelValue){
            if(!this.orgSrc){
                this.orgSrc = this.modelValue;
            }
            this.enableUrlVideo();
        }   
    },
    methods: {
        emitValue(val) {
            this.$emit('update:modelValue', val);
        },
        loadVedio(file){
            //cdcCommon:fileLoadVideoUrl(file);
            const objectURL = fileLoadVideoUrl(file);
            this.linkSrc = objectURL;
        },
        enableUrlVideo(){
            let url = this.modelValue;
            // 유튜브 동영상 
            const youtubeUrl = /(http:|https:)?(\/\/)?(www\.)?(youtube.com|youtu.be)\/(watch|embed)?(\?v=|\/)?(\S+)?/g;
            // 네이버 TV
            const naverTvUrl = /(http:|https:)?(\/\/)?(www\.)?(tv.naver.com|m.tv.naver.com)\/(\?v=|\/)?(\S+)?/g;
            
            if (url.match(youtubeUrl)) {
                const parseUrl = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
                const match = url.match(parseUrl)
                // 유튜브 동영상
                const id = match[match.length - 1];
                //url = url.replace('watch?v=', 'embed/');
                url = `https://youtube.com/embed/${id}`
            } else if (url.match(naverTvUrl)) {
                // 네이버 TV
                url = url.replace('/v/', '/embed/');
            } else {
                url = '';
            }
            this.linkSrc = url;
            return;
        },
        // 파일 업로드 취소
        uploadClear(){
            const videoFile = this.uploaderFile;
            this.uploaderFile = '';
        },

        // 파일 업로드 삭제 및 삭제 취소
        uploadState(){
            this.isUploadDel = !this.isUploadDel;
            this.$emit('file_state_video', this.isUploadDel, this.file_info);
        }
    },
}