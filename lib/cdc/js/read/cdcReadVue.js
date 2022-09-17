const app = Vue.createApp({
    setup() {},
    data() {
        return {
            imgSrcs: [],
            thumSrc: null,
            catSrc: null,

            bf_file: Array(14).fill(null),

            slide: 1,
            fullscreen: false,
            skinViews: {},

            hashTagInfos : [],
            wr_ytag: '',
            wr_cat_link: '',
            wr_video_link: '',
            wr_youtube_link: '',
            wr_playlist_link: ''
        }
    },

    created(){
        console.log('cdc Read Create....');
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
            //View Data Set
            this.skinViews = views;
            const cdcObj = this.skinViews.cdc;
            if(!cdcObj) return;

            //wr_ytag(유튜브태그)
            this.wr_ytag = cdcObj.wr_ytag;
            //cat 배너 링크
            this.wr_cat_link = cdcObj.wr_cat_link;
            //비디오 동영상 링크
            this.wr_video_link = cdcObj.wr_video_link;
            //유튜브 동영상 링크
            this.wr_youtube_link = cdcObj.wr_youtube_link;
            //재생목록 링크
            this.wr_playlist_link = cdcObj.wr_playlist_link;

            //hashTag Data
            let fd_name_pre = 'wr_mhash_';
            for(let i=1; i<=3; i++){
                this.hashTagInfos.push(cdcObj[fd_name_pre+(i)]); 
            }

            fd_name_pre = 'wr_shash_';
            for(let i=1; i<=7; i++){
                this.hashTagInfos.push(cdcObj[fd_name_pre+(i)]);
            }
            this.setImages();
            console.log('this : ', this);
        },

        async setImages(){
            const fileCount = this.skinViews.cdc.file.count;
            for(let i=0; i < fileCount; i++){
               const fileInfo = this.skinViews.cdc.file[i];
               this.bf_file[i] = await setConverFile(fileInfo);
            }
           
            const cdcObj = this.skinViews.cdc;
            const imgRange = cdcObj.is_insta == 'Y' ? 10 : 1;

            // 1 ~ 10 블로그 및 인스타 이미지
            for(let i=0; i < imgRange; i++){
                const file = this.bf_file[i];
                
                if(!file) continue;
                this.loadImageUrlData(file, "imgSrcs");
            }
            // 썸네일
            this.loadImageUrlData(this.bf_file[10], "thumSrc");
            // CAT배너
            this.loadImageUrlData(this.bf_file[11], "catSrc");
        },

        loadImageUrlData(file, img_fd_name){
            if(!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const imgData = e.target.result;
                if(img_fd_name == 'imgSrcs'){
                    this[img_fd_name].push(imgData);
                } else {
                    this[img_fd_name] = imgData
                }
            }
            reader.readAsDataURL(file);
        },

       

        clickToAction(){
            window.open(this.wr_cat_link);
        },

        enableVideo(url){
            return convertVideoUrl(url);
        },

        vedioDownload(url){
             // 비동기 진행시 token 생성 별도로 처리해야 함

        }
    }
});

app.use(Quasar);
// 카테고리
const vm = app.mount('#v-app');