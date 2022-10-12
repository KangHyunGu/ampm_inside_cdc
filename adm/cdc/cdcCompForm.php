<button @click.prevent="cdcModelCompClose" class="close">&times;</button>
<div class="cdc-title">링크</div>

<cdc_comp_form :wr_id="curList.wr_id" :bo_table="curList.bo_table" :is_blog="curList.is_blog == 'Y'" :is_insta="curList.is_insta == 'Y'" :is_youtube="curList.is_youtube == 'Y'" :wr_comp_blog_link="curList.wr_comp_blog_link" :wr_comp_insta_link="curList.wr_comp_insta_link" :wr_comp_youtube_link="curList.wr_comp_youtube_link" :g5_url="'<?php echo G5_URL; ?>'" :action_url="'<?php echo $action_url; ?>'" />