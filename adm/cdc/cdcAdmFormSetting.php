 <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.js?v=<?= CDC_VER ?>"></script>
<script>
    // vue setting
    // Vue 생성 전 setting 처리
    const list = <?php echo json_encode($list) ?>;
    const phpConfig = <?php echo json_encode($config) ?>;
</script>

<script src="<?= CDC_JS_URL ?>/cdcCommon.js?v=<?= CDC_VER ?>"></script>
<!-- CDC 모듈 Validate -->
<script src="<?= CDC_JS_URL ?>/adm/write/ValidateRules.js?v=<?= CDC_VER ?>"></script>

<script src="<?= CDC_JS_URL ?>/adm/write/cdcCompForm.js?v=<?= CDC_VER ?>"></script>

<!-- CDC 모듈 Admin-->
<script src="<?= CDC_JS_URL ?>/adm/read/admVue.js?v=<?= CDC_VER ?>"></script>
