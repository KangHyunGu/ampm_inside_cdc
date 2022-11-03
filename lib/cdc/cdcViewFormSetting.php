<?php $writer = get_marketer($write['wr_17']); ?>
<script src="<?= CDC_JS_URL ?>/cdcCommon.js?v=<?= CDC_VER ?>"></script>
<script>
	const viewData = <?php echo json_encode($view) ?>;
	const is_admin = '<?php echo $is_admin ?>';
	const member = <?php echo json_encode($member) ?>;
	const bo_table = '<?php echo $bo_table ?>';
	const writer = <?php echo json_encode($writer) ?>;
</script>
<!-- CDC 모듈 -->
<script src="<?= CDC_JS_URL ?>/read/cdcReadVue.js?v=<?= CDC_VER ?>"></script>