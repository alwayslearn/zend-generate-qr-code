<?php

namespace Alex\QrCode\Renderer;

use Alex\QrCode\Basic\BasicRender;

class GoogleChartsRenderer extends BasicRender
{
    // google api generate gr code
    const RENDER_URI = 'http://chart.apis.google.com/chart?';

    // reguired params
    const LABEL_SPECIFIES_QR_CODE = "cht";
    const LABEL_IMAGE_SIZE = "chs";
    const LABEL_DATA = "chl";
    const LABEL_ENCODING = "choe";
    const LABEL_ERROR_CORRECTION_LEVEL = "chld";

    protected $parameters = [];

    // reguired default params
    protected $default = [
        self::LABEL_SPECIFIES_QR_CODE => 'qr',
        self::LABEL_IMAGE_SIZE => '50x50',
        self::LABEL_ENCODING => 'UTF-8',
        self::LABEL_ERROR_CORRECTION_LEVEL => 'L',
    ];

    // allowed google api data
    protected $allowedData = [
        self::LABEL_SPECIFIES_QR_CODE => ['qr'],
        self::LABEL_DATA => "",
        self::LABEL_ENCODING => ['UTF-8', 'Shift_JIS', 'ISO-8859-1'],
        self::LABEL_ERROR_CORRECTION_LEVEL => ['L', 'M', 'Q', 'H'],
    ];

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->parameters = array_merge($this->default, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->parameters;
    }

    /**
     * @return bool|string
     * @throws \Exception
     */
    public function render()
    {
        if (!$this->isValid())
            throw new \Exception('Required parameters is not valid');
        else {
            $client = new \Zend_Http_Client(self::RENDER_URI);
            $client->setParameterGet($this->parameters);
            return $client->request()->getBody();
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        foreach ($this->allowedData as $param => $value) {
            switch ($param) {
                case self::LABEL_SPECIFIES_QR_CODE:

                    if (!in_array($this->parameters[self::LABEL_SPECIFIES_QR_CODE] ,$this->allowedData[self::LABEL_SPECIFIES_QR_CODE]))
                        return false;
                    break;

                case self::LABEL_DATA:

                    $valid =  new \Zend_Validate_NotEmpty();

                    if (!$valid->isValid($this->parameters[self::LABEL_DATA]))
                        return false;

                    break;
                case self::LABEL_IMAGE_SIZE:

                    $valid = new \Zend_Validate_Between(['min' => 1, 'max' => 547]);
                    list($width, $height) = explode('x', $this->parameters[self::LABEL_IMAGE_SIZE]);

                    if (!$valid->isValid($width) || !$valid->isValid($height))
                        return false;

                    break;
                case self::LABEL_ENCODING:

                    if (!in_array($this->parameters[self::LABEL_ENCODING], $this->allowedData[self::LABEL_ENCODING]))
                        return false;

                    break;
                case self::LABEL_ERROR_CORRECTION_LEVEL:

                    if (!in_array($this->parameters[self::LABEL_ERROR_CORRECTION_LEVEL], $this->allowedData[self::LABEL_ERROR_CORRECTION_LEVEL]))
                        return false;

                    break;
            }
        }
        return true;
    }
}