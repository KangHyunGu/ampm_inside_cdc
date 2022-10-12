const app = Vue.createApp({
    setup() { },
    data() {
        return {
            imgSrcs: [],
            thumSrc: null,
            catSrc: null,

            bf_file: Array(14).fill(null),
            slide2: 1,
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

            is_admin: '',
            login_user: '',
            bo_table: '',

            cdcControlVal: '',
            cdcControlOptions: [],
            options: {
                'is_blog': {
                    label: '블로그',
                    value: 'blog'
                },

                'is_insta': {
                    label: '인스타',
                    value: 'insta'
                },

                'is_youtube': {
                    label: '유튜브',
                    value: 'youtube'
                },
            },
        }
    },

    created() {
        this.skinViews = viewData;
        this.is_admin = is_admin;
        this.login_user = member.mb_id;
        this.bo_table = bo_table;
        this.setupView();
        this.setupCdcViewOpts();
        console.log('cdc Read Create....');
    },
    mounted() { },
    computed: {
        Rules: () => rules,
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
        },
        isViewAuth() {
            //슈퍼 관리자 또는 운영자는 해당 CDC 내용 조회 가능
            const admins = ['super', 'manager'];
            if (admins.indexOf(this.is_admin) != -1) {
                return true;
            }
            //로그인 사용가 작성자 같은 경우..
            const writer = this.skinViews.wr_17;
            if (this.login_user == writer) {
                return true;
            }
            return false;
        },
        isImageView() {
            // 이미지 
            const Fields = ['blog', 'insta'];
            return Fields.indexOf(this.cdcControlVal) != -1 ? true : false;
        },

        isBlogView_1() {
            // CAT배너, 동영상(15 ~ 20)
            return this.cdcControlVal == 'blog' ? true : false;
        },

        isYoutubeView() {
            // 유튜브 태그, 유튜브 영상, 썸네일, 재생목록
            return this.cdcControlVal == 'youtube' ? true : false;
        },
    },
    watch: {},
    methods: {
        setupView() {
            //View Data Set
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

        setupCdcViewOpts() {
            // CDC 매체 별 버튼 그룹 생성
            const cdcObj = this.skinViews.cdc;
            if (!cdcObj) return;
            const optionsTargets = ['is_blog', 'is_insta', 'is_youtube'];
            for (const name of optionsTargets) {
                if (cdcObj[name] == 'Y') {
                    this.cdcControlOptions.push(
                        this.options[name]
                    )
                }
            }

            if (this.cdcControlOptions.length) {
                // CDC 매체가 하나라도 존재 할 경우
                // default 값 생성
                this.cdcControlVal = this.cdcControlOptions[0].value;
            }
        },

        async setImages() {
            const fileCount = this.skinViews.cdc.file.count;
            const check_file_type = ['avi', 'wma', 'mpg', 'mp4'];

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
                await this.loadImageUrlData(file, "imgSrcs");
            }
            // 썸네일
            this.loadImageUrlData(this.bf_file[10], "thumSrc");
            // CAT배너
            this.loadImageUrlData(this.bf_file[11], "catSrc");
        },
        getBase64(file) {
            const reader = new FileReader();
            //이미지 파일의 용량크기 사이즈가 달라 순서가 틀어지는 경우가 있어
            //promise 객체로 처리
            return new Promise((resolve) => {
                reader.onload = (e) => {
                    resolve(e.target.result);
                }
                reader.readAsDataURL(file);
            });
        },

        async loadImageUrlData(file, img_fd_name) {
            if (!file) return;
            const imgData = await this.getBase64(file);
            if (img_fd_name == 'imgSrcs') {
                this[img_fd_name].push(imgData);
            } else {
                this[img_fd_name] = imgData
            }
        },

        clickToAction() {
            clickToAction(this.wr_cat_link);
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