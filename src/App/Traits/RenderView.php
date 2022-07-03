<?php
namespace Emam\Filemanager\App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

trait RenderView
{
    public function renderView($data, $baseView, $partialView)
    {
        if (\request()->ajax()) {
            $data['ajax'] = true;
            return view($partialView, $data);
        }
        $data['ajax'] = false;
        return view($baseView, $data);
    }


}
