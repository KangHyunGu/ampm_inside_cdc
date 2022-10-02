// //해시태그 Component
// const hashTagComponents = {
//     name : 'hashTag',
//     props: {
//       label : {
//         type: String,
//         default: '',
//       },
//       size : {
//         type: Number,
//         default: 20
//       },
//     },
//     data() {
// },
//     template : `
//             <div style="display: inline;">
//                 <q-input 
//                     outlined 
//                     type="text"  
//                     :label="label"  
//                     :size="size" 
//                     :dense="true"
//                 />
//             </div>
//     ` ,
//     computed: {},
//     created(){
//         console.log('HashTagcomponent...');
//     },
//     methods : {}
// }


//해시태그 Component
const InputHashComponents = {
    name : 'inputHash',
    props: {
      label_name : {
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
            :label="label_name"  
            size="20" 
            :dense="true"
         />
</div> 
    `,
    computed: {},
    methods : {},
}
