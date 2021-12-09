<?php ob_clean(); ?>
<div class="modal fade modal-wide" id="<?=$prefix?>ModalCenter" tabindex="-1" role="dialog" aria-labelledby="HPModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog cP modal-dialog-centered mw-100" role="document">
    	<div class="modal-content" id="HPMenu">
      		<div class="modal-header mh-5">
				<div id="<?=$prefix?>ModalLongTitle" class="modal-title col-md-12 titleBar"><?=$titleBar2?>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding:3px 15px;margin-top:5px;background:#f00;color:#fff;">
          				<span aria-hidden="true">&times;</span>
        			</button>
				</div>
      		</div>
      		<div class="modal-body<?=$addClass?>" style="padding:0 15px;">
                <?php if ($prefix == 'HP'): ?>
					<div class="col-md-12 predesc">Po ustawieniu odpowiedniej wartości i naciśnięciu przycisku Wyślij, Twoja akcja zostanie wyświetlona na czacie i będzie mogła zostać odrzucoona przez Game Mastera!</div>
					<div class="col-md-12 addictionBar">
						<div class="btn-group d-flex justify-content-around" data-wounds="<?=$HP->WOUNDS?>" data-hp="<?=$HP->HP?>">
							<?php foreach($HP->buttons as $k => $number):?>
							<div><button type="button" class="btn btn-primary addiction" value="<?=$number?>"><?=$number?></button></div>
							<?php endforeach ?>
							<div><button type="button" class="btn btn-primary addiction" value="<?=($HP->WOUNDS-$HP->HP)?>">max</button></div>
							<div class="col-md-4"><input type="number" style="width:80px;" readonly="true" min="0"/></div>
						</div>
					</div>
				<?php elseif($prefix == 'Trait'):
					if(in_array($traitName,array('FATEINS','LUCKMOTIVE'))):
						$predesc = 'Po ustawieniu odpowiedniej wartości i naciśnięciu przycisku Wyślij, zmienisz wartość cechy <b>'.preg_replace('#&#','i/lub',$NazwaCechy).'</b> swojego Bohatera.';
						$btnStyle = array('success','dark'); $inputsDivs='';
						foreach($btnStyle as $v => $style):
							$inputsDiv='<div class="btn-group d-flex justify-content-between"><div class="predesc2">'.$titleBar3[$v].'</div>';
							foreach($HP->buttons as $k => $number):
								$inputsDiv .='<div class="col-md-1"><button type="button" class="btn btn-'.$style.' addiction" value="'.$number.'">'.$number.'</button></div>';
							endforeach;
							$inputsDiv .='<div class="col-md-2"><input type="number" readonly="true" value="0"/></div><div class="col-md-2"><select class="form-control form-control-sm">
								<option value="+">Podwyższ</option>
								<option value="-">Obniż</option>
							</select></div>
							</div>';
							$inputsDivs.=$inputsDiv;
						endforeach;
						else :
						$predesc = 'Po ustawieniu odpowiedniej wartości i naciśnięciu przycisku Wyślij, zwiększysz cechę <b>'.$NazwaCechy.'</b> swojego Bohatera, a cała operacja zostanie wyświetlona na czacie i będzie mogła zostać odrzucona przez Game Mastera!
						<div class="predesc3">Koszt wykupu +5 punktów Cechy Głównej wynosi 100 PD (opłacalny).</div>
						<div class="predesc3">Koszt wykupu +1 punktu Cechy Głównej wynosi 23 PD (opcjonalny).</div>';
						$inputsDivs='<div class="btn-group d-flex justify-content-between" data-wounds="'.$HP->WOUNDS.'" data-hp="'.$HP->HP.'">';
						foreach($HP->buttons as $k => $number):
							$inputsDivs .='<div class="col-md-1"><button type="button" class="btn btn-info addiction" value="'.$number.'">'.$number.'</button></div>';
						endforeach;
						$inputsDivs .='<div class="col-md-1"><button type="button" class="btn btn-info addiction" value="'.($traitInit+$traitAdv-$traitAct).'">max</button></div>
						<div class="col-md-4"><input type="number" readonly="true" value="0" max="'.$traitAdv.'"/></div>
						</div>';
					?>
					<?php endif;?>
					<div class="col-md-12 predesc"><?=$predesc?></div>
					<div class="col-md-12 addictionBar">
						<?= $inputsDivs?>
					<?php if(!in_array($traitName,array('FATEINS','LUCKMOTIVE'))): $traitAdv=$traitInit+$traitAdv-$traitAct;?>
						<div class="d-flex justify-content-around badge badge-warning">
							<div class="col-md-6" style="text-align:right;line-height:20px">Całkowity Koszt PD:</div>
							<div class="col-md-6"><input type="number" readonly="true" value="0"/></div>
						</div>
						<div class="d-flex justify-content-around badge badge-primary">
							<div class="col-md-6" style="text-align:right;line-height:20px">Obecne PD:</div>
							<div class="col-md-6"><input type="number" readonly="true" value="0"/></div>
						</div>
						<div class="d-flex justify-content-around badge badge-success">
							<div class="col-md-6" style="text-align:right;line-height:20px">Aktualny schemat rozwoju cechy:</div>
							<div class="col-md-6"><input type="number" readonly="true" value="<?=$traitAdv?>"/></div>
						</div>
					<?php endif ?>
					</div>
					<input type="hidden" id="traitName" value="<?=$traitName?>"/>
					<input type="hidden" id="traitAct" value="<?=$traitAct?>"/>
					<input type="hidden" id="traitAdv" value="<?=$traitAdv?>"/>
					<input type="hidden" id="wTrait" value="<?=$wTrait?>"/>
					<input type="hidden" id="NazwaCechy" value="<?=$NazwaCechy?>"/>
                <?php elseif($prefix == 'UmZd'): ?>
                    <div class="col-md-12 predesc">Wykup każdej <?=$titleBar?> kosztuje 100 PD. Po naciśnięciu przycisku "Wykup" niewykorzystane doświadczenie zostanie odjęte z puli BG, a cała operacja zostanie wyświetlona na czacie i będzie mogła zostać odrzucona przez Game Mastera!</div>
					<div class="col-md-12 desc" style="color: #fff; text-align:justify;"></div>
					<input type="hidden" id="idUm" value="<?=$idUm?>"/>
					<input type="hidden" id="details" value="<?=$details?>"/>
				<?php elseif($prefix == 'PD'): ?>
					<div class="col-md-12 predesc">Po ustawieniu odpowiedniej wartości i naciśnięciu przycisku Wyślij, <?=$titleBar?> zmianę Punktów Doświadczenia, a cała operacja zostanie wyświetlona na czacie i będzie mogła zostać odrzucona przez Game Mastera!</div>
					<div class="col-md-12 addictionBar">
						<div class="btn-group d-flex justify-content-around">
							<?php foreach($HP->buttons as $k => $number):?>
							<div><button type="button" class="btn btn-success addiction" value="<?=$number?>"><?=$number?></button></div>
							<?php endforeach ?>
							<div class="col-md-3"><input type="number" style="width:80px;" readonly="true"/></div>
						</div>
					</div>
					<input type="hidden" id="idUm" value="<?=$idUm?>"/>
					<input type="hidden" id="details" value="<?=$details?>"/>
				<?php elseif($prefix == 'Brass'): ?>
					<div class="col-md-12 predesc">Zmień swój stan posiadania! Po ustawieniu odpowiedniej wartości i naciśnięciu przycisku Wyślij,  <?=$titleBar?>, a cała operacja zostanie wyświetlona na czacie i będzie mogła zostać odrzucona przez Game Mastera!</div>
					<div class="col-md-12 addictionBar">
						<div class="col-md-12" id="<?=$prefix?>-line"></div>
						<div class="btn-group d-flex justify-content-around">
							<?php foreach($HP->buttons as $k => $number):?>
							<div><button type="button" class="btn btn-warning addiction" value="<?=$number?>"><?=$number?></button></div>
							<?php endforeach ?>
							<div class="col-md-4"><input type="hidden" readonly="true" value="0"/></div>
						</div>
					</div>
					<input type="hidden" id="hBrass" value="<?=$hBrass?>"/>
				<?php elseif($prefix == 'Inv'): ?>
					<div class="col-md-2 predesc"><img src="<?= base_url('../assets/img/inventory/Inventory_L[72x72]/fin[72x72]/' . $item['IMG_CLASS'] . '.png') ?>"/></div>
					<div class="col-md-10 predesc">
						<?php if($item['ITEM_CLASS'] == 'WEAPON'): ?>
						<div class="align-self-center"><?=$item['HANDED']?></div>
						<?php else: ?>
						<div class="align-self-center"><?=$item['NAME']?></div>
						<div class="align-self-center"><b>Obciążenie: </b><?=$item['CHARGE']?> punktów</div>
						<?php endif ?>
						<div class="align-self-center"><b>Wartość: </b>
							<?php if($item['ITEM_CLASS'] == 'EXTRA'): ?>
							<?=$item['PRIZE']?> brass
							<?php else: ?>
							nieznana
							<?php endif ?>
						</div>
					</div>
					<?php if($item['ITEM_CLASS'] == 'WEAPON'): ?>
					<div class="col-md-12 predesc">
						<div>Typ broni: <?=$item['TYPE']?></div>
						<div>Obrażenia: <?=$item['DAMAGE'].' ('.$item['DICE'].')'?></div>
						<?php if($item['TYPE'] == 'miotająca'): ?>
						<div>Obrażenia: <?=$item['RANGE'] ?></div>
						<div>Obrażenia: <?=$item['RELOAD'] ?></div>
						<?php endif ?>
						<div>Cechy oręża: <?=$item['QUALITIES']?></div>
						<div>Obciążenie: <?=$item['LOAD']?></div>
					</div>
					<?php endif ?>
					<div class="col-md-12 predesc">
						<?=$item['DESCRIPTION']?>
						<?=$item['DETAILS']?>
						<?=$item['PERSONAL_DESC']?>
					</div>
                <?php endif; ?>
			</div>
			<div class="modal-footer">
        		<button type="button" class="btn btn-danger btn-sm">Wyślij</button>
				<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Anuluj</button>
			</div>
		</div>
	</div>
</div>
<?php exit(); ?>