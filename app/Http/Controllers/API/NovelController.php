<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NovelController extends Controller
{
    public function index(){
        return Novel::with(['chapters','categories'])->get();
    }

    public function getNovel(Novel $novel){
        return $novel->where('id',$novel->id)->with(['chapters','categories'])->get();
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5',
            'author' => 'required',
            'categories' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['data'=>$validator->errors(),'success'=>false]);
        }

        $novel = Novel::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'author' => $request->author
        ]);
        foreach(json_decode($request->categories) as $category){
            $novel->categories()->attach(
                ['category_id' => $category]
            );
        }
        return response()->json(['data'=>$request->title.' created successfully!','success'=>true]);
    }

    public function update(Request $request,Novel $novel){
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5',
            'author' => 'required',
            'categories' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['data'=>$validator->errors(),'success'=>false]);
        }

        $novel->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'author' => $request->author
        ]);
        $novel->categories()->wherePivot('novel_id','=',$novel->id)->detach();
        foreach(json_decode($request->categories) as $category){
            $novel->categories()->attach(
                ['category_id' => $category]
            );
        }
        return response()->json(['data'=>$request->title.' updated successfully!','success'=>true]);
    }

    public function delete(Novel $novel){
        $novel->delete();
        $novel->categories()->wherePivot('novel_id','=',$novel->id)->detach();
        Chapter::where('novel_id',$novel->id)->delete();
        return response()->json(['data'=>'dleted successfully!','success'=>true]);
    }
}
