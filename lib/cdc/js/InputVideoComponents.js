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
        }
    },
    data() {
        return {
            linkSrc: '',
            orgSrc: '',
        }
    },
    template:
    `<div class="q-pa-md" v-if="linkSrc != ''"> 
        <q-video
            :ratio="16/9"
            :src="linkSrc"
            />
    </div>
    <div class="q-gutter-md row items-start">
            <q-input 
                type="text"
                class="q-input"
                :name="clcd=='short' ? 'wr_video_link' : 'wr_youtube_link'"
                :model-value="modelValue"
                outlined
                @update:model-value="emitValue"
                label="영상링크 입력해주세요"
                :dense="true"
                :rules="[Rules.require({label: '영상정보'})]"
                v-model="orgSrc"
                size="100"
            />
            </q-input>
    </div>
    ` ,
    computed: {
        Rules: () => rules,
    },
    watch: {
        modelValue() {
            this.enableVideo();
        }

    },
    mounted(){
        if(this.modelValue){
            this.orgSrc = this.modelValue;
            this.enableVideo();
        }
    },
    methods: {
        emitValue(val) {
            this.$emit('update:modelValue', val);
        },
        enableVideo(){
            let url = this.modelValue;
            if(this.clcd == 'short'){
                return
            }
            // 유튜브 동영상 
            const youtubeUrl = /(http:|https:)?(\/\/)?(www\.)?(youtube.com|youtu.be)\/(watch|embed)?(\?v=|\/)?(\S+)?/g
            // 네이버 TV
            const naverTvUrl = /(http:|https:)?(\/\/)?(www\.)?(tv.naver.com|m.tv.naver.com)\/(\?v=|\/)?(\S+)?/g;
            if (url.match(youtubeUrl)) {
                // 유튜브 동영상
                url = url.replace('watch', 'embed');
                url = url.replace('?v=', '/');
            } else if (url.match(naverTvUrl)) {
                // 네이버 TV
                url = url.replace('/v/', '/embed/');
            } else {
                url = '';
            }
            this.linkSrc = url;
            return;
        },
    },
}