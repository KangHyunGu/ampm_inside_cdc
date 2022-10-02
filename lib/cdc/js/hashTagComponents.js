//해시태그 Component
const hashTagComponents = {
    name : 'cdchashtag',
    props: {
      modelValue:{type:String, required: true},
      label : {
        type: String,
        default: '',
      },
      index : {
        type: Number,
        default: 0
      },
      hashClcd : {
        type: String,
        default: 'mhash'
      }
    },
    data() {
      return {
        inputVal : '',
      }
    },
    template : `
    <div style="display: inline;">
        <q-input 
            outlined 
            @update:model-value="InputEmitValue"
            :model-value="modelValue"
            type="text"  
            :label="label"  
            size="20" 
            :dense="true"
         />
</div> 
    `,
    computed: {},
    methods : {
      InputEmitValue(e){
        console.log('InputEmitValue',this.index, this.modelValue, this.hashClcd);
        this.$emit('update:modelValue', this.modelValue, this.hashClcd, this.index);
      }
    },
}
