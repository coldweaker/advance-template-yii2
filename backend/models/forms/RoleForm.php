<?php

namespace backend\models\forms;

use Yii;
use common\models\Model;

/**
 * Define model for Role.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class RoleForm extends Model
{
    public $name;
    public $name_print;
    public $selected;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->selected = 0;
    }

    /**
     * @return arrau rules of model.
     */
    public function rules()
    {
        return [
            [['name', 'selected'], 'required'],
        ];
    }

    /**
     * @param $data array from post request.
     */
    public function loadMultiplePost($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if ($value instanceof Model) {
                    $this->attributes = $value;
                } else {
                    return false;
                }
            }
        }
        return false;
    }
}
