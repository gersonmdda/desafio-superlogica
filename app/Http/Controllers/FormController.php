<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Service\FormService;


class FormController extends BaseController
{
    private FormService $formService;

    /**
    * @param FormService formService objeto da classe que dará acesso as operações de regras de negócio
    */
    function __construct(FormService $formService) 
    {
        $this->formService = $formService;
    }

    public function create(): View
    {     
        //retorna a view que contêm o formulário de criação de usuários   
        return view('form.create');   
    }

    /**
    * @param Request $request requisição recebida pela tela de inserção de usuários
    */
    public function store(Request $request): View
    {   
        $request->validate($this->formService->getFormValidations(),$this->formService->getFormValidationsMessages());
        $id = $this->formService->storeUser($request->all());
        //retorna a view que contêm o formulário de criação de usuários com o id da inserção realizada
        return view('form.create',['id'=>$id]);   
    }

    /**
    * @param Request $request requisição recebida pela tela de listagem de usuários
    */
    public function list(Request $request): View
    {  
        $list = $this->formService->list($request->all());
        //retorna a view que contêm a listagem de usuários, filtradas de acordo com a busca realizada
        return view('form.list',['list' => $list]);
    }

}