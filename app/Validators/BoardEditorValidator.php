<?php

namespace App\Validators;

use App\Constants\BoardErrorMessageConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class BoardEditorValidator
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $validator = Validator::make($this->request->all(), [
            'sub_id'          => 'required|int',
            'title'           => 'required|string',
            'is_show'         => 'required|string',
            'show_started_at' => 'required|date',
            'show_ended_at'   => 'required|date',
            'desc'            => 'required|string',
            'image'           => 'required|file',
        ], [
            'sub_id.required'          => BoardErrorMessageConstant::getNotHaveErrorMessage("SUB_ID"),
            'title.required'           => BoardErrorMessageConstant::getNotHaveErrorMessage("TITLE"),
            'is_show.required'         => BoardErrorMessageConstant::getNotHaveErrorMessage("IS_SHOW"),
            'show_started_at.required' => BoardErrorMessageConstant::getNotHaveErrorMessage("SHOW_STARTED_AT"),
            'show_ended_at.required'   => BoardErrorMessageConstant::getNotHaveErrorMessage("SHOW_ENDED_AT"),
            'desc.required'            => BoardErrorMessageConstant::getNotHaveErrorMessage("DESC"),
            'image.required'           => BoardErrorMessageConstant::getNotHaveErrorMessage("IMAGE"),
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $image = $this->request->file('image');
        if (strpos($image->getClientMimeType(), 'image') !== 0) {
            throw new Exception("image: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_TYPE"));
        }
        // 파일 크기 검증 (2MB 이하)
        if ($image->getSize() > 2 * 1024 * 1024) {
            throw new Exception("image: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_SIZE_2MB"));
        }
        // 이미지 크기 검증 (600x600)
        list($width, $height) = getimagesize($image->getPathname());
        if ($width > 600 || $height > 600) {
            throw new Exception("image: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_600_600"));
        }
    }
}
