const app = Vue.createApp({
    setup() {

    },
    // [네이버] => 네이버
    // [카카오] => 카카오
    // [구글[유튜브]] => 구글[유튜브]
    // [META] => META
    // [바이럴] => 바이럴
    // [APP] => APP
    // [기타 매체] => 기타 매체
    // [매체 통합] => 매체 통합
    // [트렌드] => 트렌드
    // [솔루션] => 솔루션
    data() {
        return {
            bf_file: Array(10).fill(null),
            file : {},
            modelValue: {},
            img_src: '',
            input_src: '',
            input_src_youtube: '',
            message: 'Hello World CDC',
            isShow: true,
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

            //editor
            editor: {},

            bo_table: '',
            libPath: {},
            code_category: [],
            ca_name: '',
            form: null,
            thumnail_defaultUrl : null,
            VideoObj: null,

        }
    },

    created(){},
    mounted(){},

    computed: {
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
        }

    },
    watch: {
        "bf_file.2"() {
            console.log(this.bf_file);
            const reader =  new FileReader();
            reader.onload = (e) => {
                this.form.cdc.thumnailUrl = e.target.result;
            }
            reader.readAsDataURL(this.bf_file[2]);
        },
    },
    methods: {
        fetchData(write_fields) {
            if (write_fields.wr_id) {
                this.form = write_fields;
                // cdc 구현중
                this.form.cdc = {
                    // CDC 추가 매체
                    wr_id: 0,
                    bo_table: '',
                    is_youtube: 'N',
                    is_blog: 'N',
                    is_insta: 'N',
                    thumnailUrl: null,
                    wr_catban: '',
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
                    wr_youtube_link: '',
                    wr_cdc_content: '',
                    wr_cdc_title: '',
                    wr_comp_blog_link: '',
                    wr_comp_insta_link: '',
                    wr_comp_youtube_link: '',
                    wr_is_comp: false,
                    wr_brans_name: '',
                    wr_kpi: '',
                    wr_media: '',
                    wr_performance: '',
                    wr_ex_start_date: '',
                    wr_ex_end_date: '',
                };
            } else {
                // 인사이트 / 영상교육 / 래퍼런스
                this.form = {
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
                    cdc: {
                        // CDC 추가 매체
                        wr_id: 0,
                        bo_table: '',
                        is_youtube: 'N',
                        is_blog: 'N',
                        is_insta: 'N',
                        thumnailUrl: null,
                        wr_catban: '',
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
                        wr_youtube_link: '',
                        wr_cdc_content: '',
                        wr_cdc_title: '',
                        wr_comp_blog_link: '',
                        wr_comp_insta_link: '',
                        wr_comp_youtube_link: '',
                        wr_is_comp: false,
                        wr_brans_name: '',
                        wr_kpi: '',
                        wr_media: '',
                        wr_performance: '',
                        wr_ex_start_date: '',
                        wr_ex_end_date: '',
                    }
                }
            }
        },
        setBoardData(board_data) {
            this.bo_table = board_data;
        },

        thumnailFileOpen(){
            // 파일 dialog open
            this.$refs.thumnail.pickFiles();
        },

        changeState(e){
            console.log('e : ', e);
        },
       
        fileUpload(e){
           
        },
        
        // 카테고리 값
        setCateVal(ca_name){
            this.form.ca_name = ca_name;
        },

        async formSave(self){
            console.log('self : ', self);

            oEditors.getById["wr_content"].exec("UPDATE_CONTENTS_FIELD", []);
            console.log('Smart Editor content : ', $('#wr_content').val());

            console.log('bf_files : ', this.bf_file);
            const form = $('#fwrite')[0]; 
            const formData = new FormData(form);
            //console.log(formData);
            // console.log('bf_file[0]', $('input[name="bf_file[]"]')[0].prop('files')[0]);
            // console.log('bf_file[1]', $('input[name="bf_file[]"]')[1].prop('files')[0]);
            // console.log('bf_file[2]', $('input[name="bf_file[]"]')[2].prop('files')[0]);
            // console.log('bf_file[3]', $('input[name="bf_file[]"]')[3].prop('files')[0]);
           
           
            //console.log('$data222 : ', $data);

            // 비동기 진행시 token 생성 별도로 처리해야 함
            const token = get_write_token(this.bo_table);
            formData.append('token', token);
            console.log('`${g5_bbs_url}/write_update_cdc.php` : ', `${g5_bbs_url}/write_update_cdc.php`);
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
                console.log('test : ', data);
                $('#logtest').html(data);
            })
            .fail(function(){
                alert('error');
             });    
        },

        onSubmit(event){
            console.log('onSubmit : ', event);
        },

       async inputYoutubeLink(e){
            const self = this;
            const url = e.target.value;
            try{
                $.ajax({
                    type: 'GET',
                    url: url,
                    crossDomain: true,
                    dataType: 'jsonp',
                    success: function (data) {},
                    error: function (request, status, error) {
                        if(request.status == 200 && request.statusText == 'success'){
                            self.form.cdc.wr_youtube_link = url;
                        } else {
                            self.form.cdc.wr_youtube_link = '';
                        }
                    }
                });
            } catch(e){
                self.form.cdc.wr_youtube_link = '';
            }
        }
    }
});

app.use(Quasar);
// 카테고리
app.component('category', categotyComponents);
app.component('thumnail', thumnailComponents);
console.log('app : ', app);
const vm = app.mount('#q-app');