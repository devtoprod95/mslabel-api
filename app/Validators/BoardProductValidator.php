<?php

namespace App\Validators;

use App\Constants\BoardErrorMessageConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class BoardProductValidator
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $validator = Validator::make($this->request->all(), [
            'group_id'    => 'required|int',
            'sub_id'      => 'required|int',
            'title'       => 'required|string',
            'is_show'     => 'required|string',
            'desc'        => 'required|string',
            'main_img'    => 'required|file',
            'bottom_img1' => 'required|file',
            'material'    => 'required|string',
            'size'        => 'required|string',
            'shape'       => 'required|string',
            'keywords'    => 'required|string',
        ], [

            'group_id.required'    => BoardErrorMessageConstant::getNotHaveErrorMessage("GROUP_ID"),
            'sub_id.required'      => BoardErrorMessageConstant::getNotHaveErrorMessage("SUB_ID"),
            'title.required'       => BoardErrorMessageConstant::getNotHaveErrorMessage("TITLE"),
            'is_show.required'     => BoardErrorMessageConstant::getNotHaveErrorMessage("IS_SHOW"),
            'desc.required'        => BoardErrorMessageConstant::getNotHaveErrorMessage("DESC"),
            'main_img.required'    => BoardErrorMessageConstant::getNotHaveErrorMessage("MAIN_IMG"),
            'bottom_img1.required' => BoardErrorMessageConstant::getNotHaveErrorMessage("BOTTOM_IMG1"),
            'material.required'    => BoardErrorMessageConstant::getNotHaveErrorMessage("MATERIAL"),
            'size.required'        => BoardErrorMessageConstant::getNotHaveErrorMessage("SIZE"),
            'shape.required'       => BoardErrorMessageConstant::getNotHaveErrorMessage("SHAPE"),
            'keywords.required'    => BoardErrorMessageConstant::getNotHaveErrorMessage("KEYWORDS"),
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }
}
