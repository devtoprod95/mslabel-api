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

        $main_img = $this->request->file('main_img');
        if (strpos($main_img->getClientMimeType(), 'image') !== 0) {
            throw new Exception("main_img: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_TYPE"));
        }
        // 파일 크기 검증 (2MB 이하)
        if ($main_img->getSize() > 2 * 1024 * 1024) {
            throw new Exception("main_img: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_SIZE_2MB"));
        }
        // 이미지 크기 검증 (606x606)
        list($width, $height) = getimagesize($main_img->getPathname());
        if ($width > 606 || $height > 606) {
            throw new Exception("main_img: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_606_606"));
        }

        $bottom_img1 = $this->request->file('bottom_img1');
        if (strpos($bottom_img1->getClientMimeType(), 'image') !== 0) {
            throw new Exception("bottom_img1: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_TYPE"));
        }
        // 파일 크기 검증 (5MB 이하)
        if ($bottom_img1->getSize() > 5 * 1024 * 1024) {
            throw new Exception("bottom_img1: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_SIZE_5MB"));
        }
        // 이미지 크기 검증 (606x606)
        list($width, $height) = getimagesize($bottom_img1->getPathname());
        if ($width > 606 || $height > 606) {
            throw new Exception("bottom_img1: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_606_606"));
        }

        $bottom_img2 = $this->request->file('bottom_img2');
        if ($bottom_img2 && $bottom_img2->isValid()) {
            if (strpos($bottom_img2->getClientMimeType(), 'image') !== 0) {
                throw new Exception("bottom_img2: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_TYPE"));
            }
            // 파일 크기 검증 (5MB 이하)
            if ($bottom_img2->getSize() > 5 * 1024 * 1024) {
                throw new Exception("bottom_img2: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_SIZE_5MB"));
            }
            // 이미지 크기 검증 (606x606)
            list($width, $height) = getimagesize($bottom_img2->getPathname());
            if ($width > 606 || $height > 606) {
                throw new Exception("bottom_img2: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_606_606"));
            }
        }

        $bottom_img3 = $this->request->file('bottom_img3');
        if ($bottom_img3 && $bottom_img3->isValid()) {
            if (strpos($bottom_img3->getClientMimeType(), 'image') !== 0) {
                throw new Exception("bottom_img3: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_TYPE"));
            }
            // 파일 크기 검증 (5MB 이하)
            if ($bottom_img3->getSize() > 5 * 1024 * 1024) {
                throw new Exception("bottom_img3: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_SIZE_5MB"));
            }
            // 이미지 크기 검증 (606x606)
            list($width, $height) = getimagesize($bottom_img3->getPathname());
            if ($width > 606 || $height > 606) {
                throw new Exception("bottom_img3: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_606_606"));
            }
        }

        $bottom_img4 = $this->request->file('bottom_img4');
        if ($bottom_img4 && $bottom_img4->isValid()) {
            if (strpos($bottom_img4->getClientMimeType(), 'image') !== 0) {
                throw new Exception("bottom_img4: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_TYPE"));
            }
            // 파일 크기 검증 (5MB 이하)
            if ($bottom_img4->getSize() > 5 * 1024 * 1024) {
                throw new Exception("bottom_img4: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_SIZE_5MB"));
            }
            // 이미지 크기 검증 (606x606)
            list($width, $height) = getimagesize($bottom_img4->getPathname());
            if ($width > 606 || $height > 606) {
                throw new Exception("bottom_img4: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_606_606"));
            }
        }

        $bottom_img5 = $this->request->file('bottom_img5');
        if ($bottom_img5 && $bottom_img5->isValid()) {
            if (strpos($bottom_img5->getClientMimeType(), 'image') !== 0) {
                throw new Exception("bottom_img5: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_TYPE"));
            }
            // 파일 크기 검증 (5MB 이하)
            if ($bottom_img5->getSize() > 5 * 1024 * 1024) {
                throw new Exception("bottom_img5: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_SIZE_5MB"));
            }
            // 이미지 크기 검증 (606x606)
            list($width, $height) = getimagesize($bottom_img5->getPathname());
            if ($width > 606 || $height > 606) {
                throw new Exception("bottom_img5: " . BoardErrorMessageConstant::getFitErrorMessage("IMG_606_606"));
            }
        }
    }
}
