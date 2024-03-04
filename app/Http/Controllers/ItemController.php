<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Obtenha o ID do usuário autenticado
    $userId = Auth::id();

    // Consulta para obter os itens associados ao usuário atual
    $items = Item::where('user_id', $userId)->get();

    // Retorna os itens associados ao usuário logado
    return $items;
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
    // Obtenha o ID do usuário autenticado
    $userId = Auth::id();
    
    // Crie um novo item e atribua o ID do usuário
    $newItem = new Item;
    $newItem->user_id = $userId;

    if(isset($request->item['name'])){
        $newItem->name = $request->item['name'];
    }
    if(isset($request->item['description'])){
        $newItem->description = $request->item['description'];
    }

    // Salve o novo item no banco de dados
    $newItem->save();

    // Retorne o novo item
    return $newItem;
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
    // Encontre o item existente pelo ID
    $existingItem = Item::find($id);

    // Verifique se o item existe
    if($existingItem){
        if(isset($request->item['name'])){
            $existingItem->name = $request->item['name'];
        }
        if(isset($request->item['description'])){
            $existingItem->description = $request->item['description'];
        }
        if(isset($request->item['completed'])){
            $existingItem->completed = $request->item['completed'] ? true : false;
        }
        $existingItem->updated_at = Carbon::now();
        
        // Salve as mudanças no banco de dados
        $existingItem->save();
        
        // Retorne o item atualizado
        return $existingItem;
    } 

    // Se o item não for encontrado, retorne uma mensagem indicando isso
    return "Item not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingItem = Item::find($id);
        if($existingItem){
           $existingItem->delete();
           return "Item deleted";
    }
    return "Item not found";
    }
}