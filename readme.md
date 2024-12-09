# Simple PHP Image transform

## Supported formats

- jpg
- png
- bmp
- webp
- avif
- gif

## Format Conversion example (from jpg to webp)
Create a copy of the image, same name, same dimensions, different format 

```php
use Neuralpin\ImageManagement\Image;

$format = 'webp';

$MyImage = new Image('1280x720.jpg');
$MyImage->update(
    destiny: __DIR__ . "/result/{$MyImage->getName()}.{$format}",
    type: $format,
);
```

## Basic rescaling example (From 1280p to 900px)
Create a copy of the image, different dimensions (proportional), same format

```php
use Neuralpin\ImageManagement\Image;

$MyImage = new Image('1280x720.jpg');
$MyImage->update(
    destiny: __DIR__ . "/result/{$MyImage->getName()}_900.{$MyImage->getType()}",
    width: 900,
);
```

## Cropping example
Create a copy of the image, different dimensions (cropped 500x500), same format

```php
use Neuralpin\ImageManagement\Image;

$MyImage = new Image('1280x720.jpg');
$MyImage->update(
    destiny: __DIR__ . "/result/{$MyImage->getName()}_500.{$MyImage->getType()}",
    width: 500,
    height: 500,
    crop: true,
);
```

## Full use example
Create a copy of the image, different dimensions (cropped), different format

```php
use Neuralpin\ImageManagement\Image;

$width = 500:
$height = 500:
$format = 'webp';

$MyImage = new Image('1280x720.jpg');
$MyImage->update(
    destiny: __DIR__ . "/result/{$width}x{$height}.{$format}",
    type: $format,
    width: $width,
    height: $height,
    crop: true,
);
```