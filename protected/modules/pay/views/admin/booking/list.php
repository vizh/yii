<?/**
 * @var string[] $list
 * @var string $hotel
 */?>
<div class="btn-toolbar">

</div>
<div class="well">
  <ul class="nav nav-tabs">
  <?foreach (\pay\components\admin\Rif::getHotelTitles() as $key => $title):?>
    <li <?if ($key == $hotel):?>class="active"<?endif;?>>
      <a href="<?=$this->createUrl('/pay/admin/booking/list', ['hotel' => $key]);?>"><?=$title;?></a>
    </li>
  <?endforeach;?>
  </ul>

  <table class="table">
  <?foreach ($list as $item):?>
    <tr>
      <td><?=$item->UserName;?></td>
      <td><?=$item->Housing;?></td>
      <td><?=$item->Number;?></td>
    </tr>
  <?endforeach;?>
  </table>
</div>