<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ListController extends Controller
{

    public function index() {
    	$items = Item::all();
    	return view('list', compact('items'));
    }

    public function create(Request $request) {
    	$item = new Item;
    	$item->item = $request->field;
    	$item->save();
    	return "done";
    }

    public function delete(Request $request) {
    	$item = Item::where('id', $request->field);
    	$item->delete();
    }

    public function update(Request $request) {

    	$item = Item::find($request->id);
    	$item->item = $request->value;
    	$item->save();
    	
    }

}
