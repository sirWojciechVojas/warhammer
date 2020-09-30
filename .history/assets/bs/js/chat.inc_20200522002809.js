$(document).ready(function()
{
	modalBox();
	$(window).on('resize', function (e) {
		modalBox();
	});
		var how = $('#characterStats .cechy').css('height');
		//var how = $('.coto').css('background');
		//alert(how);

	//$('button[data-target="#exampleModalCenter"]').trigger('click');

	activateTooltip();
	$('#skillsPanel').on('click','.footerBar input', function (e) {
		//alert('cliknieto');
		var width=parseFloat($(this).parent().css('width'))*(-1);
		//alert(width);
		$('#skillsPanel').animate({left:width},1000);
	});
	$('#talentsPanel').on('click','.footerBar input', function (e) {
		//alert('cliknieto');
		var width=parseFloat($(this).parent().css('width'))*(-1);
		//alert(width);
		$('#talentsPanel').animate({right:width},1000);
	});

	$(document).on('click','.secList', function (e) {
		$this = $(this);
		var skillName = $(this).text().split(' (').shift();
		$('.tooltip').tooltip('hide');
		$.ajax({
			type: 'POST',
			url: 'chat/rozne',
			data: {
				skillName: skillName,
			},
			success: function(data) {
				//alert(data);
				$this.parent().html(data).animate({scrollTop: 0}, 0);
				activateTooltip();
				tooltipCss();
				//return false;
			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});
	});
	tooltipCss();
	$('.chatbox').animate({scrollTop: $('.chatbox').prop('scrollHeight')}, 500);
	$('.btn-group').on('click','.btn:not(.btn-success)',function(){
		var dice=$(this).text();
		//alert(dice);
		var max=$(this).val();
		var roll=(Math.floor(Math.random()*max)+1);
		$('form[name="sendMessage"] input[name="message"]').hide();
		$('form[name="sendMessage"] input[name="message"]').val('Wynik twojego rzutu <b>'+dice+'</b> to =><b>'+roll+'</b><=');
		$('form[name="sendMessage"]').trigger('submit');

	});

	$('.row').on('submit','form[name="sendMessage"]',function(){
		var messageObj=$(this).find('input[name="message"]');
		var message=messageObj.val();
		//alert(message);
		$.ajax({
			type: 'POST',
			url: 'chat/send',
			data: {
				message: message,
			},
			success: function(data) {
				$('.chatbox').html(data).animate({scrollTop: $('.chatbox').prop('scrollHeight')}, 500);
				messageObj.val(null);
				$('form[name="sendMessage"] input[name="message"]').show();
				activateTooltip();
				//return false;
			},
			error : function(err) {
				console.log(JSON.stringify(err));
			}
		});

		return false;
	});
});
function tooltipCss(){
	$('[data-toggle="tooltip"]').on('inserted.bs.tooltip', function (e) {
		//alert($(this).hasClass('abbList'));
  		if($(this).hasClass('abbList')){
			$('.tooltip-inner h4').css({
				'text-align':'justify',
				'font': 'normal 0.85vw Garamond, Verdana, sans-serif',
				'padding':'2% 8%',

			});
			$('.tooltip.show,.tooltip-inner,.tooltip-inner h3,.tooltip-inner h4').css({
				'width':'320px',
				'max-width': '100%'
			});
		}
	});
}
function activateTooltip(){
	$('[data-toggle="tooltip"]').tooltip({
		html: true,
		animated : 'fade',
   		container: 'body',
		boundary: 'viewport'
	});
}
function modalBox(){
	//$('#exampleModalCenter').on('shown.bs.modal', function (e) {
		var height = $(window).height();
		//var width = $(window).width();
		//var how = $('.modal-body').css('padding-right');
		var sWidth=screen.width;
		var sHeight=screen.height;
		//alert(sWidth);
		var ht=43/969*height;
		var hc=850/969*height;
		var hb=805/969*height;
		var hcG=308/969*height;
		$('.modal-title').css({
			'height':ht,
		});
		$('#characterStats').css({
			'height':hc,
		});
		$('.modal-body.cS,.cPanel').css({
			'height':hb,
		});
		$('#characterStats .cechyGlowne').css({
			'height':hcG,
		});

}