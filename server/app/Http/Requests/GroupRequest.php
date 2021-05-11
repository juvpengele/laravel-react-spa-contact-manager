<?php

namespace App\Http\Requests;


use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{

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
       $rules = [
           "name" => ["required"]
       ];

       if($this->method() === "POST") {
           $rules["name"][] = function($attribute, $value, $fail) {
               $groupExists =  Group::where(["user_id" => auth()->id(), "name" => $value])->exists();
               if($groupExists) {
                   $fail("The $attribute of the group is already used");
               }
           };
       } else {

           $rules["name"][] = function($attribute, $value, $fail) {
               $groupExists =  Group::where(["user_id" => auth()->id(), "name" => $value])
                   ->where("id", "!=", $this->route("group")->id)
                   ->exists();

               if($groupExists) {
                   $fail("The $attribute of the group is already used");
               }
           };
       }

       return $rules;
    }

    public function getFormAttributes() : array
    {
        return $this->merge(["user_id" => auth()->id()])
                    ->only(["name", "description", "user_id"]);
    }
}
