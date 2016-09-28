<div class="row">
  <div class="span12">
    <h2 class="indent-bottom3">Статистика регистраций участников</h2>

    <h4>Ранее не зарегистрированных в системе: <span class="text-success"><?=$newCount?></span></h4>
    <h4>Среди них подозрений на дубликаты: <span class="text-error"><?=sizeof($duplicates)?></span></h4>

    <?if($counter != $newCount):?>
    <h5 class="text-error">Внимание! Из-за большого объема данных, не все дубликаты были найдены. Пройдено только <?=$counter?> записей.</h5>
    <?endif?>

    <table class="table table-striped">
      <thead>
      <th colspan="2">Аккаунт на мероприятии</th>
      <th>Вероятные дубли</th>
      </thead>

      <tbody>
      <?foreach($duplicates as $info):?>
        <tr>
          <td>
            <h4><a target="_blank" href="http://rocid.ru/<?=$info['Current']->User->RocId?>"><?=$info['Current']->User->RocId?></a></h4>
          </td>
          <td>
            <strong><?=$info['Current']->User->GetFullName()?></strong><br>
            <?=$info['Current']->User->EmploymentPrimary()->Company->Name?>, <em><?=$info['Current']->User->EmploymentPrimary()->Position?></em>
          </td>

          <td>
            <table class="table table-bordered table-condensed page-user-statistics-innertable">
              <tbody>
              <?foreach($info['Check'] as $user):?>
                <tr>
                  <td style="width: 80px;"><a target="_blank" href="http://rocid.ru/<?=$user->RocId?>"><?=$user->RocId?></a></td>
                  <td style="width: 180px;"><?=$user->GetFullName()?></td>
                  <td>
                    <?foreach($user->Employments as $employment):?>
                    <?=$employment->Company->Name?>, <em><?=$employment->Position?></em><br>
                    <?endforeach?>
                  </td>
                </tr>
              <?endforeach?>
              </tbody>
            </table>
          </td>
        </tr>
      <?endforeach?>
      </tbody>
    </table>

  </div>
</div>