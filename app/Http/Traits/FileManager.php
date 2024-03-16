<?php

namespace App\Http\Traits;

trait FileManager
{
    /**
     * Validates the file from the request & persists it into storage
     * @param String $requestAttributeName from request
     * @param String $folder
     * @param String $disk
     * @return String $path
     */
    public function upload($requestAttributeName = null, $folder = '', $disk = 'public'): ?string
    {
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid()){
            $path = 'storage/'.request()->file($requestAttributeName)->store($folder, $disk);
        }
        return $path;
    }

    /**
     * Validates the file from the request & persists it into storage then unlink old one
     * @param String $requestAttributeName from request
     * @param String $folder
     * @param String $oldPath
     * @return String $path
     */
    public function updateFile($requestAttributeName = null, $folder = '',$oldPath): ?string
    {
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid()){
            $path = $this->upload($requestAttributeName,$folder);
            if(file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        return $path;
    }


    ########################################### Start upload multiple files ####################################
    public function uploadMultipleFiles(string $requestAttributeName = null, string $folder = '', string $disk = 'public'): array
    {
        $uploadedFiles = [];

        if (request()->hasFile($requestAttributeName) && is_array(request()->file($requestAttributeName)))
        {
            foreach (request()->file($requestAttributeName) as $file)
            {
                if ($file->isValid())
                {
                    $path = 'storage/' . $file->store($folder, $disk);
                    $uploadedFiles[] = $path;
                }
            }
        }

        return $uploadedFiles;
    }

    public function deleteFileMultiple($old): void
    {
        $images = json_decode($old,true);
        if($images != null){
            foreach ($images as $image){
                if(file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }
    }

    ########################################### End upload multiple files ####################################

    /**
     * Delete the file from the path
     * @param String $oldPath
     */

    public function deleteFile($oldPath): void
    {
        if(file_exists($oldPath)) {
            unlink($oldPath);
        }
    }
}
