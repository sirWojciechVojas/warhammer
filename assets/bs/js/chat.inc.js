$(document).ready(function()
{
	modalBox();
	$(window).on('resize', function (e) {
		modalBox();
	});
	discardInv();
	var minexp=$('#minexp').val();
	var nowexp=$('#nowexp').val();
	if(nowexp<minexp) $('#characterPanel .titleSpace .awans.btn-danger').addClass('disabled');
	else $('#characterPanel .titleSpace .awans.btn-danger').removeClass('disabled');

		var how = $('#characterStats .cechy').css('height');
		//var how = $('.coto').css('background');
		//alert(how);

	$('button[data-target="#exampleModalCenter"]').trigger('click');
	//$('button[data-target="#ModalCenter"]').trigger('click');

	$('#characterChanger').on('click','.glyph-icon', function (e) {
		slidePanel($(this));
	});
	$('#characterPanel .avatar').on('click','img', function (e) {
		slidePanel($(this));
	});
	$('#characterPanel .titleBar').on('click','div[data-toggle="modal"]', function (e) {
		$this = $(this);
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'HP'},
			success: function(response){
				//alert(response);
				$('body').append(response);
			  // Add response in Modal body
			//   activateTooltip();
			  executeHP();
			  $('#HPModalCenter').modal('show', $this);
			  // Display Modal
			}
		});
	});
	$('#characterStats .cCenter').on('click','.btn-danger[data-toggle="modal"]', function (e) {
		$this = $(this);
		var wTrait = $(this).closest('.cechy').attr('class');
		var key = $(this).data('key');
		var titleBar = 'Wykup Cechy ';
		var traitAct = $(this).prev().val();
		var traitAdv = $(this).prev().prev().prev().val();
		// alert(traitAct+'|'+traitAdv);
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'Trait', key: key, titleBar: titleBar, traitAct: traitAct, traitAdv: traitAdv, wTrait: wTrait},
			success: function(response){
				//alert(response);
				$('body').append(response);
			  // Add response in Modal body
				//activateTooltip();
				// Display Modal
				executeTrait();
				$('#TraitModalCenter').modal('show', $this);
			}
		});
	});
	$('#characterStats .cLeft').on('click','.btn-sm[data-toggle="modal"]', function (e) {
		$this = $(this);
		var titleBar = $(this).val()+' Monety';
		//alert(titleBar);
		var hBrass=$('#hBrass').val();
		$brass = $this.parent().parent().prev()[0].outerHTML;
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'Brass', titleBar: titleBar, hBrass: hBrass},
			success: function(response){
				//alert(response);
				$('body').append(response);
			  // Add response in Modal body
				//activateTooltip();
				// Display Modal
				executeBrass();
				$('#BrassModalCenter').modal('show', $this);
				$('#Brass-line').html($brass);
				$('#Brass-line .crown + div input').val(0+' zk');
				$('#Brass-line .shilling + div input').val(0+' s');
				$('#Brass-line .brass + div input').val(0+' p');
				$('#Brass-line .brass').addClass('activated');

			}
		});
	});
	$('#characterPanel .titleSpace').on('click','.btn-success[data-toggle="modal"]', function (e) {
		$this = $(this);
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'PD'},
			success: function(response){
				//alert(response);
				$('body').append(response);
			  // Add response in Modal body
				//activateTooltip();
				executePD();
			  // Display Modal
			  	$('#PDModalCenter').modal('show', $this);
			}
		});
	});
	$('.abbRow').on('click','.abbList:not(.secList):not(.firstOfList)', function (e) {
		$this = $(this);
		var umzd = $(this).text();
		var titleBar = $(this).parents('.row').prev().find('.titleBar').text();
		var idUm=parseInt($(this).data('id'));
		var details=parseInt($(this).data('details'));
		// alert(umzd+'|'+idUm+'|'+titleBar);
		//alert(titleBar);
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'UmZd', umzd: umzd, titleBar: titleBar, idUm: idUm, details: details },
			success: function(response){
				//alert(response);
				$('body').append(response);
			  // Add response in Modal body
			//   activateTooltip();
				executeUmZd(titleBar);
			  // Display Modal
				$('#UmZdModalCenter').modal('show', $this);
			}
		});
	});
	$('#characterPanel .titleBar .tPlace').hover(function(){
		//alert($(this).prevAll().eq(1).css('width'));
		$(this).prevAll().eq(1).find('.HPBar').toggleClass('ShineClass');
	});
	activateTooltip();
	$('#characterChanger').on('click','li', function (e) {
		var ID=$(this).attr('data-id');
		var usedname=$(this).attr('data-usedname');
		var sesi = {'ID':ID,'USEDNAME':usedname};
		//alert(sesi);

		$.ajax({
			type: 'POST',
			url: 'chat/change',
			data: {
				'sesi': sesi
				},
			success: function() {
				location.reload();
			}
		});
	});
	setPanel($('#skillsPanel').find('.footerBar input'));
	setPanel($('#talentsPanel').find('.footerBar input'));
	$('#exampleModalCenter').on('shown.bs.modal', function (e) {
		// alert($('.iCenter').width());
		var w=$('.iCenter').width();
		var bountify= $('#bountify').val();
		$.ajax({
			type: 'POST',
			url: 'chat/inventory',
			data: {
				w: w, nrRow:2
			},
			// dataType:'json',
			success: function(data) {
				var data = JSON.parse(data);
				console.log(data);
				$('#personal-inventory').html(data.personal);
				$('#ground-inventory').html(data.ground);
				$.getScript(bountify);
				//activateTooltip();
				//return false;
			},
			error : function(err) {
				console.log(JSON.stringify(err));
			}
		});
	});
	$('#exampleModalCenter').on('hide.bs.modal', function (e) {
		setPanel($('#skillsPanel').find('.footerBar input'));
		setPanel($('#talentsPanel').find('.footerBar input'));
	});
	$('#skillsPanel,#talentsPanel').on('click','.footerBar input', function (e) {
		slidePanel($(this));
	});
	$('#characterStats').on('click','.buttonSkills, .buttonTalents', function (e) {
		var width = '0';
		//alert($('#exampleModalCenter').css('z-index'));
		$('#skillsPanel,#talentsPanel').css({
			'visibility':'visible',
			'z-index': '1051',
			'position': 'absolute'
		});
		//e.preventDefault();
		if($(this).hasClass('buttonSkills')) $('#skillsPanel').animate({left:width},1000);
		else if ($(this).hasClass('buttonTalents')) $('#talentsPanel').animate({right:width},1000);
	});

	$('#characterPromotion .modal-footer').on('click','.btn-danger', function (e) {
		//alert('GOOD');
		//$this = $(this);
		//var skillName = $(this).text().split(' (').shift();
		//$('.tooltip').tooltip('hide');
		$.ajax({
			type: 'POST',
			url: 'chat/awans',
			data: {
				ID: 94,
			},
			/*dataType:"json",*/
			success: function(data) {
				//var data = JSON.parse(data);
				//alert(JSON.stringify(data));
				alert(data);
				/*
				$this.parent().html(data).animate({scrollTop: 0}, 0);
				activateTooltip();
				tooltipCss();
				*/
			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});
	});

	$(document).on('click','.secList', function (e) {
		$this = $(this);
		var skillName = $(this).text().split(' (').shift();
		//alert(skillName);
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
				$('[data-toggle="tooltip"]').tooltip('enable');
				//return false;
			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});
	});
	tooltipCss();
	$('.chatbox').animate({scrollTop: $('.chatbox').prop('scrollHeight')}, 500);

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
	$('.btn-group').on('click','.btn:not(.btn-success)',function(){
		// alert($(this).parent().attr('class'));
		var dice=$(this).text();
		// alert(dice);
		var max=$(this).val();
		var roll=(Math.floor(Math.random()*max)+1);
		$('form[name="sendMessage"] input[name="message"]').hide();
		$('form[name="sendMessage"] input[name="message"]').val('Wynik twojego rzutu <b>'+dice+'</b> to =><b>'+roll+'</b><=');
		$('form[name="sendMessage"]').trigger('submit');

	});
});
function discardInv(){
	var w=$('#characterPanel').width();
	// alert(w);
	var bountify= $('#bountify').val();
	$.ajax({
		type: 'POST',
		url: 'chat/inventory',
		data: {
			w: w/1.8, nrRow:1
		},
		success: function(data) {
			$('#discard-inventory').html(data);
			$.getScript(bountify);
			//activateTooltip();
			//return false;
		},
		error : function(err) {
			console.log(JSON.stringify(err));
		}
	});
}
function tooltipCss(){
	$('[data-toggle="tooltip"]').on('inserted.bs.tooltip', function (e) {
		//alert($(this).hasClass('abbList'));
		//alert($(this).attr('class'));
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
		else if($(this).hasClass('skill-talent')){
			$('.tooltip-inner h4').css({
				'text-align':'justify',
				'font': 'normal 1.85vh Garamond, Verdana, sans-serif',
				'padding':'2% 5%',

			});
			$('.tooltip.show,.tooltip-inner,.tooltip-inner h3,.tooltip-inner h4').css({
				'width':'360px',
				'max-width': '100%'
			});
			$('.tooltip-inner h4').css({
				'text-indent': '2.5em',
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
function executeUmZd(titleBar){
	$('#UmZdModalCenter').on('hide.bs.modal', function(event) {
		$(this).remove();
	});
	$('#UmZdModalCenter').on('show.bs.modal', function(event) {
		//var title = ['Zmniejsz Punkty Żywotności','Zwiększ Punkty Żywotności'];
		// alert($(event.relatedTarget).closest('.abbRow').data('button'));
		$(this).find('.modal-footer .btn-danger').text($(event.relatedTarget).closest('.abbRow').data('button'));
		//alert($(event.relatedTarget).closest('.abbRow').data('button'));
		//var curexp = parseInt($('#curexp').text());
		var curexp =  $('#curexp').val();
		if(curexp<100) $(this).find('.modal-footer .btn-danger').addClass('disabled').before('<div class="alert alert-danger p-1 disabled" style="margin-top: 15px">Nie posiadasz wymaganej ilości 100 PD!</div>');
		// $(this).find('.modal-footer')
		$(this).find('.desc').html($(event.relatedTarget).data('original-title'));

		//alert(titleBar);
		// alert($(event.relatedTarget).attr('title'));
		$("#UmZdModalLongTitle").text('Wykup '+titleBar);
	});
	$('#UmZdModalCenter .modal-footer').on('click','.btn-danger', function (event) {
		var titleBar = $(this).parent().prev().prev().find('.titleBar').text();
		var idUm=parseInt($('#idUm').val());
		var details=parseInt($('#details').val());
		var SOrTName=$('#HPMenu h3').text();
		if(isNaN(details)) details="";
		if(titleBar=='Wykup Umiejętności'){var co = 'um'; var what ='umiejętność';}
		else if(titleBar=='Wykup Zdolności'){var co = 'zd'; var what = 'zdolność';}
		//alert($(event.relatedTarget).html());
		// alert(titleBar+'|'+idUm+'|'+co);
		$.ajax({
			type: 'POST',
			url: 'chat/ransom_pd',
			data: {
				idUm: idUm, details: details, co: co
			},
			// dataType:"json",
			success: function(data) {
				// alert(JSON.stringify(data));
				//console.log(data);
				$('form[name="sendMessage"] input[name="message"]').hide();
				$('form[name="sendMessage"] input[name="message"]').val('BG wykupił '+what+': <b>'+SOrTName+'</b>');
				$('form[name="sendMessage"]').trigger('submit');
				location.reload();
			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});
	});
}
function executeTrait(){
	$('#TraitModalCenter').on('hide.bs.modal', function(event) {
		$(this).remove();
	});
	$('#TraitModalCenter').on('show.bs.modal', function(event) {
		// $(this).find('input[type="number"]').val(0);
		var wTrait=$('#wTrait').val();
		if(wTrait.match('cechyGlowne'))	var expMax = 23;
		else if(wTrait.match('cechyDrugorzedne-1'))	var expMax = 100;
		else var expMax = 0;
		var symbol='+';
		$(this).find('.modal-footer .btn-danger').text($(event.relatedTarget).closest('.cechy').data('button'));
		var curexp =  $('#curexp').val();
		if(curexp<expMax) $(this).find('.modal-footer .btn-danger').addClass('disabled').before('<div class="alert alert-danger p-1 disabled" style="margin-top: 15px">Nie posiadasz minimum wymaganej ilości '+expMax+' PD!</div>');
		$(this).find('.addictionBar .badge-primary input').val(curexp);
		var addiction =$(this).find('.modal-body.cP button.addiction');
		addiction.each(function(index){
			$(this).removeClass('disabled');
			if(index<3) {
				$(this).text(symbol+$(this).val());
			}
			else if(index==3) {
				$(this).val(0);
			}
		});
	});
	$('.btn-group').on('click','.btn-info',function(event){
		var wTrait=$('#wTrait').val();
		//alert(wTrait);
		var wykupBtn=$(this).closest('.modal-content').find('.modal-footer .btn-danger');
		var curexp=parseInt($(this).closest('.addictionBar').find('.badge-primary input').val());
		var traitAdv=parseInt($('#traitAdv').val());
		if($(this).hasClass('addiction')) {
			if($(this).text()=='max' || $(this).text()=='reset'){
				var a = 0;
				var b = parseInt($(this).val());
			}
			else {
				var a = parseInt($(this).closest('.addictionBar').find('.btn-group input:last-of-type').val());
				var b = parseInt($(this).text());
			}
			// alert('a='+a+'|b='+b);
			// if(a==null) a=0;
			// else a=parseInt(a);
			c=parseInt(a+b);
			if(c<=traitAdv){
				if(wTrait.match('cechyGlowne'))	var d = (c%5==0) ? 100*(c/5) : 100*Math.floor(c/5)+23*(c%5);
				else if(wTrait.match('cechyDrugorzedne-1'))	var d = c*100;
				else var d = 0;

				// alert(d+'|'+curexp+'|'+wykupBtn.prev().hasClass('alert'));
				if(wykupBtn.prev().hasClass('alert')){
					wykupBtn.removeClass('disabled');
					wykupBtn.prev().remove();
					if(curexp<23 && d<curexp) wykupBtn.addClass('disabled').before('<div class="alert alert-danger p-1 disabled" style="margin-top: 15px">Nie posiadasz minimum wymaganej ilości 23 PD!</div>');
					else if(d>curexp) wykupBtn.addClass('disabled').before('<div class="alert alert-danger p-1 disabled" style="margin-top: 15px">Nie posiadasz wystarczającej ilości '+d+' PD!</div>');
				}
				else if(!wykupBtn.prev().hasClass('alert') && d>curexp) wykupBtn.addClass('disabled').before('<div class="alert alert-danger p-1 disabled" style="margin-top: 15px">Nie posiadasz wystarczającej ilości '+d+' PD!</div>');
				$(this).closest('.addictionBar').find('.badge-warning input').val(d);
				$(this).closest('.addictionBar').find('.btn-group input:last-of-type').val(c);
			}


		}
	});
	$('#TraitModalCenter .modal-footer').on('click','.btn-danger', function (event) {
		var traitName = $('#traitName').val();
		var NazwaCechy = $('#NazwaCechy').val();
		var traitAct = parseInt($('#traitAct').val());
		var traitInc = $(this).parent().prev().find('.addictionBar .btn-group input:last-of-type').val();
		var expCost = $(this).parent().prev().find('.addictionBar .badge-warning input').val();
		// alert(traitName+'|'+traitInc+'|'+expCost);
		$.ajax({
			type: 'POST',
			url: 'chat/ransom_trait',
			data: {
				traitName: traitName, traitInc: traitInc, traitAct: traitAct, expCost: expCost
			},
			// dataType:"json",
			success: function(data) {
				// alert(JSON.stringify(data));
				// alert(data);
				//console.log(data);
				$('form[name="sendMessage"] input[name="message"]').hide();
				$('form[name="sendMessage"] input[name="message"]').val('BG powiększył cechę <u>'+NazwaCechy+'</u> o <b>'+traitInc+'</b> punktów.');
				$('form[name="sendMessage"]').trigger('submit');

				location.reload();
				$('button[data-target="#exampleModalCenter"]').trigger('click');
			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});

	});
};
function executeBrass(){
	$('#BrassModalCenter').on('hide.bs.modal', function(event) {
		$(this).remove();
	});
	$('#BrassModalCenter').on('show.bs.modal', function(event) {

		//$(this).find('input[type="number"]').val(0);
		var symbol=$(event.relatedTarget).data('symbol');
		var addiction =$(this).find('.modal-body.cP button.addiction');
		addiction.each(function(index){
			$(this).removeClass('disabled');
			if(index<5) {
				$(this).text(symbol+$(this).val());
			}
			else if(index==5) {
				$(this).val(0);
			}
		});
	});
	$('#BrassModalCenter').on('click', '.crown,.shilling,.brass', function(event) {
		$(this).parent().find('div').removeClass('activated');
		$(this).addClass('activated');
	});
	$('#BrassModalCenter .modal-footer').on('click','.btn-danger', function (event) {
		var brass = $(this).parent().prev().find('.addictionBar .btn-group input:last-of-type').val();
		//alert(brass);

		var titleBar = $(this).parent().prev().prev().find('.titleBar').text();

		//alert($(event.relatedTarget).html());
		// alert(titleBar+'|'+idUm+'|'+co);
		$.ajax({
			type: 'POST',
			url: 'chat/brass',
			data: {
				brass: brass
			},
			// dataType:"json",
			success: function(data) {
				// alert(JSON.stringify(data));
				//console.log(data);
				$('form[name="sendMessage"] input[name="message"]').hide();
				$('form[name="sendMessage"] input[name="message"]').val('BG  '+titleBar+': <b>'+brass+'</b> pensów');
				$('form[name="sendMessage"]').trigger('submit');

				location.reload();
				$('button[data-target="#exampleModalCenter"]').trigger('click');
			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});

	});
	$('.btn-group').on('click','.btn-warning',function(){
		// alert($(this).parent().parent().attr('class'));
		var titleBar = $(this).closest('.modal-body').prev().find('.titleBar').text().split('   ')[0];
		var upNum = (titleBar=='Wydaj Monety') ? 1 : 0;
		var hBrass = parseInt($('#hBrass').val());
		if($(this).hasClass('addiction')) {
			if($(this).text()=='max' || $(this).text()=='reset'){
				var a = 0;
				var b = parseInt($(this).val());
			}
			else {
				var a = parseInt($(this).closest('.addictionBar').find('.btn-group input:last-of-type').val());
				var b = parseInt($(this).text());
			}

			var mClass = $('#Brass-line .activated').attr('class').split(' ')[0];
			var d ={'crown':240,'shilling':12,'brass':1};
			var Brass=b*d[mClass]+a;
			// alert('hBrass='+hBrass+'|Brass='+Math.abs(Brass));
			if(upNum==1 && Math.abs(Brass)>hBrass) Brass=-hBrass;

			var e = {'crown':[Math.floor(Brass/240),Math.ceil(Brass/240),' zk'],'shilling':[Math.floor((Brass%240)/12),Math.ceil((Brass%240)/12),' s'],'brass':[(Brass%240)%12,(Brass%240)%12,' p']};
			$(this).closest('.addictionBar').find('.btn-group input:last-of-type').val(Brass);
			$(this).closest('.addictionBar').find('.crown + div input').val(e['crown'][upNum]+e['crown'][2]);
			$(this).closest('.addictionBar').find('.shilling + div input').val(e['shilling'][upNum]+e['shilling'][2]);
			$(this).closest('.addictionBar').find('.brass + div input').val(e['brass'][upNum]+e['brass'][2]);
			//alert($(this).closest('.addictionBar').html());
			return false;
		}
	});
}
function executePD(){
	$('#PDModalCenter').on('hide.bs.modal', function(event) {
		$(this).remove();
	});
	$('#PDModalCenter').on('show.bs.modal', function(event) {
		$(this).find('input[type="number"]').val(0);
		var symbol=$(event.relatedTarget).text();
		var a=$(event.relatedTarget).data('symbol');
		// alert(a);
		var title = ['Zmniejsz','Zwiększ'];
		$("#PDModalLongTitle").text(title[a]+' Punkty Doświadczenia');
		// var symbol = ['-','+'];
		var addiction =$(this).find('.modal-body.cP button.addiction');
		// var wounds = parseInt($(this).find('.btn-group').data('wounds'));
		// var HP = parseInt($(this).find('.btn-group').data('hp'));
		// alert(HP);
		addiction.each(function(index){
			$(this).removeClass('disabled');
			if(index<6) {
				$(this).text(symbol+$(this).val());
			}
			else if(index==6) {
				$(this).val(0);
			}
		});

	});
	$('.btn-group').on('click','.btn-success',function(){
		var wounds = parseInt($(this).closest('.btn-group').data('wounds'));
		var HP = parseInt($(this).closest('.btn-group').data('hp'));
		// alert($(this).parent().parent().attr('class'));
		if($(this).hasClass('addiction')) {
			if($(this).text()=='max' || $(this).text()=='reset'){
				var a = 0;
				var b = parseInt($(this).val());
			}
			else {
				var a = parseInt($(this).closest('.addictionBar').find('input').val());
				var b = parseInt($(this).text());
			}
			// alert('a='+a+'|b='+b);
			// if(a==null) a=0;
			// else a=parseInt(a);
			c=a+b;
			$(this).closest('.addictionBar').find('input').val(c);
			//alert($(this).closest('.addictionBar').html());
			return false;
		}
	});
	$('#HPMenu .modal-footer').on('click','.btn-danger', function (e) {
		var a = $(this).parent().prev().find('input[type=number]').val();
		// alert(a);
		//$this = $(this);
		//var skillName = $(this).text().split(' (').shift();
		//$('.tooltip').tooltip('hide');
		$.ajax({
			type: 'POST',
			url: 'chat/gain_pd',
			data: {
				ile: a,
			},
			/*dataType:"json",*/
			success: function(data) {
				var data = JSON.parse(data);
				//alert(JSON.stringify(data));
				var a = parseInt(data.ile);
				var b = parseInt(data.CUREXP);
				// $('#HPMenu .addictionBar .btn-group').attr('data-hp',b);
				// $('#HPMenu .addictionBar .btn-group').data('hp',b);
				// $('#HPMenu .addictionBar .btn-group').attr('data-wounds',c);
				// $('#HPMenu .addictionBar .btn-group').data('wounds',c);
				if(a>0) var co='zwiększył';
				else var co='zmniejszył';
				//var d = $('.tPlace').data('original-title');
				$('.tPlace').attr({'data-original-title':'<h5><b>Punkty Doświadczenia</b></h5><h6>'+b+'/'+c+'</h6>'});
				$('.HPBarPlace .HPBar').css('width',data.HPpercent+'%');
				$('#HPModalCenter').modal("hide");
				//$('.tPlace').data('original-title',5);

				$('form[name="sendMessage"] input[name="message"]').hide();
				$('form[name="sendMessage"] input[name="message"]').val('BG '+co+' swoje Punkty Doświadczenia =>z <b>'+(b-a)+'</b> na <b>'+b+'</b><=');
				$('form[name="sendMessage"]').trigger('submit');
				location.reload();
				/*
				$this.parent().html(data).animate({scrollTop: 0}, 0);
				activateTooltip();
				tooltipCss();
				*/
			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});
	});
}
function executeHP(){
	$('#HPModalCenter').on('hide.bs.modal', function(event) {
		$(this).remove();
	});
	$('#HPModalCenter').on('show.bs.modal', function(event) {
		$(this).find('input[type="number"]').val(0);
		var a=$(event.relatedTarget).data('symbol');
		// alert(a);
		var title = ['Zmniejsz','Zwiększ'];
		$("#HPModalLongTitle").text(title[a]+' Punkty Żywotności');
		var symbol = ['-','+'];
		var addiction =$(this).find('.modal-body.cP button.addiction');
		var wounds = parseInt($(this).find('.btn-group').data('wounds'));
		var HP = parseInt($(this).find('.btn-group').data('hp'));
		// alert(HP);
		addiction.each(function(index){
			$(this).removeClass('disabled');
			if(index<3) {
				if(a==0){
					if($(this).val()>HP) $(this).addClass('disabled');
					else $(this).removeClass('disabled');
				}
				else if(a==1){
					if($(this).val()>(wounds-HP)) $(this).addClass('disabled');
					else $(this).removeClass('disabled');
				}
				//$(this).val(symbol[a]+$(this).val());
				$(this).text(symbol[a]+$(this).val());
			}
			else if(index==3) {
				$(this).val(0);
			}
			else {

				if(a==0) $(this).val(-HP);
				else if(a==1) $(this).val(wounds-HP);
				//alert(HP);
			}

		});
		//alert($(this).find('.addictionBar').next().find('input').val());
		if(a==0) {
			$(this).find('.addictionBar').next().find('input').attr({
				'max':0,
				'min':-HP
			});
		}
		else if(a==1) {
			$(this).find('.addictionBar').next().find('input').attr({
				'max':(wounds-HP),
				'min':0
			});
		}
		//alert(addiction);
	});

	$('.btn-group').on('click','.btn:not(.btn-success)',function(){
		var wounds = parseInt($(this).closest('.btn-group').data('wounds'));
		var HP = parseInt($(this).closest('.btn-group').data('hp'));
		// alert($(this).parent().parent().attr('class'));
		if($(this).hasClass('addiction')) {
			if($(this).text()=='max' || $(this).text()=='reset'){
				var a = 0;
				var b = parseInt($(this).val());
			}
			else {
				var a = parseInt($(this).closest('.addictionBar').find('input').val());
				var b = parseInt($(this).text());
			}
			// alert('a='+a+'|b='+b);
			// if(a==null) a=0;
			// else a=parseInt(a);
			if(b<0){
				if((a+b)<-HP) var c = -HP;
				else var c = a+b;
			// alert((a+b)+'|'+c);
			}
			else{
				if((a+b)>(wounds-HP)) var c = wounds-HP;
				else var c = a+b;
			}
			$(this).closest('.addictionBar').find('input').val(c);
			//alert($(this).closest('.addictionBar').html());
			return false;
		}
		var dice=$(this).text();
		//alert(dice);
		var max=$(this).val();
		var roll=(Math.floor(Math.random()*max)+1);
		$('form[name="sendMessage"] input[name="message"]').hide();
		$('form[name="sendMessage"] input[name="message"]').val('Wynik twojego rzutu <b>'+dice+'</b> to =><b>'+roll+'</b><=');
		$('form[name="sendMessage"]').trigger('submit');

	});
	$('#HPMenu .modal-footer').on('click','.btn-danger', function (e) {
		var a = $(this).parent().prev().find('input[type=number]').val();
		//alert(a);
		//$this = $(this);
		//var skillName = $(this).text().split(' (').shift();
		//$('.tooltip').tooltip('hide');
		$.ajax({
			type: 'POST',
			url: 'chat/update_hp',
			data: {
				ile: a,
			},
			/*dataType:"json",*/
			success: function(data) {
				var data = JSON.parse(data);
				//alert(JSON.stringify(data));
				var a = parseInt(data.ile);
				var b = parseInt(data.HP);
				var c = parseInt(data.WOUNDS);
				$('#HPMenu .addictionBar .btn-group').attr('data-hp',b);
				$('#HPMenu .addictionBar .btn-group').data('hp',b);
				$('#HPMenu .addictionBar .btn-group').attr('data-wounds',c);
				$('#HPMenu .addictionBar .btn-group').data('wounds',c);
				if(a>0) var co='zwiększył';
				else var co='zmniejszył';
				//var d = $('.tPlace').data('original-title');
				$('.tPlace').attr({'data-original-title':'<h5><b>Punkty Żywotności</b></h5><h6>'+b+'/'+c+'</h6>'});
				$('.HPBarPlace .HPBar').css('width',data.HPpercent+'%');
				$('#HPModalCenter').modal("hide");
				//$('.tPlace').data('original-title',5);

				$('form[name="sendMessage"] input[name="message"]').hide();
				$('form[name="sendMessage"] input[name="message"]').val('BG '+co+' swoje Punkty Żywotności =>z <b>'+(b-a)+'</b> na <b>'+b+'</b><=');
				$('form[name="sendMessage"]').trigger('submit');

				/*
				$this.parent().html(data).animate({scrollTop: 0}, 0);
				activateTooltip();
				tooltipCss();
				*/
			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});
	});
}
function decodeHtml(str)
{
    var map =
    {
        '&amp;': '&',
        '&lt;': '<',
        '&gt;': '>',
        '&quot;': '"',
        '&#039;': "'"
    };
    return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) {return map[m];});
}
function slidePanel(element){
	var panel=element.parents().eq(2);
	var width=parseFloat(element.parent().css('width'))*(-1);
	var width = (element.hasClass('flipX')) ? 0 : width;
	var height=parseFloat(panel.css('height'))*(-1);//dla #characterPanel
	//alert('id:'+panel.attr('id')+'|height:'+height);
	if(panel.attr('id')=='skillsPanel') panel.animate({left:width},1000);
	else if(panel.attr('id')=='talentsPanel') panel.animate({right:width},1000);
	else if(panel.attr('id')=='characterChanger'){ panel.animate({left:width},1000); element.toggleClass('flipX');}
	else if(panel.attr('id')=='characterPanel') panel.animate({bottom:height},1000);
	panel.css({visibility: hidden});
}
function setPanel(element){
	var width=parseFloat(element.parent().width())*(-1);
	// alert(width);
	var panel=element.parents().eq(2);
	if(panel.attr('id')=='skillsPanel') panel.css({left:width});
	else if(panel.attr('id')=='talentsPanel') panel.css({right:width});
}
function modalBox(){
	//$('#exampleModalCenter').on('shown.bs.modal', function (e) {
		var height = $(window).height();
		var width = $(window).outerWidth();
		var elementWidth = parseInt($('.modal-dialog.cS').css('width'));
		//var how = $('.modal-body').css('padding-right');
		var wspX=850/1600;
		var sWidth=screen.width;
		var sHeight=screen.height;
		var ht=45/969*height;
		//var hc=850/969*height;
		var hc=850/1600*elementWidth;
		//var hb=805/1600*elementWidth;
		var hb=hc-ht;
		var hcG=308/969*height;
		//alert(elementWidth);
		$('.modal-title').css({'height':ht});
		$('#characterStats').css({'height':hc});
		$('.modal-body.cS,.cPanel').css({'height':hb});
		$('#characterStats .cechyGlowne').css({'height':hcG});
}