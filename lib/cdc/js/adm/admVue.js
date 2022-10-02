const app = Vue.createApp({
    setup() {},
    data() {
        return {
            base_val : '',
            list: null,
            php_config: null,
            toggleVal: 'blog',
            curOptions: [],
            options : {
                'is_blog' : {
                    label : '블로그',
                    value : 'blog'
                },

                'is_insta' : {
                    label : '인스타',
                    value : 'insta'
                },

                'is_youtube' : {
                    label : '유튜브',
                    value : 'youtube'
                },
            },
            curList : null,
            slide: 1,
        }
    },

    created(){
        this.list = list;
        this.php_config = phpConfig;
        console.log('this.list : ', this.list);
    },    
    mounted(){},
    computed:{
        isCompInsta(){
            const cdcObj = this.skinViews.cdc;
            return cdcObj && cdcObj.wr_comp_insta_link
        },
        isCompBlog(){
            const cdcObj = this.skinViews.cdc;
            return cdcObj && cdcObj.wr_comp_blog_link
        },
        isCompYoutube(){
            const cdcObj = this.skinViews.cdc;
            return cdcObj && cdcObj.wr_comp_youtube_link
        },
    },
    watch: {},
    methods: {
        
        setupView(views){

        },

        toggleBtn(){
            console.log(this.model);
        },
        //open popup
        cdcModalOn(index){
            const list = this.list[index];
            const optionsTargets = ['is_blog', 'is_insta', 'is_youtube'];
            let isOpen = false;
            for(const name of optionsTargets){
                if(list[name] == 'Y'){
                    this.curOptions.push(
                        this.options[name]
                    )
                    if(!isOpen) isOpen = true;
                }
            }

            if(isOpen){
                this.curList = list;
                $('.cdc-upload-modal').addClass('on');
                console.log('this.curList : ', this.curList);
            }
        },
        //close popup
        cdcModalClose(){
            $('.cdc-upload-modal').removeClass('on');
            this.curOptions = [];
            this.curList = null;
        }
    },

   
});

app.use(Quasar);
const vm = app.mount('#admin_cdc_app');

console.log('vm : ', vm);