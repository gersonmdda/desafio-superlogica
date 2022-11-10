<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public static function getTableName(): String
    {
        //retorna o nome da tabela a que está modelo representa
        return (new self())->getTable();
    }

    /**
    * @param array data é um array com os dados do form já tratados para serem persistidos no banco de dados
    */
    public static function mountInformation(?array $data = null): array
    {
        $bind = [];
        $fields = " id,
                    name,
                    zip_code,
                    user_name,
                    email ";
        if($data){
            $and = false;
            $bind= [];
            foreach($data as $key => $condition){
                if($condition){
                    if($and){
                        $conditions .= "AND ";
                    } else {
                        $conditions = " WHERE ";
                    }
                    $conditions .= $key.' LIKE :'.$key.' ';
                    $and = true;
                    $bind[$key] = '%'.$condition.'%';
                }
            }
        }
        //retorna um array com os campos, condições e binds para criar a query de busca
        return [
            'fields' => $fields,
            'conditions' => $conditions ?? null,
            'bind' => $bind
        ];
    }

    public static function getFormValidations(): array
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
                    if (self::verifyPasswordNumbersAndLetters($value)) {
                        $fail('O campo "Senha" deve conter ao meno uma letra e um número');
                    }
                },
            ],
        ];
    }

    /**
    * @param String $value é o valor do campo password que será usado para validar se há ao menos uma letra e um número 
    */
    private static function verifyPasswordNumbersAndLetters(String $value): bool
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

    public static function getFormValidationsMessages(): array
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

}
