<?php

namespace common\models\searchs;

use Yii;
use yii\data\SqlDataProvider;
use common\models\activerecords\Notification;

/**
 * NotificationSearch is the model for searching purpose.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class NotificationSearch extends Notification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_name', 'to_name', 'status', 'title'], 'trim'],
            [['from_name', 'to_name', 'status', 'title'], 'filter', 'filter' => 'strip_tags'],
        ];
    }

    /**
     * @return array labels
     */
    public function attributeLabels()
    {
        return [
            'from_name' => Yii::t('app', 'From'),
            'to_name' => Yii::t('app', 'To'),
            'status' => Yii::t('app', 'Status'),
            'title' => Yii::t('app', 'Title'),
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
            ->select(['id', 'from_name', 'to_name', 'status', 'title'])
            ->from('{{notification}}');
        $query->andWhere(['to' => Yii::$app->user->id]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'from_name', $this->from_name])
                  ->andFilterWhere(['like', 'to_name', $this->to_name])
                  ->andFilterWhere(['like', 'status', $this->status])
                  ->andFilterWhere(['like', 'title', $this->title]);
        }

        $cmd = $query->createCommand();
        $dataProvider = new SqlDataProvider([
            'sql' => $cmd->sql,
            'params' => $cmd->params,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'attributes' => [
                    'id' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                ],
            ],
        ]);

        return $dataProvider;
    }
}
