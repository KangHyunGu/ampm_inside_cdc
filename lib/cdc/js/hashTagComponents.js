//해시태그 Component
const hashTagComponents = {
    name : 'cdchashtag',
    props: {
      label : {
        type: String,
        default: '',
      },
    },
    data() {},
    template : `
    <div style="display: inline;">
        <q-input 
            outlined 
            type="text"  
            :label="label"  
            size="20" 
            :dense="true"
         />
</div> 
    `,
    computed: {},
    methods : {},
}
