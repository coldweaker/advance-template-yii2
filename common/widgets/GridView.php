<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\grid\GridView as BaseGridView;

/**
 * Extends class GridView
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class GridView extends BaseGridView
{
    public $showSerialColumn = true;
    public $dataColumnClass = '\common\widgets\DataColumn';
    public $renderExtendRowContent = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->options = ['class' => 'table-responsive no-padding'];
        $this->tableOptions = ['class' => 'table table-hover table-bordered'];
        $this->layout = "<div class='box-body'>{summary}\n<br />{items}</div><div class='box-footer'>{pager}</div>";
        $this->showOnEmpty = true;

        if ($this->showSerialColumn) {
            array_unshift($this->columns, ['class' => 'yii\grid\SerialColumn', 'header' => \Yii::t('app', 'No')]);
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function renderTableRow($model, $key, $index)
    {
        $cells = [];
        /* @var $column Column */
        foreach ($this->columns as $column) {
            $cells[] = $column->renderDataCell($model, $key, $index);
        }
        if ($this->rowOptions instanceof \Closure) {
            $options = call_user_func($this->rowOptions, $model, $key, $index, $this);
        } else {
            $options = $this->rowOptions;
        }
        $options['data-key'] = is_array($key) ? json_encode($key) : (string) $key;

        if ($this->renderExtendRowContent instanceof \Closure) {
            $test = call_user_func($this->renderExtendRowContent, $model);
            $extendRow = Html::tag('td', $test, [
                'class' => 'extend-row success', 'id' => "extend-$key", 'colspan' => count($cells)
            ]);
            return Html::tag('tr', implode('', $cells), $options)."\n".
                   Html::tag('tr', $extendRow, []);
        }
        return Html::tag('tr', implode('', $cells), $options);
    }
}
