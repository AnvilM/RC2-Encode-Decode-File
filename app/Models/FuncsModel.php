<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncsModel extends Model
{
    /**
     * Хеширование парольной фразы
     * 
     * @param string $password - Парольная фраза
     * @param int $key_len - Длина ключа
     * @return string
    */
    public static function passwordDeriveBytes($password, $key_len){
        //Генерация соли (Случайная примесь)
        $salt = openssl_random_pseudo_bytes(8);

        //Генерация хеша из парольной фразы
        return hash_pbkdf2('md5', $password, $salt, 1000, $key_len / 8);

    }

    /**
     * Генерация начального вектора
     *  
     * @param int $key_len - Длина
     * @return string
    */
    public static function IV($len){
        //Генерация начального вектора
        return openssl_random_pseudo_bytes($len);
    }

    /**
     * Проверка парольной фразы 
     *  
     * @param string $password - Парольная фраза
     * @param string $re_password - Повтор парольной фразы
     * @return bool
    */
    public static function checkPassword($password, $re_password){
        //Проверка длины пароля
        $Len = false;
        if(strlen($password) > 8){$Len = true;}

        //Проверка символов верхнего регистра
        $UpLetter = false;
        $UpLetterPattern = "/^.*[A-Z]+.*$/";
        if(preg_match($UpLetterPattern, $password)){$UpLetter = true;}

        //Проверка символов нижнего регистра
        $DownLetter = false;
        $DownLetterPattern = "/^.*[a-z]+.*$/";
        if(preg_match($DownLetterPattern, $password)){$DownLetter = true;}

        //Проверка цифр
        $Digits = false;
        $DigitsPattern = "/^.*[0-9]+.*$/";
        if(preg_match($DigitsPattern, $password)){$Digits = true;}

        //Проверка математических символов
        $Math = false;
        $Math_symbols = ['+', '-', '/', '%', '^', '*'];

        for($i = 0; $i < count($Math_symbols); $i++){
            if(str_contains($password, $Math_symbols[$i])){$Math = true;}
        }

        //Проверка соответствия паролей
        $Equal = false;
        if($password == $re_password){$Equal = true;}

        return ($UpLetter && $DownLetter && $Digits && $Math && $Equal && $Len) ? true : false;


        

    }
}
