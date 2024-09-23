<?php

namespace App\Validators;

use App\Constants\BoardErrorMessageConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class BoardProductListValidator
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $validator = Validator::make($this->request->all(), [
            'group_id'  => 'required|int',
            'sub_id'    => 'required|string',
            'page'      => 'required|int',
            'page_size' => 'required|int',
            'sort'      => 'required|string',
        ], [
            'group_id.required'  => BoardErrorMessageConstant::getNotHaveErrorMessage("GROUP_ID"),
            'sub_id.required'    => BoardErrorMessageConstant::getNotHaveErrorMessage("SUB_ID"),
            'page.required'      => BoardErrorMessageConstant::getNotHaveErrorMessage("PAGE"),
            'page_size.required' => BoardErrorMessageConstant::getNotHaveErrorMessage("PAGE_SIZE"),
            'sort.required'      => BoardErrorMessageConstant::getNotHaveErrorMessage("SORT"),
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }
}
