<?php
namespace App\Http\Requests\Admin;

use App\Sponsor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSponsorsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Sponsor::updateValidation($this);
    }
}
