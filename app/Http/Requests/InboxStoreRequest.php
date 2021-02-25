<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class InboxStoreRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'to'      => 'required',
      'subject' => 'required',
      'body'    => 'required'
    ];
  }

  protected function formatErrors (Validator $validator)
  {
      return ['message' => $validator->errors()->first()];
  }

}