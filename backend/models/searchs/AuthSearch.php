<?php

namespace backend\models\searchs;

use Yii;
use common\models\Model;
use yii\data\SqlDataProvider;
use backend\models\forms\AuthForm;
use backend\models\activerecords\Auth;

/**
 * AuthSearch is the model for searching purpose.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class AuthSearch extends Auth
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 64],
            ['name', 'match', 'pattern' => '/^[a-z-]+$/'],
            ['type', 'in', 'range' => AuthForm::getListType()],
            [['name', 'description'], 'trim'],
            [['name', 'description'], 'filter', 'filter' => 'strip_tags'],
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
            ->select(['name', 'type', 'description'])
            ->from(self::tableName());

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'name', $this->name])
                  ->andFilterWhere(['like', 'description', $this->description])
                  ->andFilterWhere(['type' => $this->type]);
        }

        $cmd = $query->createCommand();
        $dataProvider = new SqlDataProvider([
            'sql' => $cmd->sql,
            'params' => $cmd->params,
            'key' => 'name',
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'attributes' => [
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                        'default' => SORT_ASC
                    ],
                ]
            ],
        ]);

        return $dataProvider;
    }
}
