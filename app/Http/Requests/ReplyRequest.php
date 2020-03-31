<?php

namespace App\Http\Requests;


class ReplyRequest extends Request
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method())
        {
            case 'PUT':
            case 'POST':
            case 'PATCH':
            {
                return [
                    'body'=> 'required',
                ];
            }
        }
    }
}
