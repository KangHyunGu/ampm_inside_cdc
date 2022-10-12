const app = Vue.createApp({
    setup() { },
    data() {
        return {
            base_val: '',
            list: null,
            php_config: null,
            toggleVal: '',
            imgFullscreen: false,
            curOptions: [],
            cdcObj: {},
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
            curList: null,
            slide: 1,

            curImgInfos: [],
            curCtaImg: {},
            curThumNailImg: {},
            curVideoInfos: [],
            curHashTags: [],
            curYoutubeTags: [],

            isCompDialogOpen: false,
            curCdcCompForm: {},
        }
    },

    created() {
        this.setupView();
    },
    mounted() {

    },
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

        isCdcTitleView() {
            // 제목(블로그, 유튜브)
            const targetFields = ['blog', 'youtube'];
            return targetFields.indexOf(this.toggleVal) != -1;
        },

        isCdcContentView() {
            // 내용(블로그)
            return this.toggleVal == 'blog';
        },

        isCdcImgView() {
            // 이미지(블로그, 인스타)
            const targetFields = ['blog', 'insta'];
            return targetFields.indexOf(this.toggleVal) != -1 &&
                this.curImgInfos.length;
        },

        isCdcThumNailView() {
            // 썸네일(유튜브)
            return this.toggleVal == 'youtube' &&
                this.curThumNailImg.file;
        },

        isCdcCtaImgView() {
            // CTA배너(블로그)
            return this.toggleVal == 'blog' &&
                this.curCtaImg.file;
        },

        isCdcVideoView() {
            // 비디오(블로그)
            return this.toggleVal == 'blog' &&
                (this.curVideoInfos[0] || this.curList.wr_video_link);
        },

        isCdcYoutubeView() {
            // 유튜브 동영상(유튜브)
            return this.toggleVal == 'youtube' &&
                (this.curVideoInfos[1] || this.curList.wr_youtube_link);
        },

        isCdcHashTagView() {
            // 해시태그(블로그, 인스타, 유튜브)
            return this.curHashTags.length;
        },

        isCdcYoutubeTagView() {
            // 유튜브태그(유튜브)
            return this.toggleVal == 'youtube' &&
                this.curYoutubeTags.length;
        }
    },
    watch: {},
    methods: {
        setupView() {
            this.list = list;
            this.php_config = phpConfig;
        },

        toggleBtn() {
            console.log(this.toggleVal);
        },
        //open popup
        cdcModalOn(index) {
            const list = this.list[index];
            const optionsTargets = ['is_blog', 'is_insta', 'is_youtube'];
            let isOpen = false;
            for (const name of optionsTargets) {
                if (list[name] == 'Y') {
                    this.curOptions.push(
                        this.options[name]
                    )
                    if (!isOpen) isOpen = true;
                }
            }

            if (isOpen) {
                this.curList = list;
                const imgInfos = list.cdc_files;
                console.log('imgInfos : ', imgInfos);
                // 이미지 1 ~ 10장
                for (let i = 0; i < 10; i++) {
                    const fileInfo = imgInfos["" + i + ""];
                    if (!fileInfo || !fileInfo.source) continue;
                    fileInfo['imgSrc'] = `${fileInfo.path}/${fileInfo.file}`;
                    this.curImgInfos.push(fileInfo);
                }

                // 썸네일
                if (imgInfos['10']) {
                    const fileInfo = imgInfos['10'];
                    imgInfos['10']['imgSrc'] = `${fileInfo.path}/${fileInfo.file}`;
                    this.curThumNailImg = fileInfo
                }
                // CTA배너
                if (imgInfos['11']) {
                    const fileInfo = imgInfos['11'];
                    imgInfos['11']['imgSrc'] = `${fileInfo.path}/${fileInfo.file}`;
                    this.curCtaImg = fileInfo
                }

                // CTA배너 링크(클릭 링크 정보가 없을경우 작성자 마케터 페이지로 전환)
                if (!this.curList.wr_cat_link) {
                    this.curList.wr_cat_link = `http://inside.ampm.co.kr/ae-${this.curList.wr_17}`;
                }

                //동영상, 유튜브 동영상
                for (let i = 12; i < 14; i++) {
                    const fileInfo = imgInfos["" + i + ""];

                    if (!fileInfo) {
                        this.curVideoInfos.push("");
                        continue;
                    }
                    fileInfo['src'] = `${fileInfo.path}/${fileInfo.file}`;
                    this.curVideoInfos.push(fileInfo);
                }

                //해시태그
                let hTags = this.curList.wr_mhash.split("|").concat(this.curList.wr_shash.split("|"));
                // split("|") 입력 되지 않아도 최소 "" 나와 가공처리
                for (const htag of hTags) {
                    if (!htag) continue;
                    this.curHashTags.push(htag);
                }

                // 유튜브태그
                let Ytags = this.curList.wr_ytag.split("|");
                for (const ytag of Ytags) {
                    if (!ytag) continue;
                    this.curYoutubeTags.push(ytag);
                }

                this.toggleVal = this.curOptions[0].value;
                $('.cdc-upload-modal').addClass('on');
            }
        },
        //close popup
        cdcModalClose() {
            $('.cdc-upload-modal').removeClass('on');
            this.curOptions = [];
            this.curList = null;
            this.curImgInfos = [];
            this.curCtaImg = {};
            this.curThumNailImg = {};
            this.curHashTags = [];
            this.curYoutubeTags = [];
        },

        cdcModalCompOn(index) {
            const list = this.list[index];
            this.curList = list;
            this.isCompDialogOpen = true;
        },

        cdcModelCompClose() {
            this.curList = null;
            this.isCompDialogOpen = false;
        },

        imgDownload(downloadUrl, fileName) {
            // fileDownload 처리
            const element = document.createElement('a');
            element.setAttribute('href', downloadUrl);
            element.setAttribute('download', fileName);
            element.style.display = 'none';
            document.body.appendChild(element);

            element.click();

            document.body.removeChild(element);
        },

        clickToAction() {
            clickToAction(this.curList.wr_cat_link);
        },

        enableVideo(url) {
            return convertVideoUrl(url);
        },

        copy(fieldName, title) {
            let copyStr = '';
            if (fieldName == 'wr_hashTag') {
                for (const hashTag of this.curHashTags) {
                    if (!hashTag) continue;
                    copyStr = copyStr + '#' + hashTag + ' ';
                }

            } else if (fieldName == 'wr_ytag') {
                copyStr = this.curYoutubeTags.join(',');
            } else {
                copyStr = this.curList[fieldName];
            }
            console.log('copyStr : ', copyStr);
            this.$q.config.clipboard(copyStr);

            this.$q.notify(title + ' 내용이 복사 되었습니다.');
        },

        phpCompControl(index) {
            //php 변수로 CDC 완료 / 미완료 버튼 제어여부
            const list = this.list[index];
            return list.is_blog == 'Y' || list.is_insta == 'Y' || list.is_youtube == 'Y';
        },

        phpIsCdcComp(index) {
            //CDC 실제 메체등록 여부
            const list = this.list[index];
            return list.wr_is_comp == 'Y';
        },

        // CDC 완료 링크
        cdcCompSave() {

        },
    },
});

app.use(Quasar, {
    config: {
        clipboard: Quasar.copyToClipboard
    }
});
const vm = app.mount('#admin_cdc_app');