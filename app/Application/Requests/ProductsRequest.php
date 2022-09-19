<?php

namespace App\Application\Requests;

use App\Domain\Products\DataTransferObjects\FilterParamsDTO;
use App\Domain\Products\Enums\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'category' => new Enum(Category::class),
            'price' => 'integer',
        ];
    }

    public function filterParams(): FilterParamsDTO
    {
        $filterParamsDTO = new FilterParamsDTO();
        $validated_fields = (array) $this->validated();

        foreach ($validated_fields as $field => $value) {
            if (property_exists($filterParamsDTO, $field)) {
                $filterParamsDTO->$field = $value;
            }
        }

        return $filterParamsDTO;
    }

    /**
     * Customize the response when validation fails
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 0, 'errors' => $validator->errors()->toArray()
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
