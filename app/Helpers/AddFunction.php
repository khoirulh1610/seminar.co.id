<?php

function str()
{
    return new \Illuminate\Support\Str();
}

function notification(String $notification_name)
{
    $notification = new \App\Helpers\Notification();
    $notification->name($notification_name);
    return $notification;
}


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

function SpinText($string)
{
    $total = substr_count($string, "{");
    if ($total > 0) {
        for ($i = 0; $i < $total; $i++) {
            $awal = strpos($string, "{");
            $startCharCount = strpos($string, "{") + 1;
            $firstSubStr = substr($string, $startCharCount, strlen($string));
            $endCharCount = strpos($firstSubStr, "}");
            if ($endCharCount == 0) {
                $endCharCount = strlen($firstSubStr);
            }
            $hasil1 =  substr($firstSubStr, 0, $endCharCount);
            $rw = explode("|", $hasil1);
            $hasil2 = $hasil1;
            if (count($rw) > 0) {
                $n = rand(0, count($rw) - 1);
                $hasil2 = $rw[$n];
            }
            $string = str_replace("{" . $hasil1 . "}", $hasil2, $string);
        }
        return $string;
    } else {
        return $string;
    }
}


function hariIndo($hariInggris)
{
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
    $hour = (int) date("G", $b);
    $hasil = "";
    if ($hour >= 0 && $hour < 10) {
        $hasil = "Pagi";
    } elseif ($hour >= 10 && $hour < 15) {
        $hasil = "Siang";
    } elseif ($hour >= 15 && $hour <= 17) {
        $hasil = "Sore";
    } else {
        $hasil = "Malam";
    }

    $text = str_replace(['Pagi', 'Siang', 'Sore', 'Malam'], $hasil, $text);
    return $text;
}


function  ReplaceArray($array, $string)
{
    $pjg = substr_count($string, "[");
    for ($i = 0; $i < $pjg; $i++) {
        $col1 = strpos($string, "[");
        $col2 = strpos($string, "]");
        $find = strtolower(substr($string, $col1 + 1, $col2 - $col1 - 1));
        $relp = substr($string, $col1, $col2 - $col1 + 1);
        if (isset($array[$find])) {
            $string = str_replace($relp, $array[$find], $string);     //asli       
        } else {
            $string = str_replace('[' . $find . ']', '', $string);
        }
    }
    // return $string;
    return SpinText(salam($string));
}


function formatPhone(String $numberPhone, String $countryCode = '62'): String
{
    $numberPhone = preg_replace('/[^0-9]/', '', $numberPhone);
    if ((substr($numberPhone, 0, 1) == '0')) {
        $numberPhone = $countryCode . substr($numberPhone, 1, 20);
    }
    return $numberPhone;
}


function addZero($num, $length = 3)
{
    return str_pad($num, $length, '0', STR_PAD_LEFT);
}
