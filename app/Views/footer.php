	<script src="<?= base_url('../warhammer/assets/bs')?>/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script>
        $(function () {
            scrollMsgBottom()
        })

        function scrollMsgBottom(){
          var d = $('.message-holder');
                    d.scrollTop(d.prop("scrollHeight"));
        }

        function getImages(){
          const imgs = {
            'Mary' : 'mary.jpg',
            'sirWojciechVojas' : 'GAME MASTER.png',
            'Łukasz' : 'alex.jpg',
          }

          return imgs
        }

        $(function () {
            var conn = new WebSocket('ws://localhost:8082?access_token=<?= session()->get('USER_ID') ?>');
            conn.onopen = function(e) {
				console.log("Connection established!");
				//conn.send('wtf');
            };
            conn.onclose = function(e) {
				console.log("uj ci w dupe");
				//conn.send('wtf');
            };
            conn.onmessage = function(e) {
              console.log(e.data);

              var data = JSON.parse(e.data);

              if ('users' in data){
                updateUsers(data.users);
              } else if('message' in data){
                newMessage(data);
              }

            };

            $('.row').on('submit','form[name="sendMessage"]',function(){
                var msg = $('#sendInput input[name="message"]').val();
                if(msg.trim() == '') return false;
                conn.send(msg);
                myMessage(msg);
                $('#sendInput input[name="message"]').val('');
            })
        })

        function newMessage(msg){
          const imgs = getImages();

		  html = `<div class="row">
                    <div class="msg-img col-md-1 justify-content-center align-self-center">
                      <img class="profile-img-mini" src="<?=dirname(base_url());?>/assets/img/` + imgs[msg.author] + `">
					</div>
					<div class="col-md-11">
					<div class="card card-comment">
						<div class="card-header">
							<strong style="font-size: 12px; color: #076099">` + msg.author + `:</strong>
							<small>` + msg.time + `</small><br>` + msg.message + `
						</div>
					</div>
				</div>`;
          $('.chatbox').append(html);
          scrollMsgBottom();

        }

        function myMessage(msg){
          var name = '<?= session()->get('firstname') ?>';
          const imgs = getImages();
          var date = new Date;
          var minutes = date.getMinutes();
          var hour = date.getHours();
          var time = hour + ':' + minutes;
          html = `<div class="col-8 msg-item right-msg offset-4">
                    <div class="msg-img">
                      <img class="img-thumbnail rounded-circle" src="<?=base_url('/assets/img');?>/` + imgs[name] + `">
                    </div>
                    <div class="msg-text">
                      <span class="author">Ja</span> <span class="time">` + time + `</span><br>
                      <p>` + msg + `</p>
                    </div>
                  </div>`;
          $('.chatbox').append(html);
          scrollMsgBottom();
        }

        function updateUsers(users){
          var html = '';
          var myId = <?= session()->get('ID') ?>;

          for (let index = 0; index < users.length; index++) {
            if(myId != users[index].c_user_id) html += '<li class="list-group-item">'+ users[index].c_name +'</li>';
          }

          if(html == ''){
            html = '<p>Oprócz Ciebie nie ma tu nikogo!</p>';
          }


          $('#user-list').html(html);


        }
	</script>
	<script src="<?= base_url('../warhammer/assets/bs')?>/jquery-ui.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('../warhammer/assets/bs/')?>/popper.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('../warhammer/assets/bs/js')?>/bootstrap.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('../warhammer/assets/bs/js')?>/<?=$js?>" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('../warhammer/assets/bs/js')?>/footer.inc.js" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>