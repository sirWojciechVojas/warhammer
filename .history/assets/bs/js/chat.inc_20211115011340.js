jQuery(function()
{
	// $( "#characterPanel" ).draggable({handle: ".avatar", cursor: "move", containment: "body", scroll: false });
	$spinner = '<div class="row d-flex w-100 h-100 pm-0 align-items-center justify-content-center"><div class="spinner-border text-info"></div></div>';
	modalBox();
	$(window).on('resize', function (e) {
		modalBox();
		inventory('discard');
		inventory('personal');
		inventory('ground');
		inventory('A');
		inventory('B');
		inventory('handy');
	});
	inventory('discard');
	inventory('personal');
	inventory('ground');
	inventory('A');
	inventory('B');
	inventory('handy');
	var minexp=$('#minexp').val();
	var nowexp=$('#nowexp').val();
	// alert(nowexp);
	if(nowexp<minexp || nowexp==0) $('#characterPanel .titleSpace .awans.btn-danger').addClass('disabled');
	else $('#characterPanel .titleSpace .awans.btn-danger').removeClass('disabled');

	var W1=screen.width;
	var H1=screen.height;
		//var how = $('.coto').css('background');
		// alert(W1+' x '+H1);

	$('button[data-target="#trading"]').trigger('click');
	// $('button[data-target="#exampleModalCenter"]').trigger('click');
	// $('button[data-target="#ModalCenter"]').trigger('click');
	// $('#characterStats .cCenter').on('click','.skill-talent[data-toggle="tooltip"]', function (e) {
	// alert('wow');
	// 	$(this).attr('title', 'NEW_TITLE').tooltip('enable');
	// });
	$('#trading').on('shown.bs.modal', function (e) {
		// $tSell = $(this).find('#tradingSell');
		var nClass = 'individual';
		$.ajax({
			type: 'POST',
			url: 'inv/tGoods',
			data: {
				nClass: nClass,
			},
			/*dataType:"json",*/
			beforeSend: function() {
				$('#tradingBuy').parent().prev().html($spinner);
				$('#tradingBuy').html($spinner);
				$('#tradingSell').html($spinner);
				$('#tradingSell').parent().next().html($spinner);
				// $('#loader').show();
			},
			success: function(data) {
				var data = JSON.parse(data);
				// alert(JSON.stringify(data));
				$('#tradingBuy').parent().prev().html(data.tFlankL);
				$('#tradingBuy').html(data.tGInd);
				$('#tradingSell').html(data.tGInd);
				$('#tradingSell').parent().next().html(data.tFlankR);

			},
			error: function(err) {
				console.log(JSON.stringify(err));
			}
		});
	});
	$('#trading').on('click','.GM,.leftGM', function (e) {
		$('#tBuyBtn,#tSellBtn').addClass('disabled');
		$this = $(this);
		if($this.index()==1) {var nClass='trashTemp'; $tsell = 'tTrash'; $tsellTitle='Stos'; $tBuyBtn='Spersonalizuj';$tSellBtn='Usuń';}
		// else if($this.index()==2) $tsell = tGInd;
		else if($this.index()==2) {var nClass='trashTemp'; $tsell = 'tTrash'; $tsellTitle='Stos'; $tBuyBtn='Spersonalizuj';$tSellBtn='Usuń';}
		else {
			var nClass='template';
			$tsell = 'tAdd';
			$tsellTitle='Dodaj/edytuj';
			$tBuyBtn='Sklonuj';
			$tSellBtn='Zapisz';
		}

		$.ajax({
			url: 'inv/tradingGM',
			type: 'POST',
			data: {prefix: 'Inv', nClass: nClass},
			// dataType: 'json',
			beforeSend: function() {
				$('#tradingBuy').html($spinner);
				$('#tBuyBtn').text($tBuyBtn);
				$('#tradingSell').html($spinner);
				$('#tSellBtn').text($tSellBtn);
				// $('#loader').show();
			},
			success: function(data){
				var data = JSON.parse(data);

				$('#tradingBuy').parent().prev().html(data.tFlankL);
				$('#tradingBuy').prev().find('input').val('Szablony');
				$('#tradingBuy').html(data.tGTemp);

				$('#tradingSell').html(data[$tsell]);
				$('#tradingSell').prev().find('input').val($tsellTitle);
				$('#tradingSell').parent().next().html(data.tFlankR);
			}
		});
		return false;
	});
	$('#trading').on('click','.flank input',function (e) {
		// alert($(this).parent().find('#what').val());
		var what = $(this).parent().find('#what').val();
		var content = decodeHtml($(this).parent().find('#content').val());
		var data = (what=='ITEM_ID') ? $(this).data('key') : $(this).val();
		$('#'+what).val(data);
		$('#tradingSell').parent().next().html(content);
	});
	$('#trading').on('click','input[value=">"]',function (e) {
		var what = $(this).parent().prev().find('label').text();
		var content = $('#tradingSell').parent().next().html();
		$.ajax({
			url: 'inv/tDetails',
			type: 'POST',
			data: {prefix: 'Inv', what: what, content: content},
			// dataType: 'json',
			beforeSend: function() {
				$('#tradingSell').parent().next().html($spinner);
				// $('#loader').show();
			},
			success: function(response){
				var response = JSON.parse(response);
				$('#tradingSell').parent().next().html(response.tClassEdit);
			}
		});
		return false;
	});
	$('#trading').on('click','.tradingGood',function (e) {
		$this = $(this);
		$(this).siblings().removeClass('act');

		if($this.hasClass('template')){$tedit='tEdit'; $b_s='Sell'; $tBuyBtn='Sklonuj';$tSellBtn='Zapisz';}
		else if($this.hasClass('trashInd')){$tedit='tGEdit'; $b_s='Buy';$tBuyBtn='Zapisz';$tSellBtn='Usuń';}

		if($this.hasClass('template') || $this.hasClass('trashInd')){
			$this.addClass('act');
			var idTemp = $this.find('input.idTemp').val();
			var idInd = $this.find('input.idInd').val();
			$.ajax({
				url: 'inv/tradingGM',
				type: 'POST',
				data: {prefix: 'Inv', idTemp: idTemp, idInd: idInd},
				// dataType: 'json',
				beforeSend: function() {
					$('#trading'+$b_s).html($spinner);
					$('#tBuyBtn').text($tBuyBtn);
					$('#tSellBtn').text($tSellBtn);
					$('#tBuyBtn,#tSellBtn').removeClass('disabled');

					// $('#loader').show();
				},
				success: function(response){
					var response = JSON.parse(response);
					$('#trading'+$b_s).html(response[$tedit]);

					// console.log(response.pip);
				}
			});
			return false;
		}
		else if($(this).hasClass('trashTemp')){
			$(this).toggleClass('act');
			if(!$(this).siblings().hasClass('act')) $('#tBuyBtn').addClass('disabled');
			else $('#tBuyBtn').removeClass('disabled');
		}

		var hiddenBrass = $(this).parent().next().find('#hBrass');
		var hPrizeBrass = hiddenBrass.val();
		var hBrass = $(this).find('#hBrass').val();
		var tB = $(this).parent().parent().find('.input-group .tradingBrassLine');
		var Crown = tB.find('.crown + div input');
		var Shilling = tB.find('.shilling + div input');
		var Brass = tB.find('.brass + div input');
		var calcBrass = parseInt(hPrizeBrass)+parseInt(hBrass);
		//alert(calcBrass);

		var e = calculateBrass(hBrass,null);

		Crown.val(e['crown'][0]+e['crown'][2]);
		Shilling.val(e['shilling'][0]+e['shilling'][2]);
		Brass.val(e['brass'][0]+e['brass'][2]);
		hiddenBrass.val(calcBrass);
		$(this).toggleClass('active');
		// alert(sBrass);
		//$(this).parent().find('.input-group .tradingBrassLine .brass').text(hBrass);
	});
	$('#trading').on('click','#tBuyBtn, #tSellBtn',function (e) {
		// alert($(this).text());
		if($(this).text()=='Spersonalizuj'){
			var idTemp = $(this).parent().find('.tradingGood.act input.idTemp').val();
			$this=$(this);
			$.ajax({
				url: 'invBG/new',
				type: 'POST',
				data: {prefix: 'Inv', idTemp: idTemp},
				// dataType: 'json',
				beforeSend: function() {
					// $('#tradingBuy').html($spinner);
					$('#tradingSell').html($spinner);
					$thisTxt=$this.text();
					$this.addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\
										<span class="sr-only">Loading...</span>');
				},
				success: function(response){
					var response = JSON.parse(response);
					$('#tradingBuy').html(response.tGTemp);
					$('#tradingSell').html(response.tTrash);
					$this.removeClass('disabled').text($thisTxt);
				}
			});
		}
		else if($(this).text()=='Zapisz'){
			var myForm = $(this).parent().find('form');
			var dName = myForm.attr('name');
			if(dName=='inv'){
				// $tBuy = 'tGTemp';
				$tSell = 'tAdd';
				$b_s='Sell';
				$textBtn='Zapisz';
				var nClass = 'template';
			}
			else if(dName=='invbg') {
				// $vBuy = 'tGTemp';
				$tSell = 'tTrash';
				$b_s='Buy';
				$textBtn='Spersonalizuj';
				var nClass = 'trashTemp';
			}
			var co = myForm.serializeArray().reduce((acc, {name, value}) => ({...acc, [name]: value}),{});
			console.log(co);
			$.ajax({
				url: dName+'/update',
				type: 'POST',
				data: {prefix: 'Inv', co: co, nClass: nClass},
				// dataType: 'json',
				beforeSend: function() {
					$('#tradingBuy').html($spinner);
					$('#tradingSell').html($spinner);
					$('#t'+$b_s+'Btn').addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\
										 <span class="sr-only">Loading...</span>');
				},
				success: function(response){
					var response = JSON.parse(response);
					$('#tradingBuy').html(response.tGTemp);
					$('#tradingSell').html(response[$tSell]);
					$('#t'+$b_s+'Btn').text($textBtn);
					// console.log(response);
				}
			});
		}
		return false;

	});
	$('#characterStats .cLeft').on('contextmenu','.inventory-item', function (e) {
		$this = $(this);
		var invid = $this.data('invid');
		var titleBar = 'Przedmiot';
		// alert(invid);
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'Inv', invid: invid, titleBar: titleBar},
			success: function(response){
				//var response = JSON.parse(response);
				// console.log(response);

				$('body').append(response);
				// $('body').html(response);

			  // Add response in Modal body

				executeInv();
				$('.modal-footer').remove();
				$('#InvModalCenter').modal('show', $this);

			  // Display Modal
			}
		});
		return false;
	});
	$('#characterStats .cRight .row:nth-of-type(4) .diary').on('click','.btn', function (e) {
		$this = $(this);
		$this.parent().find('.alert-sm').remove();
		$element = $(this).parent().next().find('textarea');
		var textArea = $element.val();
		// alert(textArea);
		$.ajax({
			url: 'chat/update_diary',
			type: 'POST',
			data: {textArea: textArea},
			success: function(data){
				var data = JSON.parse(data);
				// console.log(data['NOTES']);
				$element.val(data['NOTES']);
				// $element.val(data);
				$this.before('<div class="alert alert-success alert-sm">Twoje notatki poprawnie zapisano.</div>');
				setTimeout(function() { $this.prev().fadeOut(); }, 2000);
			//	$('body').append(response);
			  // Add response in Modal body
			//   activateTooltip();
			  //executeHP();
			  //$('#HPModalCenter').modal('show', $this);
			  // Display Modal
			}
		});
	});
	$('#characterChanger').on('click','.glyph-icon', function (e) {
		slidePanel($(this));
	});
	$( "#draggable-chat" ).draggable({handle: ".card-header.d-flex", cursor: "move", containment: "body", scroll: false });
	$( "#dicer" ).draggable({handle: ".card-header", cursor: "move", containment: "body", scroll: false });
	$( "#draggable-chat" ).data({
		'originalLeft': $("#draggable-chat").css('left'),
		'originalTop': $("#draggable-chat").css('top')
	});
	$('#draggable-chat').on('dblclick','.card-header.d-flex', function (e) {
		$(this).parent().css({
			'left': $(this).parent().data('originalLeft'),
			'top': $(this).parent().data('originalTop')
		});
	});
	$('#characterPanel .avatar').on('dblclick','img', function (e) {
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
		if(wTrait.match('cechyDrugorzedne-2')){
			var traitAct = [$(this).prev().prev().val(), $(this).prev().val()];
			// var traitAct = $(this).prev().prev().val();
			var traitAdv = $(this).prev().prev().prev().val();
			var traitInit = $(this).prev().prev().prev().prev().val();
		}
		else{
			var traitAct = $(this).prev().val();
			var traitAdv = $(this).prev().prev().prev().val();
			var traitInit = $(this).prev().prev().prev().prev().val();
		}
		// alert(traitAct+'|'+traitAdv+'|'+traitInit);
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'Trait', key: key, titleBar: titleBar, traitAct: traitAct, traitAdv: traitAdv, traitInit:traitInit, wTrait: wTrait},
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
		// alert(titleBar);
		var hBrass=$('#hBrass').val();
		$brass = $this.parent().parent().prev()[0].outerHTML;
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'Brass', titleBar: titleBar, hBrass: hBrass},
			success: function(response){
				// console.log(JSON.parse(response));
				$('body').append(response);
			  // Add response in Modal body
				//activateTooltip();
				// Display Modal
				executeBrass();
				$('#BrassModalCenter').modal('show', $this);
				$('#Brass-line').html($brass);
				// $('#Brass-line .crown + div input').val(0+' zk');
				$('#Brass-line .crown + div input').val(0+' zf');//Bretonia
				// $('#Brass-line .shilling + div input').val(0+' s');
				$('#Brass-line .shilling + div input').val(0+' sg'); //Bretonia
				// $('#Brass-line .brass + div input').val(0+' p');
				$('#Brass-line .brass + div input').val(0+' mp'); // Bretonia
				// $('#Brass-line .brass').addClass('activated');
				$('#Brass-line .shilling').addClass('activated');// Bretonia

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
				// response = JSON.parse(response);
				// alert(response['HP'].buttons);
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
		// alert(titleBar);
		$.ajax({
			url: 'chat/dialogBox',
			type: 'POST',
			data: {prefix: 'UmZd', umzd: umzd, titleBar: titleBar, idUm: idUm, details: details },
			success: function(response){
				// var data = JSON.parse(response);
				// console.log(response);
				// alert(data['titleBar2']);
				$('body').append(response);
				// Add response in Modal body
				// activateTooltip();
				executeUmZd();
			 	// Display Modal
				$('#UmZdModalCenter').modal('show', $this);
			}
		});
	});
	$('#characterPanel .titleBar .tPlace').on('mouseenter mouseleave',function(e){
		//alert($(this).prevAll().eq(1).css('width'));
		// alert(e.type);
		$(this).prevAll().eq(1).find('.HPBar').toggleClass('ShineClass');
	});
	// activateTooltip(); // 1st
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
	// $('#exampleModalCenter').on('shown.bs.modal', function (e) {
		// alert($('.iCenter').width());
		// var w=$('.iCenter').width();
		// var bountify= $('#bountify').val();
		// $.ajax({
		// 	type: 'POST',
		// 	url: 'chat/inventory',
		// 	data: {
		// 		w: w, nrRow:2
		// 	},
		// 	// dataType:'json',
		// 	success: function(data) {
		// 		// var data = JSON.parse(data);
		// 		//alert(data.ground);
		// 		// $('#personal-inventory').html(data.personal);
		// 		// $('#ground-inventory').html(data.ground);
		// 		$.getScript(bountify);
		// 		//activateTooltip();
		// 		//return false;
		// 	},
		// 	error : function(err) {
		// 		console.log(JSON.stringify(err));
		// 	}
		// });
	// });

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
				// activateTooltip(); //2nd
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

	// $('.row').on('submit','form[name="sendMessage"]',function(){
	// 	var messageObj=$(this).find('input[name="message"]');
	// 	var message=messageObj.val();
	// 	//alert(message);
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: 'chat/send',
	// 		data: {
	// 			message: message,
	// 		},
	// 		success: function(data) {
	// 			$('.chatbox').html(data).animate({scrollTop: $('.chatbox').prop('scrollHeight')}, 500);
	// 			messageObj.val(null);
	// 			$('form[name="sendMessage"] input[name="message"]').show();
	// 			activateTooltip();
	// 			//return false;
	// 		},
	// 		error : function(err) {
	// 			console.log(JSON.stringify(err));
	// 		}
	// 	});

	// 	return false;
	// });

	$('#dicer').on('click', '.close', function(){
		$(this).parent().parent().hide();
	});
	$('.btn-group').on('click','.btn.btn-danger',function(){
		$('#dicer').show();
		// $.ajax({
		// 	type: 'POST',
		// 	url: 'roller',
		// 	contentType: 'text/plain',
		// 	data: {
		// 		// w: w/a, nrRow:nrRow, type:type
		// 	},
		// 	success: function(data) {
		// 		$('body').append('<object style="width:1000px; height:350px"><embed id="dicer" ></embed></object>');
		// 		$('#dicer').html(data);
		// 		// document.write(data);
		// 	},
		// 	error : function(err) {
		// 		console.log(JSON.stringify(err));
		// 	}
		// });
	});
	$('#diceBox .btn-group').on('click','.btn:not(.btn-success):not(.btn-danger)',function(){
		// alert($(this).parent().attr('class'));
		var dice=$(this).text();
		// alert(dice);
		var max=$(this).val();
		var roll=(Math.floor(Math.random()*max)+1);
		MsgText('Wynik rzutu <b>'+dice+'</b> to =><b>'+roll+'</b><=');

	});
});
function inventory(type){
	if(type=='discard'){ var w=$('#characterPanel').width(); var a = 1.8; var nrRow=1; }
	else if(type=='personal'){ var w=$('#characterStats .cLeft .iBottom').width(); var a = 1.7; var nrRow=3;}
	else if(type=='ground'){ var w=$('#characterStats .cLeft .iBottom').width(); var a = 10; var nrRow=4;}
	else {var w=0; var a=1; var nrRow=0;}
	// var w=$('#characterPanel').width();
	// console.log(w);
	var bountify= $('#bountify').val();
	$.ajax({
		type: 'POST',
		url: 'chat/inventory',
		data: {
			w: w/a, nrRow:nrRow, type:type
		},
		success: function(data) {
			$('#'+type+'-inventory').html(data);
			var invBG = $('#invBG').val();
			if(type=='personal'){
				// var patt = new RegExp( /[|]/ );
				var element = $('#'+type+'-inventory .inventory-cell');
				// element.first().html('<div class="inventory-item dagger" data-item-type="arms" data-toggle="tooltip" data-original-title="dasfadsfadsfasdxcvxc"></div>');
				invBG=JSON.parse(invBG);
				// console.log(invBG);

				element.each(function(){
					var x = parseInt($(this).data('slot-position-x'));
					var y = parseInt($(this).data('slot-position-y'));
					var slot=x+'|'+y;
					// jQuery.each(invBG, function(key, obj) {
					// 	// console.log(key);
					// 	if(patt.test(key)) {
					// 		var row=key.split('|')[0]; var col=key.split('|')[1];
					// 		console.log(row+'___'+col);
					// 	}
					// });
					if(invBG[slot] !== undefined){
						// invBG[slot]['NAME']+='<div class="fixed-bottom">Szczegóły: PPM.</div>';
						$(this).html('<div class="inventory-item '+invBG[slot]['IMG_CLASS']+' myPointer" data-item-type="'+invBG[slot]['ITEM_CATEGORY']+'" data-invid="'+invBG[slot]['ID']+'" data-toggle="tooltip" data-original-title="'+invBG[slot]['NAME']+'"></div>');

					}
					// console.log(y);
				});
				activateTooltip(element); //3rd to open (1)
				tooltipCss();
			} else if(type=='A' || type=='B' || type=='handy'){
				var element = $('#'+type+'-inventory .inventory-cell');
				//alert('FUCK');
				// var invBG = $('#invBG').val();
				invBG=JSON.parse(invBG);
				// console.log(invBG);
				element.each(function(){
					var sClass = $(this).attr('class').split(' ')[1];
					// console.log(invBG[sClass]);
					if(invBG[sClass] !== undefined){
						$(this).html('<div class="inventory-item '+invBG[sClass]['IMG_CLASS']+' myPointer" data-item-type="'+invBG[sClass]['ITEM_CATEGORY']+'" data-invid="'+invBG[sClass]['ID']+'" data-toggle="tooltip" data-original-title="'+invBG[sClass]['NAME']+'"></div>');
					}
					//  alert($(this).attr('class').split(' ')[1]);
				});
				activateTooltip(element); //3rd to open (2)
				tooltipCss();
			}
			$.getScript(bountify);
			//$('.tooltip.show .tooltip-inner').addClass('gFrame');
			//tooltipCss();
			//return false;
		},
		error : function(err) {
			console.log(JSON.stringify(err));
		}

	});
}
function activateTooltip(element){
	//console.log(element.find('div[data-toggle="tooltip"]').data('original-title'));
	element.find('[data-toggle="tooltip"]').tooltip({
		html: true,
		animated : 'fade',
   		container: 'body',
		boundary: 'viewport'
	});
}
function tooltipCss(){
	$('[data-toggle="tooltip"]').on('hide.bs.tooltip', function (e) {
		$('.tooltip-inner').hide();
	});
	$('[data-toggle="tooltip"]').on('shown.bs.tooltip', function (e) {
		// console.log($('.tooltip').html());
		$('.tooltip-inner').show();
	});
	$('[data-toggle="tooltip"]').on('inserted.bs.tooltip', function (e) {
		//alert($(this).hasClass('abbList'));
		// console.log($(this).attr('class'));`
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
			$('.tooltip-inner h4').addClass('umzd');
			// .css({
			// 	'text-align':'justify',
			// 	'font': 'normal 1.85vh Garamond, Verdana, sans-serif',
			// 	'padding':'2% 5%',
			// 	'text-indent': '2.5em'
			// });
			$('.tooltip.show,.tooltip-inner,.tooltip-inner h3,.tooltip-inner h4').css({
				'width':'360px',
				'max-width': '100%'
			});
		}
		else if($(this).hasClass('inventory-item')){
			$('.tooltip-inner').parent().addClass('hFrame');
			$('.tooltip-inner').addClass('gFrame').prev().remove();
			$('.tooltip-inner').append('<div class="fixed-bottom">Szczegóły: PPM.</div>');
			$('.tooltip.show,.tooltip-inner,.tooltip-inner h3,.tooltip-inner h4').css({
				'width':'300px',
				'max-width': '100%'
			});
		}
		//$('.tooltip-inner').parent().show();
	});

}

function executeInv(){
	$('#InvModalCenter').on('hide.bs.modal', function(event) {
		$(this).remove();
	});
}
function executeUmZd(){
	$('#UmZdModalCenter').on('hide.bs.modal', function(event) {
		$(this).remove();
	});
	$('#UmZdModalCenter').on('show.bs.modal', function(event) {
		$oElement = $(event.relatedTarget);
		var closeBtn = $("#UmZdModalLongTitle").html();
		//var title = ['Zmniejsz Punkty Żywotności','Zwiększ Punkty Żywotności'];
		// alert($(event.relatedTarget).closest('.abbRow').data('button'));
		$(this).find('.modal-footer .btn-danger').text($(event.relatedTarget).closest('.abbRow').data('button'));
		//alert($(event.relatedTarget).closest('.abbRow').data('button'));
		//var curexp = parseInt($('#curexp').text());
		var curexp =  $('#curexp').val();
		if(curexp<100) $(this).find('.modal-footer .btn-danger').addClass('disabled').before('<div class="alert alert-danger p-1 disabled" style="margin-top: 15px">Nie posiadasz wymaganej ilości 100 PD!</div>');
		// $(this).find('.modal-footer')
		$(this).find('.desc').html($(event.relatedTarget).data('original-title'));

		// alert(titleBar);
		// alert($(event.relatedTarget).attr('title'));

		$("#UmZdModalLongTitle").html('Wykup '+closeBtn);
	});
	$('#UmZdModalCenter .modal-footer').on('click','.btn-danger', function (event) {
		$this = $(this);
		$stArea = $('.cCenter .skills-talents');
		$UmZdArea = $stArea.first().prev();
		$('.cCenter .skills-talents').remove();
		var titleBar = $(this).parent().prev().prev().find('.titleBar').text();
		var idUm=parseInt($('#idUm').val());
		var details=parseInt($('#details').val());
		var SOrTName=$('#HPMenu h3').text();
		if(isNaN(details)) details="";
		if(titleBar.match('Wykup Umiejętności')){var co = 'um'; var what ='umiejętność';}
		else if(titleBar.match('Wykup Zdolności')){var co = 'zd'; var what = 'zdolność';}
		// $(event.relatedTarget).addClass('disabled');
		// alert($oElement.data('id'));
		// console.log(titleBar+'|'+idUm+'|'+details+'|'+co);
		$.ajax({
			type: 'POST',
			url: 'chat/ransom_pd',
			data: {
				idUm: idUm, details: details, co: co
			},
			// dataType:"json",
			success: function(data) {
				// alert(JSON.stringify(data));
				data = JSON.parse(data);
				// console.log(data);
				// $('form[name="sendMessage"] input[name="message"]').hide();
				// $('form[name="sendMessage"] input[name="message"]').val('BG wykupił '+what+': <b>'+SOrTName+'</b>');
				// $('form[name="sendMessage"]').trigger('submit');
				// location.reload();

				MsgText('BG wykupił '+what+': <b>'+SOrTName+'</b>');
				$this.closest('.modal-content').find('.close').trigger('click');
				$('#exampleModalCenter').modal('hide');
				$oElement.addClass('triList disabled'); // tymczasowe rozwiązanie -> Docelowo wczytaj całą listę albo sprawdź tylko ten element
				$UmZdArea.after(data);
				activateTooltip();
				tooltipCss();
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
		$Thisbtn = $(event.relatedTarget);

		// $(this).find('input[type="number"]').val(0);
		var wTrait=$('#wTrait').val();
		if(wTrait.match('cechyGlowne'))	var expMax = 23;
		else if(wTrait.match('cechyDrugorzedne-1'))	var expMax = 100;
		else var expMax = 0;
		var symbol='+';
		$(this).find('.modal-footer .btn-danger').text($(event.relatedTarget).closest('.cechy').data('button'));
		var curexp =  $('#curexp').val();
		if(curexp<expMax) $(this).find('.modal-footer .btn-danger').addClass('disabled').before('<div class="alert alert-danger p-1 btn-sm disabled">Nie posiadasz minimum wymaganej ilości '+expMax+' PD!</div>');
		else if(expMax==0) $(this).find('.modal-footer .btn-danger').addClass('disabled');
		$(this).find('.addictionBar .badge-primary input').val(curexp);
		if(wTrait.match('cechyDrugorzedne-2')){
			// alert('KOSSS');
			var addiction =$(this).find('.modal-dialog.cP button.addiction');
			addiction.each(function(index){
				// alert(index%5);
				$(this).removeClass('disabled');
				if(index%5<4) {
					$(this).text(symbol+$(this).val());
				}
				else if(index%5==4) {
					$(this).val(0);
				}
			});
		}
		else{
			var addiction =$(this).find('.modal-dialog.cP button.addiction');
			addiction.each(function(index){
				$(this).removeClass('disabled');
				if(index<4) {
					$(this).text(symbol+$(this).val());
				}
				else if(index==4) {
					$(this).val(0);
				}
			});
		}
		// var addiction =$(this).find('.modal-body button.addiction');
		// addiction.each(function(index){
		// 	$(this).removeClass('disabled');
		// 	if(index<4) {
		// 		if(a==0){
		// 			if($(this).val()>HP) $(this).addClass('disabled');
		// 			else $(this).removeClass('disabled');
		// 		}
		// 		else if(a==1){
		// 			if($(this).val()>(wounds-HP)) $(this).addClass('disabled');
		// 			else $(this).removeClass('disabled');
		// 		}
		// 		//$(this).val(symbol[a]+$(this).val());
		// 		$(this).text(symbol[a]+$(this).val());
		// 	}
		// 	else if(index==4) {
		// 		$(this).val(0);
		// 	}
		// 	else {
		// 		if(a==0) $(this).val(-HP);
		// 		else if(a==1) $(this).val(wounds-HP);
		// 		//alert(HP);
		// 	}
		// });
	});
	$('.btn-group').on('click','.btn-dark, .btn-success',function(event){
		if($(this).hasClass('addiction')) {
			if($(this).text()=='max' || $(this).text()=='reset'){
				var a = 0;
				var b = parseInt($(this).val());
				$(this).closest('.modal-content').find('.modal-footer .btn-danger').addClass('disabled');
			}
			else {
				var a = parseInt($(this).closest('.btn-group').find('input[type="number"]').val());
				var b = parseInt($(this).text());
				$(this).closest('.modal-content').find('.modal-footer .btn-danger').removeClass('disabled');
			}
			c=parseInt(a+b);
			$(this).closest('.btn-group').find('input[type="number"]').val(c);
		}
	});
	$('.btn-group').on('change','select',function(event){
		var symbol = $(this).val();
		var addiction = $(this).parents('.btn-group').find('.btn.addiction');
		// $(this).closest('.btn-group').find('input[type="number"]').val(0);
		$(this).closest('.btn-group').find('button:last-of-type').trigger('click');

		addiction.each(function(index){
			var i = symbol+Math.abs(parseInt($(this).val()));
			$(this).removeClass('disabled');
			if(index<4) {
				$(this).val(i);
				$(this).text(i);
			}
			else if(index==4) {
				$(this).val(0);
			}
		});
	});
	$('.btn-group').on('click','.btn-info',function(event){
		var wTrait=$('#wTrait').val();
		var NazwaCechy=$('#NazwaCechy').val();
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
			c=parseInt(a+b);
			// alert('a='+a+'|b='+b);
			// if(a==null) a=0;
			// else a=parseInt(a);

			// alert(c+'|'+traitAdv);
			if(c<=traitAdv){
				if(wTrait.match('cechyGlowne'))	var d = (c%5==0) ? 100*(c/5) : 100*Math.floor(c/5)+23*(c%5);
				else if(wTrait.match('cechyDrugorzedne-1'))	var d = c*100;
				else var d = 0;

				// alert(d+'|'+curexp+'|'+wykupBtn.prev().hasClass('alert'));
				if(wykupBtn.prev().hasClass('alert')){
					wykupBtn.removeClass('disabled');
					wykupBtn.prev().remove();
					if(curexp<23 && d<curexp) wykupBtn.addClass('disabled').before('<button class="alert alert-danger btn-sm p-1 disabled">Nie posiadasz minimum wymaganej ilości 23 PD!</button>');
					else if(d>curexp) wykupBtn.addClass('disabled').before('<button class="alert alert-danger btn-sm p-1 disabled">Nie posiadasz wystarczającej ilości '+d+' PD!</button>');
				}
				else if(!wykupBtn.prev().hasClass('alert') && d>curexp) wykupBtn.addClass('disabled').before('<button class="alert alert-danger btn-sm p-1 disabled">Nie posiadasz wystarczającej ilości '+d+' PD!</button>');
				$(this).closest('.addictionBar').find('.badge-warning input').val(d);
				$(this).closest('.addictionBar').find('.btn-group input:last-of-type').val(c);
			}
			else{
				//alert('bravo');
				if(wTrait.match('cechyGlowne'))	var d = 100*(traitAdv/5);
				else if(wTrait.match('cechyDrugorzedne-1'))	var d = traitAdv*100;
				else var d = 0;
				// if(wykupBtn.prev().hasClass('alert')){
				// 	wykupBtn.addClass('disabled').before('<div class="alert alert-danger p-1 disabled">Nie posiadasz wystarczającej ilości '+d+' PD!</div>');
				// }
				wykupBtn.removeClass('disabled');
				wykupBtn.prev().remove();
				wykupBtn.addClass('disabled').before('<button class="alert alert-success btn-sm p-1 disabled">Cecha '+NazwaCechy+' maksymalnie może zostać podniesiona o '+traitAdv+'!</button>');
				$(this).closest('.addictionBar').find('.badge-warning input').val(d);
				$(this).closest('.addictionBar').find('.btn-group input:last-of-type').val(traitAdv);
			}


		}
	});
	$('#TraitModalCenter .modal-footer').on('click','.btn-danger', function (event) {
		$this = $(this);
		var traitName = $('#traitName').val();
		if(traitName=='FATEINS' || traitName=='LUCKMOTIVE'){
			traitName = (traitName=='FATEINS') ? ['FATEPOINTS','INSANITYPOINTS'] : ['LUCKPOINTS','MOTIVATEPOINTS'];
			var traitInc = [];
			traitInc[0] = parseInt($(this).parent().prev().find('.addictionBar .btn-group:first-of-type input[type="number"]').val());
			traitInc[1] = parseInt($(this).parent().prev().find('.addictionBar .btn-group:last-of-type input[type="number"]').val());
			var traitAct = JSON.parse($('#traitAct').val());
			if(traitInc[0]==0)
			{
				traitName=traitName[1];
				traitAct =traitAct[1];
				traitInc =traitInc[1];
			}
			else if(traitInc[1]==0){
				traitName=traitName[0];
				traitAct =traitAct[0];
				traitInc =traitInc[0];
			}
			var expCost = 0;
			// var traitAct = traitInc = expCost = 1;
		}
		else{
			// var NazwaCechy = $('#NazwaCechy').val();
			var traitAct = parseInt($('#traitAct').val());
			var traitInc = $(this).parent().prev().find('.addictionBar .btn-group input:last-of-type').val();
			var expCost = $(this).parent().prev().find('.addictionBar .badge-warning input').val();
		}

		// alert(traitName+'|'+traitAct+'|'+traitInc+'|'+expCost);

		$.ajax({
			type: 'POST',
			url: 'chat/ransom_trait',
			data: {
				traitName: traitName, traitInc: traitInc, traitAct: traitAct, expCost: expCost
			},
			// dataType:"json",
			success: function(data) {
				data = JSON.parse(data);
				//alert(data);
				// console.log(data);
				// $('form[name="sendMessage"] input[name="message"]').hide();
				// $('form[name="sendMessage"] input[name="message"]').val('BG powiększył cechę <u>'+NazwaCechy+'</u> o <b>'+traitInc+'</b> punktów.');
				// $('form[name="sendMessage"]').trigger('submit');

				// location.reload();
				// $('button[data-target="#exampleModalCenter"]').trigger('click');



				// MsgText('BG za <b>'+data['expCost']+'PD</b> wykupił <b>'+data['traitInc']+incP+'</b> cechy <b>'+data['traitNamePL']+'</b>');
				if(data['expCost']==0){
					var iniMax = 2;
					// alert(iniMax);
					if(data['many']==2){
						$Thisbtn.prev().val(parseInt(data['traitAct'][1])+parseInt(data['traitInc'][1]));
						$Thisbtn.prev().prev().val(parseInt(data['traitAct'][0])+parseInt(data['traitInc'][0]));
						for(var ini=0;ini<2;ini++){
							var co = (data['traitInc'][ini]>0) ? 'zwiększył' : 'zmniejszył';
							data['traitInc'][ini]=Math.abs(data['traitInc'][ini]);
							if(data['traitInc'][ini]==1) var incP=' punkt';
							else if(data['traitInc'][ini]>1 && data['traitInc'][ini]<=4) var incP=' punkty';
							else var incP=' punktów';
							// MsgText(traitName.length+'. BG zmienił o <b>'+data['traitInc'][ini]+incP+'</b> cechy <b>'+data['traitNamePL'][ini]+'</b>');
							MsgText('BG '+co+' o <b>'+data['traitInc'][ini]+incP+'</b> cechę <b>'+data['traitNamePL'][ini]+'</b>');
						}

					}
					else {
						var co = (data['traitInc']>0) ? 'zwiększył' : 'zmniejszył';
						data['traitInc']=Math.abs(data['traitInc']);
						if(data['traitInc']==1) var incP=' punkt';
						else if(data['traitInc']>1 && data['traitInc']<=4) var incP=' punkty';
						else var incP=' punktów';
						MsgText('BG '+co+' o <b>'+data['traitInc']+incP+'</b> cechę <b>'+data['traitNamePL']+'</b>');
						if(data['traitName']=='FATEPOINTS' || data['traitName']=='LUCKPOINTS') $Thisbtn.prev().prev().val(parseInt(data['traitAct'])+parseInt(traitInc));
						else if(data['traitName']=='INSANITYPOINTS' || data['traitName']=='MOTIVATEPOINTS') $Thisbtn.prev().val(parseInt(data['traitAct'])+parseInt(traitInc));
					}

				}
				else{
					if(data['traitInc']==1) var incP=' punkt';
					else if(data['traitInc']>1 && data['traitInc']<=4) var incP=' punkty';
					else var incP=' punktów';
					MsgText('BG za <b>'+data['expCost']+'PD</b> wykupił <b>'+data['traitInc']+incP+'</b> cechy <b>'+data['traitNamePL']+'</b>');
					$Thisbtn.prev().val(traitAct+parseInt(traitInc));
				}

				$this.closest('.modal-content').find('.close').trigger('click');
				$('#exampleModalCenter').modal('hide');
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
		// alert(symbol);
		var addiction =$(this).find('.modal-body button.addiction');
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
		$this=$(this);
		var brass = $(this).parent().prev().find('.addictionBar .btn-group input:last-of-type').val();
		var titleBar = $(this).parent().prev().prev().find('.titleBar').text();

		// alert($(event.relatedTarget).html());
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
				// $('form[name="sendMessage"] input[name="message"]').hide();
				// $('form[name="sendMessage"] input[name="message"]').val('BG  '+titleBar+': <b>'+brass+'</b> pensów');
				// $('form[name="sendMessage"]').trigger('submit');
				// $('button[data-target="#exampleModalCenter"]').trigger('click');

				MsgText('BG  '+titleBar+': <b>'+brass+'</b> pensów');
				$this.closest('.modal-content').find('.close').trigger('click');
				$('#exampleModalCenter').modal('hide');
				// location.reload();
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
			// var d ={'crown':240,'shilling':12,'brass':1};
			var d ={'crown':7680,'shilling':64,'brass':1};
			var Brass=b*d[mClass]+a;
			// alert('hBrass='+hBrass+'|Brass='+Math.abs(Brass));
			if(upNum==1 && Math.abs(Brass)>hBrass) Brass=-hBrass;

			var e = calculateBrass(Brass,1);

			$(this).closest('.addictionBar').find('.btn-group input:last-of-type').val(Brass);
			$(this).closest('.addictionBar').find('.crown + div input').val(e['crown'][upNum]+e['crown'][2]);
			$(this).closest('.addictionBar').find('.shilling + div input').val(e['shilling'][upNum]+e['shilling'][2]);
			$(this).closest('.addictionBar').find('.brass + div input').val(e['brass'][upNum]+e['brass'][2]);
			// alert(Math.abs(upNum));
			// alert($(this).closest('.addictionBar').html());
			return false;
		}
	});
}
function executePD(){
	$('#PDModalCenter').on('hide.bs.modal', function(event) {
		$(this).remove();
	});
	$('#PDModalCenter').on('show.bs.modal', function(event) {
		var closeBtn = $("#PDModalLongTitle").html();
		$(this).find('input[type="number"]').val(0);
		var symbol=$(event.relatedTarget).text();
		var a=$(event.relatedTarget).data('symbol');
		//alert(symbol);
		var title = ['Zmniejsz','Zwiększ'];
		$("#PDModalLongTitle").html(title[a]+' Punkty Doświadczenia'+closeBtn);
		// var symbol = ['-','+'];
		var addiction =$(this).find('.modal-body .addictionBar .btn-group .addiction');
0
		console.log(addiction);
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
		$this=$(this);
		$PDbar = $('#characterPanel .footerSpace').first().next();
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
				console.log(data);
				// alert(JSON.stringify(data));
				var a = parseInt(data.ile);
				var b = parseInt(data.CUREXP);
				var c = parseInt(data.ALLEXP);
				var d = data.pdbars;
				// alert(a+'|'+b+'|'+c+'|'+d);
				if(a>0) var co='zwiększył';
				else var co='zmniejszył';

				$PDbar.html(d);
				activateTooltip();
				$('#HPModalCenter').modal("hide");

				// $('form[name="sendMessage"] input[name="message"]').hide();
				// $('form[name="sendMessage"] input[name="message"]').val('BG '+co+' swoje Punkty Doświadczenia =>z <b>'+(b-a)+'</b> na <b>'+b+'</b><=');
				// $('form[name="sendMessage"]').trigger('submit');
				// location.reload();
				MsgText('BG '+co+' swoje PD =>z <b>'+(b-a)+'</b> na <b>'+b+'</b><=');
				$this.closest('.modal-content').find('.close').trigger('click');
				// $('#exampleModalCenter').modal('hide');
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
		var closeBtn = $("#HPModalLongTitle").html();
		$(this).find('input[type="number"]').val(0);
		var a=$(event.relatedTarget).data('symbol');
		// alert(a);
		var title = ['Zmniejsz','Zwiększ'];
		$("#HPModalLongTitle").html(title[a]+' Punkty Żywotności'+closeBtn);
		var symbol = ['-','+'];
		var addiction =$(this).find('.modal-body button.addiction');
		var wounds = parseInt($(this).find('.btn-group').data('wounds'));
		var HP = parseInt($(this).find('.btn-group').data('hp'));
		// alert(addiction);
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
			else if(index==4) {
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
	});
	$('#HPMenu .modal-footer').on('click','.btn-danger', function (e) {
		$this=$(this);
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

				// $('form[name="sendMessage"] input[name="message"]').hide();
				// $('form[name="sendMessage"] input[name="message"]').val('BG '+co+' swoje Punkty Żywotności =>z <b>'+(b-a)+'</b> na <b>'+b+'</b><=');
				// $('form[name="sendMessage"]').trigger('submit');

				MsgText('BG '+co+' swoje Punkty Żywotności =>z <b>'+(b-a)+'</b> na <b>'+b+'</b><=');
				$this.closest('.modal-content').find('.close').trigger('click');
				$('#exampleModalCenter').modal('hide');
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
	var wLeft = (element.hasClass('docked')) ? '50%' : '100%';
	var height=parseFloat(panel.css('height'))*(-1);//dla #characterPanel
	//alert('id:'+panel.attr('id')+'|height:'+height);
	if(panel.attr('id')=='skillsPanel') panel.animate({left:width},1000);
	else if(panel.attr('id')=='talentsPanel') panel.animate({right:width},1000);
	else if(panel.attr('id')=='characterChanger'){ panel.animate({left:width},1000); element.toggleClass('flipX');}
	else if(panel.attr('id')=='characterPanel'){
		// panel.animate({bottom:height},1000);
		panel.animate({
			left:wLeft,
		},700,'easeInOutBack');
		element.toggleClass('docked');
	}
	//panel.css(visibility, "hidden");
}
function setPanel(element){
	var width=parseFloat(element.parent().width())*(-1);
	// alert(width);
	var panel=element.parents().eq(2);
	if(panel.attr('id')=='skillsPanel') panel.css({left:width});
	else if(panel.attr('id')=='talentsPanel') panel.css({right:width});
}
function calculateBrass(Brass,currency){
	//Bretoński złoty frank oraz srebrne ?guldeny
	if(currency==1)	var e = {'crown':[Math.floor(Brass/7680),Math.ceil(Brass/7680),' zf'],'shilling':[Math.floor((Brass%7680)/64),Math.ceil((Brass%7680)/64),' sg'],'brass':[(Brass%7680)%64,(Brass%7680)%64,' mp']};
	//Imperialne złote korony itp.
	else var e = {'crown':[Math.floor(Brass/240),Math.ceil(Brass/240),' zk'],'shilling':[Math.floor((Brass%240)/12),Math.ceil((Brass%240)/12),' s'],'brass':[(Brass%240)%12,(Brass%240)%12,' p']};//Imperium

	return e;
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