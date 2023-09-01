<?php

namespace App\Services;

use App\Http\Controllers\ApiResponseTrait;

class MimesToExt
{
    use ApiResponseTrait;

    /**
     * 画像のMimeTypeから拡張子を判定して返します。
     * @param string $mimetype
     * @return string
     */
    public function getImageExtFromMimeType(string $mimetype): string
    {
        $ext = "";
        switch ($mimetype) {
            case "image/png":
                $ext = "png";
                break;
            case "image/jpeg":
                $ext = "jpg";
                break;
            case "image/gif":
                $ext = "gif";
                break;
            case "image/x-ms-bmp":
                $ext = "bmp";
                break;
            case "image/vnd.wap.wbmp":
                $ext = "wbmp";
                break;
            default:
                $this->throwErrorResponse('unknown_image_type', 422);
        }
        return $ext;
    }
}
