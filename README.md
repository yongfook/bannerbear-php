# Bannerbear PHP Library

[![Integrate](https://github.com/yongfook/bannerbear-php/workflows/Integrate/badge.svg)](https://github.com/yongfook/bannerbear-php/actions)

A PHP wrapper for the Bannerbear API - an image and video generation service.

## Documentation

Find the full API documentation [here](https://developers.bannerbear.com/)

## Requirements

PHP 7.4 or Higher

## Installation

Install the package with:

```sh
composer require yongfook/bannerbear
```

To use the bindings, load it via Autoload

```php
require_once('vendor/autoload.php');
```

## Usage

### Table of Contents

- [Authentication](#authentication)
- [Account Info](#account-info)
- [Images](#images)
- [Videos](#videos)
- [Collections](#collections)
- [Animated Gifs](#animated-gifs)
- [Movies](#movies)
- [Screenshots](#screenshots)
- [Templates](#templates)
- [Template Sets](#template-sets)
- [Video Templates](#video-templates)
- [Signed URLs](#signed-urls)

> Please note that all methods return dictionaries/associative arrays. Responses can be found in the developer documentation [here](https://developers.bannerbear.com/).

### Authentication

Get the API key for your project in Bannerbear and then instantiate a new client.

```php
$bb = new Bannerbear\BannerbearClient("your api key");
```

Alternatively, set the API key in an environment variable named `BANNERBEAR_API_KEY`.

```php
$bb = new Bannerbear\BannerbearClient();
```

### Account Info

Return info about the account or project associated with the API key.

```php
$account = $bb->account();
```

### Images

#### Create an Image

To create an image you reference a template uid and a list of modifications. The default is async generation meaning the API will respond with a `pending` status and you can use `get_image` to retrieve the final image.

```php
$bb->create_image("template uid", [
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
]);
```

You can also create images synchronously - this will take longer to respond but the image will be delivered in the response:

```php
$bb->create_image(
  "template uid",
  [
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
  ],
  TRUE
);
```

##### Options

- `modifications`: an array of [modifications](https://developers.bannerbear.com/#post-v2-images) you would like to make (`array`)
- `webhook_url`: a webhook url to post the final image object to (`string`)
- `transparent`: render image with a transparent background (`boolean`)
- `synchronous`: generate the image synchronously (`boolean`)
- `render_pdf`: render a PDF in addition to an image (`boolean`)
- `metadata`: include any metadata to reference at a later point (`string`)

#### Get an Image

```php
$bb->get_image("image uid");
```

#### List all images

```php
$bb->list_images();
```

Optionally you can provide a page and limit

```php
$bb->list_images(10, 25);
```

### Videos

#### Create a Video

```php
$bb->create_video("video template uid", [
  "input_media_url" => "https://www.yourserver.com/videos/awesome_video.mp4",
  "modifications" => [
    [
      "name" => "headline",
      "text" => "Hello world",
    ],
  ],
]);
```

##### Options

- `input_media_url`: a url to a publicly available video file you want to import (string)
- `modifications`: an array of modifications you would like to make to the video overlay (array)
- `webhook_url`: a webhook url to post the final video object to (string)
- `blur`: blur the imported video from 1-10 (integer)
- `trim_to_length_in_seconds`: trim the video to a specific length (integer)
- `create_gif_preview`: create a short preview gif (boolean)
- `metadata`: include any metadata to reference at a later point (string)

If your video is using the "Multi Overlay" build pack then you can pass in a set of frames to render via:

- `frames`: an array of sets of modifications (array)
- `frame_durations`: specify the duration of each frame (array)

#### Get a video

```php
$bb->get_video("video uid");
```

#### Update a Video

```php
$bb->update_video("video uid", [
  "approved" => true,
  "transcription" => [
    "This is a new transcription",
    "It must contain the same number of lines",
    "As the previous transcription",
  ],
]);
```

##### Options

- `approved`: approve the video for rendering (boolean)
- `transcription`: an array of strings to represent the new transcription (will overwrite the existing one) (array)

#### List all Videos

```php
$bb->list_videos();
```

##### Options

- `page`: pagination (`integer`)

### Collections

Create multiple images in one API request.

```php
$bb->get_collection("collection uid");
$bb->list_collections(3);
$bb->create_collection(
  "template set uid",
  [
    "modifications" => [
      [
        "name" => "headline",
        "text" => "Hello World!",
      ],
    ],
  ],
  true
);
```

##### Options for `create_collection`

- `modifications`: an array of [modifications](https://developers.bannerbear.com/#post-v2-images) you would like to make (`array`)
- `webhook_url`: a webhook url to post the final collection object to (`string`)
- `transparent`: render image with a transparent background (`boolean`)
- `synchronous`: generate the images synchronously (`boolean`)
- `metadata`: include any metadata to reference at a later point (`string`)

### Animated Gifs

Create a slideshow style gif

```php
$bb->get_animated_gif("gif uid")
$bb->list_animated_gifs(3)
$bb->create_animated_gif("template uid", [
    "frames" => [
        [ // frame 1 starts here
            [
                "name" => "layer1",
                "text" => "This is my text"
            ],
            [
                "name" => "photo",
                "image_url" => "https//www.pathtomyphoto.com/1.jpg"
            ]
        ],
        [ // frame 2 starts here
            [
                "name" => "layer1",
                "text" => "This is my follow up text"
            ],
            [
                "name" => "photo",
                "image_url" => "https://www.pathtomyphoto.com/2.jpg"
            ]
        ]
    ]
])
```

##### Options for `create_animated_gif`

- `frames`: an array of arrays of [modifications](https://developers.bannerbear.com/#post-v2-images) you would like to make (`array`)
- `frame_durations`: an array of times (in seconds) to show each frame (`array`)
- `input_media_url`: optionally import an external video file to use as part of the gif
- `fps`: frames per second e.g. 1 (`integer`)
- `loop`: whether to loop or not (`boolean`)
- `webhook_url`: a webhook url to post the final gif object to (`string`)
- `metadata`: include any metadata to reference at a later point (`string`)

### Movies

Assemble video clips or still images into a single movie with transitions.

```php
$bb->get_movie("movie uid");
$bb->list_movies(3);
$bb->create_movie([
  "width" => 800,
  "height" => 800,
  "transition" => "pixelize",
  "inputs" => [
    [
      "asset_url" => "https://images.unsplash.com/photo-1635910160061-4b688344bd20?w=500&q=60",
    ],
    [
      "asset_url" => "https://i.imgur.com/fH7a5dO.png",
    ],
  ],
]);
```

##### Options for `create_movie`

- `width`: the movie width in pixels (`integer`)
- `height`: the movie height in pixels (`integer`)
- `transition`: the transition style: fade, pixelize, slidedown, slideright, slideup, slideleft (`string`)
- `inputs`: a list of [inputs](https://developers.bannerbear.com/#post-v2-movies) (`array`)
- `webhook_url`: a webhook url to post the final movie object to (`string`)
- `metadata`: include any metadata to reference at a later point (`string`)

### Screenshots

Take screenshots of websites.

```php
$bb->get_screenshot("screenshot uid");
$bb->list_screenshots(3);
$bb->create_screenshot(
  "https://www.bannerbear.com/",
  [
    "width" => 1000,
  ],
  true
);
```

##### Options for `create_screenshot`

- `width`: the desired screenshot width in pixels (`integer`)
- `height`: the desired screenshot height in pixels (`integer`)
- `synchronous`: generate the screenshot synchronously (`boolean`)
- `mobile`: use a mobile user agent
- `webhook_url`: a webhook url to post the final screenshot object to (`string`)

### Templates

```php
$bb->get_template("template uid");
$bb->update_template("template uid", [
  "name" => "New Template Name",
  "tags" => ["portrait", "instagram"],
]);
// Page, Limit, Tag, Name
$bb->list_templates(1, 100, 'tag', 'name');
```

### Template Sets

```php
$bb->get_template_set("template set uid");
$bb->list_template_sets(2);
```

### Video Templates

```php
$bb->get_video_template("video template uid");
$bb->list_video_templates(2);
```

### Signed URLs

This gem also includes a convenient utility for generating signed urls. Authenticate as above, then:

```php
$bb->generate_signed_url("base uid", [ "modifications" => []]);

// example
$bb->generate_signed_url("A89wavQyY3Bebk3djP", [
    "modifications" => [
        [
            "name" => "country",
            "text" => "testing!",
        ],
        [
            "name" => "photo",
            "image_url" => "https://images.unsplash.com/photo-1638356435991-4c79b00ebef3?w=764&q=80",
        ],
    ],
]);
// => https://ondemand.bannerbear.com/signedurl/A89wavQyY3Bebk3djP/image.jpg?modifications=W3sibmFtZSI6ImNvdW50cnkiLCJ0ZXh0IjoidGVzdGluZyEifSx7Im5hbWUiOiJwaG90byIsImltYWdlX3VybCI6Imh0dHBzOi8vaW1hZ2VzLnVuc3BsYXNoLmNvbS9waG90by0xNjM4MzU2NDM1OTkxLTRjNzliMDBlYmVmMz93PTc2NCZxPTgwIn1d&s=40e7c9d4902b86ea83e0c400e57d7cc580534fd527e234d40a0c7ace589a16eb
```

## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/yongfook/bannerbear-php. This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [code of conduct](https://github.com/yongfook/bannerbear-ruby/blob/master/CODE_OF_CONDUCT.md).

## License

The gem is available as open source under the terms of the [MIT License](https://opensource.org/licenses/MIT).

## Code of Conduct

Everyone interacting in the Bannerbear project's codebases, issue trackers, chat rooms and mailing lists is expected to follow the [code of conduct](https://github.com/yongfook/bannerbear-ruby/blob/master/CODE_OF_CONDUCT.md).
