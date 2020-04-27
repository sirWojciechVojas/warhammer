/////////////////////////////////////////////////////////////////////////////
//

$(document).ready(function()
{
	//alert('wow');
	$('[data-toggle="tooltip"]').tooltip({html: true});
	$('.chatbox').animate({scrollTop: $('.chatbox').prop('scrollHeight')}, 500);
	$('.input-group-btn').on('click','.btn',function(){
		var max=$(this).val();
		var roll=(Math.floor(Math.random()*max)+1);
		$('form[name="sendMessage"] input[name="message"]').val('Wynik twojego rzutu to =><b>'+roll+'</b><=');
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
				//return false;
			},
			error : function(err) {
				console.log(JSON.stringify(err));
			}
		});
		
		return false;
	});
});