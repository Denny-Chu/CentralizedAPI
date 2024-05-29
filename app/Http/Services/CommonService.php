<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

class CommonService extends Service
{

    public function dealRequest(Request $request)
    {
        $params = $request->all();
        $header['authorization'] = $request->header('authorization');

        $hash = hash("SHA256", http_build_query($params));
        $params['hash']  = $hash;

        return $params;
    }
}
