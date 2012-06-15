<?
/**
 * @var $comission Comission
 */
$comission = $this->Comission;
?>
<div class="row">
  <div class="span16">
    <h2>Члены комиссии: <?=$comission->Title;?></h2>
    <form action="<?=RouteRegistry::GetAdminUrl('comission', 'user', 'add', array('id' => $comission->ComissionId));?>" method="post">

        <div class="row">
          <div class="span8">
            <div class="clearfix">
              <label for="search">Добавить:</label>
              <div class="input">
                <input type="text" name="search" id="search" class="span4" autocomplete="off">
                <input type="hidden" name="rocID" value="">
                <span id="span_rocid" class="help-inline"></span>
                <span class="help-block">Введите ФИО или rocID.</span>
              </div>
            </div>
          </div>
          <div class="span3">
            <select name="role" class="span3">
              <?foreach ($this->Roles as $role):?>
              <option value="<?=$role->RoleId;?>"><?=$role->Name;?></option>
              <?endforeach;?>
            </select>
          </div>
          <div class="span5">
            <input id="add_user_to_comission" type="submit" class="btn primary" value="Добавить">
          </div>
        </div>

    </form>
    <table class="persons">
      <?php echo $this->Users;?>
    </table>

    
  </div>
</div>