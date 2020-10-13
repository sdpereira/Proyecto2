<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Areas;
class AreasController extends Controller
{
    public function index()
    {
        $areas=Areas::orderBy('nombre','asc')->get();
        return[
            'areas'=>$areas
        ];
    }
    public function getArea(Request $request){
        $areas = Areas::select('id','nombre')->orderBy('nombre','asc')->get();
        return[
            'areas'=>$areas
        ];
    }
 
    public function store(Request $request)
    {
        $areas=new Areas();
        $areas->nombre=$request->nombre;
        $areas->save();
    }

    public function update(Request $request, $id)
    {
        $areas=Areas::fillOrFail($request->$id);
        $areas->nombre=$request->nombre;
        $areas->save();
        }
 
    public function destroy($id)
    {
        $areas=Areas::fillOrFail($request->$id);
        $areas->delete();
    }
}
