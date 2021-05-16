<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name', 'extension', 'mime_type', 'size', 'path', 'tag',
    ];

    protected $hidden = [
        'user_id', 'mediable_id', 'mediable_type',
    ];

    protected $directory;

    public static $secureDirectories = [
        '/secure-folder',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function make($directory, User $user = null)
    {
        $media = new static;

        $media->id = uuid();
        $media->user_id = $user ? $user->id : auth()->id();
        $media->directory = $directory;

        return $media;
    }

    public function tag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    public function model(Model $model)
    {
        $this->mediable_id = $model->id;
        $this->mediable_type = get_class($model);

        return $this;
    }

    public function upload(UploadedFile $file)
    {
        $path = $file->store($this->directory);

        try {
            $this->name = $file->getClientOriginalName();
            $this->extension = $file->getClientOriginalExtension();
            $this->mime_type = $file->getMimeType();
            $this->size = kbFromBytes($file->getSize());
            $this->path = $path;

            $this->save();
        } catch (Exception $exception) {
            Storage::delete($path);

            throw $exception;
        }

        return $this;
    }

    public function getUrlAttribute()
    {
        if ($this->isSecure()) {
            return Storage::temporaryUrl($this->path, now()->addMinutes(30));
        }

        return Storage::url($this->path);
    }

    /**
     * @return bool
     */
    protected function isSecure(): bool
    {
        return config('filesystems.default') === 's3'
            && starts_with($this->path, self::$secureDirectories);
    }

    public function unlink()
    {
        Storage::delete($this->path);
    }

    public function delete()
    {
        $this->unlink();

        return parent::delete();
    }
}
