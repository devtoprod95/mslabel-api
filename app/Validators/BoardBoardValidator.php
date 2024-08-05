<?php

namespace App\Validators;

use App\Constants\BoardErrorMessageConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class BoardBoardValidator
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $validator = Validator::make($this->request->all(), [
            'sub_id'             => 'required|int',
            'company'            => 'required|string',
            'title'              => 'required|string',
            'contact_name'       => 'required|string',
            'contact_email'      => 'required|email',
            'contact_phone'      => 'required|string',
            'password'           => 'required|string',
            'mapping_categories' => 'required|string',
            'size'               => 'required|string',
            'purpose'            => 'required|string',
            'material'           => 'required|string',
            'shape'              => 'required|string',
            'quantity'           => 'required|string',
            'desc'               => 'required|string',
            'etc_file'           => 'required|file',
        ], [
            'sub_id.required'             => BoardErrorMessageConstant::getNotHaveErrorMessage("SUB_ID"),
            'company.required'            => BoardErrorMessageConstant::getNotHaveErrorMessage("COMPANY"),
            'contact_name.required'       => BoardErrorMessageConstant::getNotHaveErrorMessage("CONTACT_NAME"),
            'contact_email.required'      => BoardErrorMessageConstant::getNotHaveErrorMessage("CONTACT_EMAIL"),
            'contact_phone.required'      => BoardErrorMessageConstant::getNotHaveErrorMessage("CONTACT_PHONE"),
            'title.required'              => BoardErrorMessageConstant::getNotHaveErrorMessage("TITLE"),
            'password.required'           => BoardErrorMessageConstant::getNotHaveErrorMessage("PASSWORD"),
            'mapping_categories.required' => BoardErrorMessageConstant::getNotHaveErrorMessage("MAPPING_CATEGORIES"),
            'size.required'               => BoardErrorMessageConstant::getNotHaveErrorMessage("SIZE"),
            'purpose.required'            => BoardErrorMessageConstant::getNotHaveErrorMessage("PURPOSE"),
            'material.required'           => BoardErrorMessageConstant::getNotHaveErrorMessage("MATERIAL"),
            'shape.required'              => BoardErrorMessageConstant::getNotHaveErrorMessage("SHAPE"),
            'quantity.required'           => BoardErrorMessageConstant::getNotHaveErrorMessage("QUANTITY"),
            'desc.required'               => BoardErrorMessageConstant::getNotHaveErrorMessage("DESC"),
            'etc_file.required'           => BoardErrorMessageConstant::getNotHaveErrorMessage("ETC_FILE"),
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $etc_file = $this->request->file('etc_file');
        // 파일 크기 검증 (5MB 이하)
        if ($etc_file->getSize() > 5 * 1024 * 1024) {
            throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("FILE_SIZE_5MB"));
        }  
    }
}
