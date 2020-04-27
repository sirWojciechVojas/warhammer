/////////////////////////////////////////////////////////////////////////////
//

$(document).ready(function()
{
	$('.LOG').on('click','#loginChanger',function(){
		//var title=$(this).attr('title');
		$('.BG ul li').removeClass('marked');
		var ok=$(this).hasClass('GM');
		if(ok==true){
		$('.LOG img').attr('src','../assets/img/GM.jpg');
		$('.LOG h4').text('Zaloguj jako GM');
		$('input[name="nameBG"]').val('GAME MASTER').hide();
		$('input[name="user"]').val('GAME MASTER').attr('readonly',true);
		$('input[name="pass"]').attr('placeholder','Podaj hasło dla GM');
		$(this).removeClass('GM').addClass('BG');
		$('.BG li').addClass('disabled');
		$('.btn-success').hide();
		}
		else{
		$('.LOG img').attr('src','../assets/img/photo.png');
		$('.LOG h4').text('Zaloguj');
		$('input[name="nameBG"]').val(null).show();
		$('input[name="user"]').val(null).attr('readonly',false);
		$('input[name="pass"]').attr('placeholder','Hasło');
		$(this).removeClass('BG').addClass('GM');
		$('.BG li').removeClass('disabled');
		$('.btn-success').show();
		}
	});
	$('.BG ul').on('click','li',function(){
		var BG=$(this).find('h3').text();
		$('.BG ul li').removeClass('marked');
		$(this).addClass('marked');
		$('input[name="nameBG"]').val(BG);
		$('.LOG img').attr('src','../assets/img/'+BG+'.png');
		//$('input[name="user"]').val('GAME MASTER').attr('readonly',true);


	});
});