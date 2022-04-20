<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUpload
{
    /**
     * @param UploadedFile|UploadedFile[]|null $imageUpload
     * @return bool
     */
    public function saveImage($imageUpload)
    {
        $saved = false;

        if($imageUpload) {
            if (is_array($imageUpload)) {
                foreach ($imageUpload as $field => $image) {
                    if (!$image) {
                        break;
                    }
                    $path = storage_path('app/').$this::IMAGE_DIRECTORY;
                    $fileName = $image->hashName();

                    $image->move($path, $fileName);

                    $saved = $this->update([ $field => $fileName ]);
                }
            } else {
                $path = storage_path('app/').$this::IMAGE_DIRECTORY;
                $fileName = $imageUpload->hashName();

                $imageUpload->move($path, $fileName);

                $saved = $this->update(['image' => $fileName]);
            }
        }

        return $saved;
    }

    /**
     * Update image
     *
     * @param UploadedFile|UploadedFile[]|null $imageUpload
     * @return bool
     */
    public function updateImage($imageUpload, $field = 'image')
    {
        $updated = false;

        // Upload new file
        if ($imageUpload) {
            // Delete old image

            if (Storage::exists($this::IMAGE_DIRECTORY.$this->$field)) {
                Storage::delete($this::IMAGE_DIRECTORY.$this->$field);
            }

            // Upload new image
            $path = storage_path('app/').$this::IMAGE_DIRECTORY;

            $fileName = $imageUpload->hashName();

            $imageUpload->move($path, $fileName);

            $updated = $this->update([ $field => $fileName ]);
        }

        return $updated;
    }
}
