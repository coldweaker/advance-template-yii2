<?php

namespace backend\models\searchs;

use yii\helpers\Json;
use yii\grid\GridView;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;
use backend\models\activerecords\AuditTrail;

/**
 * AuditTrailSearch class is the model for searching purpose.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class AuditTrailSearch extends AuditTrail
{
    public $username;
    public $happened_date;

    /**
     * @return array rules
     */
    public function rules()
    {
        return [
            [['model_type', 'foreign_pk', 'username', 'type', 'data', 'happened_date'], 'safe']
        ];
    }

    /**
    * Creates data provider instance with search query applied
    *
    * @param array $params
    * @return SqlDataProvider
    */
    public function search($params)
    {
        $query = (new \yii\db\Query())
                ->select(['t.*', 'u.username'])
                ->from(['t' => self::tableName()])
                ->innerJoin(['u' => UserSearch::tableName()], 'u.id = t.user_id');

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'model_type', $this->model_type])
                  ->andFilterWhere(['like', 'foreign_pk', $this->foreign_pk])
                  ->andFilterWhere(['username' => $this->username])
                  ->andFilterWhere(['type' => $this->type]);

            if (!empty($this->happened_date)) {
                $query->andFilterWhere([
                    'between',
                    'happened_at',
                    strtotime($this->happened_date . ' 00:00:00'),
                    strtotime($this->happened_date . ' 23:59:59')
                ]);
            }
        }

        $cmd = $query->createCommand();
        $dataProvider = new SqlDataProvider([
            'sql' => $cmd->sql,
            'params' => $cmd->params,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => [
                'attributes' => [
                    'model_type' => [
                        'asc' => ['model_type' => SORT_ASC],
                        'desc' => ['model_type' => SORT_DESC],
                        'default' => SORT_ASC
                    ],
                    'happened_date' => [
                        'asc' => ['happened_at' => SORT_ASC],
                        'desc' => ['happened_at' => SORT_DESC],
                        'default' => SORT_ASC
                    ],
                ]
            ],
        ]);

        return $dataProvider;
    }

    /**
     *
     */
    public function renderDataValue($data)
    {
        $arrData = Json::decode($data);
        if (is_array($arrData)) {
            $dataProvider = new ArrayDataProvider([
                'allModels' => $arrData
            ]);
            return GridView::widget([
                'dataProvider' => $dataProvider,
                'showOnEmpty' => false,
                'options' => ['class' => 'table-responsive no-padding'],
                'tableOptions' => ['class' => 'table table-hover table-bordered'],
                'layout' => "<div class='box-body'>{items}</div>",
                'columns' => [
                    'attr',
                    [
                        'attribute' => 'from',
                        'content' => function($data){
                            return is_array($data['from']) ? Json::encode($data['from']) : $data['from'];
                        },
                    ],
                    [
                        'attribute' => 'to',
                        'content' => function($data){
                            return is_array($data['to']) ? Json::encode($data['to']) : $data['to'];
                        },
                    ],
                ],
            ]);
        }
    }
}
