<?php

namespace App\Http\Controllers;

use App\Response\Response;
use Illuminate\Http\Request;

class PretestController extends Controller
{
    public function index()
    {
        $tigaLimaNumbers = [];

        for ($number = 1; $number <= 100; $number++) {
            if ($number % 3 == 0 && $number % 5 == 0) {
                $tigaLimaNumbers[] = "TigaLima";
                continue;
            }

            if ($number % 3 == 0) {
                $tigaLimaNumbers[] = "Tiga";
                continue;
            }

            if ($number % 5 == 0) {
                $tigaLimaNumbers[] = "Lima";
                continue;
            }

            $tigaLimaNumbers[] = $number;
        }

        return Response::send(200, $tigaLimaNumbers);
    }
}
