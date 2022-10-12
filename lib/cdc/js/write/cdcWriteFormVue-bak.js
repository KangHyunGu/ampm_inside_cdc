const app = Vue.createApp({
    setup() {
    },
    data() {
        return {
            valid: true,
            //bf_file
            // 일반 이미지(0) ==> 이미지(1) 
            // 인스타 이미지(1~10)
            //(11) ==> CAT배너
            //(12) ==> 썸네일
            //(13) ==> 동영상(15 ~ 60)
            //(14) ==> 유튜브 동영상
            bf_file: Array(14).fill(null),
            action_url: '',
            formHiddenData: {},

            //php 변수들
            is_html: null,
            is_secret: null,
            is_notice: null,
            is_mail: null,
            is_dhtml_editor: null,
            is_admin: null,
            secret_checked: null,
            recv_email_checked: null,
            is_category: null,

            bo_table: '',
            libPath: {},
            code_category: [],
            ca_name: '',
            form: null,

            // CDC 파일 삭제대상(이미지, 썸네일, CAT배너, 동영상(10 ~ 15초), 유튜브영상)
            del_files: [],

            // 임시저장 처리여부
            isAutoSaveOpen: false,

            // 임시저장 목록
            skinSaveList: [],

            ytags: [],
            mhashs: [],
            shashs: [],

            // 영상 첨부파일 별도 처리
            videoFileInfos : [],

            localStorage: window.localStorage,

            //필수 입력
            //인사이트 : 제목, 내용, 이미지
            //영상교육 : 제목, 영상링크(썸네일 자동생성), 유튜브태그
            //레퍼런스 : 제목, 업종, 이미지, 마케팅KPI, 집행매체, 집행성과, 집행내용
            skinRequires: {
                'insight_cdc': ['wr_subject', 'wr_content', 'cdc_files[]'],
                'insight': ['wr_subject', 'wr_content', 'cdc_files[]'],
                'video': ['wr_subject', 'wr_5', 'wr_ytag'],
                'reference': ['wr_subject', 'wr_8', 'bf_file[]', 'wr_1', 'wr_2', 'wr_3', 'wr_content']
            },

            required: [],
            //추가 매체(필수 입력)
            addRequired: [],

            //매체별 임시저장 필드
            //인사이트 : 출처링크, 게시물 숨김 여부
            //영상교육 : 영상링크, 관련링크, 게시물 숨김 여부
            //레퍼런스 : 업종, 관련링크, 마케팅KPI, 집행매체, 집행성과, 홈페이지, 게시물 숨김여부
            as_skinFields: {
                'insight_cdc': ['wr_link', 'wr_19'],
                'insight': ['wr_link', 'wr_19'],
                'video': ['wr_5', 'wr_link', 'wr_19'],
                'reference': ['wr_8', 'wr_link1', 'wr_link2', 'wr_1', 'wr_2', 'wr_3', 'wr_4', 'wr_19'],
            },

            //업체이미지 레퍼런스에서 활용(검토 후 사용여부 결정)
            companyImage: null,
            companyImageSrc: '',
        }
    },
    created() {
        this.bo_table = bo_table;
        console.log(is_category);
        this.is_category = is_category;
        this.makeCategorys();
        this.fetchData(write_fields);
        this.initSkinLocalStorage();
    },
    mounted() {
       
    },
    computed: {
        Rules: () => rules,
        isModify() {
            return this.formHiddenData.w == 'u';
        },
        isImageForm() {
            return this.bo_table == 'insight' ||
                this.form.cdc.is_blog == 'Y' ||
                this.form.cdc.is_insta == 'Y'
        },
        // 썸네일(유튜브)
        isThumNail() {
            return this.form.cdc.is_youtube == 'Y'
        },
        // CTA 배너(블로그)
        isCtaVanner() {
            return this.form.cdc.is_blog == 'Y'
        },
        // 동영상(15~60초)(블로그)
        isShortVideo() {
            return this.form.cdc.is_blog == 'Y'
        },
        // 유튜브 동영상(유튜브)
        isYoutubeVideo() {
            return this.form.cdc.is_youtube == 'Y'
        },
        // 메인 해시태그(3개)(블로그, 인스타, 유튜브)
        isMainHashTag() {
            return this.form.cdc.is_blog == 'Y' ||
                this.form.cdc.is_insta == 'Y' ||
                this.form.cdc.is_youtube == 'Y'
        },
        // 서브 해시태그(7개)(블로그, 인스타, 유튜브)
        isSubHashTag() {
            return this.form.cdc.is_blog == 'Y' ||
                this.form.cdc.is_insta == 'Y'
        },
        // 유튜브 태그(유튜브)
        isYtag() {
            return this.bo_table == 'video' ||
                this.form.cdc.is_youtube == 'Y'
        },
        addRequiredcdc(){
            const cdcObj = this.form.cdc;
            let addRequired = [];
            if(cdcObj.is_blog == 'Y'){
                addRequired = addRequired.concat(['wr_subject', 'wr_content']);
            }

            if(cdcObj.is_insta == 'Y'){
                addRequired = addRequired.concat(['cdc_files[]']);
            }

            if(cdcObj.is_youtube == 'Y'){
                addRequired = addRequired.concat(['wr_youtube_link']);
            }
           return new Set(this.skinRequires[this.bo_table].concat((addRequired)));
        },
    },

    watch: {
        "form.cdc.is_blog"() {
            //추가매체 블로그 : wr_title, wr_content
           this.required = [...this.addRequiredcdc]
        },

        "form.cdc.is_insta"() {
            //추가매체 인스타 : cdc_files[]
            this.required = [...this.addRequiredcdc];
        },

        "form.cdc.is_youtube"(newVal) {
            //추가매체 유튜브 : wr_youtube_link
            this.required = [...this.addRequiredcdc];
        },

        mhashs() {
            this.form.cdc.wr_mhash = Object.values(this.mhashs).join('|');
        },

        shashs() {
            this.form.cdc.wr_shash = Object.values(this.shashs).join('|');
        },

        ytags() {
            this.form.cdc.wr_ytag = Object.values(this.ytags).join('|');
        },

    },
    methods: {
        fetchData(write_fields) {
            if (write_fields.wr_id) {
                this.form = write_fields;
                if (!this.form.cdc) {
                    this.form.cdc = this.initCdcForm();
                } else {
                    this.setImages();
                    if (!this.form.cdc) this.form.cdc = this.initCdcForm();
                    // 임시 default 처리..
                    if (!this.form.cdc.is_blog) { this.form.cdc.is_blog = 'N'; }
                    if (!this.form.cdc.is_insta) { this.form.cdc.is_insta = 'N'; }
                    if (!this.form.cdc.is_youtube) { this.form.cdc.is_youtube = 'N'; }

                    // 메인해시태그, 서브해시태그, 유튜브 태그
                    const hashTagFields = { 'wr_mhash': 'mhashs', 'wr_shash': 'shashs', 'wr_ytag': 'ytags' };
                    for (const [key, value] of Object.entries(hashTagFields)) {
                        if (this.form.cdc[key]) { this[value] = this.form.cdc[key].split('|') }
                    }

                    // 임시
                    if (!this.mhashs.length) {
                        const mhashtags = ['wr_mhash_1', 'wr_mhash_2', 'wr_mhash_3'];
                        const hashs = [];
                        for (const mhash of mhashtags) {
                            if (this.form.cdc[mhash]) {
                                hashs.push(this.form.cdc[mhash]);
                            }
                        }
                        this.mhashs = hashs;
                    }

                    // 임시
                    if (!this.shashs.length) {
                        const shashtags = ['wr_shash_1', 'wr_shash_2', 'wr_shash_3', 'wr_shash_4', 'wr_shash_5', 'wr_shash_6', 'wr_shash_7'];
                        const hashs = [];
                        for (const shash of shashtags) {
                            if (this.form.cdc[shash]) {
                                hashs.push(this.form.cdc[shash]);
                            }
                        }
                        this.shashs = hashs;
                    }
                }

            } else {
                // 인사이트 / 영상교육 / 래퍼런스
                this.form = this.initSkinForm();
                this.form.cdc = this.initCdcForm();
            }
        },
        initSkinForm() {
            return {
                ca_name: this.code_category.length ? this.code_category[0].value : "",
                mb_id: "", wr_1: "", wr_2: "", wr_3: "",
                wr_4: "", wr_5: "", wr_6: "", wr_7: "", wr_8: "", wr_9: "",
                wr_10: "", wr_11: "", wr_12: "", wr_13: "", wr_14: "", wr_15: "",
                wr_16: "", wr_17: "", wr_18: "", wr_19: "Y", wr_20: "", wr_ampm_user: "",
                wr_comment: "", wr_comment_reply: "", wr_content: "", wr_datetime: "",
                wr_email: "", wr_facebook_user: "", wr_file: "", wr_good: "", wr_hit: "",
                wr_homepage: "", wr_id: "", wr_ip: "", wr_is_comment: "", wr_last: "",
                wr_link1: "", wr_link1_hit: "", wr_link2: "", wr_link2_hit: "", wr_name: "",
                wr_nogood: "", wr_num: "", wr_option: "", wr_parent: "", wr_password: "",
                wr_reply: "", wr_seo_title: "", wr_subject: "", wr_twitter_user: "",
            }
        },
        initCdcForm() {
            return {
                wr_id: 0,
                bo_table: '',
                is_youtube: 'N',
                is_blog: 'N',
                is_insta: 'N',
                thumnailUrl: null,
                wr_cat_link: '',
                wr_mhash: '',
                wr_shash: '',
                wr_ytag: '',
                wr_video_link: '',
                wr_youtube_link: '',
                wr_cdc_content: '',
                wr_cdc_title: '',
                wr_comp_blog_link: '',
                wr_comp_insta_link: '',
                wr_comp_youtube_link: '',
                wr_playlist_link: '',
                wr_is_comp: false,
            }
        },
        makeCategorys(){
            for(const val of catNames){
                this.code_category.push({
                    label : val,
                    value : val,
                    name: 'ca_name',
                })
            }
        },
        async setImages() {
            //파일 처리 시 
            //이미지 : file 객체로 매칭
            //영상첨부파일 : 별도 info 처리
            
            for (let i = 0; i < 12; i++) {
                const fileInfo = this.form.cdc.file[i];
                if(!fileInfo || !fileInfo.source) continue;
                this.bf_file[i] = await setConverFile(fileInfo);
            }

            //비디오 파일 정보
            for(let i = 12; i < 14; i++){
                const fileInfo = this.form.cdc.file[i];
                this.videoFileInfos.push(fileInfo);
            }

        },

        initSkinLocalStorage() {
            const bo_table = this.bo_table;
            const localStorage = this.localStorage
            if (!localStorage.getItem(bo_table)) {
                localStorage.setItem(bo_table, JSON.stringify([]));
            }
            const items = JSON.parse(localStorage.getItem(bo_table));
            for (const item of items) {
                this.skinSaveList.push(item);
            }
        },

        // 카테고리 값
        setCateVal(ca_name) {
            this.form.ca_name = ca_name;
        },

        async formSave($event) {
            //기본 입력 검사(필수 입력처리)
            this.$refs.form.validate();
            await this.$nextTick();

            if (!this.valid) return;

            //제목 및 게시글 작성 filter 
            const form = $('#fwrite')[0];
            const formData = new FormData(form);
            let appendData = {};
            let content_valid = true;
            if (this.required.indexOf('wr_content') != -1) {
                // 내용입력 필수 입력 체크 및 갱신
                // 주제 : 인사이트
                // 매체 : 블로그
                content_valid = fwrite_submit(form);

            } else {
                // 영상교육, 추가매체 블로그가 아닐경우엔 필수 입력 X
                oEditors.getById["wr_content"].exec("UPDATE_CONTENTS_FIELD", []);
                formData.set('wr_content', $('#wr_content').val());
            }

            if (!content_valid) return;
            
            // 유튜브 태그, 메인 해시태그, 서브 해시태그
            for(const tagFields of ['wr_ytag', 'wr_mhash', 'wr_shash']){
                appendData[tagFields] = this.form.cdc[tagFields];
            }

            //게시글 수정여부 있을경우 삭제여부 있는지 확인
            if (this.isModify) {
                if(this.del_files.length){
                    appendData['cdc_remove_files'] = this.del_files;
                }
            }

            // append actual data..
            const appendKeys = Object.keys(appendData);
            for (const appendKey of appendKeys) {
                const input = this.createInput(appendKey, appendData[appendKey]);
                $event.target.appendChild(input);
                
            }

            this.$q.loading.show({
                message: `<p style="color: white;">
                              게시글 입력 처리 중 입니다. <br /> 
                              파일 첨부 시 용량이 많을 경우 처리시간이 <br />
                              지연 될 수도 있습니다. <br />
                            </p> 
                `,
                html: true
            });
            $event.target.submit(formData); 
        },
        // append actual data..
        createInput(name, value, type = 'text') {
            const Input = document.createElement('input');
            Input.style.visibility = 'hidden'
            Input.setAttribute('name', name);
            Input.setAttribute('type', type);
            if(type == 'file'){
                const dt = new DataTransfer();
                const files = dt.files;
                Input.files = files;
            } else {
                Input.setAttribute('value', value);
            }
            return Input;
        },

        autoSave() {
            // 임시 저장 처리
            const formData = this.form

            if (!formData.wr_subject) {
                alert('제목을 입력해주세요.');
                return;
            }
            let saveData = { cdc: {} };
            //주제별 공통 : 카테고리 선택, 제목, 내용
            const saveSkinTargets = ['ca_name', 'wr_subject'];
            const saveCdcTargets = ['is_blog', 'is_insta', 'is_youtube',
                'wr_mhash', 'wr_shash', 'wr_video_link', 'wr_youtube_link',
                'wr_ytag', 'wr_playlist_link',
            ]
            // 일반 Skin 데이터
            for (const field of saveSkinTargets) {
                saveData[field] = formData[field];
            }

            // 주제별 임시 저장 필드
            const skinFields = this.as_skinFields[this.bo_table];
            for (const skinField of skinFields) {
                saveData[skinField] = formData[skinField];
            }

            oEditors.getById["wr_content"].exec("UPDATE_CONTENTS_FIELD", []);
            // 스마트에디터(내용)
            saveData['wr_content'] = $('#wr_content').val();

            // CDC 데이터 
            for (const cdcField of saveCdcTargets) {
                saveData["cdc"][cdcField] = formData["cdc"][cdcField];
            }

            const bo_table = this.bo_table;
            let dateTime = dateFormat(new Date());
            saveData["date"] = dateTime;
            // 저장 Key 생성
            this.skinSaveList.unshift(saveData);
            // 임시저장시 Value 값은 JSON String으로 변환 후 처리
            this.localStorage.setItem(bo_table, JSON.stringify(this.skinSaveList));

            alert('임시 저장 처리가 완료되었습니다.');
        },

        autosave_load(item) {
            const skinFields = this.as_skinFields[this.bo_table];
            const keys = ['wr_subject', 'ca_name'].concat(skinFields);
            // 공통    : 제목 또는 브랜드명, 카테고리
            // 인사이트 : 출처링크, 게시물 숨김 여부
            // 영상교육 : 영상링크, 관련링크, 게시물 숨김 여부
            // 레퍼런스 :
            for (const key of keys) {
                this.form[key] = item[key]
            }

            //게시글내용 
            //기존 내용에서 초기화
            oEditors.getById["wr_content"].exec("SET_IR", [""]);
            //선택 된 임시 저장 리스트의 값 set
            oEditors.getById["wr_content"].exec("PASTE_HTML", [item.wr_content]);

            //CDC(블로그, 인스타, 유튜브, 메인해시태그 1 ~ 3, 서브해시태그 1 ~ 7, 비디오링크, 유튜브링크, 유튜브태그)
            const cdc_keys = Object.keys(item.cdc);
            for (const cdc_key of cdc_keys) {
                this.form.cdc[cdc_key] = item.cdc[cdc_key];
            }

            //메인 해시태그, 서브 해시태그, 유튜브 태그 Array로 변환
            const hashTags = {
                'ytags': 'wr_ytag',
                'mhashs': 'wr_mhash',
                'shashs': 'wr_shash'
            }

            for (const tagField in hashTags) {
                const val = this.form.cdc[hashTags[tagField]];

                if (val) { this[tagField] = val.split('|'); }
            }
            this.isAutoSaveOpen = false;
        },

        autosave_remove(index) {
            this.skinSaveList.splice(index, 1);
            // 해당 내용 삭제 후 localStorage에 재 저장
            const bo_table = this.bo_table;
            this.localStorage.setItem(bo_table, JSON.stringify(this.skinSaveList));
        },

        uploaderVideo(ev, field_name, index) {
            this[field_name][index] = ev;
        },

        addYtags(val, done) {
            // 유튜브 태그
            done(val, 'add-unique');
        },

        addMhash(val, done) {
            // 메인해시태그 최대 입력 3개
            if (this.mhashs.length >= 3) return;
            done(val, 'add-unique');
        },

        addShash(val, done) {
            // 서브해시태그 최대 입력 7개
            if (this.shashs.length >= 7) return;
            done(val, 'add-unique');
        },

        mandatory(field, title) {
            const requireds = this.required;
            if (requireds.indexOf(field) != -1) {
                if (field == 'cdc_files[]') {
                    return [this.Rules.imageRequired({ label: title })]
                } else {
                    return [this.Rules.require({ label: title })];
                }

            } else {
                return [v => true];
            }
        },

        // 래퍼런스에서 활용
        changeCompanyImage() {
            console.log(this.companyImage);
            const file = this.companyImage[0];
            if (!file) {
                this.companyImageSrc = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                this.companyImageSrc = e.target.result;
            }
            reader.readAsDataURL(file);
        },

        validationError(ref){
            alert('입력사항을 다시 확인해주시길 바랍니다.');
        },

        //이미지 파일 삭제처리
        removeImageFile(file) {
            this.del_files.push(file.name);
        },

        //비디오 첨부 파일 Control(삭제, 삭제취소)
        uploadingFileControl(state, fileInfo){
            if(state){
                this.del_files.push(fileInfo.file);
            } else {
                const index = this.del_files.indexOf(fileInfo.file);
                this.del_files.splice(index, 1);
            }
        }
    }
});

app.component('category', categotyComponents);
app.component('imageform', imageformComponents);
app.component('inputvideo', inputVideoComponents);

app.use(Quasar);
const vm = app.mount('#q-app');




