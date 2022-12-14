//카테고리 Component
const categotyComponents = {
    name : 'category',
    props: {
        opts : {
            type: Array,
            default: [],
        },
        modelValue: {
            type: String,
            default: '',
        }
    },
    data() {
        return{
            group : '네이버'
        }
       
},
    template : `
    <div class="q-pa-sm">
        <q-option-group
            size="xs"
            v-model="group"
            @update:model-value="emitValue"
            :options="opts"
            color="primary"
            inline
            dense
        />   
    </div>
    ` ,
    mounted() {
        if(this.modelValue){
            this.group = this.modelValue;
        }
    },
    computed: {},
    methods : {
        emitValue(val){
            this.$emit('update:modelValue', val);
        },
    }
}