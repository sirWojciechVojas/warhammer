<div class="container">
	<div class="row">
		<div class="col-md-6 offset-md-3 d-flex justify-content-center align-self-center">
			<div class="card card-height" style="margin-top:4%;">
				<?php foreach($status as $s): ?>
				<div class="card-header d-flex justify-content-between">
					<strong><?=$session->get['user'];?></strong>
					<a href="<?= base_url('login/logout') ?>" class="btn btn-danger btn-xs pull-right">WYLOGUJ</a>
					<?php
						if ($session->get('akses') == 'ADMIN') {
							echo "<a href=".base_url('chat')." class=\"btn btn-primary btn-xs\" title=\"User Perlu Persetujuan\"><i class=\"glyphicon glyphicon-comment\"></i> Chatbox</a>";
							if($s->status == TRUE) {
								echo "<a href=".base_url('chat/maintenance')." class=\"btn btn-warning btn-xs\" title=\"Disable Chat\"><i class=\"glyphicon glyphicon-lock\"></i> Maintenance</a>";
							} else {
								echo "<a href=".base_url('chat/open')." class=\"btn btn-success btn-xs\" title=\"Enable Chat\"><i class=\"glyphicon glyphicon-ok\"></i> Otwórz Chat</a>";
							}
						}
					?>
				</div>
				<?php endforeach ?>
				<div class="card-body chatbox-bg" style="height: 300px; overflow-y: scroll">
					<table class="table table-condensed">
						<thead>
							<th>No</th>
							<th>Login</th>
							<th>BG</th>
							<th>Akcje</th>
						</thead>
						<?php $i=1; foreach($orang->getResult() as $o): ?>
						<tbody>
							<td><?= $i++ ?></td>
							<td><?= $o->user ?></td>
							<td><?= $o->role ?></td>
							<td>
								<?php
									if ($o->status == TRUE) {
										echo "<a href=".base_url("chat/nonaktif/$o->user")." class=\"btn btn-xs btn-warning\" title=\"Dezaktywuj\"><i class=\"glyphicon glyphicon-warning-sign\"></i></a>";
									} else {
										echo "<a href=".base_url("chat/aktif/$o->user")." class=\"btn btn-xs btn-success\" title=\"Aktywuj\"><i class=\"glyphicon glyphicon-check\"></i></a>";
									}
								?>
								<a href="<?= base_url("chat/delete_user/$o->user") ?>" class="btn btn-xs btn-danger" title="Usuń"><i class="glyphicon glyphicon-trash"></i></a>
							</td>
						</tbody>
						<?php endforeach ?>
					</table>
				</div>
				<div class="card-footer">
					<div class="col-md-12">Liczba użytkowników: <?= $orang->resultID->num_rows ?></div>
				</div>
			</div>
		</div>
	</div>
</div>