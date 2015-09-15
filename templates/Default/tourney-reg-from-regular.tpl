<div class="form-group">
    <input type="text" maxlength="17" id="argBtag" value="" required="" placeholder="&nbsp;&nbsp;Battle.net таг" class="form-control input-sm">
</div>

<div class="form-group">
    <input type="text" id="argVK" value="" required="" placeholder="&nbsp;&nbsp;iD Vkontakte" class="form-control input-sm" onkeyup="validator_lat(this)">
</div>

<div class="form-group">
  <select class="form-control" id="arg1">
    <option selected="selected" disabled="disabled">Выберите героя #1</option>
    <option>Paladin</option>
    <option>Shaman</option>
    <option>Priest</option>
    <option>Warrior</option>
    <option>Warlock</option>   
    <option>Rogue</option>
    <option>Hunter</option>   
    <option>Druid</option>   
    <option>Mage</option>   
  </select>
</div>

<div class="form-group">
  <select class="form-control" id="arg2">
    <option selected="selected" disabled="disabled">Выберите героя #2</option>
    <option>Paladin</option>
    <option>Shaman</option>
    <option>Priest</option>
    <option>Warrior</option>
    <option>Warlock</option>   
    <option>Rogue</option>
    <option>Hunter</option>   
    <option>Druid</option>   
    <option>Mage</option>   
  </select>
</div>

<div class="form-group">
  <select class="form-control" id="arg3">
    <option selected="selected" disabled="disabled">Выберите героя #3</option>
    <option>Paladin</option>
    <option>Shaman</option>
    <option>Priest</option>
    <option>Warrior</option>
    <option>Warlock</option>   
    <option>Rogue</option>
    <option>Hunter</option>   
    <option>Druid</option>   
    <option>Mage</option>   
  </select>
</div>

<a class="btn btn-lg btn-block btn-primary button" onclick="tourRegistration(this);">Регистрация</a>