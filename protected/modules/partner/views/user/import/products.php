<?php
/**
 * @var string[] $productNames
 * @var \pay\models\Product[] $products
 * @var array $values
 * @var string $error
 * @var \partner\components\Controller $this
 */

$this->setPageTitle(\Yii::t('app', 'Импорт участников мероприятия'));
?>

<?=CHtml::beginForm()?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-arrows-h"></i> <?=\Yii::t('app', 'Выберите соответствие столбцов и полей данных')?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <?if($error):?>
                <div class="alert alert-danger"><?=\Yii::t('app', 'Необходимо заполнить все товары!')?></p></div>
            <?endif?>
            <div class="table-info">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td><?=\Yii::t('app', 'Поле из файла')?></td>
                            <td><?=\Yii::t('app', 'Товар')?></td>
                        </tr>
                    </thead>
                    <tbody>
                    <?foreach($productNames as $name):?>
                        <tr>
                            <td><?=$name?></td>
                            <td>
                                <select name="values[<?=!empty($name) ? $name : 0?>]" class="form-control">
                                    <option value="0">Не задан</option>
                                    <option value="-1">Нет товара</option>
                                    <?foreach($products as $product):?>
                                        <option value="<?=$product->Id?>" <?=isset($values[$name]) && $values[$name] == $product->Id ? 'selected="selected"' : ''?>><?=$product->Title?></option>
                                    <?endforeach?>
                                </select>
                            </td>
                        </tr>
                    <?endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Продолжить'), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
<?=CHtml::endForm()?>