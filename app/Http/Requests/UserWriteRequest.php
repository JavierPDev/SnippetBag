<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserWriteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      if (!Auth::user())
      {
        return false;
      }
      if ($this->id && (Auth::id() !== $this->id) && !Auth::user()->is_admin)
      {
        return false;
      }

      return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name'=>'required|max:50',
          'email'=>'required|email|max:150',
        ];
    }
}
