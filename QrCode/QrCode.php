<?php

namespace Alex\QrCode;

use Alex\QrCode\Basic\BasicRender;

class QrCode
{
    protected $text;
    protected $width;
    protected $height;

    protected $otherData = [];

    protected $renderer = null;


    /**
     * QrCode constructor.
     * @param string $text
     * @param int $width
     * @param int $height
     * @param array $otherData
     */
    public function __construct(string $text, int $width = 50, int $height = 50, array $otherData = [])
    {
        $this->text = trim($text);
        $this->width = $width;
        $this->height = $height;
        $this->otherData = $otherData;
    }

    /**
     * @param BasicRender $renderer
     */
    public function setRenderer(BasicRender $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return array_merge($this->otherData, [
            'chl' => $this->text,
            'chs' => $this->width . 'x' . $this->height,

        ]);
    }

    /**
     * @return null|BasicRender object
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * @return bool|Exception|img
     * @throws \Exception
     */
    public function generate()
    {
        if ($this->renderer == null)
            throw new \Exception('You must set renderer');
        else {
            $this->renderer->setData($this->getParams());
            return $this->renderer->render();
        }
        return false;
    }
}