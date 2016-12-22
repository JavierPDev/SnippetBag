<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SnippetWriteRequest extends FormRequest
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
      // Edit
      if ($this->id)
      {
        // TODO: Add OR isAdmin check
        if (Auth::id() !== $this->id)
        {
          return false;
        }
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
          'title'=>'required|max:50',
          'description'=>'max:150',
          'file'=>'max:120',
          'text'=>'max:25000'
        ];
    }
}
