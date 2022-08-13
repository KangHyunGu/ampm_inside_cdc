//카테고리 Component
const categotyComponents = {
    name : 'category',
    props: {
        opts : {
            type: Array,
            default: [],
        },
        group: {
            type: String,
            default: '',
        }
    },
    data() {
},
    template : `
    <div class="q-pa-sm">
        <q-option-group
            size="xs"
            v-model="group"
            @update:group="emitValue"
            :options="opts"
            color="primary"
            inline
            dense
        />   
    </div>
    ` ,
    computed: {},
    methods : {
        emitValue(val){
            this.$emit('ca_name', val);
        },
    }
}