<?php

namespace backend\models\forms;

use Yii;
use common\models\Model;

/**
 * DocumentForm is the model behind the document form.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DocumentForm extends Model
{
    public $id;
    public $name;
    public $content;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id', 'name', 'content'], 'required'],
            ['id', 'match', 'pattern' => '/^\d{2}$/'],
            ['name', 'string', 'length' => [5, 50]],
            [['name', 'content'], 'trim'],
            ['name', 'filter', 'filter' => 'strip_tags'],
        ];
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
