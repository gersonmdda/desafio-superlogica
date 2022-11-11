<?php

namespace App\Service;


use Illuminate\Support\Facades\Hash;
use App\Repository\FormRepository;
use App\Models\User;


class FormService
{
    

    private FormRepository $formRepository;

    /**
    * @param FormRepository formRepository objeto da classe que dará acesso as operações com banco de dados
    */
    function __construct(FormRepository $formRepository) 
    {
        $this->formRepository = $formRepository;
    }

    public function getFormValidations(): array
    {
        //retorna o array necessário para as validações que devem ser feitas, referentes ao formulário
        return User::getFormValidations();;
    }


    public function getFormValidationsMessages(): array
    {
        //retorna o array necessário para as mensagens referentes as validações
        return User::getFormValidationsMessages();
    }

    /**
    * @param array $data é o valores vindos do form de usuários
    */
    public function storeUser(array $data): int
    {
        $informacao = [
            'name'     => $data['name'],
            'zip_code'  => str_replace("-", "", $data['zipCode']),
            'user_name' => $data['userName'],
            'password' => Hash::make($data['password']),
            'email'    => $data['email']
        ];
        //Retorna o id do usuário persistido no banco de dados
        return $this->formRepository->insert(User::getTableName(),$informacao);
        
    }
    
   /**
    * @param array $data é o valores vindos do form de da tela de busc de usuários
    */
    public function list(array $data): array
    {
        if($data){
            $data = [
                'name'     => $data['name'],
                'zip_code'  => str_replace("-", "", $data['zipCode']),
                'user_name' => $data['userName'],
                'email'    => $data['email']
            ];
        }
        //retorna o resultado da consulta por usuários 
        return $this->formRepository->select(User::getTableName(),User::mountInformation($data));
        
    }




}