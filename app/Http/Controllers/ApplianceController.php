<?php

namespace App\Http\Controllers;

use App\Models\Appliance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Appliance::query();

        if ($request->has('name') && $request->tension != "") {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'LIKE' ,'%'.$request->name.'%');
            });
        }

        if ($request->has('tension') && $request->tension != "Todas") {
            $query->where(function ($query) use ($request) {
                $query->where('tension', $request->tension);
            });
        }

        if ($request->has('brand') && $request->brand != "Todas") {
            $query->where(function ($query) use ($request) {
                $query->where('brand', $request->brand);
            });
        }

        if ($request->has('paginate')) {
            $data = $query->paginate($request->per_page);
        } else {
            $data = $query->get();
        }
        
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|unique:appliances|max:255',
            'tension' => 'required|in:110v,220v',
            'brand' => 'required|in:Electrolux,Brastemp,Fischer,Samsung,LG'
        ]);

        if (!$validator->fails()) {

            $new_appliance = Appliance::create($data);

            if ($new_appliance) {
                return response()->json([
                    "message" => "Eletrodoméstico cadastrado com sucesso."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Erro ao cadastrar o eletrodoméstico."
                ], 500);
            }
            
        } else {
            return response()->json($validator->errors());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appliance  $appliance
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appliance = Appliance::find($id);

        if ($appliance) {
            return response()->json($appliance);
        } else {
            return response()->json([
                "message" => "Eletrodoméstico não encontrado."
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appliance  $appliance
     * @return \Illuminate\Http\Response
     */
    public function edit(Appliance $appliance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'max:255',
            'tension' => 'in:110v,220v',
            'brand' => 'in:Electrolux,Brastemp,Fischer,Samsung,LG'
        ]);

        if (!$validator->fails()) {

            $appliance = Appliance::find($id);

            $save = $appliance->update($data);

            if ($save) {
                return response()->json([
                    "message" => "Eletrodoméstico atualizado com sucesso."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Erro ao atualizar o eletrodoméstico."
                ], 500);
            }
            
        } else {
            return response()->json($validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appliance  $appliance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appliance = Appliance::find($id);

        $deleted = $appliance->delete();

        if ($deleted) {
            return response()->json([
                "message" => "Eletrodoméstico removido com sucesso."
            ], 200);
        } else {
            return response()->json([
                "message" => "Erro ao remover o eletrodoméstico."
            ], 500);
        }
    }
}
