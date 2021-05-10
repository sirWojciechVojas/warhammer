<?php if(preg_match('#Chat#',$controllerName) && $methodName!=='pending') : ?>
<script>
        $(function () {
            scrollMsgBottom()
        })

        function scrollMsgBottom(){
          $('.chatbox').animate({scrollTop: $('.chatbox').prop('scrollHeight')}, 500);
          // var d = $('.message-holder');
          //           d.scrollTop(d.prop("scrollHeight"));
        }

        function getImages(){
          var data = <?=$controller->data_images(); ?>

          return data
        }

        $(function () {
            var SOCKET_CONNECTING = 0;
            var SOCKET_OPEN = 1;
            var SOCKET_CLOSING = 2;
            var SOCKET_CLOSED = 3;
            var conn = new WebSocket('<?=$wsAddress . session()->get('USER_ID') ?>');
            console.log('<?=$wsAddress . session()->get('USER_ID') ?>');

            $conn=conn;
            conn.onopen = function(e) {
			    	console.log("Connection established!");
				// conn.send('wtf');
            };
            conn.onclose = function(e) {
				//conn.send('wtf');
            };
            conn.onmessage = function(e) {
              console.log(e.data);

              var data = JSON.parse(e.data);

              if ('users' in data){
                updateUsers(data.users);
              } else if('message' in data){
                newMessage(data);
                activateTooltip();
              }

            };

            $('.row').on('submit','form[name="sendMessage"]',function(){
                var messageObj = $('#sendInput input[name="message"]')
                var msg = messageObj.val()
                messageObj.val(msg)
                messageObj.hide()
                if(msg.trim() == '') return false
                conn.send(msg)
                myMessage(msg)
                messageObj.val('')
                MsgText(conn,msg)
                return false
            })

      }),
      function ping(client) {
        if (ws.readyState === SOCKET_OPEN) {
          ws.send('__ping__');
        } else {
          console.log('Server - connection has been closed for client ' + client);
          removeUser(client);
        }
      }
      function removeUser(client) {

        console.log('Server - removing user: ' + client)

        var found = false;
        for (var i = 0; i < userList.length; i++) {
          if (userList[i].name === client) {
            userList.splice(i, 1);
            found = true;
          }
        }

        //send out the updated users list
        if (found) {
          wss.broadcast(JSON.stringify({userList: userList}));
        };

        return found;
      }

      function pong(client) {
        console.log('Server - ' + client + ' is still active');
        clearTimeout(keepAlive);
        setTimeout(function () {
          ping(client);
        }, keepAliveInterval);
      }

      function MsgText(msg,conn=$conn){
          var messageObj = $('#sendInput input[name="message"]');
          // alert(msg)
          messageObj.val(msg);
          // messageObj.hide();
          if(msg.trim() == '') return false;
          conn.send(msg);
          myMessage(msg);
          // $('.chatbox').html(data).animate({scrollTop: $('.chatbox').prop('scrollHeight')}, 500);
          messageObj.val(null);
          // messageObj.show();
          activateTooltip();
      }
      function newMessage(msg){
         var title = msg.role+'<br>('+msg.author+')';
        const imgs = getImages();
        html = msgHtml(title,imgs[msg.author],msg.time,msg.message,msg.author);
          $('.chatbox').append(html);
          scrollMsgBottom();
      }
      function myMessage(msg){
          var name = '<?= session()->get('user') ?>';
          var role = '<?= session()->get('role') ?>';
          var title = role+'<br>('+name+')';
          const imgs = getImages();
          var date = new Date;
          // var date2 = new Date('Y-m-d H:i:s');
          var time1 = addZero(date.getDate())+'.'+addZero(date.getMonth()+1)+'.'+date.getFullYear();
          var time2 = addZero(date.getHours())+':'+addZero(date.getMinutes())+':'+addZero(date.getSeconds());
          var time = time1 + ' ' + time2;
          html = msgHtml(title,imgs[name],time,msg);
          $('.chatbox').append(html);
          scrollMsgBottom();
          $.ajax({
            url: 'chat/send',
            type: 'POST',
            data: {user: name, role: role, waktu: date, teks: msg},
            success: function(response){
              // alert(response);
              // var response = JSON.parse(response);
              // console.log(response);
              // $('body').append(response);
              // Add response in Modal body
            //   activateTooltip();
              // executeInv();
              // $('.modal-footer').remove();
              // $('#InvModalCenter').modal('show', $this);
              // Display Modal
            }
          });
      }
      function addZero(i) {
          if (i < 10) {
              i = "0" + i;
          }
          return i;
      }
      function msgHtml(title,imgName,time,msg,author='Ja'){
          var color = (author=='Ja') ? '#179907' : '#076099';
          html=`<div class="row">
                <div class="msg-img col-md-1 justify-content-center align-self-center">
                  <img data-toggle="tooltip" data-placement="left" data-original-title="` + title + `" class="profile-img-mini" src="<?=base_url();?>/assets/img/` + imgName + `">
                </div>
                <div class="col-md-11">
                  <div class="card card-comment">
                    <div class="card-header">
                      <div class="col-md-12"><strong style="font-size: 12px; color: ` + color + `">` + author + `:&nbsp;</strong><small>` + time + `</small></div>
                      <div class="card-chatText">` + msg + `</div>
                    </div>
                  </div>
                </div>`;
          return html;
      }
      function updateUsers(users){
          var html = '';
          var myId = <?= session()->get('USER_ID') ?>;

          for (let index = 0; index < users.length; index++) {
            //if(myId !== parseInt(users[index].c_user_id)) html += '<li class="list-group-item">['+ users[index].c_user_id+'/'+myId+']'+users[index].c_name +'</li>';
            // html += '<li class="list-group-item">'+users[index].c_name +'</li>';
            html += '<li class="list-group-item">'+ users[index].c_role+' ('+users[index].c_name +')</li>';
            // console.log( JSON.stringify(myId) );
            // console.log( JSON.stringify(users[index].c_user_id) );
          }

          if(html == ''){
            html = '<li class="list-group-item">Oprócz Ciebie nie ma tu nikogo!</li>';
          }
          $('#user-list').html(html);
        }
  </script>
<?php endif ?>
	<script src="<?= base_url('assets/bs')?>/jquery-ui.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('assets/bs/')?>/popper.min.js" type="text/javascript" charset="utf-8" async defer></script>
  <script src="<?= base_url('assets/bs/js')?>/bootstrap.min.js" type="text/javascript" charset="utf-8" async defer></script>
<?php if($methodName!=='pending') : ?>
  <script src="<?= base_url('assets/bs/js')?>/<?=$js?>" type="text/javascript" charset="utf-8" async defer></script>
<?php endif ?>
	<script src="<?= base_url('assets/bs/js')?>/footer.inc.js" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>