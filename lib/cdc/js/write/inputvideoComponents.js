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
    },
    data() {
        return {
            linkSrc: '',
            orgSrc: '',
            uploadSrc: '',
            uploaderFile: '',
            uploadType: "0",
        }
    },
    template:`

    <div class="q-pa-md" v-if="linkSrc != ''"> 
        <q-video
            ref="vedioObj"
            :ratio="16/9"
            :src="linkSrc"
            referrerpolicy="no-referrer"
            />
    </div>


        <div class="q-px-md q-py-md row items-start">
            <q-input 
                type="text"
                class="q-input"
                :name="clcd=='short' ? 'wr_video_link' : 'wr_youtube_link'"
                :model-value="modelValue"
                outlined
                :rules="[
                    v => !!v || !!uploaderFile || '영상링크 또는 파일업로드 둘 중 하나는 필수입니다.'
                ]"
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
                    :rules="[
                        v => !!v || !!modelValue || '영상링크 또는 파일업로드 둘 중 하나는 필수입니다.'
                    ]"
                    :reactive-rules="true"
                    label="영상파일 첨부"
                    :dense="true"
                    style="width:100%;"
                    accept="video/*"
                    >
                    <template v-slot:prepend>
                        <q-icon name="attach_file" />
                    </template>
                    <template v-slot:append>
                        <q-icon v-if="uploaderFile" @click.stop="uploadClear" name="cancel" />
                    </template>
                </q-file>
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

        uploadType() {
            if(this.uploadType == '1'){
                this.orgSrc = ''
                this.$emit('update:modelValue', '')
            } else {
                this.uploaderFile = '';
            }
            
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
            const youtubeUrl = /(http:|https:)?(\/\/)?(www\.)?(youtube.com|youtu.be)\/(watch|embed)?(\?v=|\/)?(\S+)?/g
            // 네이버 TV
            const naverTvUrl = /(http:|https:)?(\/\/)?(www\.)?(tv.naver.com|m.tv.naver.com)\/(\?v=|\/)?(\S+)?/g;
            if (url.match(youtubeUrl)) {
                // 유튜브 동영상
                if(url.split('&').length > 1){
                    url = url.split('&')[0];
                }
                url = url.replace('watch?v=', 'embed/');
            } else if (url.match(naverTvUrl)) {
                // 네이버 TV
                url = url.replace('/v/', '/embed/');
            } else {
                url = '';
            }
            this.linkSrc = url;
            return;
        },
        uploadClear(){
            this.uploaderFile = '';
        }
    },
}