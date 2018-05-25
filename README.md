# zend-generate-qr-code
install composer require "alwayslearn/zend-generate-qr-code @dev"


```php
<?php

use Library\QrCode\QrCode;
use Library\QrCode\Renderer\GoogleChartRenderer;

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $qrCode = new QrCode('Some text', 50, 50); // text, width, height
        $qrCode->setRenderer(new GoogleChartRenderer());
        $qrCodeData = $qrCode->generate();  // return the image data

        header('Content-Type: image/png');
        return print $qrCodeData;
    }
}