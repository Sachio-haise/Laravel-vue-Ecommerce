<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    public function index(){
        return Chapter::with('novel')->get();
    }

    public function getChapter(Chapter $chapter){
        return $chapter;
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'novel_id' => 'required',
            'title' => 'required|min:10|max:50',
            'paragraph' => 'required|min:50',
        ]);

        if($validator->fails()){
            return response()->json(['data' => $validator->errors(),'success' => false]);
        }

        $chapter = Chapter::create([
            'novel_id' => $request->novel_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'paragraph' => $request->paragraph
        ]);

        return response()->json(['data' => $request->title.' created successfully!','success'=>true]);
    }

    public function update(Request $request,Chapter $chapter){
        $validator = Validator::make($request->all(),[
            // 'novel_id' => 'required',
            'title' => 'required|min:10|max:50',
            // 'paragraph' => 'required|min:50',
        ]);

        if($validator->fails()){
            return response()->json(['data' => $validator->errors(),'success' => false]);
        }

        $chapter->update([
            'novel_id' => $request->novel_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'paragraph' => $request->paragraph
        ]);

        return response()->json(['data' => $request->title.' updated successfully!','success'=>true]);
    }

    public function delete(Chapter $chapter){
        $chapter->delete();
        return response()->json(['data' => $chapter->title.' deleted successfully!','success' => true]);
    }
}
