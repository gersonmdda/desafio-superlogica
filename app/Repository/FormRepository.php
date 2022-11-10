<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;




class FormRepository
{

    /**
    * @param string $nome_da_tabela nome da tabela a ser consultada
    * @param array informacao é um array com os mesmos nomes dos elementos do form
    */
    public function select(string $nomeDaTabela, array $informacao): array
    {
        return  DB::select(
            DB::raw(
                "SELECT ".$informacao['fields']."FROM ".$nomeDaTabela.$informacao['conditions']
            ),
            $informacao['bind']
        );

    }
    /**
    * @param array informacao é um array com os mesmos nomes dos elementos do form
    */
    public function insert(string $nomeDaTabela, array $informacao): int
    {
        try{
            return DB::table($nomeDaTabela)->insertGetId($informacao);
        } catch(Exception $e){
            throw $e;
        }
    }

}