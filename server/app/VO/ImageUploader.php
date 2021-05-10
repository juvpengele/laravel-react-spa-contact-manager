<?php


namespace App\VO;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploader
{
    protected static $requestKey = "image";
    protected $model;
    protected string $disk;

    public static function generateName($length = 10, $requestKey = null) : string
    {
        return Str::random($length) . "." . request()->file($requestKey ?? static::$requestKey)->getClientOriginalExtension();
    }

    public function __construct(Model $model, $disk = "public")
    {
        $this->model = $model;
        $this->disk = $disk;
    }

    public function save(UploadedFile $uploadedFile, string $imageName, $path = "") : void
    {
        $uploadedFile->storeAs($path, $imageName, [
            "disk" => $this->disk
        ]);
    }

    public function __get($key)
    {
        $method = "get" . ucfirst($key) . "Attribute";

        if(method_exists($this, $method)) {
            return $this->$method($key);
        }

        return null;
    }

    public function getUrlAttribute($key) : string
    {
        return Storage::disk($this->disk)->url($this->model->image_name);
    }
}
