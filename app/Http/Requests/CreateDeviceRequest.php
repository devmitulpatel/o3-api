<?php

namespace App\Http\Requests;

use App\Models\Device;
use Illuminate\Foundation\Http\FormRequest;

class CreateDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token'      => ['required', 'string', 'max:255', 'unique:devices'],
            'name'       => ['nullable', 'string', 'max:50'],
            'type'       => ['required', 'string', 'max:50'],
            'os_version' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function persist()
    {
        $device = new Device($this->validated());
        $device->user_id = auth()->id();
        $device->save();

        return $device;
    }
}
