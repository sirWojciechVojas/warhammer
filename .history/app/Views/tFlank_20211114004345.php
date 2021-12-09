<?php ob_clean();?>
<?php if($acc == 'GM' && $side == 'left'):?>
        <button class="btn btn-secondary square justify-content-center <?=$acc?>1 active">Szablony-dodaj/edytuj</button>
        <button class="btn btn-info square justify-content-center <?=$acc?>2">Stos - spersonalizuj</button>
        <button class="btn btn-warning square justify-content-center <?=$acc?>3">Ekwipunek BG - spersonalizuj</button>
<?php elseif($acc == 'GM' && $side == 'right'):?>
        <button class="btn btn-secondary square justify-content-center">Sklep-dodaj/edytuj</button>
        <button class="btn btn-warning square justify-content-center">Sklep-ustal asortyment</button>
        <button class="btn btn-warning square justify-content-center">Ekwipunek BG - (BG1+BG2+...) & Trash</button>
        <button class="btn btn-info square justify-content-center">Stos BG - (BG1+BG2+...) & Trash</button>
<?php elseif($acc !== 'GM' && $side == 'left'):?>
        <button class="btn btn-secondary square justify-content-center active">Szyld-img</button>
        <button class="btn btn-info square justify-content-center">Sklep aktywny nr 1</button>
        <button class="btn btn-info square justify-content-center">Sklep aktywny nr 2</button>
        <button class="btn btn-info square justify-content-center">Sklep aktywny nr 3</button>
<?php elseif($acc !== 'GM' && $side == 'right'):?>
        <button class="btn btn-secondary square justify-content-center active">Stan sakiewki BG</button>
        <button class="btn btn-info square justify-content-center">Obciążenie BG</button>
<?php else: ?>
        <button class="btn btn-warning square justify-content-center">nice-1</button>
        <button class="btn btn-warning square justify-content-center">nice-2</button>
<?php endif; ?>