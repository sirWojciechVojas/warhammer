<div>
    By: <a href="http://ericeastwood.com/">Eric Eastwood</a>
</div>

<div>
    Wierszy:<input type="range" id="row-count" min="1" max="50" step="1" value="3" /><label for="row-count"></label>
    <br />
    Kolumn:<input type="range" id="column-count" min="1" max="50" step="1" value="3" /><label for="column-count"></label>
</div>
    
<div class="inventory-table" id="personal-inventory">
    <div class="inventory-row">
        <div class="inventory-cell">
            <div class="inventory-item springBerries"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item sword" data-item-type="weapon sword"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item potionOfPower"></div>
        </div>
        <div class="inventory-cell">
        </div>
        <div class="inventory-cell">
        </div>
    </div>
    <div class="inventory-row">
        <div class="inventory-cell">
            <div class="inventory-item vegetables" data-item-type="food"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item meat" data-item-type="food cookable"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item meatDish" data-item-type="food cookable"></div>
        </div>
        <div class="inventory-cell"></div>
        <div class="inventory-cell"></div>
    </div>
    <div class="inventory-row">
        <div class="inventory-cell">
            <div class="inventory-item battleAxe" data-item-type="weapon axe"></div>    
        </div>
        <div class="inventory-cell">
        </div>
        <div class="inventory-cell">
            <div class="inventory-item vegetables" data-item-type="food"></div>
        </div>
        <div class="inventory-cell"></div>
        <div class="inventory-cell"></div>
    </div>
</div>

<br />

Skrzynka:
<div class="inventory-table">
    <div class="inventory-row">
        <div class="inventory-cell">
            <div class="inventory-item springBerries" data-item-type="food"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item sword" data-item-type="weapon sword"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item fruits" data-item-type="food"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item swordLyssandrasBlade" data-item-type="weapon sword enchanted"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item warBow magic" data-item-type="weapon bow enchanted"></div>
        </div>
    </div>
    <div class="inventory-row">
        <div class="inventory-cell">
            <div class="inventory-item springBerries" data-item-type="food"></div>
        </div>
        <div class="inventory-cell">
            <div class="inventory-item battleAxeEofR magic" data-item-type="weapon axe enchanted"></div>
        </div>
        <div class="inventory-cell"></div>
        <div class="inventory-cell"></div>
        <div class="inventory-cell"></div>
    </div>
</div>



<br />

Piec(Kuchenka):
<div class="inventory-table" data-item-filter-whitelist="cookable">
    <div class="inventory-row">
        <div class="inventory-cell">
        </div>
        <div class="inventory-cell">
        </div>
    </div>
    <div class="inventory-row">
        <div class="inventory-cell">
        </div>
        <div class="inventory-cell">
        </div>
    </div>
</div>

<br />

Tylko zaklęta broń, która nie jest siekierą:
<div class="inventory-table" data-item-filter-whitelist="weapon+enchanted" data-item-filter-blacklist="axe">
    <div class="inventory-row">
        <div class="inventory-cell">
            <div class="inventory-item warBow rare" data-item-type="weapon bow enchanted"></div>
        </div>
        <div class="inventory-cell">
        </div>
    </div>
    <div class="inventory-row">
        <div class="inventory-cell">
        </div>
        <div class="inventory-cell">
        </div>
    </div>
</div>
<?php /* ?>
<div class="inventory-table">
    <div class="inventory-row">
        <div class="myHcell">
<div class="inventory-table">
<?php foreach($imgL as $fileName): ?>
    <div class="inventory-row">
        <div class="my-cell"><img src="<?=base_url('../warhammer/assets/img/inventory/unit').'/'.$dirL.'/'.$fileName?>"></div>
        <div class="my-cell"><?=$fileName?></div>
    </div>
<?php endforeach ?>
</div>
        </div>
        <div class="myHcell">
<div class="inventory-table">
<?php foreach($imgS as $fileName): ?>
    <div class="inventory-row">
        <div class="my-cell"><img src="<?=base_url('../warhammer/assets/img/inventory/unit').'/'.$dirS.'/'.$fileName?>"></div>
        <div class="my-cell"><?=$fileName?></div>
    </div>
<?php endforeach ?>
</div>
        </div>
    </div>
</div>
<?php */ ?>