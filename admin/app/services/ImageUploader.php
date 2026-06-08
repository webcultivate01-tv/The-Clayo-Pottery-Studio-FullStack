<?php
declare(strict_types=1);

namespace Calyo\Services;

use RuntimeException;

/**
 * ImageUploader — validates an uploaded image, resizes it if larger than a max
 * width, converts it to WebP, and stores it under the project-root /public
 * folder. Returns the path relative to /public so it can be stored in the DB
 * and joined to the public URL prefix at render time.
 */
final class ImageUploader
{
    private const MAX_WIDTH       = 1600;
    private const WEBP_QUALITY    = 82;
    private const MAX_BYTES       = 8 * 1024 * 1024;
    private const ALLOWED_MIMES   = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

    /**
     * Handle a $_FILES entry. Returns the stored path relative to the public
     * folder (e.g. "uploads/services/abc123.webp"), or null when nothing was
     * uploaded. Throws on any validation / processing error.
     */
    public function store(array $file, string $subdir, string $slugHint = ''): ?string
    {
        if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException($this->uploadErrorMessage((int) $file['error']));
        }

        if (($file['size'] ?? 0) > self::MAX_BYTES) {
            throw new RuntimeException('Image is larger than 8 MB.');
        }

        $tmp = $file['tmp_name'] ?? '';
        if (!is_uploaded_file($tmp)) {
            throw new RuntimeException('Invalid upload.');
        }

        $info = @getimagesize($tmp);
        if ($info === false) {
            throw new RuntimeException('Uploaded file is not a valid image.');
        }

        $mime = $info['mime'] ?? '';
        if (!in_array($mime, self::ALLOWED_MIMES, true)) {
            throw new RuntimeException('Unsupported image format. Use JPG, PNG, WebP or GIF.');
        }

        if (!function_exists('imagewebp')) {
            throw new RuntimeException('Server is missing WebP support (GD imagewebp).');
        }

        $src = $this->loadImage($tmp, $mime);
        try {
            $src = $this->resizeIfNeeded($src);

            $destRel = $this->buildRelativePath($subdir, $slugHint);
            $destAbs = $this->publicRoot() . '/' . $destRel;

            $this->ensureDir(dirname($destAbs));

            if (!imagewebp($src, $destAbs, self::WEBP_QUALITY)) {
                throw new RuntimeException('Failed to write WebP image.');
            }

            return str_replace('\\', '/', $destRel);
        } finally {
            if ($src instanceof \GdImage) {
                imagedestroy($src);
            }
        }
    }

    /**
     * Delete a stored image given its public-relative path. Silently ignores
     * missing files so callers can use it during update/destroy without extra
     * checks.
     */
    public function delete(?string $relativePath): void
    {
        if (!$relativePath) return;
        $abs = $this->publicRoot() . '/' . ltrim($relativePath, '/');
        if (is_file($abs)) {
            @unlink($abs);
        }
    }

    /** Absolute filesystem path to project-root /public. */
    public function publicRoot(): string
    {
        // ROOT_PATH is the admin/ folder; project root is one level up.
        return rtrim(dirname(ROOT_PATH), '/\\') . DIRECTORY_SEPARATOR . 'public';
    }

    // ── internals ────────────────────────────────────────────────────────────

    private function loadImage(string $path, string $mime): \GdImage
    {
        $img = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png'  => @imagecreatefrompng($path),
            'image/webp' => @imagecreatefromwebp($path),
            'image/gif'  => @imagecreatefromgif($path),
            default      => false,
        };
        if (!$img instanceof \GdImage) {
            throw new RuntimeException('Could not decode image.');
        }
        return $img;
    }

    private function resizeIfNeeded(\GdImage $src): \GdImage
    {
        $w = imagesx($src);
        $h = imagesy($src);
        if ($w <= self::MAX_WIDTH) {
            return $src;
        }
        $newW = self::MAX_WIDTH;
        $newH = (int) round($h * ($newW / $w));

        $dst = imagecreatetruecolor($newW, $newH);
        // Preserve transparency for source PNG/WebP/GIF
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
        imagefilledrectangle($dst, 0, 0, $newW, $newH, $transparent);

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);
        imagedestroy($src);
        return $dst;
    }

    private function buildRelativePath(string $subdir, string $slugHint): string
    {
        $subdir = trim($subdir, '/\\');
        $slug   = $this->slug($slugHint);
        $rand   = bin2hex(random_bytes(4));
        $name   = ($slug !== '' ? $slug . '-' : '') . date('Ymd') . '-' . $rand . '.webp';
        return $subdir . '/' . $name;
    }

    private function slug(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        return trim($value, '-');
    }

    private function ensureDir(string $dir): void
    {
        if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new RuntimeException('Could not create upload directory: ' . $dir);
        }
    }

    private function uploadErrorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Image is too large.',
            UPLOAD_ERR_PARTIAL                        => 'Image upload was interrupted.',
            UPLOAD_ERR_NO_TMP_DIR                     => 'Server has no temp folder for uploads.',
            UPLOAD_ERR_CANT_WRITE                     => 'Server failed to write the upload.',
            UPLOAD_ERR_EXTENSION                      => 'A PHP extension blocked the upload.',
            default                                   => 'Image upload failed.',
        };
    }
}
