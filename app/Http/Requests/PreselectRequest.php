<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class PreselectRequest extends FormRequest {

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      //
    ];
  }

}