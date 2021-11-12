<?php
if ($type == 'Goods') $nClass='tradingBrassLine bg-transparent text-light ih-50 p-0 d-flex align-items-center justify-content-end outline';
elseif($type == 'BG') $nClass='col-md-12 d-flex justify-content-center';
?>
<?php if ($prefix == 'Imperium'): ?>
<div class="<?= $nClass ?>" style="padding:0;">
    <div class="crown"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mCrown ?> zk"></div>
    <div class="shilling"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mShilling ?> s"></div>
    <div class="brass"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mPenny ?> p"></div>
    <input type="hidden" id="hBrass" value="<?= $mGold->hBrass ?>" />
</div>
<?php elseif ($prefix == 'Bretonia'): ?>
<div class="<?= $nClass ?>" style="padding:0;">
    <div class="crown"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mCrown ?> zf"></div>
    <div class="shilling"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mShilling ?> sg"></div>
    <input type="hidden" id="hBrass" value="<?= $mGold->hBrass ?>" />
</div>
<?php endif; ?>
