<?php

namespace backend\models\searchs;

use Yii;
use yii\data\SqlDataProvider;
use backend\models\activerecords\Document;

/**
 * DocumentSearch is the model for searching purpose.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class DocumentSearch extends Document
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'trim'],
            [['id', 'name'], 'filter', 'filter' => 'strip_tags'],
        ];
    }

    /**
     * @return array labels
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'name' => Yii::t('app', 'Name'),
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
            ->select(['id', 'name'])
            ->from(self::tableName());

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['id' => $this->id])
                  ->andFilterWhere(['like', 'name', $this->name]);
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
