<?php ob_clean(); ?>
<?php foreach($equipFieldNames as $key => $val):
    if ($val == 'ID' || $val == 'NAME'):?>

    <?php elseif ($val == 'ITEM_ID'):?>

    <?php else: ?>

<?php endif; ?>
<?php endforeach; ?>
</form>