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

function SpinText($string){    
    $total = substr_count($string,"{");
    if($total>0){
        for ($i=0; $i < $total; $i++) { 
            $awal = strpos($string,"{");
            $startCharCount = strpos($string,"{")+1;
            $firstSubStr = substr($string, $startCharCount, strlen($string));
            $endCharCount = strpos($firstSubStr, "}");        
            if ($endCharCount == 0) {
                $endCharCount = strlen($firstSubStr);
            }
            $hasil1 =  substr($firstSubStr, 0, $endCharCount);
            $rw = explode("|",$hasil1);
            $hasil2 = $hasil1;
            if(count($rw)>0){
                $n = rand(0,count($rw)-1);
                $hasil2 = $rw[$n];
            }
            $string = str_replace("{".$hasil1."}",$hasil2,$string);    
        }
        return $string;
    }else {
        return $string;
    }
}


function hariIndo ($hariInggris) {
    switch ($hariInggris) {
      case 'Sunday':
        return 'Minggu';
      case 'Monday':
        return 'Senin';
      case 'Tuesday':
        return 'Selasa';
      case 'Wednesday':
        return 'Rabu';
      case 'Thursday':
        return 'Kamis';
      case 'Friday':
        return 'Jumat';
      case 'Saturday':
        return 'Sabtu';
      default:
        return $hariInggris;
    }
  }

  function salam($text)
    {
        $b = time();
        $hour = (Int) date("G",$b);
        $hasil = "";
        if ($hour>=0 && $hour<10)
        {
            $hasil = "Pagi";
        }
        elseif ($hour >=10 && $hour<15)
        {
            $hasil = "Siang";
        }
        elseif ($hour >=15 && $hour<=17)
        {
            $hasil = "Sore";
        }
        else{
            $hasil = "Malam";
        }
        
        $text = str_replace(['Pagi','Siang','Sore','Malam'],$hasil,$text);
        return $text;
        
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
    // return $string;
    return SpinText(salam($string));
}

