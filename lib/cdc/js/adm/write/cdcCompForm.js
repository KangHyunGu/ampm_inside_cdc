const compForm = {
    name: 'cdc_comp_form',
    props: {
        wr_id: {
            type: Number,
            default: null,
        },
        bo_table: {
            type: String,
            default: '',
        },
        is_blog: {
            type: Boolean,
            default: false
        },
        is_insta: {
            type: Boolean,
            default: false
        },
        is_youtube: {
            type: Boolean,
            default: false
        },
        wr_comp_blog_link: {
            type: String,
            default: ''
        },
        wr_comp_insta_link: {
            type: String,
            default: ''
        },
        wr_comp_youtube_link: {
            type: String,
            default: ''
        },
        g5_url: {
            type: String,
            default: ''
        },
        action_url: {
            type: String,
            default: '',
        },

    },
    data() {
        return {
            valid: true,

            form: {
                wr_comp_blog_link: '',
                wr_comp_insta_link: '',
                wr_comp_youtube_link: '',
            }

        }
    },



    template: `
    <q-form name="cdcCompForm" ref="cdcCompForm" id="cdcCompForm" @submit.prevent="cdcCompSave" method="post" autocomplete="off" :action="action_url">
        <q-input type="hidden"  v-show="false" name="wr_id" id="wr_id" v-model="wr_id" />
        <q-input type="hidden" v-show="false" name="bo_table" id="bo_table" v-model="bo_table" />
        <q-input type="hidden" v-show="false" name="is_blog" id="is_blog" v-model="is_blog" />
        <q-input type="hidden" v-show="false" name="is_insta" id="is_insta" v-model="is_insta" />
        <q-input type="hidden" v-show="false" name="is_youtube" id="is_youtube" v-model="is_youtube" />

        <div class="cdc-con-box">
            <div class="write-area blog" v-if="is_blog">
                <img :src="g5_url + '/images/cdc-blog.png'">
                <q-input type="text" name="wr_comp_blog_link" id="wr_comp_blog_link" v-model="form.wr_comp_blog_link" placeholder="URL을 입력하세요." :rules="[Rules.require({label : '블로그 완료 링크'})]" :lazy-rules="true" size="90">
            </div>
            <div class="write-area instagram" v-if="is_insta">
                <img :src="g5_url + '/images/cdc-instagram.png'">
                <q-input type="text" name="wr_comp_insta_link" id="wr_comp_insta_link" v-model="form.wr_comp_insta_link" placeholder="URL을 입력하세요." :rules="[Rules.require({label : '인스타 완료 링크'})]" :lazy-rules="true" size="90">
            </div>
            <div class="write-area youtube" v-if="is_youtube">
                <img :src="g5_url + '/images/cdc-youtube.png'">
                <q-input type="text" name="wr_comp_youtube_link" id="wr_comp_youtube_link" v-model="form.wr_comp_youtube_link" placeholder="URL을 입력하세요." :rules="[Rules.require({label : '유튜브 완료 링크'})]" :lazy-rules="true" size="90">
            </div>
            <button class="write-btn">확인</button>
        </div>
    </q-form>
    `,

    computed: {
        Rules: () => rules,
    },

    mounted() {
        const wr_comp_links = ['wr_comp_blog_link', 'wr_comp_insta_link', 'wr_comp_youtube_link']

        for (const name of wr_comp_links) {
            this.form[name] = this[name];
        }
    },

    methods: {
        async cdcCompSave($event) {
            this.$refs.cdcCompForm.validate();
            await this.$nextTick();
            if (!this.valid) return;
            $event.target.submit();
        }
    }
}
