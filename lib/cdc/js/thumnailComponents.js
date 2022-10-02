//썸네일 Component
const imageFormComponents = {
    name : 'imageForm',
    props: {
       modelValue: {type: [Object, File]},
       src: {type: String, default: ""},
       bf_file: {type: File},
       isCatVanner: {type: Boolean, default: false},
    },
    data() {
        return {
            imgSrc: this.src,
            imgFile: null,
            del_files: [],
        }
    },
    mounted() {
        if(this.bf_file){
            this.imageLoad(this.bf_file);
        }
    },
    template : `
    <div class="drop-zone" 
    @dragenter.prevent 
    @dragover.prevent 
    @drop.prevent="onDrop($event)">
        <q-img 
            :src="imgSrc && imgSrc.startsWith('data') ? imgSrc : 'https://d29fhpw069ctt2.cloudfront.net/icon/image/37950/preview.svg'"
            outlined
            spinner-color="primary" spinner-size="82px" 
            @click="filePick"
            :ratio="16/9"
            width="100%"
            height="100%"
            fit="contain"
            style="border: 2px solid black;"
            >
            <q-icon 
                v-if="modelValue"
                class="absolute all-pointer-events" 
                size="sm" 
                name="cancel" 
                color="red" 
                style="top: 8px; right: 8px"
                @click.stop="removeImage"
                >
                <q-tooltip>이미지삭제</q-tooltip>
            </q-icon>
        </q-img>
      
        <q-file
                type="file"
                name="cdc_file[]"
                ref="file" color="teal"
                :model-value="modelValue"
                v-model="imgFile"
                @update:model-value="emitValue"
                style="display: none;"
                accept="image/*"
        ></q-file>
    </div>
    ` ,
    created(){},
    computed: {},
    watch : {
        src() {
            this.imgSrc = this.src;
        },
        modelValue() {
            if(!this.modelValue) {
                this.imgSrc = this.src;
                return;
            }
            this.imageLoad(this.modelValue);
        }
    },
    methods : {
        emitValue(val){
            this.$emit("update:modelValue", val);
        },

        // file Dialog Open
        filePick(){
            this.$refs.file.pickFiles();
        },

        imageLoad(file){
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imgSrc = e.target.result;
            }
            reader.readAsDataURL(file);

            //form 데이터 작성시 cdc_files[] Value값을 인식하는 용도로 사용
            if(!this.imgFile){
                this.imgFile = file;
            }
        },

        removeImage(){
            const imgFile = this.imgFile;
            this.imgFile = null;
            this.$emit('update:modelValue', null);
            this.$emit('remove', imgFile);
        },

        async onDrop(ev){
            const items = (ev.dataTransfer.items);
            const files = await getAllFileEntries(items);
            this.$emit('update:modelValue', files[0]);
        }

    }
}


{/* <q-img 
:src="imgSrc && imgSrc.startsWith('data') ? imgSrc : 'https://d29fhpw069ctt2.cloudfront.net/icon/image/37950/preview.svg'"
outlined
@click="filePick"
spinner-color="primary" spinner-size="82px" 
width="300px"
height="300px"
style="display: block; margin-left: auto; margin-right: auto;">
</q-img> */}