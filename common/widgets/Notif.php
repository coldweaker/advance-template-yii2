<?php

namespace common\widgets;

use Yii;
use yii\helpers\Url;
use yii\base\Widget;
use common\models\activerecords\User;
use common\components\helpers\DateTimeHelper;
use common\components\helpers\ImageHelper;
use common\models\activerecords\Notification;

/**
 * Widget for notifications
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class Notif extends Widget
{
    /**
     * @var integer
     */
    public $count = 0;

    /**
     * @var array data notif
     */
    public $items = [];

    /**
     * @var string path asset adminlte
     */
    public $directoryAsset;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $items = (new \yii\db\Query())
            ->select(['t.id', 't.title', 't.content', 't.created_at'])
            ->from(['t' => Notification::tableName()])
            ->innerJoin(['u' => User::tableName()], 't.from = u.id')
            ->where(['t.status' => Notification::STATUS_INIT, 'to' => Yii::$app->user->id])
            ->orderBy(['t.created_at' => SORT_DESC])
            ->limit(10)
            ->all();
        $this->count = count($items);
        $this->items = $items;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $header = $this->renderHeader();
        $arrLi = [];
        foreach ($this->items as $key => $item) {
            $arrLi[] = $this->renderItem($item);
        }
        $strLi = "<li><ul class=\"menu\">\n" . implode("\n", $arrLi) . "</ul></li>\n";
        $result = [];
        $result[] = "<li class=\"header\">" . \Yii::t('app', 'You have {count} messages', [
                    'count' => $this->count]) . "</li>";
        $result[] = $strLi;
        $result[] = "<li class=\"footer\"><a href=\"" . Url::to(['/notif']) . "\">" .
                    \Yii::t('app', 'See All Messages') . "</a></li>";
        $strResult = $header .
                    "\n<ul class=\"dropdown-menu\">\n" .
                    implode("\n", $result) .
                    "</ul>\n";
        return $strResult;
    }

    /**
     * Render header notification
     */
    protected function renderHeader()
    {
        $header = "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                        <i class=\"fa fa-envelope-o\"></i>
                        <span class=\"label label-success\">{$this->count}</span>
                    </a>";
        return $header;
    }

    /**
     * @param array $item Notification
     * @return string
     */
    protected function renderItem(array $item)
    {
        $partialTitle = substr($item['title'], 0, 20);
        $partialContent = substr($item['content'], 0, 30);
        $ago = DateTimeHelper::timeAgo($item['created_at'], true);
        $img = ImageHelper::render(null, '/uploads/employee/', [
            'class' => 'img-circle',
            'alt' => 'user-image'
        ]);
        $li = "<li>
                    <a href=\"" . Url::to(['/notif/view', 'id' => $item['id']]) . "\">
                        <div class=\"pull-left\">
                            {$img}
                        </div>
                        <h4>
                            {$partialTitle}
                            <small><i class=\"fa fa-clock-o\"></i> {$ago}</small>
                        </h4>
                        <p>{$partialContent}</p>
                    </a>
                </li>";
        return $li;
    }
}