<?php

namespace App\Kernel\Storage;

use App\Kernel\Config\ConfigInterface;

class Storage implements StorageInterface
{
    public function __construct(
        private ConfigInterface $config,
    ){}
    public function url(string $path): string
    {
        return BASE_URL . "/$path";
    }
    public function get(string $path): string
    {
        return file_get_contents($this->storagePath($path));
    }
    private function storagePath(string $path)
    {
        return BASE_PATH . "/storage/$path";
    }
}