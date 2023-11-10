<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpseclib3\Crypt\RC2;



class EncryptModel extends Model
{
    private $password_bytes;
    private $src_file_path;
    private $end_file_path;
    private $delete_src_file;
    private $IV;
 
    /**
     * Стандартный конструктор
     * 
     * @param sting $password_bytes - Хеш из парольной фразы
     * @param sting $src_file_path - Путь к исходному файлу
     * @param sting $end_file_path - Путь к конечному файлу
     * @param bool $delete_src_file - Удаление исходного файла
     * @param sting $IV - Начальный вектор
    */
    
    public function __construct($password_bytes, $src_file_path, $end_file_path, $delete_src_file, $IV){
        $this->password_bytes = $password_bytes;
        $this->src_file_path = $src_file_path;
        $this->end_file_path = $end_file_path;
        $this->delete_src_file = $delete_src_file;
        $this->IV = $IV;
    }

    /**
     * Шифрование
     * 
     * @return bool
    */
    public function Encode(){

        //Содержимое исходного файла
        $src_data = file_get_contents($this->src_file_path);

        //Шифрование
        $cipher = new RC2('ctr');
        $cipher->setIV($this->IV);
        $cipher->setKey($this->password_bytes);
        $res = $cipher->encrypt($src_data);

        //Запись зашифрованного сообщения в конечный файл
        file_put_contents($this->end_file_path, $res);
        
        //Удаление исходного файла
        if($this->delete_src_file == true){unlink($this->src_file_path);}

        return true;

    }

    /**
     * Дешифрование
     * 
     * @return bool
    */

    public function Decode(){
        //Содержимое исходного файла
        $src_data = file_get_contents($this->src_file_path);

        //Дешифрование
        $cipher = new RC2('ctr');
        $cipher->setIV($this->IV);
        $cipher->setKey($this->password_bytes);
        $res = $cipher->decrypt($src_data);

        //Запись дешифрованного сообщения в файл
        file_put_contents($this->end_file_path, $res);

        return true;
    }
   
}

