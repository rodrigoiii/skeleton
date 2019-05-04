<?php


/**
 * Generate image
 *
 * @source https://github.com/Rodz3rd2/image-generator/blob/master/image-generator.php
 * @param  Core\App $app
 * @return void
 */
function api_image_generator($app)
{
    $app->get('/image-generator', function() {
        // default gray
        $bg_colors = [
            'red' => isset($_GET['bg_r']) ? $_GET['bg_r'] : 128,
            'green' => isset($_GET['bg_g']) ? $_GET['bg_g'] : 128,
            'blue' => isset($_GET['bg_b']) ? $_GET['bg_b'] : 128
        ];

        // default white
        $text_colors = [
            'red' => isset($_GET['text_r']) ? $_GET['text_r'] : 255,
            'green' => isset($_GET['text_g']) ? $_GET['text_g'] : 255,
            'blue' => isset($_GET['text_b']) ? $_GET['text_b'] : 255
        ];

        // text properties
        $text_prop = [
            'size' => isset($_GET['text_size']) ? $_GET['text_size'] : 10,
            'angle' => isset($_GET['text_angle']) ? $_GET['text_angle'] : 0,
            'font' => isset($_GET['text_font']) ? $_GET['text_font'] : core_path("font/UbuntuMono-B.ttf"),
            'text' => isset($_GET['text']) ? $_GET['text'] : "Image Generator",

            'x' => isset($_GET['text_x']) ? $_GET['text_x'] : 0,
            'y' => isset($_GET['text_y']) ? $_GET['text_y'] : 0,
            'w' => 0,
            'h' => 0
        ];

        $image_dimension = [
            'w' => isset($_GET['w']) ? $_GET['w'] : 200,
            'h' => isset($_GET['h']) ? $_GET['h'] : 200
        ];

        $image = imagecreate($image_dimension['w'], $image_dimension['h']) or die("Cannot initialize new GD image stream");
        $bg_color = imagecolorallocate($image, $bg_colors['red'], $bg_colors['green'], $bg_colors['blue']);
        $text_color = imagecolorallocate($image, $text_colors['red'], $text_colors['green'], $text_colors['blue']);

        if (file_exists($text_prop['font']))
        {
            $bbox = imagettfbbox($text_prop['size'], $text_prop['angle'], $text_prop['font'], $text_prop['text']);

            // lower left
            $ll_coor_plane = [
                'x' => array_shift($bbox),
                'y' => array_shift($bbox)
            ];

            // lower right
            $lr_coor_plane = [
                'x' => array_shift($bbox),
                'y' => array_shift($bbox)
            ];

            // upper right
            $ur_coor_plane = [
                'x' => array_shift($bbox),
                'y' => array_shift($bbox)
            ];

            // upper left
            $ul_coor_plane = [
                'x' => array_shift($bbox),
                'y' => array_shift($bbox)
            ];

            $text_prop['w'] = $ur_coor_plane['x'] - $ul_coor_plane['x'];
            $text_prop['h'] = $ll_coor_plane['y'] - $ul_coor_plane['y'];

            $diffx = $image_dimension['w'] - $text_prop['w'];
            $diffy = $image_dimension['h'] - $text_prop['h'];

            // center the text if x and y are not define
            if ($text_prop['x'] === 0 && $text_prop['y'] === 0) {
                $text_prop['x'] = $diffx / 2;
                $text_prop['y'] = ($diffy / 2) + $text_prop['h'];
            } else {
                $text_prop['y'] += $text_prop['h'];
            }
        }

        if (!file_exists(storage_path("cache/image-generator")))
        {
            mkdir(storage_path("cache/image-generator"), 0755);
        }

        header("Content-Type: image/png");

        $filename = md5(implode("", $bg_colors) . "-" .
                    implode("", $text_colors) . "-" .
                    implode("", $text_prop) . "-" .
                    implode("", $image_dimension));

        if (!file_exists(storage_path("cache/image-generator/{$filename}")))
        {
            if (file_exists($text_prop['font']))
            {
                imagettftext($image, $text_prop['size'], $text_prop['angle'], $text_prop['x'], $text_prop['y'], $text_color, $text_prop['font'], $text_prop['text']);
            }
            else
            {
                imagestring($image, 1, $text_prop['x'], $text_prop['y'], $text_prop['text'], $text_color);
            }
            imagepng($image, storage_path("cache/image-generator/{$filename}"));
            imagedestroy($image);
        }

        readfile(storage_path("cache/image-generator/{$filename}"));
        exit;
    });
}
