<?php

namespace common\widgets;

use yii\grid\DataColumn as BaseDataColumn;

/**
 * Extends class DataColumn
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DataColumn extends BaseDataColumn
{
    public $filterInputOptions = ['class' => 'form-control input-sm', 'id' => null];
}
