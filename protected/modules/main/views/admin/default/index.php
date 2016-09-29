<?
/**
 * @var Event[] $waitEvents
 * @var Event[] $publishedEvents
 * @var User $users
 * @var Order[] $orders
 * @var Statistics $statistics
 * @var \application\components\controllers\AdminMainController $this
 */
use application\components\helpers\Url;
use event\models\Event;
use user\models\User;
use \pay\models\Order;
use main\components\admin\Statistics;
$this->setPageTitle('Администрирование');
?>
<div class="search-well">
    <form class="form-inline">
        <input type="text" class="input-xlarge" placeholder="Строка для поиска....">
        <select name="by">
            <option data-url-pattern="/event/list/index/?Query=#query#">По мероприятиям</option>
            <option data-url-pattern="/user/list/index/?user\models\forms\admin\ListFilter[Query]=#query#&user\models\forms\admin\ListFilter[Sort]=CreationTime_DESC&user\models\forms\admin\ListFilter[PerPage]=20">По пользователям</option>
        </select>
        <button class="btn" type="submit"><i class="icon-search"></i> Искать</button>
    </form>
</div>
<?=$this->renderPartial('index/_statistics', ['statistics' => $statistics])?>
<div class="row-fluid">
    <div class="span<?if(!empty($waitEvents)):?>6<?else:?>12<?endif?> block">
        <?=$this->renderPartial('index/_published-events', ['events' => $publishedEvents])?>
    </div>
    <?if(!empty($waitEvents)):?>
    <div class="span6 block">
        <?=$this->renderPartial('index/_wait-events', ['events' => $waitEvents])?>
    </div>
    <?endif?>
</div>
<div class="row-fluid">
    <div class="block span6">
        <?=$this->renderPartial('index/_users', ['users' => $users])?>
    </div>
    <div class="block span6">
        <?=$this->renderPartial('index/_orders', ['orders' => $orders])?>
    </div>
</div>