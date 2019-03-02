<?php

namespace App\Contracts;

interface QrCodeWriterContract
{
    /**
     * Generate qr code file contents
     * 
     * @param string $input
     * @return string
     */
    public function generate(string $input); 

    /**
     * Get file format extension
     * 
     * @return string
     */
    public function getExtension(); 
}