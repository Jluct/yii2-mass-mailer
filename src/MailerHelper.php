<?php
/**
 * Created by PhpStorm.
 * User: Listopadov
 * Date: 05.04.2017
 * Time: 7:59
 */

namespace jluct\mailer;

use Yii;
use yii\mail\MailerInterface;

class MailerHelper
{
    private $_mailer;

    public $layout = null;

    public function __construct()
    {
        $this->_mailer = \Yii::$app->mailer;
    }

    public function initMessage($to, $subject)
    {
        if (!empty($this->layout))
            $this->_mailer->htmlLayout = $this->layout;

        $this->_mailer = $this->_mailer->compose();

        $this->_mailer = $this->_mailer->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($to)
            ->setSubject($subject);


        return $this;

    }

    public function setHtml($view, $data = null)
    {
        $this->_mailer = $this->_mailer->setHtmlBody(Yii::$app->view->render($view, $data));
        return $this;

    }

    public function setText($text)
    {
        $this->_mailer = $this->_mailer->setTextBody($text);
        return $this;

    }

    public function attach($file)
    {
        if (empty($file))
            return false;

        if (is_array($file))
            foreach ($file as &$value)
                $this->_mailer = $this->_mailer->attach($value);
        else
            $this->_mailer = $this->_mailer->attach($file);

        return $this;
    }

    public function attachContent($fileContent)
    {
        if (empty($fileContent))
            return false;

        if (is_array($fileContent[0]) && count($fileContent))
            foreach ($fileContent as &$value)
                $this->_mailer = $this->_mailer->attachContent($value[0], array_slice($value, 1));
        else
            $this->_mailer = $this->_mailer->attachContent($fileContent[0], array_slice($fileContent, 1));

        return $this;
    }

    /**
     * @param $addresses array
     * @return $this
     */
    public function addAdditionalCopy($addresses)
    {
        $this->_mailer = $this->_mailer->setCc($addresses);
        return $this;
    }

    /**
     * @param $addresses array
     * @return $this
     */
    public function addHiddenAdditionalCopy($addresses)
    {
        $this->_mailer = $this->_mailer->setBcc($addresses);
        return $this;
    }

    /**
     * @property MailerInterface $this->_mailer
     * @return bool
     */
    public function send()
    {
        if (!!$this->_mailer->getTo())
            $this->_mailer->send();

        return true;
    }

    public function test()
    {
        Yii::$app->mailer->compose('asddfdfd')->getBcc();
    }

    /**
     * @return mixed
     */
    public function getMailer()
    {
        return $this->_mailer;
    }

    /**
     * @param mixed $mailer
     */
    public function setMailer($mailer)
    {
        $this->_mailer = $mailer;
    }

}