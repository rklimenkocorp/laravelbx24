<?php

namespace Mind4me\Bx24_integration\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Mind4me\Bx24_integration\Services\B24;

class IndexController extends BaseController
{

    public function auth()
    {
        return view('integration::index');
    }

    public function install()
    {
        return view('integration::install');
    }

    public function index()
    {
        $b24 = new B24();
        $data = $b24->callMethod('/rest/user.search', 'get', [
            'start' => 0
        ]);
        print_r('<pre>' . print_r(isset($data->result) ? $data->result : $data, true) . '</pre><hr>');

    }

}
