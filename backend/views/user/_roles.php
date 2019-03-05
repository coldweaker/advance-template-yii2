<?php
use yii\helpers\Html;
use yii\helpers\Inflector;

/* @var $model \app\models\forms\UserForm */
/* @var $form \yii\bootstrap\ActiveForm */
?>

<div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                        <th><?= \Yii::t('app', 'No') ?></th>
                        <th><?= \Yii::t('app', 'Roles') ?></th>
                        <th><?= \Yii::t('app', 'Action') ?></th>
                    </tr>
                    <?php $no = 1; foreach($model->roles as $key => $role): ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td>
                            <?= Inflector::camel2words($role->name) ?>
                            <?= Html::activeHiddenInput($role, "[$key]name") ?>
                        </td>
                        <td><?= Html::activeCheckbox($role, "[$key]selected", ['label' => false, 'uncheck' => 0]) ?></td>
                    </tr>
                    <?php $no++; endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><?= Html::error($model, 'roles', ['class' => 'text-red']) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
