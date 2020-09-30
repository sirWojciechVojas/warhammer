<div class="container">
	<div class="row">
		<div class="col-md-6 offset-md-3 d-flex justify-content-center align-self-center">
				<?=$session->getFlashdata('done');?>
				<div class="card card-height" style="margin-top:4%;">
					<?php foreach($status as $s): ?>
					<div class="card-header d-flex justify-content-between">
						<strong><?=$session->get('user');?></strong>
						<a href="<?= base_url('login/logout') ?>" class="btn btn-danger btn-sm pull-right order-3">WYLOGUJ</a>
						<?php if ($session->get('akses') == 'ADMIN'): ?>
								<a href="<?= base_url('chat/pending')?>" class="btn btn-primary btn-sm order-1" title="User Perlu Persetujuan"><i class="glyphicon glyphicon-user"></i> Użytkownicy</a>
								<?php if($s->status == TRUE): ?>
									<a href="<?=base_url('chat/maintenance')?>" class="btn btn-warning btn-sm order-2" title="Disable Chat"><i class="glyphicon glyphicon-lock"></i> Wyłącz Chat</a>
								<?php else: ?>
									<a href="<?=base_url('chat/open')?>" class="btn btn-success btn-sm order-2" title="Enable Chat"><i class="glyphicon glyphicon-ok"></i> Włącz Chat</a>
								<?php endif; ?>
						<?php endif; ?>
					</div>
					<?php endforeach ?>
					<?php if ($s->status == TRUE): ?>
					<div class="card-body chatbox-bg">
						<div class="col-md-12 chatbox">
					<?php if($ajax==true) ob_clean(); foreach ($chat as $c){ ?>
						<?php if($c->pengirim == $session->get('nama')){ ?>
						<div class="row">
							<div class="col-md-1 justify-content-center align-self-center">
								<img data-toggle="tooltip" data-placement="left" title="<?=$session->get('nama')?><br>(<?=$session->get('user')?>)" class="profile-img-mini" src="<?= base_url('../warhammer/assets/img/'.$session->get('nama').'.png') ?>" alt="Avatar">
							</div>
							<div class="col-md-11">
								<div class="card card-comment">
									<div class="card-header" >
										<strong style="font-size: 12px; color: #179907">Ja : &nbsp;&nbsp;&nbsp;</strong>
										<small><?php echo date("d.m.Y H:i:s", strtotime($c->waktu)); ?></small><br/>
										<?= $c->teks ?>
									</div>
								</div>
							</div>
						</div>
						<?php } else { ?>
						<div class="row">
							<div class="col-md-1 justify-content-center align-self-center">
								<img data-toggle="tooltip" data-placement="left" title="Leopold Leinweber" class="profile-img-mini" src="<?= base_url('../warhammer/assets/img/'.$c->pengirim.'.png') ?>" alt="Avatar">
							</div>
							<div class="col-md-11">
								<div class="card card-comment">
									<div class="card-header" >
										<strong style="font-size: 12px; color: #076099"><?= $c->pengirim ?>:</strong>
										<small><?php echo date("d.m.Y H:i:s", strtotime($c->waktu)); ?></small><br/>
										<?= $c->teks ?>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					<?php } ?>
						</div>
					</div>
					<?php endif ?>
					<?php if($ajax==true) exit(); if ($s->status == FALSE): ?>
					<div class="card-body">
						<h4 class="text-center" style="color: #FF0000">Przepraszamy<br>Aktualnie serwer jest offline!<br><br>Poczekaj na postawienie serwera przez Game Mastera.</h4>
					</div>
					<?php endif ?>
				<?php if ($s->status == TRUE): ?>
					<div class="card-footer">
						<form name="sendMessage" method="post" action="" autocomplete="off">
							<div id="sendInput" class="input-group">
								<input type="text" name="message" class="form-control" placeholder="Tu wprowadź tekst">
								<div class="input-group-btn"><input class="btn btn-success btn-sm" type="submit" value="Wyślij"></div>
							</div>
						</form>
					</div>
					<div class="col-md-12 btn-group d-flex justify-content-between" style="padding:0;">
							<?php foreach ($dices as $num): ?>
							<div style="width:61px;">
								<button type="button" style="width:61px;" class="btn btn-primary" value="<?=$num?>">K<?=$num?></button>
							</div>
							<?php endforeach ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-wide" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog cP modal-dialog-centered mw-100" role="document">
    	<div class="modal-content" id="characterPromotion">
      		<div class="modal-header mh-5">
				<div id="exampleModalLongTitle" class="modal-title col-md-12 titleBar">Awans postaci BG
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding:3px 15px;margin-top:5px;background:#f00;color:#fff;">
          				<span aria-hidden="true">&times;</span>
        			</button>
				</div>
      		</div>
      		<div class="modal-body cP" style="padding:0 15px;">
					<div class="row h-25 d-flex">
						<div class="col-md-6 opis">Aktualna profesja:</div><div class="col-md-6"><span><?=$curCareer['NAME']?></span></div>
						<div class="col-md-6 opis">Poprzednie profesje:</span></div><div class="col-md-6"><span><?=$prevCareer['NAME']?></span></div>
								<div class="col-md-12 btn-group d-flex justify-content-between" style="padding:0;">
								<?php foreach ($dices as $num): ?>
								<div style="width:61px;">
									<button type="button" style="width:61px;" class="btn btn-secondary" value="<?=$num?>">Du<?=$num?></button>
								</div>
								<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>

<div class="modal fade modal-wide" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog cS modal-dialog-centered mw-100" role="document">
    <div class="modal-content" id="characterStats">
      <div class="modal-header mh-5">
		<div id="exampleModalLongTitle" class="modal-title col-md-12 titleBar"><?=$BG['USEDNAME']?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding:3px 15px;margin-top:5px;background:#f00;color:#fff;">
          <span aria-hidden="true">&times;</span>
        </button>
		</div>
      </div>
      <div class="modal-body cS" style="padding:0 15px;">
	<div class="row h-100 d-flex">
		<div class="col-md-4 cPanel cLeft">
			<div class="row h-100">
				<div class="col-md-3 iSide"></div>
				<div class="col-md-6 iCenter BG<?=$BG['ID']?> d-flex align-content-start flex-column">
					<input type="text" readonly="true" value="<?=$RestInfo[1]['HEAD']?>"/>
					<input type="text" readonly="true" value="<?=$RestInfo[1]['RIGHTHAND']?>"/>
					<input type="text" readonly="true" value="<?=$RestInfo[1]['LEFTHAND']?>"/>
					<input type="text" readonly="true" value="<?=$RestInfo[1]['BODY']?>"/>
					<input type="text" readonly="true" value="<?=$RestInfo[1]['LEFTLEG']?>"/>
					<input type="text" readonly="true" value="<?=$RestInfo[1]['RIGHTLEG']?>"/>
				</div>
				<div class="col-md-3 iSide"></div>
				<div class="col-md-10 offset-md-1 imBottom"></div>
				<div class="col-md-10 offset-md-1 iBottom"></div>
			</div>
		</div>
		<div class="col-md-4 cPanel cCenter">
			<div class="row h-100 d-flex align-content-start flex-wrap">
				<div class="col-md-12 title">Cechy Bohatera</div>
				<div class="col-md-5 offset-md-1 cechy cechyGlowne d-flex justify-content-between flex-column">
				<?php foreach($Glowne[2] as $k => $val): $k1=$k.'_IN'; $k2=$k.'_ADV'; $R=($Glowne[2][$k]-$Glowne[0][$k1])/5;?>
				<?php if($Glowne[2][$k]<$Glowne[0][$k1]+$Glowne[1][$k2]): $klasa=null; else: $klasa=' disabled'; endif?>
					<div class="d-flex justify-content-between">
						<input type="text" readonly="true" value="<?=$Glowne[0][$k1]?>"/>
						<input type="text" readonly="true" value="<?=$Glowne[1][$k2]?>"/>
						<input type="text" readonly="true" class="R-<?=$R?>"/>
						<input type="text" readonly="true" value="<?=$Glowne[2][$k]?>"/>
						<input type="button" class="btn btn-danger<?=$klasa?>" value="+5"/>
					</div>
				<?php endforeach ?>
				</div>
				<div class="col-md-5 flex-column" style="padding:0;">
				<div class="col-md-12 cechy cechyDrugorzedne-1 d-flex justify-content-between flex-column">
				<?php foreach($Drugo1[2] as $k => $val): $k1=$k.'_IN'; $k2=$k.'_ADV';$R=($Drugo1[2][$k]-$Drugo1[0][$k1]);?>
				<?php if($Drugo1[2][$k]<$Drugo1[0][$k1]+$Drugo1[1][$k2]): $klasa=null; else: $klasa=' disabled'; endif?>
					<div class="d-flex justify-content-between">
						<input type="text" readonly="true" value="<?=$Drugo1[0][$k1]?>"/>
						<?php if($Drugo1[1][$k2]==0) $Drugo1[1][$k2]='-'; ?>
						<input type="text" readonly="true" value="<?=$Drugo1[1][$k2]?>"/>
						<input type="text" readonly="true" class="R-<?=$R?>"/>
						<input type="text" readonly="true" value="<?=$Drugo1[2][$k]?>"/>
						<input type="button" class="btn btn-danger<?=$klasa?>" value="+1"/>
					</div>
				<?php endforeach ?>
				</div>
				<div class="col-md-12 cechy cechyDrugorzedne-2 d-flex justify-content-between flex-column">
					<div>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['STRENGTHBONUS']?>"/>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['TOUGHNESSBONUS']?>"/>
					</div>
					<div>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['FATEPOINTS']?>"/>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['INSANITYPOINTS']?>"/>
					</div>
				</div>
				</div>
				<div class="col-md-2"><input type="button"class="buttonSkills"/></div>
				<div class="col-md-8 title">Umiejętności i Zdolności</div>
				<div class="col-md-2"><input type="button" class="buttonTalents align-self-center"/></div>
				<div class="col-md-5 offset-md-1 d-flex justify-content-between flex-column">
				<?php foreach($aSkills as $k => $val):?>
					<?php foreach($val as $ke => $va):?>
						<div><?=$ke.' '.$va?></div>
					<?php endforeach ?>
				<?php endforeach ?>
				</div>
				<div class="col-md-5 d-flex justify-content-between flex-column">
					<div>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['STRENGTHBONUS']?>"/>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['TOUGHNESSBONUS']?>"/>
					</div>
					<div>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['FATEPOINTS']?>"/>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['INSANITYPOINTS']?>"/>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 cPanel cRight">
			<div class="row">
				<div class="col-md-12 title">Informacje o postaci</div>
				<div class="col-md-12 name"><?=$BG['NAME']?></div>
				<?php if($BG['NAME']!==$BG['USEDNAME']):?>
				<div class="col-md-12 usedname"><i><b>Twoja falszywa tożsamość:</b></i> <span><?=$BG['USEDNAME']?></span></div>
				<?php endif; $BG_h=explode('|',$BG['HISTORY']);?>
			</div>
			<div class="row">
				<div class="col-md-6 opis">Aktualna profesja:</div>
				<div class="col-md-6 opis">Poprzednie profesje:</span></div>
				<div class="col-md-6"><span><?=$curCareer['NAME']?></span></div>
				<div class="col-md-6"><span><?=$prevCareer['NAME']?></span></div>

				<div class="col-md-3 opis">Rasa:</div>
				<div class="col-md-3 opis">Płeć:</div>
				<div class="col-md-6 opis">&nbsp </div>
				<div class="col-md-3"><span><?=$BG['BREED']?></span></div>
				<div class="col-md-3"><span><?=$BG['SEX']?></span></div>
				<div class="col-md-6"><span>&nbsp </span></div>

				<div class="col-md-3 opis">Oczy:</div>
				<div class="col-md-3 opis">Włosy:</div>
				<div class="col-md-6 opis">Miejsce urodzenia:</div>
				<div class="col-md-3"><span><?=$BG['EYESCOLOUR']?></span></div>
				<div class="col-md-3"><span><?=$BG['HAIRCOLOUR']?></span></div>
				<div class="col-md-6"><span><?=$BG['BIRTHPLACE']?></span></div>

				<div class="col-md-2 opis">Wiek:</div>
				<div class="col-md-2 opis">Wzrost:</div>
				<div class="col-md-2 opis">Waga:</div>
				<div class="col-md-6 opis">Rodzina (rodzeństwo):</div>
				<div class="col-md-2"><span><?=$BG['AGE']?> l.</span></div>
				<div class="col-md-2"><span><?=$BG['HEIGHT']?> cm</span></div>
				<div class="col-md-2"><span><?=$BG['WEIGHT']?> kg</span></div>
				<div class="col-md-6"><span><?=$BG['SIBLINGS']?></span></div>

				<div class="col-md-6 opis">Znak gwiezdny:</div>
				<div class="col-md-6 opis">Zaburzenia psychiczne:</div>
				<div class="col-md-6"><span><?=$BG['STARSIGN']?></span></div>
				<div class="col-md-6"><span><?=$BG['DISORDERS']?></span></div>

				<div class="col-md-6 opis">Znaki szczególne:</div>
				<div class="col-md-6 opis">Rany i blizny:</div>
				<div class="col-md-6"><span><?=$BG['SPECIALSIGNS']?></span></div>
				<div class="col-md-6"><span><?=$BG['WOUNDS&SCARS']?></span></div>
			</div>
			<div class="row">
				<div class="history">
					<div class="col-md-12"><b>Historia: </b><?=$BG_h[0]?></div>
					<div class="col-md-12"><b>Uzupełnienie: </b><?=$BG_h[1]?></div>
					<div class="col-md-12"><b>Twój Sekret: </b><?=$BG_h[2]?></div>
					<?php if(isset($BG_h[3])):?>
					<div class="col-md-12"><br><?=$BG_h[3]?></div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
      </div>
    </div>
  </div>
</div>
<div class="row align-items-center h-100 justify-content-md-center" style="display:none;">
  <div class="col-md-10" id="characterStats">
	<div class="row">
		<div class="col-md-12 titleBar"><?=$BG['USEDNAME']?></div>
	</div>
	<div class="row">
		<div class="col-md-4 cPanel cLeft">
			<div class="row">
				<div class="col-md-2 iSide"></div>
				<div class="col-md-8 iCenter BG<?=$BG['ID']?>"></div>
				<div class="col-md-2 iSide"></div>
			</div>
			<div class="row">
				<div class="col-md-10 offset-md-1 iMBottom"></div>
			</div>
			<div class="row">
				<div class="col-md-10 offset-md-1 iBottom"></div>
			</div>
		</div>
		<div class="col-md-4 cPanel cCenter">
			<div class="row">
				<div class="col-md-12 title">Cechy Bohatera</div>
				<div class="col-md-6 cechy cechyGlowne">
				<?php foreach($Glowne[2] as $k => $val): $k1=$k.'_IN'; $k2=$k.'_ADV';?>
					<div>
						<input type="text" readonly="true" value="<?=$Glowne[0][$k1]?>"/>
						<input type="text" readonly="true" value="<?=$Glowne[1][$k2]?>""/>
						<input type="text" readonly="true" value="<?=$Glowne[2][$k]?>""/>
						<input type="button" value="+5"/>
					</div>
				<?php endforeach ?>
				</div>
				<div class="col-md-6 cechy cechyDrugorzedne">
				<?php foreach($Drugo1[2] as $k => $val): $k1=$k.'_IN'; $k2=$k.'_ADV';?>
					<div>
						<input type="text" readonly="true" value="<?=$Drugo1[0][$k1]?>"/>
						<input type="text" readonly="true" value="<?=$Drugo1[1][$k2]?>"/>
						<input type="text" readonly="true" value="<?=$Drugo1[2][$k]?>"/>
						<input type="button" value="+1"/>
					</div>
				<?php endforeach ?>
					<div>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['STRENGTHBONUS']?>"/>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['TOUGHNESSBONUS']?>"/>
					</div>
					<div>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['FATEPOINTS']?>"/>
						<input type="text" readonly="true" value="<?=$Drugo2[1]['INSANITYPOINTS']?>"/>
					</div>
				</div>
				<div class="col-md-12 title">Umiejętności i Zdolności</div>
			</div>
		</div>
		<div class="col-md-4 cPanel cRight">
			<div class="row">
				<div class="col-md-12 title">Informacje o postaci</div>
				<div class="col-md-12 name"><?=$BG['NAME']?></div>
				<?php if($BG['NAME']!==$BG['USEDNAME']):?>
				<div class="col-md-12 usedname"><i><b>Twoja falszywa tożsamość:</b></i> <span><?=$BG['USEDNAME']?></span></div>
				<?php endif; $BG_h=explode('|',$BG['HISTORY']);?>
			</div>
			<div class="row">
				<div class="col-md-6 opis">Aktualna profesja:</div>
				<div class="col-md-6 opis">Poprzednie profesje:</span></div>
				<div class="col-md-6"><span><?=$curCareer['NAME']?></span></div>
				<div class="col-md-6"><span><?=$prevCareer['NAME']?></span></div>

				<div class="col-md-3 opis">Rasa:</div>
				<div class="col-md-3 opis">Płeć:</div>
				<div class="col-md-6 opis">&nbsp </div>
				<div class="col-md-3"><span><?=$BG['BREED']?></span></div>
				<div class="col-md-3"><span><?=$BG['SEX']?></span></div>
				<div class="col-md-6"><span>&nbsp </span></div>

				<div class="col-md-3 opis">Oczy:</div>
				<div class="col-md-3 opis">Włosy:</div>
				<div class="col-md-6 opis">Miejsce urodzenia:</div>
				<div class="col-md-3"><span><?=$BG['EYESCOLOUR']?></span></div>
				<div class="col-md-3"><span><?=$BG['HAIRCOLOUR']?></span></div>
				<div class="col-md-6"><span><?=$BG['BIRTHPLACE']?></span></div>

				<div class="col-md-2 opis">Wiek:</div>
				<div class="col-md-2 opis">Wzrost:</div>
				<div class="col-md-2 opis">Waga:</div>
				<div class="col-md-6 opis">Rodzina (rodzeństwo):</div>
				<div class="col-md-2"><span><?=$BG['AGE']?> l.</span></div>
				<div class="col-md-2"><span><?=$BG['HEIGHT']?> cm</span></div>
				<div class="col-md-2"><span><?=$BG['WEIGHT']?> kg</span></div>
				<div class="col-md-6"><span><?=$BG['SIBLINGS']?></span></div>

				<div class="col-md-6 opis">Znak gwiezdny:</div>
				<div class="col-md-6 opis">Zaburzenia psychiczne:</div>
				<div class="col-md-6"><span><?=$BG['STARSIGN']?></span></div>
				<div class="col-md-6"><span><?=$BG['DISORDERS']?></span></div>

				<div class="col-md-6 opis">Znaki szczególne:</div>
				<div class="col-md-6 opis">Rany i blizny:</div>
				<div class="col-md-6"><span><?=$BG['SPECIALSIGNS']?></span></div>
				<div class="col-md-6"><span><?=$BG['WOUNDS&SCARS']?></span></div>
			</div>
			<div class="row">
				<div class="history">
					<div class="col-md-12"><b>Historia: </b><?=$BG_h[0]?></div>
					<div class="col-md-12"><b>Uzupełnienie: </b><?=$BG_h[1]?></div>
					<div class="col-md-12"><b>Twój Sekret: </b><?=$BG_h[2]?></div>
					<?php if(isset($BG_h[3])):?>
					<div class="col-md-12"><br><?=$BG_h[3]?></div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>
<div id="skillsPanel">
	<div class="row">
		<div class="col-md-12 titleBar">Umiejętności</div>
	</div>
	<div class="row abbRow">
        <div class="col-md-10 abbListLtr">
		<?php foreach($skills as $k => $skill):
		$sec = (preg_match('#różne#',$skill['NAME'])) ? ' secList' : null;
		?>
		<div class="abbList<?=$sec?>" data-toggle="tooltip" data-placement="right" title="<?=htmlspecialchars('<h3><b>'.$skill['NAME'].'</b></h3><h4>'.$skill['DESCRIPTION'].'</h4>')?>"><?=$skill['NAME']?></div>
		<?php endforeach ?>
	    </div>
	</div>
	<div class="row">
		<div class="col-md-12 footerBar">
				<input type="button" value="wróć"/>
				<input type="button" value="wykup"/>
		</div>
	</div>
</div>
<div id="talentsPanel">
	<div class="row">
		<div class="col-md-12 titleBar">Zdolności</div>
	</div>
	<div class="row abbRow">
        <div class="col-md-10 offset-md-2 abbListRtr">
		<?php foreach($talents as $k => $talent):
		$sec = (preg_match('#różne#',$talent['NAME'])) ? ' secList' : null;
		?>
		<div class="abbList<?=$sec?>" data-toggle="tooltip" data-placement="left" title="<?=htmlspecialchars('<h3><b>'.$talent['NAME'].'</b></h3><h4>'.$talent['DESCRIPTION'].'</h4>')?>"><?=$talent['NAME']?></div>
		<?php endforeach ?>
	    </div>
	</div>
	<div class="row">
		<div class="col-md-12 footerBar">
				<input type="button" value="wróć"/>
				<input type="button" value="wykup"/>
		</div>
	</div>
</div>
<div id="characterPanel">
	<div class="row avatar">
		<div class="col-md-12 d-flex align-items-center justify-content-md-center"><img src="<?= base_url('../warhammer/assets/img/Richard Krupse.png') ?>"/></div>
	</div>
	<div class="row background d-flex align-items-start justify-content-between">
		<div class="col-md-3"><button type="button" class="btn btn-primary awans" data-toggle="modal" data-target="#exampleModalCenter">Panel BG</button></div>
		<div class="col-md-6 titleBar">Richard Krupse</div>
		<div class="col-md-3" align="right"><button class="btn btn-secondary awans" data-toggle="modal" data-target="#ModalCenter">Awansuj</button></div>
		<div class="row">
			<div class="col-md-12 textBar">1 złota korona = 20 srebrnych szylingów = 240 miedzianych pensów<br>1 srebrny szyling = 12 miedzianych pensów</div>
		</div>
	</div>
</div>