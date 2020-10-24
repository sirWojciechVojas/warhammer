jQuery(function()
{
	$('.LOG').on('click','#loginChanger',function(){
		//var title=$(this).attr('title');
		$('.BG ul li').removeClass('marked');
		var ok=$(this).hasClass('GM');
		if(ok==true){
			$('.LOG img').attr('src','../assets/img/GM.jpg');
			$('.LOG h4').text('Zaloguj jako GM');
			$('input[name="nameBG"]').val('GAME MASTER');
			$('input[name="user"]').val('sirWojciechVojas').hide();
			$('input[name="pass"]').attr('placeholder','Podaj hasło dla GM');
			$(this).removeClass('GM').addClass('BG');
			$('.BG li').addClass('disabled');
			$('.btn-success').hide();
		}
		else{
			$('.LOG img').attr('src','../assets/img/photo.png');
			$('.LOG h4').text('Zaloguj');
			$('input[name="nameBG"]').val(null).show();
			$('input[name="user"]').val(null).show();
			$('input[name="pass"]').attr('placeholder','Hasło');
			$(this).removeClass('BG').addClass('GM');
			$('.BG li').removeClass('disabled');
			$('.btn-success').show();
		}
	});
	$('.BG ul').on('click','li',function(){
		var BG=$(this).find('h3').text();
		var what=$(this).parents(':eq(2)').prev().find('.account-wall');
		if(what.hasClass('LOG')) var preUrl='../'; else var preUrl='../../';
		var img=$(this).parents(':eq(2)').prev().find('img');
		$('.BG ul li').removeClass('marked');
		$(this).addClass('marked');
		$('input[name="nameBG"]').val(BG);
		img.attr('src',preUrl+'assets/img/'+BG+'.png');
		//alert(what);
		//$('input[name="user"]').val('GAME MASTER').attr('readonly',true);
	});
});