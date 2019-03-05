<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\InputWidget;
use common\assets\Select2Asset;

/**
 * Widget for select2
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class Select2 extends InputWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        Select2Asset::register($this->getView());
        $defaultClientOptions = [];
        $this->clientOptions = ArrayHelper::merge($this->clientOptions, $defaultClientOptions);
        $this->registerPlugin('select2');
        $this->getView()->registerCss('
            .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
                border: 1px solid #d2d6de;
                border-radius: 0;
                padding: 6px 12px;
                height: 34px;
            }
            .select2-result-repository__avatar {
                float:left;
                width:60px;
                margin-right:10px;
            }
            .select2-result-repository__avatar img {
                width:100%;
                height:auto;
                border-radius:2px;
            }
            .select2-result-repository__meta {
                margin-left:70px;
            }
            .select2-result-repository__title {
                color:black;
                font-weight:700;
                word-wrap:break-word;
                line-height:1.1;
                margin-bottom:4px;
            }
            .select2-result-repository__forks,
            .select2-result-repository__stargazers,
            .select2-result-repository__watchers {
                margin-right:1em;
            }
            .select2-result-repository__forks,
            .select2-result-repository__stargazers,
            .select2-result-repository__watchers {
                display:inline-block;
                color:#aaa;
                font-size:11px;
            }
            .select2-result-repository__description{
                font-size:13px;
                color:#777;
                margin-top:4px;
            }
            .select2-results__option--highlighted .select2-result-repository__title {
                color:white;
            }
            .select2-results__option--highlighted .select2-result-repository__forks,
            .select2-results__option--highlighted .select2-result-repository__stargazers,
            .select2-results__option--highlighted .select2-result-repository__description,
            .select2-results__option--highlighted .select2-result-repository__watchers {
            color:#c6dcef;
            }
        ', [], 'css-select2');
    }
}
