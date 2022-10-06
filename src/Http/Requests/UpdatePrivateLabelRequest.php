<?php

namespace Mach3builders\PrivateLabel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mach3builders\PrivateLabel\PrivateLabelFacade;

class UpdatePrivateLabelRequest extends FormRequest
{
    public function authorize(): bool
    {
        $owner = PrivateLabelFacade::findOwnerById($this->owner_id);

        // @TODO GATE
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'logo_login_height' => 'nullable|numeric|max:100',
            'logo_app_height' => 'nullable|numeric|max:100',
        ];

        if (! PrivateLabelFacade::findOwnerById($this->owner_id)->privateLabel) {
            $rules['domain'] = 'required|unique:private_labels,domain|string|max:255';
        }

        return $rules;
    }
}
