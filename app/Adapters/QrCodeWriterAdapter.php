<?php

namespace App\Adapters;

use App\Contracts\QrCodeWriterContract;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeWriterAdapter implements QrCodeWriterContract
{
    /**
    * Qr code writer
    * 
    * @var BaconQrCode\Writer
    */
    protected $writer = null;
    
    /**
    * Creates a qr code writer instance
    * @return void
    */
    public function __construct()
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $this->writer = new Writer($renderer);
    }
    
    /**
    * Generate qr code file contents
    * 
    * @param string $input
    * @return string
    */
    public function generate(string $input)
    {
        return $this->writer->writeString($input);
    } 

    /**
     * Get file format extension
     * 
     * @return string
     */
    public function getExtension()
    {
        return 'svg';
    }
}