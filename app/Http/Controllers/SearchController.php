<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Service\Search;

class SearchController
{
    public function store(SearchRequest $request)
    {
        return (new Search)->find($request->needle);
    }
}
