$(document).ready(function() {

	$('#m_quick').click(function(){

		$('#m_quick_open').addClass('on');
		$(this).addClass('on');
	});


    
    $('#m_quick_open .close').click(function(){

		$('#m_quick_open').removeClass('on');
		$('#m_quick').removeClass('on');
	});

    

});