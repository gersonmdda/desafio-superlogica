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
        $fields = implode(',',$data);
        $bind = [];
        $fields = " id,
                    name,
                    zip_code,
                    user_name,
                    email ";
        if($data){
            $conditions = " WHERE ";
            $and = false;
            $bind= [];
            foreach($data as $key => $condition){
                if($condition){
                    if($and){
                        $conditions .= "AND ";
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

}
