const app = Vue.createApp({
    setup() { },
    data() {
        return {
            imgSrcs: [],
            thumSrc: null,
            catSrc: null,

            bf_file: Array(14).fill(null),

            slide: 1,
            fullscreen: false,
            skinViews: {},

            hashTagInfos: [],
            wr_ytag: '',
            wr_ytags: [],
            wr_cat_link: '',
            wr_video_link: '',
            wr_youtube_link: '',
            wr_playlist_link: '',
            video_file_info: '',
            youtube_file_info: '',
        }
    },

    created() {
        console.log(this.skinViews.cdc);
        console.log('cdc Read Create....');
    },
    mounted() { },
    computed: {
        isCompInsta() {
            const cdcObj = this.skinViews.cdc;
            return cdcObj && cdcObj.wr_comp_insta_link
        },
        isCompBlog() {
            const cdcObj = this.skinViews.cdc;
            return cdcObj && cdcObj.wr_comp_blog_link
        },
        isCompYoutube() {
            const cdcObj = this.skinViews.cdc;
            return cdcObj && cdcObj.wr_comp_youtube_link
        },

        isBlog() {
            const cdcObj = this.skinViews.cdc;

            return cdcObj && cdcObj.is_blog == 'Y';
        },

        isInsta() {
            const cdcObj = this.skinViews.cdc;
            return cdcObj && cdcObj.is_insta == 'Y';
        },

        isYoutube() {
            const cdcObj = this.skinViews.cdc;
            return cdcObj && cdcObj.is_youtube == 'Y';
        }
    },
    watch: {},
    methods: {
        setupView(views) {
            //View Data Set
            this.skinViews = views;
            const cdcObj = this.skinViews.cdc;
            if (!cdcObj) return;

            //wr_ytag(유튜브태그)
            this.wr_ytag = cdcObj.wr_ytag;
            if (this.wr_ytag) {
                const arrs = this.wr_ytag.split("|");
                for (const val of arrs) {
                    if (val) { this.wr_ytags.push(val); }
                }
            }

            //cat 배너 링크
            //입력  : 입력한 URL
            //미입력 : 작성자 마케터 페이지 URL
            this.wr_cat_link = cdcObj.wr_cat_link
                ? cdcObj.wr_cat_link
                : `http://inside.ampm.co.kr/ae-${this.skinViews.wr_17}`;
            //비디오 동영상 링크
            this.wr_video_link = cdcObj.wr_video_link;
            //비디오 파일정보
            this.video_file_info = cdcObj.file[12];
            //유튜브 동영상 링크
            this.wr_youtube_link = cdcObj.wr_youtube_link;
            //유튜브 동영상 파일정보
            this.youtube_file_info = cdcObj.file[13];
            //재생목록 링크
            this.wr_playlist_link = cdcObj.wr_playlist_link;

            //hashTag Data
            let fd_name_pre = 'wr_mhash_';
            for (let i = 1; i <= 3; i++) {
                const hashVal = cdcObj[fd_name_pre + (i)];
                if (hashVal) {
                    this.hashTagInfos.push(cdcObj[fd_name_pre + (i)]);
                }
            }

            //임시
            if (!this.hashTagInfos.length) {
                const hashs = cdcObj['wr_mhash'].split('|')
                for (const hash of hashs) {
                    if (!hash) continue;
                    this.hashTagInfos.push(hash);
                }
            }

            fd_name_pre = 'wr_shash_';
            for (let i = 1; i <= 7; i++) {
                const hashVal = cdcObj[fd_name_pre + (i)];
                if (hashVal) {
                    this.hashTagInfos.push(cdcObj[fd_name_pre + (i)]);
                }
            }


            //임시
            const hashs = cdcObj['wr_shash'].split('|')
            for (const hash of hashs) {
                if (!hash) continue;
                this.hashTagInfos.push(hash);
            }



            this.setImages();
        },

        async setImages() {
            const fileCount = this.skinViews.cdc.file.count;
            const check_file_type = ['.avi', '.wma', '.mpg', '.mp4'];
            for (let i = 0; i < fileCount; i++) {
                const fileInfo = this.skinViews.cdc.file[i];
                const exeName = fileInfo.source.split('.')[1];

                //조회 모드에서 비디오 추출 제외(용량이 많이 로딩 느려짐)
                if (check_file_type.indexOf(exeName) != -1) continue;

                this.bf_file[i] = await setConverFile(fileInfo);
            }

            // 1 ~ 10 블로그 및 인스타 이미지
            for (let i = 0; i < 10; i++) {
                const file = this.bf_file[i];

                if (!file) continue;
                this.loadImageUrlData(file, "imgSrcs");
            }
            // 썸네일
            this.loadImageUrlData(this.bf_file[10], "thumSrc");
            // CAT배너
            this.loadImageUrlData(this.bf_file[11], "catSrc");
            console.log(this.bf_file);
        },

        loadImageUrlData(file, img_fd_name) {
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const imgData = e.target.result;
                if (img_fd_name == 'imgSrcs') {
                    this[img_fd_name].push(imgData);
                } else {
                    this[img_fd_name] = imgData
                }
            }
            reader.readAsDataURL(file);
        },

        clickToAction() {
            const httpPatten = /(http(s)?:\/\/)([a-z0-9\w]+\.*)+[a-z0-9]{2,4}/gi;
            let actionUrl = this.wr_cat_link;
            if (!actionUrl.match(httpPatten) || actionUrl.startsWith('data')) {
                actionUrl = `http://${actionUrl}`
            }
            window.open(actionUrl);
        },

        enableVideo(url) {
            return convertVideoUrl(url);
        },

        vedioDownload(url) {
            // 비동기 진행시 token 생성 별도로 처리해야 함

        }
    }
});

app.use(Quasar);
// 카테고리
const vm = app.mount('#v-app');