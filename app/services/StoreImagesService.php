<?php

namespace App\services;

use Illuminate\Support\Facades\Storage;

class StoreImagesService
{

    /**
     * Store files
     *
     * @param array $files, array $folder
     * @return array $paths|null
     */
    public function uploadManyFiles($files, $folder)
    { 
        try {
            $paths = [];
            foreach ($files as $image) {      
                $paths[] = is_object($image) ? $image->store($folder, 'public') : $image;
            }
            return $paths;  
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Delete files
     *
     * @param array $files
     * @return array $files|null
     */
    public function deleteManyFiles($files)
    {
        try { 
            foreach ($files as $path) { 
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            return $files;
        } catch (\Exception $e) {
            return null;
        }
    }
}
