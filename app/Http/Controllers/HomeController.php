<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EncryptModel;
use App\Models\FuncsModel;
use Illuminate\Contracts\Session\Session;

class HomeController extends Controller
{
    private $EncryptModel;

    public function Encrypt(Request $request){
        //Проверка исходного файла
        if($request->post('src_file_path') == '' || !file_exists($request->post('src_file_path'))){return back()->withInput();}

        //Проверка конечного файла
        if($request->post('end_file_path') == ''){return back()->withInput();}

        //Проверка пароля
        if(!FuncsModel::checkPassword($request->post('password'), $request->post('re_password'))){return back()->withInput();}

        //Проверка длины ключа
        if($request->post('key_len') % 8 != 0){return back()->withInput();}    

        //Проверка нажатой кнопки
        if($request->post('button') != 'Encode' && $request->post('button') != 'Decode'){return back()->withInput();}

        //Инициализация переменных
        $password = $request->post('password');
        $key_len = $request->post('key_len');
        $button = $request->post('button');
        $src_file_path = $request->post('src_file_path');
        $end_file_path = $request->post('end_file_path');
        $delete_src_file = $request->post('delete_src_file') != '' ? true : false;
        

        //Проверка вызванной функции
        if($button == 'Encode'){
            //Генерация хешированной парольной фразы
            $password_bytes = FuncsModel::passwordDeriveBytes($password, $key_len);
            Session(['password_bytes' => $password_bytes]);

            //Инициализация начального вектора
            $IV = FuncsModel::IV(8);
            Session(['IV' => $IV]);
        }
        else{
            //Инициализация хешированной парольноый фразы
            $password_bytes = session()->get('password_bytes');

            //Инициализация начального вектора
            $IV = session()->get('IV');
        }

        //Вызов соответствующего метода
        $this->EncryptModel = new EncryptModel($password_bytes, $src_file_path, $end_file_path, $delete_src_file, $IV);
        $this->EncryptModel->$button();

        //Возврат на предыдущую страницу
        return back();

        

        
        
        
        

    }
}
