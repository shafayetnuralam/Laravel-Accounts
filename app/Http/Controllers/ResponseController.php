<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    //Send JSON Response
        public function sendResponse($result, $message)
    {        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }


    public function sendError($error, $ErrorMessage = [],$code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($ErrorMessage)) {
            $response['data'] = $ErrorMessage;
        }

        return response()->json($response, $code);
    }

}
