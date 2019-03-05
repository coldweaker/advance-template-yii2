<?php

namespace backend\models\activerecords;

use Yii;
use common\models\ActiveRecord;
use backend\models\forms\DocumentForm;

/**
 * Document activerecord.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class Document extends ActiveRecord
{
    /**
     * @return table name `document`
     */
    public static function tableName()
    {
        return '{{document}}';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id', 'name', 'content'], 'safe'],
        ];
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        $documentForm = new DocumentForm();
        return $documentForm->attributeLabels();
    }

    /**
     * @param $docForm DocumentForm
     * @return bool
     */
    public function saveModel(DocumentForm $docForm)
    {
        $this->attributes = $docForm->attributes;
        return $this->save();
    }

    /**
     * @param $docForm DocumentForm
     * @return bool
     */
    public function updateModel(DocumentForm $docForm)
    {
        $this->attributes = $docForm->attributes;
        return $this->save();
    }
}
