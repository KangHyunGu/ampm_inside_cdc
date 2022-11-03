//썸네일 Component
const imageformComponents = {
    name: 'imageForm',
    props: {
        modelValue: { type: [Object, File] },
        src: { type: String, default: "" },
        bf_file: { type: File },
        add_icon_size: { type: String, default: '70px' },

        // reference에서 활용
        inputFileBlonk: { type: Boolean, default: false },
        imageName: { type: String, default: 'cdc_file[]' },
        imageTitle: { type: String, default: '' },
    },
    data() {
        return {
            imgSrc: this.src,
            imgFile: null,
            del_files: [],
        }
    },
    mounted() {
        if (this.bf_file) {
            this.imageLoad(this.bf_file);
        }
    },
    template: `
    <div class="drop-zone" 
    @dragenter.prevent 
    @dragover.prevent 
    @drop.prevent="onDrop($event)">
        
        <q-img 
            :src="imgSrc"
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
          
                <q-tooltip>이미지 삭제</q-tooltip>
            </q-icon>
            <q-icon
                v-else
                class="fixed-center absolute-center text-center"
                :size="add_icon_size"
                name="add_circle_outline"
            >
            </q-icon>

        </q-img>
      
        <q-file
                type="file"
                outlined
                name="cdc_file[]"
                :title="imageTitle"
                ref="file" color="teal"
                :model-value="modelValue"
                v-model="imgFile"
                @update:model-value="emitValue"
                :style="inputFileBlonk ? '' : 'display: none;'"
                accept="image/*"
        ></q-file>
    </div>
    ` ,
    created() { },
    computed: {},
    watch: {
        src() {
            this.imgSrc = this.src;
        },
        modelValue() {
            if (!this.modelValue) {
                this.imgSrc = this.src;
                return;
            }
            this.imageLoad(this.modelValue);
            this.imageFormValid();
        }
    },
    methods: {
        emitValue(val) {
            this.$emit("update:modelValue", val);
        },

        // file Dialog Open
        filePick() {
            this.$refs.file.pickFiles();
        },

        imageLoad(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imgSrc = e.target.result;
            }
            reader.readAsDataURL(file);

            //form 데이터 작성시 cdc_file[] Value값을 인식하는 용도로 사용
            this.imgFile = file;
        },

        removeImage() {
            const imgFile = this.imgFile;
            this.imgFile = null;
            this.$emit('update:modelValue', null);
            this.$emit('remove', imgFile);
        },

        async onDrop(ev) {
            const items = (ev.dataTransfer.items);
            const files = await getAllFileEntries(items);
            this.$emit('update:modelValue', files[0]);
        },
        imageFormValid() {
            // 이미지 폼 rule 체크
            vm.$refs.images.validate();
        }
    }
}