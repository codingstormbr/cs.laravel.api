<?php

namespace App\Helpers;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\RendererStyle\Fill;

class QrCode
{
    private $size = 200;
    private $backgroundColor = [255, 255, 255];
    private $color =  [0, 0, 0];
    private $margin = "1";
    private $content = "Hello";

    public function size($size = 200)
    {
        if (!empty($size)) {
            $this->size = $size;
        }
        return $this;
    }

    public function backgroundColor($backgroundColor = [255, 255, 255])
    {
        if (!empty($backgroundColor)) {
            $this->backgroundColor = $backgroundColor;
        }
        return $this;
    }

    public function color($color = [0, 0, 0])
    {
        if (!empty($color)) {
            $this->color = $color;
        }
        return $this;
    }

    public function margin($margin = 1)
    {
        if (!empty($margin)) {
            $this->margin = $margin;
        }
        return $this;
    }

    public function content($content = 'Hello')
    {
        if (!empty($content)) {
            $this->content = $content;
        }
        return $this;
    }

    private function style()
    {
        $_color = $this->color;
        $_backgroundColor = $this->backgroundColor;

        $color = new Rgb($_color[0], $_color[1], $_color[2]);
        $backgroundColor = new Rgb($_backgroundColor[0], $_backgroundColor[1], $_backgroundColor[2]);

        $fill = Fill::uniformColor($backgroundColor, $color);
        $style = new RendererStyle($this->size, $this->margin, null, null, $fill);

        return $style;
    }

    public function generateSVG()
    {
        $style = $this->style();
        $codeImage = new SvgImageBackEnd();
        $renderer = new ImageRenderer(
            $style,
            $codeImage
        );
        $writer = new Writer($renderer);
        return $writer->writeString($this->content);
    }

    public function generateBase64()
    {
        $style = $this->style();
        $codeImage = new ImagickImageBackEnd();
        $renderer = new ImageRenderer(
            $style,
            $codeImage
        );
        $writer = new Writer($renderer);
        $image = $writer->writeString($this->content);

        return base64_encode($image);
    }
}
