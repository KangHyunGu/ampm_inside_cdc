<!-- JavaScript Method(Vue.js 3) -->
<script src="<?= CDC_JS_URL ?>/cdcCommon.js?v=<?= CDC_VER ?>"></script>

<script>
    const board_data = <?php echo json_encode($board); ?>;
    const write_fields = <?php echo json_encode($write); ?>;
    const bo_table = board_data.bo_table;
</script>

<script src="<?= CDC_JS_URL ?>/write/DragAndDrop.js?v=<?= CDC_VER ?>"></script>
<script src="<?= CDC_JS_URL ?>/write/categoryComponents.js?v=<?= CDC_VER ?>"></script>
<script src="<?= CDC_JS_URL ?>/write/imageformComponents.js?v=<?= CDC_VER ?>"></script>
<script src="<?= CDC_JS_URL ?>/write/inputvideoComponents.js?v=<?= CDC_VER ?>"></script>
<script src="<?= CDC_JS_URL ?>/write/ValidateRules.js?v=<?= CDC_VER ?>"></script>
<script src="<?= CDC_JS_URL ?>/write/cdcWriteFormVue.js?v=<?= CDC_VER ?>"></script>