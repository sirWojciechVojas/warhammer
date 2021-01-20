<div class="container h-100">
	<div class="row align-items-center h-100 justify-content-md-center">
		<div class="col-sm-8 col-md-4">
			<div class="account-wall LOG"><br>
				<button id="loginChanger" type="button" class="btn btn-default btn-lg GM" title="Zaloguj się jako Game Master"></button>
				<h4 class="text-center" style="margin-top: -10px">Zaloguj</h4><br>
				<img class="profile-img" src="<?= base_url('../warhammer/assets/img/photo.png') ?>" alt="Avatar">
				<form class="form-signin" action="<?= base_url('login/auth') ?>" method="post">
				<?= $session->getFlashdata('gagal'); ?>
				<?= $session->getFlashdata('login'); ?>
				<?= $session->getFlashdata('scc'); ?>
					<div class="form-group">
						<input name="nameBG" type="text" readonly="true" class="form-control" placeholder="Imię Bohatera Gracza" required>
					</div>
					<div class="form-group">
						<input name="user" type="text" class="form-control" placeholder="Nazwa użytkownika" required autofocus>
					</div>
					<div class="form-group">
						<input name="pass" type="password" class="form-control" placeholder="Hasło" required>
					</div>
					<input type="submit" name="login" value="Zaloguj" class="btn btn-lg btn-primary btn-block">
				<a href="<?= base_url('login/register') ?>" class="btn btn-lg btn-success btn-block">Rejestracja</a>
				</form>
			</div>
		</div>
		<div class="col-sm-12 col-md-6 BG0">
			<div class="account-wall BG"><br>
				<h4 class="text-center" style="margin-top: -10px">Wybierz Bohatera</h4><br>
				<ul class="row">
				<?php foreach($BG as $id): ?>
					<?php if($id->CAMPAIGN_NAME==2): ?>
					<li class="col-sm-10 col-md-12">
						<img class="profile-img" src="<?= base_url("../warhammer/assets/img/$id->USEDNAME.png") ?>" alt="Avatar">
						<h3><?=$id->USEDNAME;?></h3>
						<h6><?=$id->HISTORY; ?>...</h6>
					</li>
					<?php endif ?>
				<?php endforeach ?>
				</ul>
			</div>
		</div>
	</div>
</div>