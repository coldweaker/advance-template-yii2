<?php

namespace common\components\validators;

use yii\validators\Validator;

/**
 * OneWhiteSpaceFilter is the standalone validator
 * for removing more than one white-space in string to only one white-space
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class OneWhiteSpaceFilter extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttributes($model, $attributes = null)
    {
        if (is_array($attributes)) {
            $newAttributes = [];
            $attributeNames = $this->getAttributeNames();
            foreach ($attributes as $attribute) {
                if (in_array($attribute, $attributeNames, true)) {
                    $newAttributes[] = $attribute;
                }
            }
            $attributes = $newAttributes;
        } else {
            $attributes = $this->getAttributeNames();
        }

        foreach ($attributes as $key => $attribute) {
            $model->$attribute = preg_replace('/\s+/', ' ', $model->$attribute);
        }
    }
}
