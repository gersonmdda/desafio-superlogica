<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;




class FormRepository
{

    /**
    * @param string $nome_da_tabela nome da tabela a ser consultada
    * @param array informacao é um array com os campos, condições e binds para criar a query
    */
    public function select(string $nomeDaTabela, array $informacao): array
    {
        // retorna o resultado da consulta
        return  DB::select(
            DB::raw(
                "SELECT ".$informacao['fields']."FROM ".$nomeDaTabela.$informacao['conditions']
            ),
            $informacao['bind']
        );

    }
    /**
    * @param string $nome_da_tabela nome da tabela na qual vai inserir os dados
    * @param array informacao é um array com os dados enviados pelo form, já tratados para serem persistidos no banco de dados
    */
    public function insert(string $nomeDaTabela, array $informacao): int
    {
        try{
            // retorna o id do usuário que foi inserido
            return DB::table($nomeDaTabela)->insertGetId($informacao);
        } catch(Exception $e){
            throw $e;
        }
    }

}