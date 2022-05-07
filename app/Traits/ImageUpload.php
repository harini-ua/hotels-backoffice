<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUpload
{
    /**
     * Update image
     *
     * @param UploadedFile|UploadedFile[]|null $imageUpload
     * @return bool
     */
    public function updateDefaultImage($imageUpload, $field, $current)
    {
        $updated = false;

        if ($imageUpload) {
            if (Storage::exists($this::IMAGE_DIRECTORY.$current)) {
                Storage::delete($this::IMAGE_DIRECTORY.$current);
            }

            $path = storage_path('app/').$this::IMAGE_DIRECTORY;
            $fileName = $field.'.'.$imageUpload->extension();

            $imageUpload->move($path, $fileName);
            $updated = $this->update([ $field => $fileName ]);
        }

        return $updated;
    }

    /**
     * Delete image
     *
     * @param string $filename
     */
    public function deleteDefaultImage($filename)
    {
        if (Storage::exists($this::IMAGE_DIRECTORY.$filename)) {
            Storage::delete($this::IMAGE_DIRECTORY.$filename);
        }
    }
}
