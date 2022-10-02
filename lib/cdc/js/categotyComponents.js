const categotyComponents = {
    name : 'category',
    setup() {
        return {
            group: '',
            options : []
        }
    },
    template : `
    <div class="q-pa-lg">
        <q-option-group
            v-model="group"
            @update:group="emitValue"
            :options="options"
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
        }
    }
}