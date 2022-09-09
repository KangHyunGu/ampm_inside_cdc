const app = Vue.createApp({
    setup() {},
    data() {
        return {
            valid: true,
            //bf_file
            //(0~9) ==> 이미지(1~10) 네이버(1), 인스타(1 ~ 10)
            //(10) ==> CAT배너
            //(11) ==> 썸네일
            bf_file: Array(12).fill(null),
            action_url: '',
            formHiddenData : {},

            //php 변수들
            is_html : null,
            is_secret : null,
            is_notice : null,
            is_mail : null,
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
          
            // CDC 파일 삭제대상(이미지, 썸네일, CAT배너)
            del_files: [],

            // 임시저장 처리여부
            isAutoSaveOpen: false,

            // 임시저장 목록
            skinSaveList: [],

            localStorage: window.localStorage,
        }
    },

    created(){},    
    mounted(){},
    computed: {
        Rules: () => rules,
        isImageForm(){
            return this.form.cdc.is_blog == 'Y' || this.form.cdc.is_insta == 'Y'
        },
        // 썸네일(유튜브)
        isThumNail(){
            return this.form.cdc.is_youtube == 'Y'
        },
        // CTA 배너(블로그)
        isCtaVanner(){
            return this.form.cdc.is_blog == 'Y'
        },
        // 동영상(15~60초)(블로그)
        isShortVideo(){
            return this.form.cdc.is_blog == 'Y'
        },
        // 유튜브 동영상(유튜브)
        isYoutubeVideo(){
            return this.form.cdc.is_youtube == 'Y'
        },
        // 메인 해시태그(3개)(블로그, 인스타, 유튜브)
        isMainHashTag(){
            return this.form.cdc.is_blog == 'Y' ||
                   this.form.cdc.is_insta == 'Y' ||
                   this.form.cdc.is_youtube == 'Y'
        },
        // 서브 해시태그(7개)(블로그, 인스타, 유튜브)
        isSubHashTag(){
            return this.form.cdc.is_blog == 'Y' ||
                   this.form.cdc.is_insta == 'Y'
        },
        // 유튜브 태그(유튜브)
        isYtag(){
            return this.form.cdc.is_youtube == 'Y'
        },
        // 재생목록
        isVideoList(){
            return this.form.cdc.is_youtube == 'Y'
        },
        // 추가매체(블로그, 인스타, 유튜브) 체크
        isCdcMode(){
            return this.form.cdc.is_blog == 'Y' ||
            this.form.cdc.is_insta == 'Y' ||
            this.form.cdc.is_youtube == 'Y'
        },
        // 게시글 수정상태 여부
        isModify(){
            return this.formHiddenData.w == 'u';
        },

        imageUpCount(){
            //추가 매체가 인스타그램 체크 될 경우 10장까지
            return this.form.cdc.is_insta == 'Y' ? 10 : 1;
        }
    },
    watch: {},
    methods: {
        removeImage(file){
            this.del_files.push(file);
        },

        fetchData(write_fields) {
            if (write_fields.wr_id) {
                this.form = write_fields;
                this.setImages();
                if(!this.form.cdc) this.form.cdc = this.initCdcForm();
                // 임시 default 처리..
                if(!this.form.cdc.is_blog){this.form.cdc.is_blog = 'N';}
                if(!this.form.cdc.is_insta){this.form.cdc.is_insta = 'N';}
                if(!this.form.cdc.is_youtube){this.form.cdc.is_youtube = 'N';}
                
            } else {
                // 인사이트 / 영상교육 / 래퍼런스
                this.form = this.initSkinForm();
                this.form.cdc = this.initCdcForm();
            }
        },
        initSkinForm(){
            return {
                ca_name: this.code_category.length ? this.code_category[0].value : "", 
                mb_id: "", wr_1: "", wr_2: "", wr_3: "",
                wr_4: "", wr_5: "", wr_6: "", wr_7: "", wr_8: "", wr_9: "",
                wr_10: "", wr_11: "", wr_12: "", wr_13: "", wr_14: "", wr_15: "",
                wr_16: "", wr_17: "", wr_18: "", wr_19: "", wr_20: "", wr_ampm_user: "",
                wr_comment: "", wr_comment_reply: "", wr_content: "", wr_datetime: "",
                wr_email: "", wr_facebook_user: "", wr_file: "", wr_good: "", wr_hit: "",
                wr_homepage: "", wr_id: "", wr_ip: "", wr_is_comment: "", wr_last: "",
                wr_link1: "", wr_link1_hit: "", wr_link2: "", wr_link2_hit: "", wr_name: "",
                wr_nogood: "", wr_num: "", wr_option: "", wr_parent: "", wr_password: "",
                wr_reply: "", wr_seo_title: "", wr_subject: "", wr_twitter_user: "",
            }
        },
        initCdcForm(){
            return {
                wr_id: 0,
                bo_table: '',
                is_youtube: 'N',
                is_blog: 'N',
                is_insta: 'N',
                thumnailUrl: null,
                wr_cat_link: '',
                wr_mhash_1: '',
                wr_mhash_2: '',
                wr_mhash_3: '',
                wr_shash_1: '',
                wr_shash_2: '',
                wr_shash_3: '',
                wr_shash_4: '',
                wr_shash_5: '',
                wr_shash_6: '',
                wr_shash_7: '',
                wr_ytag: '',
                wr_video_link: '',
                wr_youtube_link: '',
                wr_cdc_content: '',
                wr_cdc_title: '',
                wr_comp_blog_link: '',
                wr_comp_insta_link: '',
                wr_comp_youtube_link: '',
                wr_is_comp: false,
            }
        },
        async setImages(){
            const fileCount = this.form.cdc.file.count;
            for(let i=0; i < fileCount; i++){
               const fileInfo = this.form.cdc.file[i];
               const fileSource = fileInfo.source;
               if(!fileSource) continue;
               const filePath = fileInfo.path;
               const fileName = fileInfo.file;
               const fileSrc = `${filePath}/${fileName}`;

               const response = await fetch(fileSrc);

               const data = await response.blob();
               const ext = fileSrc.split(".").pop();
               const metadata = { type: `image/${ext}` };
               const file = new File([data], fileName, metadata);
               this.bf_file[i] = file;
            }           
        },

        initSkinLocalStorage() {
            const bo_table = this.bo_table;
            const localStorage = this.localStorage;
            if(!localStorage.getItem(bo_table)){
                localStorage.setItem(bo_table, JSON.stringify([]));
            }
            const items = JSON.parse(localStorage.getItem(bo_table));
            for(const item of items){
                this.skinSaveList.push(item);
            }
           
        },

        // 카테고리 값
        setCateVal(ca_name){
            this.form.ca_name = ca_name;
        },

        async formSave(){
            //기본 입력 검사(필수 입력처리)
            this.$refs.form.validate();
            await this.$nextTick();
            if(!this.valid) return;

            //제목 및 게시글 작성 filter 
            const form = $('#fwrite')[0]; 
            const valid2 = fwrite_submit(form);
            if(!valid2) return;
          
            const formData = new FormData(form);
            //게시글 수정여부 있을경우 삭제여부 있는지 확인
            if(this.isModify) {
                for(const file of this.del_files){
                    formData.append("cdc_remove_files[]", file);
                }
            }

            // 비동기 진행시 token 생성 별도로 처리해야 함
            const token = get_write_token(this.bo_table);
            formData.append('token', token);
            $.ajax({
                url : `${g5_bbs_url}/write_update.php`,
                enctype: 'multipart/form-data',
                type: 'POST',
                data: formData,
                contentType : false,
                processData : false,
                cache: false,
            })
            .done(function (data){
                window.location.href = data;
                //$('#logtest').html(data);
            })
            .fail(function(){
                alert('게시글 저장 도중 에러가 발생하였습니다.');
             });    
        },

        autoSave(){
            // 임시 저장 처리
            const formData = this.form

            if(!formData.wr_subject){
                alert('제목을 입력해주세요.');
                return;
            }
            let saveData = {cdc : {}};

            const saveSkinTargets = ['ca_name', 'wr_subject'];
            const saveCdcTargets = ['is_blog', 'is_insta', 'is_youtube',
                                    'wr_mhash_1', 'wr_mhash_2', 'wr_mhash_3',
                                    'wr_shash_1', 'wr_shash_2', 'wr_shash_3',
                                    'wr_shash_4', 'wr_shash_5', 'wr_shash_6',
                                    'wr_shash_7', 'wr_video_link', 'wr_youtube_link',
                                    'wr_ytag'
                                ]
            // 일반 Skin 데이터
            for(const field of saveSkinTargets){
                saveData[field] = formData[field];
            }
            oEditors.getById["wr_content"].exec("UPDATE_CONTENTS_FIELD", []);
            // 스마트에디터(내용)
            saveData['wr_content'] = $('#wr_content').val();
            
            // CDC 데이터 
            for(const cdcField of saveCdcTargets){
                saveData["cdc"][cdcField] = formData["cdc"][cdcField];
            }

            const bo_table = this.bo_table;
            let dateTime = dateFormat(new Date());
            saveData["date"] = dateTime;
            // 저장 Key 생성
            this.skinSaveList.unshift(saveData);
            // 임시저장시 Value 값은 JSON String으로 변환 후 처리
            this.localStorage.setItem(bo_table, JSON.stringify(this.skinSaveList));
        },

        autosave_load(item){
            console.log('item : ', item);
            const keys = ['wr_subject', 'ca_name']
            // 제목, 카테고리
            for(const key of keys){
                this.form[key] = item[key]
            }

            //게시글내용 
            //기존 내용에서 초기화
            oEditors.getById["wr_content"].exec("SET_IR", [""]);
            //선택 된 임시 저장 리스트의 값 set
            oEditors.getById["wr_content"].exec("PASTE_HTML", [item.wr_content]); 

            //CDC(블로그, 인스타, 유튜브, 메인해시태그 1 ~ 3, 서브해시태그 1 ~ 7, 비디오링크, 유튜브링크, 유튜브태그)
            const cdc_keys = Object.keys(item.cdc);
            for(const cdc_key of cdc_keys){
                this.form.cdc[cdc_key] = item.cdc[cdc_key];
            }
        },

        autosave_remove(index){
           this.skinSaveList.splice(index, 1);
           console.log('autosave_remove : ', this.skinSaveList);
           // 해당 내용 삭제 후 localStorage에 재 저장
           const bo_table = this.bo_table;
           this.localStorage.setItem(bo_table, JSON.stringify(this.skinSaveList));
        }
    }
});

app.use(Quasar);
// 카테고리
app.component('category', categotyComponents);
app.component('imageform', imageformComponents);
app.component('inputvideo', inputVideoComponents);
const vm = app.mount('#q-app');