<?php

namespace Modules\Banner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'url' => 'required|max:500|min:1',
            'status' => 'required|numeric|in:0,1',
            'position' => 'required|numeric',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif',
        ];
        if (!$this->isMethod('post')) {
            $rules['image'] = 'mimes:png,jpg,jpeg,gif';
        }
        return $rules;
    }

    public function uploadImage()
    {
        $image = $this->file('image');
        if(in_array($image->extension(), ['jpeg', 'jpg', 'png', 'gif'])) {
            dd(1);
        }
    }
}
