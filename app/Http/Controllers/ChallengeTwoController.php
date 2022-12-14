<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Service\ChallengeTwoService;


class ChallengeTwoController extends BaseController
{

    private ChallengeTwoService $challengeTwoService;

    /**
    * @param ChallengeTwoService $challengeTwoService objeto da classe que dará acesso as operações de regras de negócio
    */
    function __construct(ChallengeTwoService $challengeTwoService) 
    {
        $this->challengeTwoService = $challengeTwoService;
    }

    public function processing(): void
    {     
        $this->challengeTwoService->processing();
    }

}