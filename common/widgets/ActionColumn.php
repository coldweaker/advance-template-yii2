<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use common\components\helpers\ArrayHelper;
use yii\grid\ActionColumn as BaseActionColumn;

/**
 * Extends class ActionColumn
 *
 * @author Hendi Andriansah <hendi@docotel.com>
 */
class ActionColumn extends BaseActionColumn
{
    public $type_link = 'btn';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->header = Yii::t('app', 'Action');
        parent::init();
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('update', 'edit');
        $this->initDefaultButton('delete', 'trash');
    }

    /**
     * @inheritdoc
     * Change icon attribute from glyphicon
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'Detail');
                        $color = 'info';
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        $color = 'warning';
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $color = 'danger';
                        break;
                    default:
                        $title = ucfirst($name);
                        $color = 'default';
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                if ($this->type_link === 'btn') {
                    $options = ArrayHelper::merge(['class' => "btn btn-$color btn-sm"], $options);
                    return Html::a($title, $url, $options);
                } else {
                    $icon = Html::tag('span', '', ['class' => "fa fa-$iconName"]);
                    return Html::a($icon, $url, $options);
                }
            };
        }
    }
}
