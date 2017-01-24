<?php
namespace catalog\models\company;

use application\components\ActiveRecord;
use Yii;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Url
 * @property string $CreationTime
 * @property string $UpdateTime
 * @property int $CompanyId
 *
 * Описание вспомогательных методов
 * @method Company   with($condition = '')
 * @method Company   find($condition = '', $params = [])
 * @method Company   findByPk($pk, $condition = '', $params = [])
 * @method Company   findByAttributes($attributes, $condition = '', $params = [])
 * @method Company[] findAll($condition = '', $params = [])
 * @method Company[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Company byId(int $id, bool $useAnd = true)
 * @method Company byTitle(string $title, bool $useAnd = true)
 * @method Company byUrl(string $url, bool $useAnd = true)
 * @method Company byCompanyId(int $id, bool $useAnd = true)
 */
class Company extends ActiveRecord
{
    private $logos = null;
    protected $fileDir;

    /**
     * @param string $className
     * @return Company
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'CatalogCompany';
    }

    public function getLogos()
    {
        if ($this->logos == null) {
            $logos = [];
            $contents = scandir($this->getDir(true), SCANDIR_SORT_ASCENDING);
            foreach ($contents as $content) {
                if (is_dir($this->getPath($content, true)) && !strstr($content, '.')) {
                    $logos[] = new Logo($content, $this);
                }
            }
            $this->logos = $logos;
        }

        return $this->logos;
    }

    protected function getNextLogoId()
    {
        $logos = $this->getLogos();
        if (!empty($logos)) {
            $logo = array_pop($logos);

            return $logo->getId() + 1;
        }

        return 1;
    }

    public function afterSave()
    {
        if ($this->getIsNewRecord()) {
            mkdir($this->getDir(true));
        }

        return parent::afterSave();
    }

    public function saveLogo(\catalog\models\company\forms\Logo $form)
    {
        $logoId = !empty($form->Id) ? $form->Id : $this->getNextLogoId();
        $logo = new Logo($logoId, $this);
        $logo->save($form);
    }

    public function deleteLogo($logoId)
    {
        $logo = new Logo($logoId, $this);
        $logo->delete();
    }

    public function getPath($fileName = '', $absolute = false)
    {
        return $this->getDir($absolute).$fileName;
    }

    public function getDir($absolute = false)
    {
        if ($this->fileDir === null) {
            $this->fileDir = sprintf(Yii::app()->params['CatalogCompanyDir'], $this->Id);
        }

        return ($absolute ? Yii::getPathOfAlias('webroot') : '').$this->fileDir;
    }
}
