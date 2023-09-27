<?php
namespace App\Orchid\Helpers;

class Helper
{
    public static function getImage(string $url, int $width = 100, int $height = null): string
    {
        return "<img src='$url' width='$width' height='$height'/>";
    }
}
