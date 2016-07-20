<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Response;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('downloads');
    }

    public function download($name)
    {
        switch($name)
        {
            case 1:
                $name = "AMMod.u";
                break;
            case 2:
                $name = "antics_v1.u";
                break;
            case 3:
                $name = "KMod.u";
                break;
            case 4:
                $name = "StreakMod.u";
                break;
            default:
                $name = "";
        }


        $file = storage_path() . DIRECTORY_SEPARATOR. "{$name}";
        //dd($file);
        if(File::exists($file))
        {
            return Response::download($file, $name);
        }
        else
        {
            return redirect()->home()->with('error','Error! File Not Found');
        }
    }
}
