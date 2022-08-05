

const app = Vue.createApp({
    setup() {

    },
    //[네이버] => 네이버
    //[카카오] => 카카오
    //[구글[유튜브]] => 구글[유튜브]
    //[META] => META
    //[바이럴] => 바이럴
    //[APP] => APP
    //[기타 매체] => 기타 매체
    //[매체 통합] => 매체 통합
    //[트렌드] => 트렌드
    //[솔루션] => 솔루션
    data() {
        return {
            message: 'Hello World CDC',
            isShow: true,
            bo_table: {},
            config: {},
            code_category: [],
            form: {},
            is_blog: 'N',
            is_insta: 'N',
            is_youtube: 'N',
        }
    },

    created() {

    },

    computed: {
        optArrKeys() {
            return Object.keys(this.optArr);
        }

    },
    methods: {
        fetchData(write_fields) {
            if (write_fields.length) {
                this.form = write_fields;
                // cdc 구현중
                this.form.cdc = {};
            } else {
                // 인사이트 / 영상교육 / 래퍼런스
                this.form = {
                    wr_id: 0,
                    ca_name: "", mb_id: "", wr_1: "", wr_2: "", wr_3: "",
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
                        is_youtube: this.is_youtube,
                        is_blog: this.is_blog,
                        is_insta: this.is_insta,
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
        }
    }
});
app.use(Quasar);
const vm = app.mount('#q-app');
