//카테고리 Component
const inputVedioComponents = {
    name : 'inputvideo',
    props: {
        modelValue: {
            type: String,
            default: '',
        }
    },
    data() {
        return{
            linkSrc : '',
            orgSrc: '',
        }
    },
    template : `
   <div class="q-pa-md"> 
        <q-Video
            :ratio="16/9"
            :src="linkSrc"
            />
    </div>
    <div class="q-qutter-md row items-start">
        <q-field>
            <q-input 
                type="text"
                name="wr_youtube_link"
                :model-value="modelValue"
                @update:model-value="emitValue"
                lebel="영상링크 입력해주세요"
                :dense="dense"
                v-model="orgSrc"
            />
        </q-field>
    </div>
    ` ,
    computed: {},
    watch: {
        modelValue(){
            console.log(this.modelValue);
        }
    },
    methods : {
        emitValue(val){
            this.$emit('update:modelValue', val);
        },
    }
}