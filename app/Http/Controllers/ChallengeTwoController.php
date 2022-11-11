<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Service\ChallengeTwoService;


class ChallengeTwoController extends BaseController
{

    private ChallengeTwoService $challengeTwoService;

    function __construct(ChallengeTwoService $challengeTwoService) 
    {
        $this->challengeTwoService = $challengeTwoService;
    }

    public function processing(): void
    {     
        $this->challengeTwoService->processing();
    }

}