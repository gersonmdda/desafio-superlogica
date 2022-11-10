<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use App\Service\FormService;
use \Throwable;


class FormController extends BaseController
{
    private FormService $formService;

    function __construct(FormService $formService) 
    {
        $this->formService = $formService;
    }

    public function create(): View
    {        
        return view('form.create');   
    }

    public function store(Request $request): View
    {   
        $request->validate($this->formService->getFormValidations(),$this->formService->getFormValidationsMessages());
        $id = $this->formService->storeUser($request->all());
        return view('form.create',['id'=>$id]);   
    }

    public function list(Request $request): View
    {  
        $list = $this->formService->list($request->all());
        return view('form.list',['list' => $list]);
    }

}