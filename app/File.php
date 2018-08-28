<?php

namespace App;

use App\Presenters\FilePresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use McCool\LaravelAutoPresenter\HasPresenter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Model implements HasPresenter
{
    protected $guarded = [];

    public static function createFromUploadedFile(UploadedFile $file, $attributes = [])
    {
        $attributes = array_merge([
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize()
        ], $attributes);

        return static::create($attributes);
    }

    public function getUrlAttribute()
    {
        return Storage::disk($this->getAttribute('disk'))
            ->url($this->getAttribute('path'));
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return FilePresenter::class;
    }
}
