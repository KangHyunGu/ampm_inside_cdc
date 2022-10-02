	<div class="top_sch">
		<form name="fsearch" id="fsearch">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sop" value="and">
			
			<select name="sear_part" id="sear_part" class="form-control">
				<option value=''> 본부 </option>
				<?=codeToHtml($code_part5, $sear_part, "cbo", "")?>
			</select>
			<select name="sear_team" id="sear_team" class="form-control">
				<option value=''> 팀 </option>
				<?=codeToHtml($code_new_team, $sear_team, "cbo", "")?>
			</select>
			<select name="sfl" id="sfl">
				<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
				<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
				<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
				<?php if($bo_table == 'qna'){ ?>
				<option value="wr_name"<?php echo get_selected($sfl, 'wr_name'); ?>>작성자</option>
				<option value="wr_12,1"<?php echo get_selected($sfl, 'wr_12,1'); ?>>지정마케터</option>
				<?php }else if($bo_table == 'request'){ ?>
				<option value="wr_name"<?php echo get_selected($sfl, 'wr_name'); ?>>대행의뢰자</option>
				<option value="wr_12,1"<?php echo get_selected($sfl, 'wr_12,1'); ?>>담당마케터</option>
				<?php }else{ ?>
				<option value="wr_name"<?php echo get_selected($sfl, 'wr_name'); ?>>원글작성자</option>
				<option value="wr_18,1"<?php echo get_selected($sfl, 'wr_18,1'); ?>>담당자</option>
				<?php } ?>
			</select>
			<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="form-control" placeholder="검색어를 입력하세요.">
		  
			<button type="button" id="btn_submit" class="btn btn-primary">검색</button>
			<button type="button" id="reset" class="btn btn-secondary">초기화</button>
			<!--a href="<? G5_URL ?>/bbs/board.php?bo_table=insight" class="btn btn-link" target="_blank">인사이트 바로가기</a-->
		</form>
	</div>
