<?php

namespace App\Abstracts\Admin;

use App\Constants\BoardConstant;
use App\Constants\BoardErrorMessageConstant;
use App\Constants\MenuConstant;
use App\DTOs\Board\BoardBoardDto;
use App\DTOs\Board\BoardEditorDto;
use App\DTOs\Board\BoardProductDto;
use App\Models\BoardBoardData;
use App\Models\BoardCategoryData;
use App\Models\BoardCategoryMapping;
use App\Models\BoardEditorData;
use App\Models\BoardProductData;
use App\Models\BoardReplyData;
use App\Models\NoticeSubData;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

abstract class BoardAbstract
{
    protected array $returnMsg;

    public function __construct()
    {
        $this->returnMsg = helpers_fail_message();
    }

    /**
     * @func list
     * @description '게시판 리스트'
     * @param string $type
     * @param Request $request
     * @return array
     */
    public function list(string $type, Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $groupId    = $request->get("group_id");
            $subIds     = explode(",", $request->get("sub_id"));
            $isShow     = $request->get("is_show", "");
            $searchCls  = $request->get("search_cls", "");
            $keyword    = $request->get("keyword", "");
            $categories = explode(",", $request->get("categories", ""));
            $isReply    = $request->get("is_reply", "");
            $page       = $request->get("page", 1);
            $pageSize   = $request->get("page_size", 20);
            $sortArr    = explode("|", $request->get("sort", "created_at|desc"));

            if( $pageSize > 20 ) $pageSize = 20;

            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                $builder = BoardProductData::where([
                    "group_id" => $groupId,
                ]);

                if( !empty($isShow) ){
                    $builder->where("is_show", $isShow);
                }
            } else if( $type == MenuConstant::SUB_TYPE_BOARD ){
                $builder = BoardBoardData::with(["categories"])->where([
                    "group_id" => $groupId,
                ]);

                if( !empty($isReply) ){
                    $builder->where("is_reply", $isReply);
                }
                if( !empty($categories) ){
                    foreach ($categories as $category) {
                        if( $category ){
                            $builder->whereHas('categories', function ($query) use ($category) {
                                $query->where('board_category_datas.id', $category);
                            });
                        }
                    }
                }
            } else if( $type == MenuConstant::SUB_TYPE_EDITOR ){
                $builder = BoardEditorData::where([
                    "group_id" => $groupId,
                ]);

                if( !empty($isShow) ){
                    $builder->where("is_show", $isShow);
                }
            } else {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("TYPE"));
            }

            $builder->whereIn("sub_id", $subIds);

            if( !empty($keyword) ){
                if( $searchCls == "title"){
                    $builder->where($searchCls, "like", "%" . $keyword . "%");
                } else if( $searchCls == "desc"){
                    $builder->where($searchCls, "like", "%" . $keyword . "%");
                }
            }

            $builder->orderBy($sortArr[0], $sortArr[1]);

            $lists        = $builder->paginate($pageSize, ['*'], 'page', $page);
            $totalRecords = $lists->total();
            $lastPage     = $lists->lastPage();
            $objs         = $lists->items();

            $result = [
                "total_records" => $totalRecords,
                "last_page"     => $lastPage,
                "records"       => $objs,
                "page"          => (int)$page,
                "page_size"     => (int)$pageSize
            ];

            $returnMsg = helpers_success_message($result);
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    /**
     * @func detail
     * @description '게시판 상세'
     * @param string $type
     * @param int $id
     * @return array
     */
    public function detail(string $type, int $id): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $obj = null;

            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                $obj = BoardProductData::with([
                    "admin_user"
                ])->where([
                   "id" => $id,
                ])->first();
            } else if( $type == MenuConstant::SUB_TYPE_BOARD ){
                $obj = BoardBoardData::with([
                    "categories",
                    "admin_user",
                    "replies.admin_user"
                ])->where([
                    "id" => $id,
                ])->first();
            } else if( $type == MenuConstant::SUB_TYPE_EDITOR ){
                $obj = BoardEditorData::with([
                    "admin_user"
                ])->where([
                    "id" => $id,
                ])->first();
            } else {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("TYPE"));
            }

            if( $obj == null ){
                throw new Exception(BoardErrorMessageConstant::getNotHaveErrorMessage("BOARD"));
            }

            $returnMsg = helpers_success_message($obj->toArray());
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    /**
     * @func create
     * @description '게시판 생성'
     * @param string $type
     * @param Request $request
     * @return array
     */
    public function create(string $type, Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $sub_id = $request->post('sub_id');
            $obj    = NoticeSubData::where("id", $sub_id)->first();
            if( $obj == null ){
                throw new Exception(BoardErrorMessageConstant::getNotHaveErrorMessage("SUB_MENU"));
            }
            if( $type != $obj->type ){
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("SUB_TYPE"));
            }

            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                $result = $this->createProduct($request);
            } else if( $type == MenuConstant::SUB_TYPE_BOARD ){
                $result = $this->createBoard($request);
            } else if( $type == MenuConstant::SUB_TYPE_EDITOR ){
                $result = $this->createEditor($request);
            } else {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("TYPE"));
            }

            if( $result["isSuccess"] !== true ){
                throw new Exception($result["msg"]);
            }

            $returnMsg = helpers_success_message($result["data"]);
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    /**
     * @func edit
     * @description '게시판 수정'
     * @param string $type
     * @param int $id
     * @param Request $request
     * @return array
     */
    public function edit(string $type, int $id, Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $sub_id = $request->post('sub_id');
            $obj    = NoticeSubData::where("id", $sub_id)->first();
            if( $obj == null ){
                throw new Exception(BoardErrorMessageConstant::getNotHaveErrorMessage("SUB_MENU"));
            }
            if( $type != $obj->type ){
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("SUB_TYPE"));
            }

            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                $result = $this->editProduct($id, $request);
            } else if( $type == MenuConstant::SUB_TYPE_EDITOR ){
                $result = $this->editEditor($id, $request);
            } else {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("TYPE"));
            }

            if( $result["isSuccess"] !== true ){
                throw new Exception($result["msg"]);
            }

            $returnMsg = helpers_success_message($result["data"]);
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    protected function createProduct(Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $sub_id       = $request->post('sub_id');
            $title        = $request->post('title');
            $is_show      = $request->post('is_show');
            $desc         = $request->post('desc');
            $main_file    = $request->file('main_img');
            $bottom_file1 = $request->file('bottom_img1');
            $bottom_file2 = $request->file("bottom_img2");
            $bottom_file3 = $request->file("bottom_img3");
            $bottom_file4 = $request->file("bottom_img4");
            $bottom_file5 = $request->file("bottom_img5");
            $material     = $request->post('material');
            $size         = $request->post('size');
            $shape        = $request->post('shape');
            $keywords     = $request->post('keywords');

            $obj       = NoticeSubData::where("id", $sub_id)->first();
            $group_id  = $obj->group_id;
            $date_name = Carbon::now()->format("Y/m/d");

            $path            = "board/product/{$date_name}";
            $main_saved_path = saveLocalImage($main_file, $path, "main");
            $main_img        = $main_saved_path;

            $path                    = "board/product/{$date_name}";
            $bottom_file1_saved_path = saveLocalImage($bottom_file1, $path, "bottom1");
            $bottom_img1             = $bottom_file1_saved_path;

            $bottom_img2 = "";
            if ($bottom_file2 && $bottom_file2->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file2_saved_path = saveLocalImage($bottom_file2, $path, "bottom2");
                $bottom_img2             = $bottom_file2_saved_path;
            }

            $bottom_img3 = "";
            if ($bottom_file3 && $bottom_file3->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file3_saved_path = saveLocalImage($bottom_file3, $path, "bottom3");
                $bottom_img3             = $bottom_file3_saved_path;
            }

            $bottom_img4 = "";
            if ($bottom_file4 && $bottom_file4->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file4_saved_path = saveLocalImage($bottom_file4, $path, "bottom4");
                $bottom_img4             = $bottom_file4_saved_path;
            }

            $bottom_img5 = "";
            if ($bottom_file5 && $bottom_file5->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file5_saved_path = saveLocalImage($bottom_file5, $path, "bottom5");
                $bottom_img5             = $bottom_file5_saved_path;
            }

            $bindParam = [
                'group_id'    => $group_id,
                'sub_id'      => $sub_id,
                'title'       => $title,
                'is_show'     => $is_show,
                'desc'        => $desc,
                'main_img'    => $main_img,
                'bottom_img1' => $bottom_img1,
                'bottom_img2' => $bottom_img2,
                'bottom_img3' => $bottom_img3,
                'bottom_img4' => $bottom_img4,
                'bottom_img5' => $bottom_img5,
                'material'    => $material,
                'size'        => $size,
                'shape'       => $shape,
                'keywords'    => $keywords,
            ];

            $boardDto = new BoardProductDto();
            $boardDto->bind($bindParam);

            $obj = BoardProductData::create($boardDto->getAllProperties());
            
            $returnMsg = helpers_success_message($obj->toArray());
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    protected function createEditor(Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $sub_id          = $request->post('sub_id');
            $title           = $request->post('title');
            $is_show         = $request->post('is_show');
            $desc            = $request->post('desc');
            $show_started_at = Carbon::parse($request->post('show_started_at'))->format('Y-m-d');
            $show_ended_at   = Carbon::parse($request->post('show_ended_at'))->format('Y-m-d');
            $image           = $request->file('image');

            $obj       = NoticeSubData::where("id", $sub_id)->first();
            $group_id  = $obj->group_id;
            $date_name = Carbon::now()->format("Y/m/d");

            $path       = "board/editor/{$date_name}";
            $saved_path = saveLocalImage($image, $path);

            $bindParam = [
                'group_id'        => $group_id,
                'sub_id'          => $sub_id,
                'title'           => $title,
                'is_show'         => $is_show,
                'desc'            => $desc,
                'image'           => $saved_path,
                'show_started_at' => $show_started_at,
                'show_ended_at'   => $show_ended_at,
            ];

            $boardDto = new BoardEditorDto();
            $boardDto->bind($bindParam);

            $obj = BoardEditorData::create($boardDto->getAllProperties());
            
            $returnMsg = helpers_success_message($obj->toArray());
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    protected function createBoard(Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $sub_id             = $request->post("sub_id");
            $company            = $request->post("company");
            $title              = $request->post("title");
            $contact_name       = $request->post("contact_name");
            $contact_email      = $request->post("contact_email");
            $contact_phone      = $request->post("contact_phone");
            $password           = $request->post("password");
            $mapping_categories = explode(",", $request->post("mapping_categories"));
            $size               = $request->post("size");
            $purpose            = $request->post("purpose");
            $material           = $request->post("material");
            $shape              = $request->post("shape");
            $quantity           = $request->post("quantity");
            $desc               = $request->post("desc");
            $etc_file           = $request->file("etc_file");

            $cateIds            = BoardCategoryData::whereIn("id", $mapping_categories)->pluck("id")->toArray();
            $mapping_categories = array_map('intval', $mapping_categories);

            sort($cateIds);
            sort($mapping_categories);
            if ($mapping_categories !== $cateIds) {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("CATE_TYPE"));
            }

            $obj       = NoticeSubData::where("id", $sub_id)->first();
            $group_id  = $obj->group_id;
            $date_name = Carbon::now()->format("Y/m/d");

            $path       = "board/board/{$date_name}";
            $saved_path = saveLocalFile($etc_file, $path);

            $bindParam = [
                'group_id'      => $group_id,
                'sub_id'        => $sub_id,
                'company'       => $company,
                'title'         => $title,
                'is_reply'      => BoardConstant::IS_REPLY_N,
                'contact_name'  => $contact_name,
                'contact_email' => $contact_email,
                'contact_phone' => $contact_phone,
                'password'      => $password,
                'size'          => $size,
                'purpose'       => $purpose,
                'material'      => $material,
                'shape'         => $shape,
                'quantity'      => $quantity,
                'desc'          => $desc,
                'etc_file'      => $saved_path,
            ];

            $boardDto = new BoardBoardDto();
            $boardDto->bind($bindParam);

            $obj = BoardBoardData::create($boardDto->getAllProperties());
            foreach ($mapping_categories as $category) {
                BoardCategoryMapping::create([
                    "board_id"    => $obj->id,
                    "category_id" => $category,
                ]);
            }

            $returnMsg = helpers_success_message($obj->toArray());
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    protected function editProduct(int $id, Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $sub_id       = $request->post('sub_id');
            $title        = $request->post('title');
            $is_show      = $request->post('is_show');
            $desc         = $request->post('desc');
            $main_file    = $request->file('main_img');
            $bottom_file1 = $request->file('bottom_img1');
            $bottom_file2 = $request->file("bottom_img2");
            $bottom_file3 = $request->file("bottom_img3");
            $bottom_file4 = $request->file("bottom_img4");
            $bottom_file5 = $request->file("bottom_img5");
            $material     = $request->post('material');
            $size         = $request->post('size');
            $shape        = $request->post('shape');
            $keywords     = $request->post('keywords');

            $boardObj = BoardProductData::where("id", $id)->first();
            if( $boardObj == null ){
                throw new Exception(BoardErrorMessageConstant::getNotHaveErrorMessage("BOARD"));
            }

            $obj       = NoticeSubData::where("id", $sub_id)->first();
            $group_id  = $obj->group_id;
            $date_name = Carbon::now()->format("Y/m/d");

            $path            = "board/product/{$date_name}";
            $main_saved_path = saveLocalImage($main_file, $path, "main");
            $main_img        = $main_saved_path;

            $path                    = "board/product/{$date_name}";
            $bottom_file1_saved_path = saveLocalImage($bottom_file1, $path, "bottom1");
            $bottom_img1             = $bottom_file1_saved_path;

            $bottom_img2 = "";
            if ($bottom_file2 && $bottom_file2->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file2_saved_path = saveLocalImage($bottom_file2, $path, "bottom2");
                $bottom_img2             = $bottom_file2_saved_path;
            }

            $bottom_img3 = "";
            if ($bottom_file3 && $bottom_file3->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file3_saved_path = saveLocalImage($bottom_file3, $path, "bottom3");
                $bottom_img3             = $bottom_file3_saved_path;
            }

            $bottom_img4 = "";
            if ($bottom_file4 && $bottom_file4->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file4_saved_path = saveLocalImage($bottom_file4, $path, "bottom4");
                $bottom_img4             = $bottom_file4_saved_path;
            }

            $bottom_img5 = "";
            if ($bottom_file5 && $bottom_file5->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file5_saved_path = saveLocalImage($bottom_file5, $path, "bottom5");
                $bottom_img5             = $bottom_file5_saved_path;
            }

            $bindParam = [
                'group_id'    => $group_id,
                'sub_id'      => $sub_id,
                'title'       => $title,
                'is_show'     => $is_show,
                'desc'        => $desc,
                'main_img'    => $main_img,
                'bottom_img1' => $bottom_img1,
                'bottom_img2' => $bottom_img2,
                'bottom_img3' => $bottom_img3,
                'bottom_img4' => $bottom_img4,
                'bottom_img5' => $bottom_img5,
                'material'    => $material,
                'size'        => $size,
                'shape'       => $shape,
                'keywords'    => $keywords,
            ];

            $boardDto = new BoardProductDto();
            $boardDto->bind($bindParam);

            $boardObj->update($boardDto->getAllProperties());
            
            $returnMsg = helpers_success_message($boardObj->toArray());
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        if( $returnMsg["isSuccess"] === true ){
            deleteLocalFile($boardObj->main_img);
            deleteLocalFile($boardObj->bottom_img1);
            if ($boardObj->bottom_img2) {
                deleteLocalFile($boardObj->bottom_img2);
            }
            if ($boardObj->bottom_img3) {
                deleteLocalFile($boardObj->bottom_img3);
            }
            if ($boardObj->bottom_img4) {
                deleteLocalFile($boardObj->bottom_img4);
            }
            if ($boardObj->bottom_img5) {
                deleteLocalFile($boardObj->bottom_img5);
            }
        }

        return $returnMsg;
    }

    protected function editEditor(int $id, Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $sub_id          = $request->post('sub_id');
            $title           = $request->post('title');
            $is_show         = $request->post('is_show');
            $desc            = $request->post('desc');
            $show_started_at = Carbon::parse($request->post('show_started_at'))->format('Y-m-d');
            $show_ended_at   = Carbon::parse($request->post('show_ended_at'))->format('Y-m-d');
            $image           = $request->file('image');

            $boardObj = BoardEditorData::where("id", $id)->first();
            if( $boardObj == null ){
                throw new Exception(BoardErrorMessageConstant::getNotHaveErrorMessage("BOARD"));
            }

            $obj       = NoticeSubData::where("id", $sub_id)->first();
            $group_id  = $obj->group_id;
            $date_name = Carbon::now()->format("Y/m/d");

            $path       = "board/editor/{$date_name}";
            $saved_path = saveLocalImage($image, $path);

            $bindParam = [
                'group_id'        => $group_id,
                'sub_id'          => $sub_id,
                'title'           => $title,
                'is_show'         => $is_show,
                'desc'            => $desc,
                'image'           => $saved_path,
                'show_started_at' => $show_started_at,
                'show_ended_at'   => $show_ended_at,
            ];

            $boardDto = new BoardEditorDto();
            $boardDto->bind($bindParam);

            $boardObj->update($boardDto->getAllProperties());

            $returnMsg = helpers_success_message($boardObj->toArray());
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        if( $returnMsg["isSuccess"] === true ){
            deleteLocalFile($boardObj->image);
        }

        return $returnMsg;
    }

    public function reply(int $id, Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $replyType = $request->post('reply_type');
            $desc      = $request->post('desc');

            $boardObj = BoardBoardData::where("id", $id)->first();
            if( $boardObj == null ){
                throw new Exception(BoardErrorMessageConstant::getNotHaveErrorMessage("BOARD"));
            }

            $insertParam = [
                'board_id'   => $id,
                'user_id'    => session("admin_user")->sub->user->user_id,
                'reply_type' => $replyType,
                'desc'       => $desc,
            ];
            $replyObj = BoardReplyData::create($insertParam);
            $boardObj->update([
                "is_reply" => BoardConstant::IS_REPLY_Y
            ]);

            $returnMsg = helpers_success_message($replyObj->toArray());
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    /**
     * @func delete
     * @description '게시판 삭제'
     * @param string $type
     * @param int $id
     * @return array
     */
    public function delete(string $type, int $id): array
    {
        $returnMsg = $this->returnMsg;

        try {
            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                BoardProductData::where([
                   "id" => $id,
                ])->delete();
            } else if( $type == MenuConstant::SUB_TYPE_BOARD ){
                BoardBoardData::where([
                    "id" => $id,
                ])->delete();
            } else if( $type == MenuConstant::SUB_TYPE_EDITOR ){
                BoardEditorData::where([
                    "id" => $id,
                ])->delete();
            } else {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("TYPE"));
            }

            $returnMsg = helpers_success_message();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }
}
