<script>
	vm.$data.config = {
		cdc_path: '<?= CDC_PATH ?>',
		cdc_url: '<?= CDC_URL ?>',
		cdc_css_url: '<?= CDC_CSS_URL ?>',
		cdc_js_url: '<?= CDC_JS_URL ?>',
		G5_URL : '<?= G5_URL ?>',
	}

	vm.$data.action_url = '<?= $action_url?>'

	vm.$data.formHiddenData = {
			uid : '<?= get_uniqid(); ?>',
			w   : '<?= $w ?>',
			wr_id : '<?= $wr_id ?>',
			sca : '<?= $sca ?>',
			sfl : '<?= $sfl ?>',
			stx : '<?= $stx ?>',
			spt : '<?= $spt ?>',
			sst : '<?= $sst ?>',
			sod : '<?= $sod ?>',
			page : '<?= $page ?>'
	}
		
    vm.$data.is_html = '<?= $is_html ?>';
    vm.$data.is_secret = '<?= $is_secret ?>';
    vm.$data.is_notice = '<?= $is_notice ?>';
    vm.$data.is_mail = '<?= $is_mail ?>';
    vm.$data.is_admin = '<?= $is_admin ?>';
    vm.$data.secret_checked = '<?= $secret_checked ?>'
    vm.$data.recv_email_checked = '<?= $reve_email_checked ?>';
    vm.$data.is_category = '<?= $is_category ?>';

    vm.$data.editor = {
        write_min : '<?php $write_min ?>',
        write_max : '<?php $write_max ?>'
    }

    const catNames = board_data.bo_category_list.split("|");

    for(const val of catNames){
        vm.$data.code_category.push({
            label : val,
            value : val,
            name: 'ca_name',
        })
    }

    //vm.fetchData(write_fields);
    //vm.initSkinLocalStorage();


    console.log('vm.$data.form : ', vm.$data.form);
    console.log('write_fields : ', write_fields);
    console.log('board_data : ', board_data);
    console.log('vm.$data.config : ', vm.$data.config);
    console.log('file', vm.$data.files)

    console.log('vm.allData : ', vm.$data);
    console.log('vm : ', vm.$);
    console.log('Ruels : ', rules);

    vm.test();
</script>
