<?php

namespace App\Traits;

use App\Models\Admin\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Documentable
{
    protected $folderName = '';

    protected $docLocation = '';

    protected $trashLocation = '';

    protected $tenant = '';

    protected $transFolder = '';

    protected $parentFolder = 'documents';

    protected $documentableType = '';

    protected $now = '';

    // model part
    public static function bootDocumentable()
    {
        static::saved(function ($model) {
            if (isset($model->id)) {
                if (isset(request()->documents) && is_array(request()->documents) && ! empty(request()->documents)) {

                    $model->uploadDocs(request()->documents, $model);

                }/*elseif(isset(request()->bulkItems) && is_array(request()->bulkItems) && ! empty(request()->bulkItems)){
                    foreach (request()->bulkItems as $key => $item) {
                        if (  isset($item['documents']) && is_array($item['documents']) && ! empty($item['documents'])) {
                            $model->uploadDocs($item['documents'], $model);
                        }

                    }
                }*/

            }
        });

        static::deleted(function ($model) {
            $model->trashDoc($model);
        });
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function initDocumentable($model)
    {
        $this->now = now();
        $this->setFolderNameByModel($model);
        $this->setDocLocation();
        $this->setTrashLocation();
        $this->documentableType = get_class($model);
    }

    public function uploadDocs($files, $model)
    {
        if (! is_array($files) || empty($files)) {
            return;
        }
        if (! is_object($model)) {
            return;
        }
        $this->initDocumentable($model);
        foreach ($files as $key => $file) {
            if (! is_object($file)) {
                continue;
            }

            $type = $file->getClientMimeType();
            $extension = $file->extension();
            $size = $file->getSize();

            $name = $model->transaction_id.'_'.time().'_'.$key.'.'.$file->extension();
            $path = $file->storeAs($this->docLocation, $name);
            $code = $this->folderName.'_'.time().'_'.$key.'_'.rand(99, 9999);

            $doc = [
                'documentable_id' => $model->id,
                'documentable_type' => $this->documentableType,
                'name' => $name,
                'type' => $type,
                'doc_code' => $code,
                'size' => $size,
                'extension' => $extension,
                'month' => $this->now->format('m'),
                'year' => $this->now->year,
                'url' => ' not required ',
                'image_path' => $path,
            ];
            Document::create($doc);
        }

    }

    public function trashDoc($model)
    {
        $this->initDocumentable($model);
        $documents = Document::where('documentable_id', $model->id)
            ->where('documentable_type', $this->documentableType)
            ->get();

        // dd($documents);
        if (! is_null($documents) && ! empty($documents)) {
            foreach ($documents as $key => $doc) {
                if (! Storage::exists($doc->image_path)) {
                    continue;
                }

                $fileName = pathinfo($doc->image_path, PATHINFO_FILENAME).'.'.pathinfo($doc->image_path, PATHINFO_EXTENSION);
                // dd($fileName);
                $trashLocation = $this->trashLocation.DIRECTORY_SEPARATOR.$fileName;
                Storage::move($doc->image_path, $trashLocation);
                $doc->delete();
            }
        }
    }

    private function setDocLocation()
    {
        $this->docLocation = $this->parentFolder.DIRECTORY_SEPARATOR.'docs'.DIRECTORY_SEPARATOR.$this->folderName.DIRECTORY_SEPARATOR.$this->now->year.DIRECTORY_SEPARATOR.$this->now->format('m');
    }

    private function setTrashLocation()
    {

        $this->trashLocation = $this->parentFolder.DIRECTORY_SEPARATOR.'trash'.DIRECTORY_SEPARATOR.$this->folderName.DIRECTORY_SEPARATOR.$this->now->year.DIRECTORY_SEPARATOR.$this->now->format('m');
    }

    /*private function getModelName($model){
        $nameSpace = (explode('\\', get_class($this)));
        return $nameSpace[count($nameSpace)-1];
    }*/

    private function setFolderNameByModel($modelObject)
    {
        $nameSpace = (explode('\\', get_class($modelObject)));
        $folderName = strtolower($nameSpace[count($nameSpace) - 1]);
        $this->folderName = Str::plural($folderName);
    }
}
