<ul>
    <!-- instagram -->
    <li>
        <a target="blank" v-if="isCompInsta" :href="skinViews.cdc.wr_comp_insta_link">
            <img src="<?= G5_URL ?>/images/instagram_on.png" />
        </a>
        <a v-else href="#" > 
            <img v-if="isInsta" src="<?= G5_URL ?>/images/instagram.png" />
        </a>
    </li>
    <!-- naver -->
    <li>
        <a target="blank" v-if="isCompBlog" :href="skinViews.cdc.wr_comp_blog_link">
            <img src="<?= G5_URL ?>/images/blog_on.png" alt="">
        </a>
        <a v-else href="#" > 
            <img v-if="isBlog" src="<?= G5_URL ?>/images/blog.png" />
        </a>
    </li>
    <!-- youtube -->
    <li>
        <a target="blank" v-if="isCompYoutube" :href="skinViews.cdc.wr_comp_youtube_link">
            <img src="<?= G5_URL ?>/images/youtube_on.png" alt="">
        </a>
        <a v-else href="#">
            <img v-if="isYoutube" src="<?= G5_URL ?>/images/youtube.png" />
        </a>
    </li>
</ul>