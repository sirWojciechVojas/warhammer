<?php ob_clean(); ?>
<?php foreach($equipFieldNames as $key => $val):
    if ($val == 'ID' || $val == 'NAME'):?>

    <?php elseif ($val == 'ITEM_ID'):?>

    <?php else: ?>
    <button class="btn btn-secondary square justify-content-center active">Szblony-dodaj/edytuj</button>
    <button class="btn btn-info square justify-content-center">Stos - spersonalizuj</button>
    <button class="btn btn-warning square justify-content-center">Sklep-ustal asortyment</button>
<?php endif; ?>
<?php endforeach; ?>