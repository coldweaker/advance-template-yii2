<?php

namespace backend\models\searchs;

use Yii;
use common\models\Model;
use yii\data\SqlDataProvider;
use common\models\activerecords\User;

/**
 * UserSearch is the model for searching purpose.
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class UserSearch extends User
{
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'match', 'pattern' => '/^[a-z\d_]+$/'],
            ['role', 'match', 'pattern' => '/^[a-z-]+$/'],
            ['username', 'string', 'max' => 20],
            ['role', 'string', 'max' => 64],
            ['email', 'string', 'max' => 50],
            [['username', 'email', 'role'], 'trim'],
            [['username', 'email', 'role'], 'filter', 'filter' => 'strip_tags'],
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
        $subQuery = (new \yii\db\Query())
            ->select(["GROUP_CONCAT(item_name SEPARATOR ', ') AS role"])
            ->from('auth_assignment')
            ->where('user_id = {{user}}.[[id]]');
        $query = (new \yii\db\Query())
            ->select(['id', 'username', 'email', 'role' => $subQuery])
            ->from(static::tableName());
        $lastQuery = (new \yii\db\Query())
            ->from(['a' => $query]);

        if ($this->load($params) && $this->validate()) {
            $lastQuery->andFilterWhere(['like', 'username', $this->username])
                  ->andFilterWhere(['like', 'email', $this->email])
                  ->andFilterWhere(['like', 'role', $this->role]);
        }

        $cmd = $lastQuery->createCommand();
        $dataProvider = new SqlDataProvider([
            'sql' => $cmd->sql,
            'params' => $cmd->params,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'attributes' => [
                    'username' => [
                        'asc' => ['username' => SORT_ASC],
                        'desc' => ['username' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'email' => [
                        'asc' => ['email' => SORT_ASC],
                        'desc' => ['email' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                ],
            ],
        ]);

        return $dataProvider;
    }
}
