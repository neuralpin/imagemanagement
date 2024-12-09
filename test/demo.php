<?php

use Neuralpin\ImageManagement\Image;

require __DIR__.'/../vendor/autoload.php';


$MyImage = new Image('1280x720.jpg');

// Copying file
// try{
//     $MyImage->update( __DIR__."/{$MyImage->getName()}.{$MyImage->getType()}");
// }catch(\Exception|\Throwable $e){
//     var_dump($e);
// }

// Upscaling
// try {
//     $MyImage->update(
//         destiny: __DIR__ . "/1920x1080.{$MyImage->getType()}",
//         width: 1920,
//         height: 1080,
//     );
// } catch (\Exception | \Throwable $e) {
//     var_dump($e);
// }

// // Rescaling width
// try {
//     $MyImage->update(
//         destiny: __DIR__ . "/w_900.{$MyImage->getType()}",
//         width: 900,
//     );
// } catch (\Exception | \Throwable $e) {
//     var_dump($e);
// }

// // Cropping width
// try {
//     $MyImage->update(
//         destiny: __DIR__ . "/w_900_cropped.{$MyImage->getType()}",
//         width: 900,
//         crop: true
//     );
// } catch (\Exception | \Throwable $e) {
//     var_dump($e);
// }

// Rescaling width & height
try {
    $MyImage->update(
        destiny: __DIR__ . "/500.webp",
        type: 'webp',
        width: 500,
        height: 500,
        crop: true
    );
} catch (\Exception | \Throwable $e) {
    var_dump($e);
}

var_dump($MyImage);