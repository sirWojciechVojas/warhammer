<div class="container h-100">
	<div class="row align-items-center h-100 justify-content-md-center">
		<div class="col-sm-8 col-md-4">
			<div class="account-wall REG"><br>
				<h4 class="text-center" style="margin-top: -10px">Rejestracja</h4><br>
				<img class="profile-img" src="<?= base_url('../warhammer/assets/img/photo.png') ?>" alt="Avatar">
				<form class="form-signin" action="<?= base_url('login/regis') ?>" method="post">
				<?= $session->getFlashdata('fail'); ?>
					<div class="form-group">
						<input name="nameBG" type="text" readonly="true" class="form-control" placeholder="Imię Bohatera Gracza" required>
					</div>
					<div class="form-group">
						<input name="user" type="text" class="form-control" placeholder="Nazwa użytkownika" required autofocus>
					</div>
					<div class="form-group">
						<input name="passFirst" type="password" class="form-control" placeholder="Hasło" required>
					</div>
					<div class="form-group">
						<input name="passCheck" type="password" class="form-control" placeholder="Powtórz Hasło" required>
					</div>
					<input type="submit" name="regis" value="Zarejestruj" class="btn btn-lg btn-success btn-block">
					<a href="<?= base_url() ?>" class="btn btn-lg btn-primary btn-block">Logowanie</a>
				</form>
			</div>
		</div>
		<div class="col-sm-12 col-md-6 BG0">
			<div class="account-wall BG"><br>
				<h4 class="text-center" style="margin-top: -10px">Wybierz Bohatera</h4><br>
				<ul style="list-style: none;">
				<?php foreach($BG as $id): ?>
					<li>
						<img class="profile-img" src="<?= base_url("../warhammer/assets/img/$id->USEDNAME.png") ?>" alt="Avatar">
						<h3><?=$id->USEDNAME;?></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod ultrices ante, ac laoreet nulla vestibulum adipiscing.</p>
					</li>
				<?php endforeach ?>
				</ul>
			</div>
		</div>
	</div>
</div>