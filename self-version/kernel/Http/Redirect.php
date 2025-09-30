<?php


namespace App\Kernel\Http;


class Redirect implements RedirectInterface
{

    public function to(string $url)
    {
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header("location: {$base}/{$url}");
        exit;
    }


}