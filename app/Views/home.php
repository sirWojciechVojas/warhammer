	<input type="hidden" id="parent_notation" value="">
	<input type="hidden" id="parent_roll" value="0">
	<button id="turnOnRoom" title="Roll for Myself" style="display: none;">Roll for Myself</button>

	<div id="waitform"></div>

	<div id="loginform" style="display: none;">
		<div style="display: table-cell; vertical-align: middle">
			<div style="margin-left: auto; margin-right: auto; width: 100%">
				<div class="loginform">
					<fieldset>
						<h1>Major's 3D Dice Roller</h1>
					</fieldset>

					<fieldset>
						<legend>Offline Dice</legend>
						<div class="lform">
							<button id="button_single" title="Roll for Myself">Roll for Myself</button>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>

	<div id="desk" class="noselect">
		<div id="selector_div" style="display: none">
			<div class="center_field">
				<div>
					<button id="clear" title="Reset Dice">❌</button>
					<button id="save" title="Save Favorite">❤️</button>
					<input type="text" id="set" name="set" value="1d100+1d10"></input>
					<button id="rage" title="Add Rage">💢</button>
					<button id="throw" title="Throw Dice">🎲</button>
				</div>
				<div id="sethelp">
					Click to Add, Drag to Throw
				</div>
				<div id="labelhelp">
					Click to continue, Drag to throw again
				</div>
			</div>
		</div>
		<div id="canvas"></div>
		<div id="info_div" style="display: none">
			<div class="center_field">
				<div id="label"></div>
			</div>
		</div>
		<div class="info-field">
			<div class="center_field">
				<span id="label_players" style="display: none"></span>
			</div>
		</div>
	</div>

	<div id="log" class="teal-chat" style="display: none"></div>

	<div id="fav_container">
		<fieldset class="fav_draggable">
			<legend class="fav_name">Attack</legend>
			<button class="fav_edit" title="Edit Favorite Name">✏️</button><button class="fav_delete" title="Delete Favorite">❌</button><input type="text" class="fav_notation" value="2d20"></input>
			<button class="fav_throw" title="Throw Dice">🎲</button>
			<input type="hidden" class="fav_colorset" value=""></input>
			<input type="hidden" class="fav_texture" value=""></input>
		</fieldset>
	</div>

	<!-- <fieldset id="control_panel_buttons" class="noselect">
		<button id="cp_showsettings" title="Show Settings Panel">⚙️</button>
		<!--<button id="cp_showhelp" title="View Help Page">❔</button>-->
	</fieldset> -->

	<fieldset id="control_panel" class="noselect" style="display:none;">
		<legend>Settings</legend>
		<fieldset>
			<legend>Dice</legend>
			<div>
				<label id="colorname" class="control_label" for="color">Theme: </label>
				<select id="color" name="color"></select><select id="texture" name="texture"></select><select id="material" name="material"></select>
				<label for="checkbox_allowdiceoverride" title="Allow some dice to override your color settings"><input type="checkbox" value='' id="checkbox_allowdiceoverride"> Allow Some Dice to Override Colors</label>
				<p>Star Wars dice have themes they can use individually.</p>
				<label for="system" title="Select which type of dice to display">Set:</label>
				<select id="system" name="system"></select>
			</div>
		</fieldset>
		<fieldset>
			<legend>Site Theme</legend>
			<div>
				<label for="theme" title="Set an overall color theme for the page">Theme:</label>
				<select id="theme" name="theme"></select>
				<label for="fgcolor">Foreground:</label>
				<input id="fgcolor" class="control_fgcolor" value="rgb(0,255,0)" />
				<label for="bgcolor">Background:</label>
				<input id="bgcolor" class="control_bgcolor" value="rgb(0,255,0)" />
			</div>
		</fieldset>
		<fieldset>
			<legend>Da Graphecs</legend>
			<div>
				<label for="checkbox_bumpmap" title="Enable/Disable Bumpmapping"><input type="checkbox" value='' id="checkbox_bumpmap"> Bumpmapping</label>
				<label for="checkbox_shadows" title="Enable/Disable Shadows"><input type="checkbox" value='' id="checkbox_shadows"> Shadows</label>
				<p>May speed up rendering.<br>Recommend off for chroma keying.</p>
				<label for="checkbox_sounds" title="Enable/Disable Sound Effects"><input type="checkbox" value='' id="checkbox_sounds"> Sound Effects</label>
				<select id="surface" name="surface">
					<option value="felt">Felt</option>
					<option value="wood_tray">Wood Tray</option>
					<option value="wood_table">Wood Table</option>
					<option value="metal">Metal</option>
				</select>
				<p>Can cause lag on older browsers or systems.</p>
				<label for="volume_slider">Sounds Effects Volume: </label>
				<div id="volume_slider"><div id="volume_handle" class="ui-slider-handle"></div></div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Elements</legend>
			<div>
				<button id="toggle_selector" title="Show/Hide Throw Buttons">Toggle Dice Buttons</button>
				<label for="checkbox_tally" title="Show/Hide Dice Tally"><input type="checkbox" value='' id="checkbox_tally"> Show Dice Tally</label>
				<label for="checkbox_users" title="Show/Hide Userlist"><input type="checkbox" value='' id="checkbox_users"> Show Userlist</label>
			</div>
		</fieldset>
		<br><br>
		<div class="connection_message control_label" style="color:orange">Loading Textures...</div>
		<button id="cp_hidesettings" title="Close Settings Panel">✔️</button>
	</fieldset>
