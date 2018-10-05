<?php
/**
 * Created by PhpStorm.
 * User: sile
 * Date: 26.9.18.
 * Time: 01.20
 */

namespace App\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait UploadableImageTrait
{
    /**
     * Define folder path for uploaded images.
     *
     * @var string
     */
    protected $folder = 'upload/';

    /**
     * Method for storing image.
     *
     * @param string $fieldName
     * @param string $attributeName
     * @return string
     * @throws \ReflectionException
     */
    public function storeImage($fieldName = 'image', $attributeName = 'image') {

        if ($image = request()->file($fieldName)) {

            if ($this->$attributeName) File::delete($this->$attributeName);

            return 'storage/' . request()->file($fieldName)->storeAs(
                    $this->getFolderName(),
                    $this->getFileName($image),
                    'public'
                );
        }
        return $this->$attributeName;
    }

    /**
     * Get folder path based on current($this) object class name.
     *
     * @return string
     * @throws \ReflectionException
     */
    protected function getFolderName()
    {
        // // Get this class name which will be used as folder name to store image
        $className = (new \ReflectionClass($this))->getShortName();

        // Get path to folder name, example: 'upload/posts/'
        $path = $this->folder . Str::lower(str_plural($className, 2)) . '/';

        // Return actual path, example: "upload/posts/may-2018"
        return $path . Carbon::now()->format('m-Y');
    }

    /**
     * Generate filename with random string.
     *
     * @param $image
     * @return string
     */
    protected function getFileName($image){
        $res = '';
        if (isset($this->title)) {
            $res .= str_slug($this->title) . '-';
        } elseif (isset($this->name)){
            $res .= str_slug($this->name) . '-';
        }
        return $res . Carbon::now()->timestamp . '-' . str_random(2) . '.' .  $image->getClientOriginalExtension();
    }
}