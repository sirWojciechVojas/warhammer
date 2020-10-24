	<script src="<?= base_url('../warhammer/assets/bs')?>/bootstrap-validate.js" type="text/javascript" charset="utf-8" async defer></script>
	<script>
		bootstrapValidate(['input[name="user"]','input[name="passFirst"]','input[name="passCheck"]'], 'min:5:Musisz wpisać conajmniej 5 znaków!');
		// bootstrapValidate(['input[name="user"]','input[name="passFirst"]','input[name="passCheck"]'], 'min:5:Musisz wpisać conajmniej 5 znaków!|startsWith:To pole musi zaczynać sie od litery');
	</script>
	<script src="<?= base_url('../warhammer/assets/bs')?>/jquery.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('../warhammer/assets/bs')?>/jquery-ui.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('../warhammer/assets/bs')?>/popper.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('../warhammer/assets/bs/js')?>/bootstrap.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="<?= base_url('../warhammer/assets/bs/js')?>/<?=$js?>" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>