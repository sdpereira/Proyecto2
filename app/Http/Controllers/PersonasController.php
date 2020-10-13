<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonasController extends Controller
{

    public function index()
    {
        $personas=Personas::orderBy('nombre','asc')->get();
        return[
            'personas'=>$personas
        ];
    }
 
    public function store(Request $request)
    {
        $personas=new Personas();
        $personas->nombre=$request->nombre;
        $personas->save();
    }

    public function update(Request $request, $id)
    {
        $personas=Personas::fillOrFail($request->$id);
        $personas->nombre=$request->nombre;
        $personas->save();
        }
 
    public function destroy($id)
    {
        $personas=Personas::fillOrFail($request->$id);
        $personas->delete();
    }
}
