<?php

namespace App\Service;



class ChallengeTwoService
{
    
    public function processing(): void
    {
       $array = [
        17,3,8,2,25,37,45
       ];
       dump($array[2]);
       $string = implode(',',$array);
       dump($string);
       $newArray = explode(',',$string);
       dump($newArray);
       unset($array);
       if (in_array(14, $newArray)) {
            dump('14 existe');
       } else {
            dump('14 não existe');
       }
       $newArray = $this->removePrevious($newArray);
       dump($newArray);
       array_pop($newArray);
       dump($newArray);
       $reversed = array_reverse($newArray);
       dd($reversed);
    }

    public function removePrevious(array $newArray, $count = 0)
    {
        $removed = false;
        $previus = null;
        
        foreach($newArray as $key => $number){
            if($previus && $number < $previus){
                unset($newArray[$key]);
                $removed = true;
            }
            $previus = $number;
        }
        if($removed){
            $newArray = $this->removePrevious($newArray);
        }
        return $newArray;
    }

}