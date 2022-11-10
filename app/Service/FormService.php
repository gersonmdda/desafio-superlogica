<?php

namespace App\Service;


use \Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        return [
            'name'     => 'required|max:255',
            'userName' => 'required|unique:App\Models\User,user_name|max:255',
            'zipCode'  => [
                'required',
                'max:9',
                'regex:/[0-9]{5}[-][0-9]{3}|[0-9]{8}/'
            ],
            'email'    => 'required|unique:users|max:255|email',
            'password' => [
                'required',
                'max:255',
                'min:8',
                function ($attribute, $value, $fail) {
                    if ($this->verifyPasswordNumbersAndLetters($value)) {
                        $fail('O campo "Senha" deve conter ao meno uma letra e um número');
                    }
                },
            ],
        ];
    }

    /**
    * @param String $value é o valor do campo password que será usado para validar se há ao menos uma letra e um número 
    */
    private function verifyPasswordNumbersAndLetters(String $value): bool
    {
        preg_match_all(
            '/[0-9]/',
            $value,$matchesNumbers);
        preg_match_all(
            '/[a-zA-Z]/',
            $value,$matchesLetters);
        $return = false;
        if (count($matchesNumbers[0]) == 0 || count($matchesLetters[0]) == 0) {
            $return = true;
        }
        //retorna o resultado da verificação, referente a existência de ao menos um número e uma letra na senha
        return $return;
    }

    public function getFormValidationsMessages(): array
    {
        //retorna o array necessário para as mensagens referentes as validações
        return [
            'name.required'     => 'O campo "Nome completo" deve ser preenchido!',
            'name.max'          => 'O campo "Nome completo" deve ter no máximo 255 caracteres!',
            'userName.required' => 'O campo "Nome de login" deve ser preenchido!',
            'userName.unique'   => 'O campo "Nome de login" já está sendo utilizado!',
            'userName.max'      => 'O campo "Nome de login" deve ter no máximo 255 caracteres!',
            'zipCode.required'  => 'O campo "CEP" deve ser preenchido!',
            'zipCode.max'       => 'O campo "CEP" deve ter no máximo 8 caracteres!',
            'zipCode.regex'     => 'O campo "CEP" deve ter o formato 00000000 ou 00000-000!',
            'email.required'    => 'O campo "Email" deve ser preenchido!',
            'email.unique'      => 'O campo "Email" já está sendo utilizado!',
            'email.max'         => 'O campo "Email" deve ter no máximo 255 caracteres!',
            'email.email'       => 'O campo "Email" deve ser um e-mail válido',
            'password.required' => 'O campo "Senha" deve ser preenchido!',
            'password.max'      => 'O campo "Senha" deve ter no máximo 255 caracteres!',
            'password.min'      => 'O campo "Senha" deve ter no mínimo 8 caracteres!',
        ];
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
        try{
            //Retorna o id do usuário persistido no banco de dados
            return $this->formRepository->insert(User::getTableName(),$informacao);
        } catch(Exception $e){
            throw $e;
        }
    }
    
   
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