<?php
require_once(__DIR__ . '/../vendor/autoload.php');

$bb = new Bannerbear\BannerbearClient('');

$account = $bb->account();
echo $account;

$image_list = $bb->list_screenshots();
echo $image_list;

$image = $bb->create_image("20KwqnDEAAyDl17dYG", [
    "modifications" => [
        [
            "name" => "headline",
            "text" => "Hello world!",
        ],
        [
            "name" => "photo",
            "image_url" =>
            "https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=1000&q=80",
        ],
    ],
], TRUE);

echo $image;

$image2 = $bb->get_image("nyLXxdvaNQgG1aXgQ9wePZm1E");
echo 'Image res: ' . json_encode($image2);

$images_list = $bb->list_images(10, 25);
echo $images_list;

$bb->create_video("dqxR47Z9O28yEBVnAk", [
    "input_media_url" => "https://www.yourserver.com/videos/awesome_video.mp4",
    "modifications" => [
        [
            "name" => "headline",
            "text" => "Hello world",
        ],
    ],
]);

$ss = $bb->create_screenshot(
    "https://www.bannerbear.com/",
    [
        "width" => 1000,
    ],
    true
);
echo $ss;

echo $bb->generate_signed_url("A89wavQyY3Bebk3djP", [
    "modifications" => [
        [
            "name" => "country",
            "text" => "testing!",
        ],
        [
            "name" => "photo",
            "image_url" =>
            "https://images.unsplash.com/photo-1638356435991-4c79b00ebef3?w=764&q=80",
        ],
    ],
]);
