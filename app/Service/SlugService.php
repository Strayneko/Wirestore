<?php

namespace App\Service;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class SlugService {

    /**
     * Generate unique slug based on product name
     * @param string|null $productName
     * @return string|null
     */
    public function generateSlug(?string $string, $model): ?string
    {
        $stringInvalid = is_null($string) || (!is_null($string) && strlen($string) === 0);
        if($stringInvalid) return null;

        return \Cviebrock\EloquentSluggable\Services\SlugService::createSlug($model, 'slug', $string, ['unique' => true]);
    }

}
