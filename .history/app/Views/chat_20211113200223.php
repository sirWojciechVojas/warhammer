<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?= $session->getFlashdata('done'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3 d-flex justify-content-center align-self-center">
            <div id="draggable-chat" class="card card-height">
                <?php foreach ($status as $s) : if($s->status == FALSE) $a++; if($a>1) continue; ?>
                <div class="card-header d-flex justify-content-between">
                    <strong><?= $session->get('role'); ?> (<?= $session->get('user') ?>)</strong>
                    <a href="<?= base_url('public/login/logout') ?>"
                        class="btn btn-danger btn-sm pull-right order-3 d-flex align-items-center">WYLOGUJ</a>
                    <?php if ($session->get('akses') == 'ADMIN') : ?>
                    <a href="<?= base_url('public/chat/pending') ?>"
                        class="btn btn-primary btn-sm order-1 d-flex align-items-center glyph-icon"
                        title="Zarządzanie użytkownikami">
                        <svg xmlns="http://www.w3.org/2000/svg" class="si-glyph-person">
                            <use xlink:href="<?= base_url('assets/bs') ?>/sprite.svg#si-glyph-person" />
                        </svg>
                    </a>
                        <?php if ($s->status == TRUE) : ?>
                    <a href="<?= base_url('public/chat/maintenance') ?>"
                        class="btn btn-warning btn-sm order-2 d-flex align-items-center glyph-icon" title="Wyłącz Chat">
                        <svg xmlns="http://www.w3.org/2000/svg" class="si-glyph-lock">
                            <use xlink:href="<?= base_url('assets/bs') ?>/sprite.svg#si-glyph-lock" />
                        </svg>
                    </a>
                        <?php else : ?>
                    <a href="<?= base_url('public/chat/open') ?>"
                        class="btn btn-success btn-sm order-2 d-flex align-items-center glyph-icon" title="Włącz Chat">
                        <svg xmlns="http://www.w3.org/2000/svg" class="si-glyph-lock-unlock">
                            <use
                                xlink:href="<?= base_url('assets/bs') ?>/sprite.svg#si-glyph-lock-unlock" />
                        </svg>
                    </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endforeach ?>
                <?php if ($s->status == TRUE) : ?>
                <div class="card-body chatbox-bg">
                    <div class="col-md-12 chatbox">
                        <?php if ($ajax == true) ob_clean();
							foreach ($chat as $c) { ?>
                        <?php if ($c->role == $session->get('role')) { ?>
                        <div class="row">
                            <div class="col-md-1 justify-content-center align-self-center">
                                <img data-toggle="tooltip" data-placement="left" data-original-title="<?= $session->get('role') ?><br>(<?= $session->get('user') ?>)" class="profile-img-mini"
                                src="<?= base_url('assets/img/' . $session->get('role') . '.png') ?>" alt="Avatar">
                            </div>
                            <div class="col-md-11">
                                <div class="card card-comment">
                                    <div class="card-header">
                                        <div class="col-md-12"><strong style="font-size: 12px; color: #179907">Ja:&nbsp;</strong><small><?=date("d.m.Y H:i:s", strtotime($c->waktu)); ?></small></div>
                                        <div class="card-chatText"><?= $c->teks ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="row">
                            <div class="col-md-1 justify-content-center align-self-center">
                                <img data-toggle="tooltip" data-placement="left" data-original-title="<?= $c->role ?><br>(<?= $c->user ?>)" class="profile-img-mini"
                                src="<?= base_url('assets/img/' . $c->role . '.png') ?>" alt="Avatar">
                            </div>
                            <div class="col-md-11">
                                <div class="card card-comment">
                                    <div class="card-header">
                                        <div class="col-md-12"><strong style="font-size: 12px; color: #076099"><?= $c->user ?>:&nbsp;</strong><small><?php echo date("d.m.Y H:i:s", strtotime($c->waktu)); ?></small></div>
                                        <div class="card-chatText"><?= $c->teks ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <?php endif ?>
                <?php if ($ajax == true) exit();
				if ($s->status == FALSE) : ?>
                <div class="card-body">
                    <h4 class="text-center" style="color: #FF0000">Przepraszamy<br>Aktualnie serwer jest
                        offline!<br><br>Poczekaj na postawienie serwera przez Game Mastera.</h4>
                </div>
                <?php endif ?>
                <?php if ($s->status == TRUE) : ?>
                <div class="card-footer">
                    <form name="sendMessage" method="post" action="" autocomplete="off">
                        <div id="sendInput" class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Tu wprowadź tekst">
                            <div class="input-group-btn"><input class="btn btn-success btn-sm" type="submit" value="Wyślij"></div>
                        </div>
                    </form>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<div id="diceBox" class="btn-group btn-group-vertical d-flex justify-content-between">
    <?php foreach ($dices as $num) : ?>
    <div class="d-flex justify-content-between">
        <?php
            $Knum = ($num=='3D') ? $num : 'K'.$num;
            $btnClass = ($num=='3D') ? ' btn-danger' : ' btn-primary';
        ?>
        <button type="button" class="btn<?=$btnClass?>"
            value="<?= $num ?>"><?= $Knum ?></button>
    </div>
    <?php endforeach ?>
    <input id="bountify" type="hidden"
        value="<?= base_url('assets/bs/js') ?>/bountify.inc.js">
</div>

<div class="modal fade modal-wide" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog cP modal-dialog-centered mw-100" role="document">
        <div class="modal-content" id="characterPromotion">
            <div class="modal-header mh-5">
                <div id="exampleModalLongTitle" class="modal-title col-md-12 titleBar">Awans postaci BG
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="padding:3px 15px;margin-top:5px;background:#f00;color:#fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body cP" style="padding:0 15px;">
                <div class="row h-25 d-flex">
                    <div class="col-md-5" style="border:1px solid #fff">
                        <div class="col-md-12 opis">Poprzednie profesje:</span></div>
                        <div class="col-md-6"><span><?= $prevCareer['NAME'] ?></span></div>
                        <div class="col-md-12 opis">Aktualna profesja:</div>
                        <div class="col-md-6"><span><?= $curCareer['NAME'] ?></span></div>
                        <div class="col-md-12 awansListLtr list-group" id="list-tab" role="tablist">
                            <?php foreach (explode(',', $curCareer['OUTPUTPROFESSION']) as $k => $oProf) :
								//$sec = (preg_match('#różne#',$talent['NAME'])) ? ' secList' : null;
							?>
                            <a class="awansList ist-group-item list-group-item-action" id="list-<?= $oProf ?>-list"
                                data-toggle="list" href="#list-<?= $oProf ?>" role="tab"
                                aria-controls="<?= $oProf ?>"><?= $oProf ?></a>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-md-7 tab-content" id="nav-tabContent" style="border:1px solid #fff">
                        <?php foreach (explode(',', $curCareer['OUTPUTPROFESSION']) as $k => $oProf) :
							//$sec = (preg_match('#różne#',$talent['NAME'])) ? ' secList' : null;
						?>
                        <div class="tab-pane fade" id="list-<?= $oProf ?>" role="tabpanel"
                            aria-labelledby="list-<?= $oProf ?>-list">Twoja nowa profesja: <?= $oProf ?></div>
                        <?php endforeach ?>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm">Awansuj</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Anuluj</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-wide" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog cS modal-dialog-centered mw-100" role="document">
        <div class="modal-content" id="characterStats">
            <div class="modal-header mh-5">
                <div id="exampleModalLongTitle" class="modal-title col-md-12 titleBar"><?= $BG['USEDNAME'] ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body cS" style="padding:0 15px;">
                <div class="row h-100 d-flex">
                    <div class="col-md-4 cPanel cLeft">
                        <div class="row h-100">
                            <div class="col-md-3 iSide d-flex">
                                <div class="inventory-table mx-auto" id="A-inventory"></div>
                            </div>
                            <div class="col-md-6 icCenter">
                                <div class="col-md-12 iCenter BG<?= $BG['ID'] ?> d-flex align-content-start flex-column">
                                    <input type="text" readonly="true" value="<?= $RestInfo[1]['HEAD'] ?>" />
                                    <input type="text" readonly="true" value="<?= $RestInfo[1]['RIGHTHAND'] ?>" />
                                    <input type="text" readonly="true" value="<?= $RestInfo[1]['LEFTHAND'] ?>" />
                                    <input type="text" readonly="true" value="<?= $RestInfo[1]['BODY'] ?>" />
                                    <input type="text" readonly="true" value="<?= $RestInfo[1]['LEFTLEG'] ?>" />
                                    <input type="text" readonly="true" value="<?= $RestInfo[1]['RIGHTLEG'] ?>" />
                                </div>
                                <div class="col-md-12 icBottom">
                                <div class="inventory-table" id="handy-inventory"></div>
                                </div>
                            </div>
                            <div class="col-md-3 iSide d-flex">
                                <div class="inventory-table mx-auto" id="B-inventory"></div>
                            </div>
                            <div class="col-md-10 offset-md-1 imBottom">
                                <div class="col-md-12 d-flex justify-content-around" style="padding:0;">Stan Twojej sakiewki:</div>
                                <?=$mGoldPanel?>
                                <div class="col-md-12 d-flex justify-content-around align-items-top">
                                    <div><input type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-symbol="+" value="Pozyskaj"></div>
                                    <div><input type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-symbol="-" value="Wydaj"></div>
                                </div>
                            </div>
                            <div class="iBottom mx-auto d-flex justify-content-around align-items-center">
                                <div class="inventory-table" id="personal-inventory"></div>
                                <div class="inventory-table" id="ground-inventory"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 cPanel cCenter">
                        <div class="row h-100 d-flex align-content-start flex-wrap">
                            <div class="col-md-12 title">Cechy Bohatera</div>
                            <div class="col-md-5 offset-md-1 cechy cechyGlowne d-flex justify-content-between flex-column"
                                data-button="Wykup">
                                <?php foreach ($Glowne[2] as $k => $val) : $k1 = $k . '_IN';
									$k2 = $k . '_ADV';
									$R = ($Glowne[2][$k] - $Glowne[0][$k1]) / 5; ?>
                                <?php if ($Glowne[2][$k] < $Glowne[0][$k1] + $Glowne[1][$k2]) : $klasa = null;
									else : $klasa = ' disabled';
									endif ?>
                                <div class="d-flex justify-content-between">
                                    <input type="text" readonly="true" value="<?= $Glowne[0][$k1] ?>" />
                                    <input type="text" readonly="true" value="<?= $Glowne[1][$k2] ?>" />
                                    <input type="text" readonly="true" class="R-<?= $R ?>" />
                                    <input type="text" readonly="true" value="<?= $Glowne[2][$k] ?>" />
                                    <input type="button" data-key="<?= $k ?>" data-toggle="modal"
                                        class="btn btn-danger<?= $klasa ?>" value="+5" />
                                </div>
                                <?php endforeach ?>
                            </div>
                            <div class="col-md-5 flex-column" style="padding:0;">
                                <div
                                    class="col-md-12 cechy cechyDrugorzedne-1 d-flex justify-content-between flex-column">
                                    <?php foreach ($Drugo1[2] as $k => $val) : $k1 = $k . '_IN';
										$k2 = $k . '_ADV';
										$R = ($Drugo1[2][$k] - $Drugo1[0][$k1]); ?>
                                    <?php if ($Drugo1[2][$k] < $Drugo1[0][$k1] + $Drugo1[1][$k2]) : $klasa = null;
										else : $klasa = ' disabled';
										endif ?>
                                    <div class="d-flex justify-content-between">
                                        <input type="text" readonly="true" value="<?= $Drugo1[0][$k1] ?>" />
                                        <?php if ($Drugo1[1][$k2] == 0) $Drugo1[1][$k2] = '-';?>
                                        <input type="text" readonly="true" value="<?= $Drugo1[1][$k2] ?>" />
                                        <input type="text" readonly="true" class="R-<?= $R ?>" />
                                        <input type="text" readonly="true" value="<?= $Drugo1[2][$k] ?>" />
                                        <input type="button" data-key="<?= $k ?>" data-toggle="modal"
                                            class="btn btn-danger<?= $klasa ?>" value="+1" />
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div
                                    class="col-md-12 cechy cechyDrugorzedne-2 d-flex justify-content-between flex-column">
                                    <div>
                                        <input type="text" readonly="true" value="<?= $Drugo2[1]['STRENGTHBONUS'] ?>" />
                                        <input type="text" readonly="true" value="<?= $Drugo2[1]['TOUGHNESSBONUS'] ?>" />
                                    </div>
                                    <div>
                                        <input type="text" readonly="true" value="<?= $Drugo2[1]['FATEPOINTS'] ?>" />
                                        <input type="text" readonly="true" value="<?= $Drugo2[1]['INSANITYPOINTS'] ?>" />
                                        <input type="button" data-key="FATEINS" data-toggle="modal" class="btn btn-danger" value="&" />
                                    </div>
                                    <div>
                                        <input type="text" readonly="true" value="<?= $Drugo2[1]['LUCKPOINTS'] ?>" />
                                        <input type="text" readonly="true" value="<?= $Drugo2[1]['MOTIVATEPOINTS'] ?>" />
                                        <input type="button" data-key="LUCKMOTIVE" data-toggle="modal" class="btn btn-danger" value="&" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-end" style="padding:0"><input type="button" class="buttonSkills align-self-center" /></div>
                            <div class="col-md-8 title">Umiejętności i Zdolności</div>
                            <div class="col-md-2 d-flex justify-content-start" style="padding:0"><input type="button" class="buttonTalents align-self-center" /></div>
                            <div class="col-md-5 offset-md-1 skills-talents d-flex flex-column">
                                <?php foreach ($allMySkills as $k => $val) : ?>
                                <?php if ((int) $val['STATUS'] !== 0) : ?>
                                <div class="skill-talent" data-toggle="tooltip" data-placement="left" data-original-title="<?= htmlspecialchars('<h3><b>' . $val['NAME'] . '</b></h3><h4>' . $val['DESCRIPTION'] . '</h4>') ?>">
                                    <input type="text" readonly="true" class="L-<?= $val['STATUS'] ?>" /><?= $val['NAME'] ?>
                                </div>
                                <?php endif ?>
                                <?php endforeach ?>
                            </div>
                            <div class="col-md-5 skills-talents d-flex flex-column">
                                <?php foreach ($allMyTalents as $k => $val) : ?>
                                <?php if ((int) $val['STATUS'] !== 0) : ?>
                                <div class="skill-talent" data-toggle="tooltip" data-placement="right" data-original-title="<?= htmlspecialchars('<h3><b>' . $val['NAME'] . '</b></h3><h4>' . $val['DESCRIPTION'] . '</h4>') ?>">
                                    <input type="text" readonly="true" class="R-<?= $val['STATUS'] ?>" /><?= $val['NAME'] ?>
                                </div>
                                <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 cPanel cRight">
                        <div class="row<?=($BG['NAME'] !== $BG['USEDNAME']) ? ' usedName': null; ?>">
                            <div class="col-md-12 title">Informacje o postaci</div>
                            <div class="col-md-12 name"><?= $BG['NAME'] ?></div>
                            <?php if ($BG['NAME'] !== $BG['USEDNAME'] && $BG['NAME']!=='Tugor Barriksson') : ?>
                            <div class="col-md-12 usedname"><i><b>Twoja fałszywa tożsamość:</b></i>
                                <span><?= $BG['USEDNAME'] ?></span>
                            </div>
                            <?php elseif ($BG['NAME'] !== $BG['USEDNAME'] && $BG['NAME']=='Tugor Barriksson') : ?>
                            <div class="col-md-12 usedname"><i><b>Twoje wcielenie:</b></i>
                                <span><?= $BG['USEDNAME'] ?></span>
                            </div>
                            <?php endif;
							$BG_h = explode('|', $BG['HISTORY']); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6 opis">Aktualna profesja:</div>
                            <div class="col-md-6 opis">Poprzednie profesje:</span></div>
                            <div class="col-md-6"><span><?= $curCareer['NAME'] ?></span></div>
                            <div class="col-md-6"><span><?= @$prevCareer['NAME'] ?></span></div>

                            <div class="col-md-3 opis">Rasa:</div>
                            <div class="col-md-3 opis">Płeć:</div>
                            <div class="col-md-6 opis">Czczone Bóstwo: </div>
                            <div class="col-md-3"><span><?= $BG['BREED'] ?></span></div>
                            <div class="col-md-3"><span><?= $BG['SEX'] ?></span></div>
                            <div class="col-md-6"><span><?= $BG['WORSHIPGOD'] ?></span></div>

                            <div class="col-md-3 opis">Oczy:</div>
                            <div class="col-md-3 opis">Włosy:</div>
                            <div class="col-md-6 opis">Miejsce urodzenia:</div>
                            <div class="col-md-3"><span><?= $BG['EYESCOLOUR'] ?></span></div>
                            <div class="col-md-3"><span><?= $BG['HAIRCOLOUR'] ?></span></div>
                            <div class="col-md-6"><span><?= $BG['BIRTHPLACE'] ?></span></div>

                            <div class="col-md-2 opis">Wiek:</div>
                            <div class="col-md-2 opis">Wzrost:</div>
                            <div class="col-md-2 opis">Waga:</div>
                            <div class="col-md-6 opis">Rodzina (rodzeństwo):</div>
                            <div class="col-md-2"><span><?= $BG['AGE'] ?> l.</span></div>
                            <div class="col-md-2"><span><?= $BG['HEIGHT'] ?> cm</span></div>
                            <div class="col-md-2"><span><?= $BG['WEIGHT'] ?> kg</span></div>
                            <div class="col-md-6"><span><?= $BG['SIBLINGS'] ?></span></div>

                            <div class="col-md-6 opis">Znak gwiezdny:</div>
                            <div class="col-md-6 opis">Zaburzenia psychiczne:</div>
                            <div class="col-md-6"><span><?= $BG['STARSIGN'] ?></span></div>
                            <div class="col-md-6"><span><?= $BG['DISORDERS'] ?></span></div>

                            <div class="col-md-6 opis">Znaki szczególne:</div>
                            <div class="col-md-6 opis">Rany i blizny:</div>
                            <div class="col-md-6"><span><?= $BG['SPECIALSIGNS'] ?></span></div>
                            <div class="col-md-6"><span><?= $BG['WOUNDS&SCARS'] ?></span></div>
                        </div>
                        <div class="row<?=($BG['NAME'] !== $BG['USEDNAME']) ? ' usedName': null; ?>">
                            <div class="history">
                                <div class="col-md-12"><b>Historia: </b><?= $BG_h[0] ?></div>
                                <div class="col-md-12"><b>Uzupełnienie: </b><?= $BG_h[1] ?></div>
                                <div class="col-md-12"><b>Twój Sekret: </b><?= $BG_h[2] ?></div>
                                <?php if (isset($BG_h[3])) : ?>
                                <div class="col-md-12"><br><?= $BG_h[3] ?></div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="diary">
                                <div class="col-md-12 d-flex justify-content-between diaryTitle">Twoje Notatki<input type="button" class="btn btn-secondary btn-sm" value="Zapisz"/></div>
                                <div class="col-md-12">
                                    <textarea spellcheck="false"><?=$diary->NOTES ?></textarea>
                                </div>
                            </div>
                        </div>
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
    <div class="row abbRow" data-button="Wykup">
        <div class="col-md-10 abbListLtr">
            <?php foreach ($allMySkills as $k => $skill) :
				$sec = (preg_match('#dowolność#', $skill['NAME'])) ? ' secList' : null;
				$sec .= ($skill['STATUS'] == $skill['LEVEL']) ? ' triList disabled' : null;
			?>
            <div class="abbList<?= $sec ?>" data-toggle="tooltip" data-placement="right"
                data-details="<?= $skill['DETAILS'] ?>" data-id="<?= $skill['ID'] ?>"
                data-original-title="<?= htmlspecialchars('<h3><b>' . $skill['NAME'] . '</b></h3><h4>' . $skill['DESCRIPTION'] . '</h4>') ?>">
                <?= $skill['NAME'] ?></div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 footerBar">
            <input type="button" />
            <!-- <input type="button" value="wykup"/> -->
        </div>
    </div>
</div>
<div id="talentsPanel">
    <div class="row">
        <div class="col-md-12 titleBar">Zdolności</div>
    </div>
    <div class="row abbRow" data-button="Wykup">
        <div class="col-md-10 offset-md-2 abbListRtr">
            <?php foreach ($allMyTalents as $k => $talent) :
				$sec = (preg_match('#dowolność#', $talent['NAME'])) ? ' secList' : null;
				$sec .= ($talent['STATUS'] == '1') ? ' triList disabled' : null;
			?>
            <div class="abbList<?= $sec ?>" data-toggle="tooltip" data-placement="left"
                data-details="<?= $talent['DETAILS'] ?>" data-id="<?= $talent['ID'] ?>"
                data-original-title="<?= htmlspecialchars('<h3><b>' . $talent['NAME'] . '</b></h3><h4>' . $talent['DESCRIPTION'] . '</h4>') ?>">
                <?= $talent['NAME'] ?></div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 footerBar">
            <input type="button" />
            <!-- <input type="button" value="wykup"/> -->
        </div>
    </div>
</div>
<div id="characterPanel">
    <div class="row avatar">
        <div class="col-md-12 d-flex align-items-center justify-content-md-center"><img src="<?= base_url('assets/img/' . $session->get('USEDNAME') . '.png') ?>"/></div>
    </div>
    <div class="row background d-flex align-items-start justify-content-between">
        <div class="row col-md-6 offset-md-3 titleBar">
            <div class="col-md-12 HPBarPlace">
                <div class="col-md-12 HPBar" style="width:<?= $HP->HPpercent ?>%;"></div>
            </div>
            <div style="width:6.75%;" data-toggle="modal" data-target="#HPModalCenter" data-symbol="0">-</div>
            <div style="width:86%;" class="tPlace myPointer" data-toggle="tooltip" data-placement="top" data-original-title="<?= htmlspecialchars('<h5><b>Punkty Żywotności</b></h5><h6>' . $HP->HP . '/' . $HP->WOUNDS . '</h6>') ?>">
                <?= $session->get('USEDNAME') ?></div>
            <div style="width:6.75%;" data-toggle="modal" data-target="#HPModalCenter" data-symbol="1">+</div>
        </div>
        <div class="row col-md-12 textSpace">
            <div class="iBottom mx-auto d-flex justify-content-center align-items-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn" title="Główna" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"><i class="bi-house-door-fill"></i></button>
                    <button type="button" class="btn" title="Panel BG" data-toggle="modal" data-target="#exampleModalCenter"><i class="bi-person-square"></i></button>
                    <button type="button" class="btn disabled" title="Mapa"><i class="bi-map-fill"></i></button>
                    <button type="button" class="btn disabled" title="Historia BG"><i class="bi-journals"></i></button>
                    <button type="button" class="btn disabled" title="Ekwipunek"><i class="bi-person-square"></i></button>
                    <button type="button" class="btn disabled" title="Cechy BG"><i class="bi-person"></i></button>
                    <button type="button" class="btn disabled" title="Notatki"><i class="bi-journal"></i></button>
                    <button type="button" class="btn" title="Sklep" data-toggle="modal" data-target="#trading"><i class="bi-shop"></i></button>
                    <button type="button" class="btn disabled" title="Rzuty"><i class="bi-dice-6"></i></button>
                    <button type="button" class="btn disabled" title="Czary"><i class="bi-person-square"></i></button>
                    <button type="button" class="btn" title="Awansuj" data-toggle="modal" data-target="#ModalCenter"><i class="bi-person-fill"></i></button>
                    <button type="button" class="btn disabled" title="Ustawienia"><i class="bi-gear"></i></button>
                </div>
            </div>
            <!-- <div class="col-md-12 offset-md-1 textBar">Pasek Punktów Doświadczenia</div> -->
        </div>
        <div class="col-md-1 titleSpace footerSpace" align="left"><button class="btn btn-success btn-sm disabled" data-toggle="modal" data-symbol="0" data-target="#PDModalCenter">-</button></div>
        <div class="col-md-10 footerSpace" style="padding:0;margin:0;">
            <div class="col-md-12 PDBar d-flex" data-toggle="tooltip" data-placement="top"
                title="<?= htmlspecialchars('<h6><b>Punkty Doświadczenia</b></h6><h6><u>Pasek kompleksowy</u></h6><h6>' . $PD[1] . '/' . $PD[3] . ' PD<br>(niewykorzytane: ' . $PD[5] . ' PD)</h6>') ?>">
                <div class="PD-1 myPointer" style="width:<?= $PD[6] ?>%;"></div>
                <div class="PD-5 myPointer" style="width:<?= $PD[9] ?>%;"></div>
                <input type="hidden" id="curexp" value="<?= $PD[5] ?>" />
                <input type="hidden" id="minexp" value="<?= $PD[2] ?>" />
                <input type="hidden" id="nowexp" value="<?= $PD[4] ?>" />
            </div>
            <div class="col-md-12 PDBar d-flex" data-toggle="tooltip" data-placement="top" data-original-title="<?= htmlspecialchars('<h6><b>Punkty Doświadczenia</b></h6><h6><u>Pasek minimalny</u></h6><h6>' . $PD[4] . '/' . $PD[2] . ' PD<br>(niewykorzytane: ' . $PD[5] . ' PD)</h6>'); ?>">
                <div class="PD-4 myPointer" style="width:<?= $PD[8] ?>%;"></div>
                <div class="PD-5 myPointer" style="width:<?= $PD[9] ?>%;"></div>
            </div>
        </div>
        <div class="col-md-1 titleSpace footerSpace" align="right"><button class="btn btn-success btn-sm" data-toggle="modal" data-symbol="1" data-target="#PDModalCenter">+</button></div>
    </div>
</div>
<?php if ($session->get('akses') == 'ADMIN') : ?>
<div id="characterChanger" style="left:-100%;">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary glyph-icon flipX">
                <svg xmlns="http://www.w3.org/2000/svg" class="si-glyph-two-arrow-left">
                    <use xlink:href="<?= base_url('assets/bs') ?>/sprite.svg#si-glyph-two-arrow-left" />
                </svg>
            </button>
            <h4 class="text-center">Wybierz Bohatera</h4>
        </div>
        <div class="col-md-12">
            <ul class="d-flex justify-content-around">
                <?php foreach ($BGs as $id) :
						$activ = ($session->get('ID') == $id->ID) ? ' activ' : null; ?>
                <li class="myPointer<?= $activ ?>" data-id="<?= $id->ID; ?>" data-usedname="<?= $id->USEDNAME; ?>">
                    <img data-toggle="tooltip" data-placement="bottom" data-original-title="<?=htmlspecialchars('ID: <span>'.$id->ID.'</span><br>'.$id->USEDNAME.'<br>('.$id->GAMER_NAME.')');?>" class="profile-img-mid" src="<?= base_url("assets/img/$id->USEDNAME.png") ?>" alt="Avatar">
                </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
<?php endif ?>
<div id="users">
    <div class="list-group-item"><b>Aktywność:</b></div>
    <ul id="user-list" class="list-group"></ul>
</div>

<div id="dicer" class="card" style="display: none;">
    <div class="card-header d-flex justify-content-between ui-draggable-handle">
        Symulator 3D rzutu kością
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
            style="padding:3px 15px;margin-top:5px;background:#f00;color:#fff;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="card-body">
        <object name="dicerObject" data="<?=base_url();?>/public/roller" style="width:1000px; height:600px"></object>
    </div>
    <!-- <div class="card-footer">Adjusting by sWV</div> -->
</div>
<div class="modal fade modal-wide" id="trading" tabindex="-1" role="dialog" aria-labelledby="tradingModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog tS modal-dialog-centered mw-100" role="document">
        <div class="modal-content" id="tradingStats">
            <div class="modal-header mh-5">
                <div id="tradingModalLongTitle" class="modal-title col-md-12 titleBar">
                    <button type="button" class="btn btn-default btn-lg GM" title="Zaloguj się jako Game Master"></button>
                    Kupno & Sprzedaż
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body" style="padding-top:0;">
                <div class="row d-flex">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="h2 text-light lh-5">Pod Kuflem Piwa</div>
                    </div>
                    <div class="col-md-2 d-flex flex-column flank align-items-center justify-content-around">
                        <button class="btn btn-secondary card square justify-content-center">Szblony-dodaj/edytuj</button>
                        <button class="outline card square bg-light text-dark justify-content-center">Stos - spersonalizuj</button>
                        <button class="outline card square bg-light text-dark justify-content-center">Sklep-ustal asortyment</button>
                    </div>
                    <div class="col-md-4 d-flex flex-column align-items-end">
                        <div class="input-group input-group-md mb-2">
                            <input type="text" class="form-control bg-transparent text-light ih-95" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="Sklep" disabled>
                        </div>
                        <div id="tradingBuy" class="row d-flex outline w-100 h-75 text-light bg-transparent pm-0 mb-2 align-items-center justify-content-center"></div>
                        <div class="input-group input-group-md">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent text-light ih-100" id="inputGroup-sizing-lg">Koszt:</span>
                            </div>
                            <div class="tradingBrassLine form-control bg-transparent ih-100 text-light p-0 d-flex align-items-center justify-content-end">
                                <div class="crown"></div>
                                <div><input type="text" readonly="true" value="999 zk"></div>
                                <div class="shilling"></div>
                                <div><input type="text" readonly="true" value="<?= $mGold->mShilling ?> s"></div>
                                <div class="brass"></div>
                                <div><input type="text" readonly="true" value="<?= $mGold->mPenny ?> p"></div>
                                <input type="hidden" id="hBrass" value="<?= $mGold->hBrass ?>" />
                            </div>
                        </div>
                        <button id="tBuyBtn" class="btn btn-secondary w-50 align-self-center mt-auto">Kup</button>
                    </div>
                    <div class="col-md-4 d-flex flex-column align-items-start">
                        <div class="input-group input-group-md mb-2">
                            <input type="text" class="form-control bg-transparent text-light ih-95" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="Ekwipunek BG" readonly="readonly" disabled>
                        </div>
                        <div id="tradingSell" class="row d-flex tab-content outline w-100 h-75 text-light bg-transparent pm-0 mb-2 align-items-center justify-content-center"></div>
                        <div class="input-group input-group-md">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent text-light ih-100" id="inputGroup-sizing-lg">Cena:</span>
                            </div>
                            <div class="tradingBrassLine form-control bg-transparent ih-100 text-light p-0 d-flex align-items-center justify-content-end">
                                <div class="crown"></div>
                                <div><input type="text" readonly="true" value="0 zk"></div>
                                <div class="shilling"></div>
                                <div><input type="text" readonly="true" value="0 s"></div>
                                <div class="brass"></div>
                                <div><input type="text" readonly="true" value="0 p"></div>
                                <input type="hidden" id="hBrass" value="0" />
                            </div>
                        </div>
                        <button id="tSellBtn" class="btn btn-secondary w-50 align-self-center mt-auto">Sprzedaj</button>
                    </div>
                    <div class="col-md-2 d-flex flex-column flank align-items-center justify-content-evenly">
                        <div class="outline card square bg-light text-dark">nice1</div>
                        <div class="outline card square bg-light text-dark">nice2</div>
                        <div class="outline card square bg-light text-dark">nice3</div>
                        <div class="outline card square bg-light text-dark">nice4</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center pm-0">
                <div class="row d-flex w-100 pm-0">
                    <div class="col-md-12 d-flex justify-content-space-around pm-0">
                        <div class="col-md-3 text-light">GM</div>
                        <div class="col-md-3 text-light">Wycena Kupca</div>
                        <div class="col-md-3 text-light">Koszt</div>
                        <div class="col-md-3 text-light">Targowanie</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-5 justify-content-center" id="dropdownMacos">
  <ul class="dropdown-menu dropdown-menu-macos mx-0 shadow" style="width: 220px;">
    <li><a class="dropdown-item active" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li><a class="dropdown-item" href="#">Something else here</a></li>
    <li><a class="dropdown-item" href="#">Separated link</a></li>
  </ul>
</div>