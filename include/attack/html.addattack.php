<br />
<div class="mains">
Add an attack</div>

<div class="contents">

<table class="attackTable">
<tr>
<th>Type</th><th>Origin</th><th>Target</th><th>Arrival</th><th>Notes</th><th>Units</th>
</tr>

<tr>
<td>
<select name="attacktype">
  <option value="cleaner">Clean</option>
  <option value="nobler">Noble</option>
  <option value="fake">Fake</option>
  <option value="support">Support</option>
  <option value="spy">Spying</option>
</select>
</td>

<td><input name="origin" type="text" value="xxx|yyy" size="6" /></td>
<td><input name="target" type="text" value="xxx|yyy" size="6" /></td>
<td><input name="hours" type="text" value="hh" size="2" />
    <input name="minutes" type="text" value="mm" size="2" />
    <input name="seconds" type="text" value="ss" size="2" /> -
    <input name="day" type="text" value="dd" size="2" />
    <input name="month" type="text" value="mm" size="2" />
    <input name="year" type="text" value="yyyy" size="4" />
</td>
<td onclick="if(document.getElementById('notes').style.display == 'none'){document.getElementById('notes').style.display='block'; this.innerHTML='Close Notes'}else{document.getElementById('notes').style.display='none'; this.innerHTML='Open Notes'}">Open Editor</td>
<td onclick="if(document.getElementById('units_table').style.display == 'none'){document.getElementById('units_table').style.display='block'; this.innerHTML='Close Units'}else{document.getElementById('units_table').style.display='none'; this.innerHTML='Open Units'}">Open Units</td>
</tr>
</table>
</div>

<div style="display:none; " id="units_table">
<br />
<div class="mains">
Units</div>
<div class="contents">

<table class="attackTable">

<tr>
<td colspan="12"><input name="hide_units" type="checkbox" value="yes"/>Do not add unit information</td>
</tr>

<tr>
<td><img alt="" src="images/ingame/units/unit_spear.png" /></td>
<td><img alt="" src="images/ingame/units/unit_sword.png" /></td>
<td><img alt="" src="images/ingame/units/unit_axe.png" /></td>
<td><img alt="" src="images/ingame/units/unit_archer.png" /></td>
<td><img alt="" src="images/ingame/units/unit_spy.png" /></td>
<td><img alt="" src="images/ingame/units/unit_light.png" /></td>
<td><img alt="" src="images/ingame/units/unit_marcher.png" /></td>
<td><img alt="" src="images/ingame/units/unit_heavy.png" /></td>
<td><img alt="" src="images/ingame/units/unit_ram.png" /></td>
<td><img alt="" src="images/ingame/units/unit_catapult.png" /></td>
<td><img alt="" src="images/ingame/units/unit_knight.png" /></td>
<td><img alt="" src="images/ingame/units/unit_snob.png" /></td>
</tr>

<tr id="unit_numbers">
<td><input name="unit_spear" type="text" value="" size="4" /></td>
<td><input name="unit_sword" type="text" value="" size="4" /></td>
<td><input name="unit_axe" type="text" value="" size="4" /></td>
<td><input name="unit_archer" type="text" value="" size="4" /></td>
<td><input name="unit_spy" type="text" value="" size="4" /></td>
<td><input name="unit_light" type="text" value="" size="4" /></td>
<td><input name="unit_marcher" type="text" value="" size="4" /></td>
<td><input name="unit_heavy" type="text" value="" size="4" /></td>
<td><input name="unit_ram" type="text" value="" size="4" /></td>
<td><input name="unit_catapult" type="text" value="" size="4" /></td>
<td><input name="unit_knight" type="text" value="" size="4" /></td>
<td><input name="unit_snob" type="text" value="" size="4" /></td>
</tr>
</table>
</div>
</div>

<div style="display:none; " id="notes">
<br />
<div class="mains">
Notes</div>
<div class="contents">
<table class="attackTable">

<tr>
<td><input name="hide_notes" type="checkbox" value="yes" />Do not add notes</td>
</tr>

<tr>
<td><textarea name="notes" cols="50" rows="10"></textarea></td>
</tr>

</table>

</div>

</div>
<input type="submit" name="index" value="Save new attack" />