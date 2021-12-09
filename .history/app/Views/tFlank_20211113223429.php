<?php ob_clean(); ?>
<?php foreach($equipFieldNames as $key => $val):
    if ($val == 'GM' && $val == 'left'):?>
        <button class="btn btn-secondary square justify-content-center active">Szblony-dodaj/edytuj</button>
        <button class="btn btn-info square justify-content-center">Stos - spersonalizuj</button>
        <button class="btn btn-warning square justify-content-center">Ekwipunek BG - spersonalizuj</button>
        <?php elseif ($val == 'GM' && $val == 'right'):?>
        <button class="btn btn-secondary square justify-content-center active">Sklep-dodaj/edytuj</button>
        <button class="btn btn-warning square justify-content-center">Sklep-ustal asortyment</button>
        <button class="btn btn-warning square justify-content-center">Ekwipunek BG - (BG1+BG2+...) & Trash</button>
        <button class="btn btn-info square justify-content-center">Stos BG - (BG1+BG2+...) & Trash</button>
    <?php else: ?>
    <button class="btn btn-secondary square justify-content-center active">Szblony-dodaj/edytuj</button>
    <button class="btn btn-info square justify-content-center">Stos - spersonalizuj</button>
    <button class="btn btn-warning square justify-content-center">Sklep-ustal asortyment</button>
<?php endif; ?>
<?php endforeach; ?>