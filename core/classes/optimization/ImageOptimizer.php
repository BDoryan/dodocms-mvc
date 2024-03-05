<?php

/**
 * This classe is used to optimize images for the website.
 * For example, it can be used to resize images to a specific size, but also
 * to compress them.
 *
 * @author Doryan BESSIERE
 */
class ImageOptimizer
{

    /**
     * The resize mode "default" is used to resize the image to the exact size defined by the width and height parameters.
     */
    const RESIZE_MODE_DEFAULT = 'exact';

    /**
     * The resize mode "crop" is used to resize the image to the exact size defined by the width and height parameters.
     */
    const RESIZE_MODE_CROP = 'crop';

    /**
     * The resize mode "fill" is used to resize the image to the exact size defined by the width and height parameters.
     */
    const RESIZE_MODE_FILL = 'fill';

    const STEP_LOAD = 1;
    const STEP_RESIZE = 2;
    const STEP_COMPRESS = 3;
    const STEP_OPTIMIZED = 4;

    private $gd_image;
    private int $exif_orientation = 0;
    private int $quality = 80;

    private string $image_src;
    private string $image_out;

    private bool $force = false;
    private int $step = 0;

    /**
     * ImageOptimizer constructor.
     *
     * @param string $image_src the source image path
     * @param bool $force if you want to force the optimization
     * @throws Exception
     */
    public function __construct(string $image_src, bool $force = false)
    {
        $this->image_src = $image_src;
        $this->force = $force;

        // Check if the gd library is installed
        if (!extension_loaded('gd')) {
            throw new Exception('The gd library is not installed');
        }
    }

    /**
     * Return the extension of the file with the mime type.
     *
     * @return false|string
     */
    public function extension()
    {
        // get mime of the image
        $mime = mime_content_type($this->image_src);
        if ($mime === false) {
            return false;
        }

        $mime_type = explode('/', $mime);
        if ($mime_type[0] !== 'image') {
            return false;
        }
        return $mime_type[1];
    }

    /**
     * Load the graphic image from the source path.
     *
     * @return bool
     */
    public function load(): bool
    {
        try {
            // Compress image, and if the compression fails, we return false
            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            });

            $basename = basename($this->image_src);
            $extension_basename = pathinfo($basename, PATHINFO_EXTENSION);

            // get mime of the image
            $extension = $this->extension() ?? $extension_basename;

            if ($extension === "jpg" || $extension === "jpeg") {
                // verify if the image is a valid jpeg
                $this->gd_image = @imagecreatefromjpeg($this->image_src);

                if ($this->gd_image === false) {
                    // Log the error
                    $error = error_get_last();
                    Application::get()->getLogger()->error('Failed to load JPEG image ' . $this->image_src . ': ' . $error['message']);
                    return false;
                }
            } else if ($extension === "png") {
                // verify if the image is a valid png
                $this->gd_image = @imagecreatefrompng($this->image_src);
                imagepalettetotruecolor($this->gd_image);

                if ($this->gd_image === false) {
                    // Log the error
                    $error = error_get_last();
                    Application::get()->getLogger()->error('Failed to load PNG image ' . $this->image_src . ': ' . $error['message']);
                    return false;
                }
            } else if ($extension === "gif") {
                // verify if the image is a valid gif
                $this->gd_image = @imagecreatefromgif($this->image_src);

                if ($this->gd_image === false) {
                    // Log the error
                    $error = error_get_last();
                    Application::get()->getLogger()->error('Failed to load GIF image ' . $this->image_src . ': ' . $error['message']);
                    return false;
                }
            } else {
                return false;
            }
            restore_error_handler();

            // Get the exif orientation of the image
            try {
                if (extension_loaded('exif')) {
                    set_error_handler(function () {
                        return false;
                    });
                    $exif = @exif_read_data($this->image_src);
                    restore_error_handler();

                    $this->exif_orientation = $exif['Orientation'] ?? 0;
                }
            } catch (Error|Exception $e) {
                $this->exif_orientation = 0;
            }

            $this->step = self::STEP_LOAD;
            return true;
        } catch (Error $e) {
            Application::get()->getLogger()->printError($e);
        } catch (Exception $e) {
            Application::get()->getLogger()->printException($e);
        }
        return false;
    }

    private string $md5_name;

    /**
     * Define the md5 name of the image and return it.
     *
     * @return string
     */
    private function generateMd5Name(): string
    {
        $last_modified = filemtime($this->image_src);
        $this->md5_name = md5($this->image_src .'-' . $this->quality. '-' . $last_modified);
        return $this->md5_name;
    }

    /**
     * Return the md5 name of the image or generate it if not exists.
     *
     * @return string
     */
    public function md5(): string
    {
        return $this->md5_name ?? $this->generateMd5Name();
    }

    /**
     * The optimize method is used to optimize the image, you can use the width and height
     * parameters to define the new size of the image. If you don't want to resize the image,
     * you can pass arguments as the value of the parameters.
     *
     * After the resize, the image is compressed to reduce its size.
     *
     * This method returns true if the image has been optimized, false otherwise.
     *
     * @param int $quality the quality of the image
     * @param int|null $width the new width of the image
     * @param int|null $height the new height of the image
     * @return bool true if the image has been optimized, false otherwise
     */
    public function optimize(int $quality = 80, ?int $width = null, ?int $height = null, string $mode = null): bool
    {
        $this->quality = $quality;
        $md5_name = $this->md5();
        $extension = pathinfo(basename($this->image_src), PATHINFO_EXTENSION);

        if ($width !== null && $height !== null) {
            if (!$this->isForce() && file_exists(Cache::toFileInCache('images/' . $md5_name . '.' . $extension))) {
                $this->image_out = Cache::toFileInCache('images/' . $md5_name . '.' . $extension);
                Application::get()->getLogger()->info('Image already resized: ' . $this->image_out);
                return true;
            }

            if ($mode === null)
                $mode = self::RESIZE_MODE_DEFAULT;

            if (!$this->resize($width, $height, $mode)) {
                $this->image_out = $this->image_src;
                return false;
            }
            $this->image_src = $this->image_out;
        }

        if (!$this->isForce() && file_exists(Cache::toFileInCache('images/' . $md5_name . '.webp'))) {
            $this->image_out = Cache::toFileInCache('images/' . $md5_name . '.webp');
            Application::get()->getLogger()->info('Image already optimized: ' . $this->image_out);
            return true;
        } else {
            if (!$this->compress($quality)) {
                $this->image_out = $this->image_src;
                return false;
            }
        }

        // Create directory if not exists
        if (!file_exists(dirname($this->image_out)))
            mkdir(dirname($this->image_out), 0775, true);

        if (empty($this->image_out))
            $this->image_out = $this->image_src;

        $this->step = self::STEP_OPTIMIZED;
        return true;
    }

    private function configureImage($image, int $width, int $height)
    {
        imagealphablending($image, false);
        imagesavealpha($image, true);
        $transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
        imagefilledrectangle($image, 0, 0, $width, $height, $transparent);
        return $image;
    }

    /**
     * The resize method is used to resize the image to a specific size.
     * The width and height parameters are used to define the new size of the image.
     *
     * @param int $width the new width of the image
     * @param int $height the new height of the image
     * @return bool true if the image has been resized, false otherwise
     */
    public function resize(int $width, int $height, ?string $mode = null): bool
    {
        if (!$this->step >= self::STEP_LOAD && !$this->load()) {
            $this->image_out = $this->image_src;
            Application::get()->getLogger()->error('Failed to load image ' . $this->image_src);
            return false;
        }

        if ($mode === null)
            $mode = self::RESIZE_MODE_DEFAULT;

        switch ($mode) {
            case self::RESIZE_MODE_DEFAULT: // Exact size
                // Create a true-color image with alpha channel
                $resizedImage = imagecreatetruecolor($width, $height);
                imagesavealpha($resizedImage, true);
                $transparency = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
                imagefill($resizedImage, 0, 0, $transparency);

                // Resize the image with transparency support
                imagecopyresampled($resizedImage, $this->gd_image, 0, 0, 0, 0, $width, $height, imagesx($this->gd_image), imagesy($this->gd_image));

                // Set the transparent color
                $transparentColor = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
                imagecolortransparent($resizedImage, $transparentColor);

                // Fill the image with the transparent color to remove the black background
                imagefill($resizedImage, 0, 0, $transparentColor);
                imagedestroy($this->gd_image); // Free up memory from the original image (not needed anymore for the rest of the script)

                $this->gd_image = $resizedImage;
                break;
            case self::RESIZE_MODE_FILL: // Fill the image with respect ratio
                $originalWidth = imagesx($this->gd_image);
                $originalHeight = imagesy($this->gd_image);
                $aspectRatio = $originalWidth / $originalHeight;

                $resizedWidth = $width;
                $resizedHeight = $height;

                if ($originalWidth / $originalHeight > $aspectRatio) {
                    $resizedWidth = $height * $aspectRatio;
                } else {
                    $resizedHeight = $width / $aspectRatio;
                }

                // Create a true-color image with an alpha channel
                $resizedImage = imagecreatetruecolor($resizedWidth, $resizedHeight);
                imagesavealpha($resizedImage, true);
                $transparency = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
                imagefill($resizedImage, 0, 0, $transparency);

                // Resize the image with transparency support
                imagecopyresampled($resizedImage, $this->gd_image, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $originalWidth, $originalHeight);

                imagedestroy($this->gd_image); // Free up memory from the original image (not needed anymore for the rest of the script)

                $this->gd_image = $resizedImage;
                break;
            case self::RESIZE_MODE_CROP:
                // Create a true-color image with alpha channel
                $croppedImage = imagecreatetruecolor($width, $height);
                imagesavealpha($croppedImage, true);
                $transparency = imagecolorallocatealpha($croppedImage, 0, 0, 0, 127);
                imagefill($croppedImage, 0, 0, $transparency);

                // Calculate the center coordinates for cropping
                $centerX = floor((imagesx($this->gd_image) - $width) / 2);
                $centerY = floor((imagesy($this->gd_image) - $height) / 2);

                // Crop the image with transparency support
                imagecopy($croppedImage, $this->gd_image, 0, 0, $centerX, $centerY, $width, $height);
                imagedestroy($this->gd_image); // Free up memory from the original image (not needed anymore for the rest of the script)

                $this->gd_image = $croppedImage;
                break;
            default:
                Application::get()->getLogger()->error('Invalid resize mode');
                return false;
        }

        // Rotate the image if necessary
        if ($this->exif_orientation > 1)
            $this->gd_image = imagerotate($this->gd_image, 90 * ($this->exif_orientation - 2), 0);

        // Save the image
        $basename = basename($this->image_src);
        $extension_basename = pathinfo($basename, PATHINFO_EXTENSION);

        $extension = $this->extension() ?? $extension_basename;
        $md5_name = $this->md5();

        Application::get()->getLogger()->info('Resizing image ' . $this->image_src . ' to ' . $width . 'x' . $height);
        $this->image_out = Cache::toFileInCache('images/' . $md5_name . '.' . $extension);
        Application::get()->getLogger()->info('Saving image to ' . $this->image_out);

        if ($extension === "jpg" || $extension === "jpeg") {
            if (!imagejpeg($this->gd_image, $this->image_out, 100)) {
                Application::get()->getLogger()->error('Failed to save JPEG image ' . $this->image_out);
                return false;
            }
        } else if ($extension === "png") {
            if (!imagepng($this->gd_image, $this->image_out, 9)) {
                Application::get()->getLogger()->error('Failed to save PNG image ' . $this->image_out);
                return false;
            }
        } else if ($extension === "gif") {
            if (!imagegif($this->gd_image, $this->image_out)) {
                Application::get()->getLogger()->error('Failed to save GIF image ' . $this->image_out);
                return false;
            }
        } else {
            Application::get()->getLogger()->error('Invalid image extension');
            return false;
        }

        // Create directory if not exists
        if (!file_exists(dirname($this->image_out)))
            mkdir(dirname($this->image_out), 0775, true);

        $this->step = self::STEP_RESIZE;
        return true;
    }

    /**
     * The compress method is used to compress the image and reduce its size,
     * without losing too much quality.
     *
     * This solution uses the WebP format, which is a modern image format that
     *
     * @return bool true if the image has been compressed, false otherwise
     */
    public function compress(int $quality = 80): bool
    {
        $this->quality = $quality;

        try {
            if (!$this->step >= self::STEP_LOAD && !$this->load()) {
                $this->image_out = $this->image_src;
                Application::get()->getLogger()->error('Failed to load image ' . $this->image_src);
                return false;
            }

            $md5_name = $this->md5();

            Application::get()->getLogger()->info('Compressing image ' . $this->image_src . ' to webp');
            $this->image_out = Cache::toFileInCache('images/' . $md5_name . '.webp');

            // Compress image, and if the compression fails, we return false
            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            });

            if (!imagewebp($this->gd_image, $this->image_out, $quality)) {
                Application::get()->getLogger()->error('Failed to compress image ' . $this->image_src);
                return false;
            }

            restore_error_handler();

            $this->step = self::STEP_COMPRESS;
            return true;
        } catch (Exception|Error $e) {
            Application::get()->getLogger()->error('Failed to compress image ' . $this->image_src);
            Application::get()->getLogger()->printException($e);
            return false;
        }
    }


    /**
     * This method returns the current step of the optimization process.
     *
     * @return int the current step of the optimization process
     */
    public function getStep(): int
    {
        return $this->step;
    }

    /**
     * Return the optimized image path, it's important to use this method for
     * empty the memory and avoid memory leaks.
     *
     * @return string the optimized image path
     */
    public function output(): string
    {
        if ($this->gd_image !== null)
            imagedestroy($this->gd_image);
        return $this->image_out;
    }

    /**
     * This method returns the original image path.
     *
     * @return string the original image path
     */
    public function getImageSrc(): string
    {
        return $this->image_src;
    }

    /**
     * @return bool if the optimization is forced
     */
    public function isForce(): bool
    {
        return $this->force;
    }

    /**
     * Return the quality of the image.
     *
     * @return int
     */
    public function getQuality(): int
    {
        return $this->quality;
    }
}