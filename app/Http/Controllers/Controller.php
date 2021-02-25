<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // paginate
    public function paginate($data)
    {
        $lastPage    = $data->lastPage();
        $currentPage = $data->currentPage();
        $nextPage    = ($data->nextPageUrl()) ? explode('=', $data->nextPageUrl())[1] : 0;
        $prevPage    = ($data->previousPageUrl()) ? explode('=', $data->previousPageUrl())[1] : 0;
        $perPage     = $data->perPage();
        $total       = $data->total();
        $pagination  = [
                'total'         => (int)$total, 
                'per_page'      => (int)$perPage, 
                'current_page'  => (int)$currentPage, 
                'next_page'     => (int)$nextPage,
                'prev_page'     => (int)$prevPage,
                'last_page'     => (int)$lastPage
              ];
        return $pagination;
    }
}
