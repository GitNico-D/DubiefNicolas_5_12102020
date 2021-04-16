<?php

namespace App\Services;

use App\Services\FileUploader;

class RequestVerification 
{

    protected $fileUploader;

    /**
     * 
     * @param FileUploader $fileUploader
     */
    public function __construct(FileUploader $fileUploader) 
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * Check the POST request content to determinate if data is FormData type or Json type
     * @param $request
     * @param $configuration
     */
    public function checkAddContent($request, $configuration)
    {
        if($request->getContent()) {
            $jsonRequest = $request->getContent();
        } else {
            $jsonRequest = json_encode($this->specificException($request->request->all()));
        }
        return $jsonRequest;
    }

    /**
     * Check the PUT request content to determinate if data is FormData type or Json type
     * And delete the entity's image File to replace by the new one if needed
     * @param $entity
     * @param $request
     * @param $configuration
     */
    public function checkUpdateContent($entity, $request, $configuration) 
    {
        if ($request->getContent()) {
            $requestArray = json_decode($request->getContent(), true);
            foreach ($requestArray as $key => $value) {
                if ($value == null) {
                    $getImage = 'get' . ucfirst($key);
                    $requestArray[$key] = $entity->$getImage();
                }
            }
            $jsonRequest = json_encode($requestArray);
        } else {
            $jsonRequest = json_encode($this->specificException($request->request->all()));
            if ($request->files) {
                $this->fileUploader->deleteFile($entity, $configuration->getName());
                $uploadFile = $this->fileUploader->getUploadFile($request->files, $configuration->getName());
                $this->fileUploader->setUploadFile($uploadFile, $entity, $configuration);
            }
        }
        return $jsonRequest;
    }

    /**
     * Specific project function to convert string receive by FormData into 
     * integer.
     * @param $requestContent
     */
    public function specificException($requestContent)
    {
        foreach ($requestContent as $key => $value) {
            if ($key == 'knowledgeLevel') {
                $requestContent[$key] = (int)$value;
            } elseif ($key == 'knowledge_level') {
                $requestContent[$key] = (int)$value;
            } elseif ($key == 'category') {
                $requestContent[$key] = (int)$value;
            } elseif ($key == 'presentation') {
                $requestContent[$key] = (int)$value;
            } elseif ($key == 'masteryOf') {
                $requestContent[$key] = (int)$value;
            }
        }
        return $requestContent;
    }
}