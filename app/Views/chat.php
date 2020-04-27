<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<br><br><br><br>
				<?=$session->getFlashdata('done');?>
				<div class="panel panel-default panel-height">
					<?php foreach($status as $s): ?>
					<div class="panel-heading">
						<strong><?=$session->get('nama');?></strong>
						<a href="<?= base_url('login/logout') ?>" class="btn btn-danger btn-xs pull-right">WYLOGUJ</a>
						<?php 
							if ($session->get('akses') == 'ADMIN') {
								echo "<a href=".base_url('chat/pending')." class=\"btn btn-primary btn-xs\" title=\"User Perlu Persetujuan\"><i class=\"glyphicon glyphicon-user\"></i> Użytkownicy</a>";
								if($s->status == TRUE) {
									echo "<a href=".base_url('chat/maintenance')." class=\"btn btn-warning btn-xs\" title=\"Disable Chat\"><i class=\"glyphicon glyphicon-lock\"></i> Wyłącz Chat</a>";
								} else {
									echo "<a href=".base_url('chat/open')." class=\"btn btn-success btn-xs\" title=\"Enable Chat\"><i class=\"glyphicon glyphicon-ok\"></i> Włącz Chat</a>";
								}
							}
						?>
					</div>
					<?php endforeach ?>
					<?php if ($s->status == TRUE): ?>
					<div class="panel-body chatbox">
					<?php if($ajax==true) ob_clean(); foreach ($chat as $c){ ?>
						<?php if($c->pengirim == $session->get('user')){ ?>
							<div class="pull-left image" style="float:left;">
								<img data-toggle="tooltip" data-placement="left" title="Leopold Leinweber<br>(Wojciech Vojas)" class="profile-img-mini" src="<?= base_url("../warhammer/assets/img/Leopold Leinweber.png") ?>" alt="Avatar">					
							</div>
							<div class="col-md-11" style="float:left;">
								<div class="panel panel-comment">
									<div class="panel-heading" >
										<strong style="opacity: .5; font-size: 12px; color: #4BD239">Ja : &nbsp;&nbsp;&nbsp;</strong>
										<small><?php echo date("d.m.Y H:i:s", strtotime($c->waktu)); ?></small><br/>
										<?= $c->teks ?>
									</div>
								</div>
							</div>
						<?php } else { ?>
							<div class="pull-left image" style="float:left;">
								<img data-toggle="tooltip" data-placement="left" title="Leopold Leinweber" class="profile-img-mini" src="<?= base_url("../warhammer/assets/img/Leopold Leinweber.png") ?>" alt="Avatar">					
							</div>
							<div class="col-md-11" style="float:left;">
								<div class="panel panel-comment">
									<div class="panel-heading" >
										<strong style="opacity: .5; font-size: 12px; color: #DCD15B"><?= $c->pengirim ?>:</strong>
										<small><?php echo date("d.m.Y H:i:s", strtotime($c->waktu)); ?></small><br/>
										<?= $c->teks ?>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					</div>
					<?php endif ?>
					<?php if($ajax==true) exit(); if ($s->status == FALSE): ?>
					<div class="panel-body">
						<h4 class="text-center" style="color: #FF0000">Przepraszamy<br>Aktualnie serwer jest offline!<br><br>Poczekaj na postawienie serwera przez Game Mastera.</h4>
					</div>
					<?php endif ?>
				</div>
				<?php if ($s->status == TRUE): ?>
					<div class="row">
						<div class="col-md-13">
							<form name="sendMessage" method="post" action="" autocomplete="off">
								<div class="col-md-13">
									<div id="sendInput" class="input-group panel">
										<input type="text" name="message" class="form-control" placeholder="Tu wprowadź tekst">
										<span class="input-group-btn">
											<input class="btn btn-success" type="submit" value="Wyślij">
										</span>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 ">
								<div class="col-md-12">
									<div class="input-group">
										<?php foreach ($dices as $num){ ?>
										<span class="input-group-btn">
											<button class="btn" value="<?=$num?>">K<?=$num?></button>
										</span>
										<?php } ?>
									</div>
								</div>
						</div>
					</div>				
				<?php endif ?>
		</div>
	</div>
</div>
<?/*<div id="characterStats"></div>*/?>
<div id="characterPanel"></div>