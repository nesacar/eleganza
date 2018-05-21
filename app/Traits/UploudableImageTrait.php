<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Str;

trait UploudableImageTrait{

    protected $folder = 'uploads/';

    protected $_relations = [
        'Product' => 'photo',
        'Post' => 'gallery',
        'Brand' => 'slider',
    ];

    public function storeImage( $fieldName = 'image', $attributeName = 'image') {
        if($image = request()->file($fieldName)) {
            if($this->$attributeName) File::delete($this->$attributeName);
            $className = (new \ReflectionClass($this))->getShortName();
            return 'storage/' . request()->file($fieldName)->storeAs(
                $this->getFolderName($this->folder . Str::lower(str_plural($className, 2)) . '/'),
                $this->getFileName($image),
                'public'
                );
        }
        return $this->image;
    }

    protected function getFolderName($path){
        return $path . Carbon::now()->format('m-Y');
    }

    protected function getFileName($image){
        $res = '';
        if(isset($this->title)) {
            $res .= str_slug($this->title) . '-';
        }elseif(isset($this->name)){
            $res .= str_slug($this->name) . '-';
        }
        return $res . $this->id . '-' . str_random(2) . '.' .  $image->getClientOriginalExtension();
    }

    public function storeGallery($fieldName = 'file', $attributeName = 'file_path', $aditional = 'galleries') {
        if($image = request()->file($fieldName)) {
            if($this->$attributeName) File::delete($this->$attributeName);
            $className = (new \ReflectionClass($this))->getShortName();
            $fileName = $this->getFileName($image);
            $filePath = 'storage/' . request()->file($fieldName)->storeAs(
                    $this->folder . Str::lower(str_plural($className, 2)) . '/' . $aditional . '/' . $this->slug . '-' . $this->id,
                    $fileName,
                    'public'
                );

            $reflection = new \ReflectionClass($this);
            $string = (string) $this->_relations[$reflection->getShortName()];
            $className = get_class($this->$string()->getRelated());

            $this->$string()->save(new $className([
                'file_name' => $fileName,
                'file_path' => $filePath,
                'publish' => 1
            ]));

            return 'done';

        }
        return '';
    }

    protected function getGalleryFolderName($path){
        return $path . Carbon::now()->format('m-Y');
    }

}