<?php

namespace common\components;

use Yii;
use yii\log\Target;
use yii\httpclient\Client;
use yii\base\InvalidConfigException;

/**
 * TelegramTargetTarget send log messages to telegram group chat
 * >>>>>> need `"yiisoft/yii2-httpclient": "^2.0"` <<<<<<<
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class TelegramTarget extends Target
{
    const API_BASE_URL = 'https://api.telegram.org/bot';

    public $token;
    public $chatId;
    private $_client;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (empty($this->token) || empty($this->chatId)) {
            throw new InvalidConfigException('The "token" and "chatId" property must be set for TelegramTarget');
        }
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        if ($this->_client) {
            return $this->_client;
        }
        return new Client(['baseUrl' => self::API_BASE_URL . $this->token]);
    }

    /**
     * Sends log messages to group chat telegram
     * @throws LogRuntimeException
     */
    public function export()
    {
        $messages = array_map([$this, 'formatMessage'], $this->messages);
        $body = trim(implode("\n", $messages));
        $message = substr($body, 0, 195) . '...';
        $this->sendMessage($message);
        $this->sendDocument($body);
    }

    /**
     * Send message as text
     */
    private function sendMessage($message)
    {
        $response = $this->getClient()
                ->post('sendMessage', ['chat_id' => $this->chatId, 'text' => $message])
                ->send();
        if (!$response->isOk) {
            throw new LogRuntimeException('Unable to export log message through Telegram!');
        }
    }

    /**
     * send message as file
     */
    private function sendDocument($text)
    {
        if (strlen($text) >= 200) {
            $filename = Yii::$app->security->generateRandomString() . '.txt';
            $txtFile =  Yii::$app->getRuntimePath() . '/logs/' . $filename;
            if (($fp = @fopen($txtFile, 'w')) === false) {
                throw new InvalidConfigException("Unable to write to log file: {$txtFile}");
            }
            $writeResult = @fwrite($fp, $text);
            @fclose($fp);
            $response = (new Client())->createRequest()
                ->setMethod('POST')
                ->setUrl(self::API_BASE_URL . $this->token . '/sendDocument')
                ->setData(['chat_id' => $this->chatId])
                ->addFile('document', $txtFile)
                ->send();
            @unlink($txtFile);
            if (!$response->isOk) {
                throw new LogRuntimeException('Unable to export log document through Telegram!');
            }
        }
    }
}
