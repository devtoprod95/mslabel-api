<?php

namespace App\Services\v1;

use App\Abstracts\MenuAbstract;
use App\Constants\MenuErrorMessageConstant;
use App\Models\NoticeGroupData;
use App\Models\NoticeSubData;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class MenuV1 extends MenuAbstract
{
    private array $returnMsg;

    public function __construct()
    {
        $this->returnMsg = helpers_fail_message();
    }

    public function mainList(): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $result = [];

            $objs = NoticeGroupData::with(["sub_menus"])->orderBy("rank", "asc")->get();
            foreach ($objs as $obj) {
                $subMenus = [];
                foreach ($obj->sub_menus as $subObj) {
                    $subMenus[] = [
                        "id"    => $subObj->id,
                        "title" => $subObj->title,
                        "type"  => $subObj->type,
                        "rank"  => $subObj->rank,
                    ];
                }
                $result[] = [
                    "id"        => $obj->id,
                    "title"     => $obj->title,
                    "rank"      => $obj->rank,
                    "sub_menus" => $subMenus
                ];
            }

            $returnMsg = helpers_success_message($result);
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    public function mainEdit(array $params): array
    {
        $returnMsg = $this->returnMsg;

        try {
            DB::beginTransaction();

            $id    = $params["id"];
            $title = $params["title"];

            $obj = NoticeGroupData::where("id", $id)->first();
            if( $obj == null ){
                throw new Exception(MenuErrorMessageConstant::getNotHaveErrorMessage("MAIN_MENU"));
            }

            NoticeGroupData::where("id", $id)->update([
                "title" => $title
            ]);

            $returnMsg = helpers_success_message();
            DB::commit();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
            DB::rollBack();
        }

        return $returnMsg;
    }

    public function subList(array $params): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $pageSize  = $params["pageSize"];
            $groupId   = $params["groupId"];
            $searchCls = $params["searchCls"];
            $keyword   = $params["keyword"];
            $sortArr   = explode("|", $params["sort"]);

            $builder = NoticeGroupData::select([
                "b.id",
                "b.rank as sub_rank",
                "notice_group_datas.title as main_title",
                "b.title as sub_title",
                "b.group_id",
                "b.type",
            ]);
            $builder->join("notice_sub_datas as b", "notice_group_datas.id", "=", "b.group_id");
            $builder->orderBy("notice_group_datas." . $sortArr[0], $sortArr[1]);
            $builder->orderBy("b.rank", "asc");

            if( isset($groupId) && !empty($groupId) ){
                $builder->where("notice_group_datas.id", $groupId);
            }

            if( !empty($keyword) ){
                if( empty($searchCls) ){
                    $builder->where(function($query1) use ($keyword) {
                        $query1->where("notice_group_datas." . "title", "like", "%" . $keyword . "%")
                        ->orWhere("b." . "title", "like", "%" . $keyword . "%");
                    });
                } else if( $searchCls == "sub_title"){
                    $builder->where("b." . "title", "like", "%" . $keyword . "%");
                }
            }

            $lists    = $builder->paginate($pageSize)->appends($params);
            $lastPage = $lists->lastPage();
            $page     = $lists->currentPage();
            $pageSize = $lists->perPage();

            $result = [
                "result"        => $lists->items(),
                "total_records" => $lists->total(),
                "last_page"     => $lastPage,
                "page"          => $page,
                "page_size"     => (int)$pageSize
            ];

            $returnMsg = helpers_success_message($result);
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    public function subMenuCreate(array $params): array
    {
        $returnMsg = $this->returnMsg;

        try {
            DB::beginTransaction();

            $groupId = $params["groupId"];
            $title   = $params["title"];
            $type    = $params["type"];

            $lastRank = NoticeSubData::where("group_id", $groupId)->latest('rank')->value('rank');
            if( $lastRank == null ){
                $lastRank = 1;
            } else {
                $lastRank++;
            }

            NoticeSubData::create([
                "group_id" => $groupId,
                "title"    => $title,
                "type"     => $type,
                "rank"     => $lastRank
            ]);

            $returnMsg = helpers_success_message();
            DB::commit();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
            DB::rollBack();
        }

        return $returnMsg;
    }

    public function subEdit(array $params): array
    {
        $returnMsg = $this->returnMsg;

        try {
            DB::beginTransaction();

            $id      = $params["id"];
            $groupId = $params["groupId"];
            $title   = $params["title"];
            $type    = $params["type"];
            $rank    = $params["rank"];

            $obj = NoticeSubData::where("id", $id)->first();
            if( $obj == null ){
                throw new Exception(MenuErrorMessageConstant::getNotHaveErrorMessage("SUB_MENU"));
            }

            NoticeSubData::where("id", $id)->update([
                "group_id" => $groupId,
                "title"    => $title,
                "type"     => $type,
                "rank"     => $rank,
            ]);

            $returnMsg = helpers_success_message();
            DB::commit();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
            DB::rollBack();
        }

        return $returnMsg;
    }

    public function subDelete(int $id): array
    {
        $returnMsg = $this->returnMsg;

        try {
            DB::beginTransaction();

            NoticeSubData::where("id", $id)->delete();

            $returnMsg = helpers_success_message();
            DB::commit();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
            DB::rollBack();
        }

        return $returnMsg;
    }
}
