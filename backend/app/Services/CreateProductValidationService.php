<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class CreateProductValidationService.
 */
class CreateProductValidationService
{
    public function validateProduct(array $data)
    {
        $validator = validator($data, (new ProductRequest())->rules());

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422));
        }
        return $data;
    }
}
