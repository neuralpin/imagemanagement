<?php

namespace Neuralpin\ImageManagement;

final class Image
{
    public string $filePath;

    public string $name;

    public string $path;

    public ?int $width;

    public ?int $height;

    public string $type;

    private mixed $Resource;

    public function __construct(
        string $filePath,
    ) {
        $this->filePath = $filePath;

        if (!is_file($this->filePath)) {
            throw new \Exception(message: "File cannot be accessed: {$this->filePath}");
        }

        $pathInfo = pathinfo($this->filePath);

        $this->name = $pathInfo['filename'];
        $this->path = $pathInfo['dirname'];

        if (![$this->width, $this->height, $type] = getimagesize($this->filePath)) {
            throw new \Exception(message: 'Not valid picture');
        }

        if (is_null($this->imageTypes[$type])) {
            throw new \Exception(message: 'Unsupported picture type');
        }

        $this->type = $this->imageTypes[$type];

        $this->Resource = $this->imageCreateFrom($this->filePath, $this->type);
    }

    private function imageCreateFrom(string $filePath, string $type): mixed
    {
        switch ($type) {
            case 'jpg':
                return imagecreatefromjpeg($filePath);
            case 'png':
                return imagecreatefrompng($filePath);
            case 'webp':
                return imagecreatefromwebp($filePath);
            case 'bmp':
                return imagecreatefromwbmp($filePath);
            case 'gif':
                return imagecreatefromgif($filePath);
            case 'avif':
                return imagecreatefromavif($filePath);
            default:
                return null;
        }
    }

    private function saveFormat(string $type, mixed $resource, string $destiny)
    {
        switch ($type) {
            case 'bmp':
                return imagewbmp($resource, $destiny);
            case 'gif':
                return imagegif($resource, $destiny);
            case 'jpg':
                return imagejpeg($resource, $destiny);
            case 'png':
                return imagepng($resource, $destiny);
            case 'webp':
                return imagewebp($resource, $destiny);
            case 'avif':
                return imageavif($resource, $destiny);
        }
    }

    private $imageTypes = [
        // 0=>'unknown',
        1 => 'gif',
        2 => 'jpg',
        3 => 'png',
        // 4=>'swf',
        // 5=>'psd',
        6 => 'bmp',
        // 7=>'tiff_ii',
        // 8=>'tiff_mm',
        // 9=>'jpc',
        // 10=>'jp2',
        // 11=>'jpx',
        // 12=>'jb2',
        // 13=>'swc',
        // 14=>'iff',
        // 15=>'wbmp',
        // 16=>'xbm',
        // 17=>'ico',
        18 => 'webp',
        19 => 'avif',
    ];

    private function createImage(
        mixed $Resource,
        string $type,
        int $width,
        int $height,
        int $x,
        int $w,
        int $h,
    ) {
        $imageCopy = imagecreatetruecolor($width, $height);

        // preserve transparency
        if ($type == 'gif' or $type == 'png') {
            imagecolortransparent($imageCopy, imagecolorallocatealpha($imageCopy, 0, 0, 0, 127));
            imagealphablending($imageCopy, false);
            imagesavealpha($imageCopy, true);
        }

        imagecopyresampled($imageCopy, $Resource, 0, 0, $x, 0, $width, $height, $w, $h);

        return $imageCopy;
    }

    public function update(
        ?string $destiny = null,
        ?string $type = null,
        ?int $width = null,
        ?int $height = null,
        bool $crop = false,
    ) {

        if (!is_null($type) && !in_array($type, $this->imageTypes)) {
            throw new \Exception(message: 'Unsupported picture type');
        }

        if (is_null($destiny)) {
            $destiny = $this->path;
        }

        if (is_null($width)) {
            $width = $this->width;
        }
        
        if (is_null($height)) {
            $height = $this->height;
        }

        if (is_null($type)) {
            $type = $this->type;
        }

        if ($crop && (!is_null($width) || !is_null($width))) {
            $ratio = max($width / $this->width, $height / $this->height);
            $x = ($this->width - $width / $ratio) / 2;
            $h = $height / $ratio;
            $w = $width / $ratio;
        } else {
            $ratio = min($width / $this->width, $height / $this->height);
            $width = $this->width * $ratio;
            $height = $this->height * $ratio;
            $x = 0;
            $h = $this->height;
            $w = $this->width;
        }

        $imageCopy = $this->createImage(
            Resource: $this->Resource,
            type: $type,
            width: $width,
            height: $height,
            x: $x,
            w: $w,
            h: $h
        );

        return $this->saveFormat($type, $imageCopy, $destiny);
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getType(): string
    {
        return $this->type;
    }
}
