<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(){
        return Category::all();
    }

    public function getCategory(Category $category){
        return $category;
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);
        if($validator->fails()) return response()->json(['data'=>$validator->errors(),'success'=>false]);
        $category = Category::create([
            'name'=>$request->name,
            'slug'=> Str::slug($request->name)
        ]);
        return response()->json(['data'=>$request->name.' created successfully!','success'=>true]);
    }

    public function update(Request $request,Category $category){
        $validator = Validator::make($request->all(),[
            'name'=>'required'
        ]);
        if($validator->fails()) return response()->json(['data'=>$validator->errors(),'success'=>false]);

        $category->update([
                'name'=>$request->name,
                'slug'=>Str::slug($request->name,'-')
            ]);
        return response()->json(['data'=>$request->name.' updated successfully!','success'=>true]);

    }

    public function delete(Category $category){
        $category->delete();
        return response()->json(['data'=>'Deleted successfully!','success'=>true]);
    }
}
