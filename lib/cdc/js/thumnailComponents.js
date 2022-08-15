//썸네일 Component
const thumnailComponents = {
    name : 'thumnail',
    props: {
       modelValue: {type: [Object, File]},
       src: {type: String, default: ""},
       bf_file: {type: File}
    },
    data() {
        return {
            imgSrc: this.src,
        }
    },
    template : `
        <q-img 
                :src="imgSrc && imgSrc.startsWith('data') ? imgSrc : 'https://d29fhpw069ctt2.cloudfront.net/icon/image/37950/preview.svg'"
                outlined
                @click="filePick"
                spinner-color="primary" spinner-size="82px" 
                width="400px"
                height="400px"
                style="display: block; margin-left: auto; margin-right: auto;">
        </q-img>
        <q-file 
                name="bf_file[]"
                ref="file" color="teal"
                :model-value="modelValue"
                @update:model-value="emitValue"
                style="display: none;"
                accept="image/*"
        ></q-file>
    ` ,
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

            const reader = new FileReader();
            reader.onload = (e) => {
                this.imgSrc = e.target.result;
            }
            reader.readAsDataURL(this.modelValue);
        }
    },
    methods : {
        emitValue(val){
            this.$emit("update:modelValue", val);
        },

        // file Dialog Open
        filePick(){
            console.log(this.$refs.file);
            this.$refs.file.pickFiles();
        }
    }
}