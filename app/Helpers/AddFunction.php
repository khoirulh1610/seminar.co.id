<?php


function Encript($string)
{
    $Crypt = Illuminate\Support\Facades\Crypt::encryptString($string);
    return $Crypt;
}

function Decript($string)
{
    try {
        $Crypt = Illuminate\Support\Facades\Crypt::decryptString($string);
        return $Crypt;
    } catch (Illuminate\Contracts\Encryption\DecryptException $th) {
        return $th;
    }
}


function  ReplaceArray($array,$string){        
    $pjg = substr_count($string,"[");   
    for ($i=0; $i < $pjg ; $i++) { 
        $col1 = strpos($string,"[");
        $col2 = strpos($string,"]");  
        $find = strtolower(substr($string,$col1+1,$col2-$col1-1));
        $relp = substr($string,$col1,$col2-$col1+1);            
        if(isset($array[$find])){          
            $string = str_replace($relp,$array[$find],$string);     //asli       
        }else{
            $string = str_replace('['.$find.']','',$string);            
        } 
        
    }           
    return $string;
}

function  ReplaceArray2($array,$string){            
    $pjg = substr_count($string,"{");   
    for ($i=0; $i < $pjg ; $i++) { 
        $col1 = strpos($string,"{");
        $col2 = strpos($string,"}");  
        $find = strtolower(substr($string,$col1+1,$col2-$col1-1));
        $relp = substr($string,$col1,$col2-$col1+1);            
        if(isset($array[$find])){          
            $string = str_replace($relp,$array[$find],$string);     //asli       
        }else{
            $string = str_replace('{'.$find.'}','',$string);            
        } 
        
    }           
    return $string;
}