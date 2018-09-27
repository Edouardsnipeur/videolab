<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theme=$this->getTheme();
        $category =Category::with('videos')->get();
        return view('admin.category.index',compact(['category','theme']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $theme=$this->getTheme();
        return view('admin.category.create',compact(['theme']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
           [
               'name'=>'required',
               'image'=>'required'
           ]
        );


        $image = $request->file('image');
        $slug=str_slug($request->name);



        
        $Category= new Category();
        $Category->name=$request->name;
        $Category->slug=$slug;
        $Category->image=$request->image;
        $Category->save();
        Toastr::success('Categorie creer avec success', 'success', ["positionClass" => "toast-bottom-left"]);
        return redirect()->route('admin.category.index');
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
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Category $category)
    {
        $theme=$this->getTheme();
        return view('admin.category.create',compact(['theme','category']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,
            [
                'name'=>'required',
                'image'=>'required'
            ]
        );


        $slug=str_slug($request->name);
        $category->name=$request->name;
        $category->slug=$slug;
        $category->image=$request->image;
        $category->save();
        Toastr::success('Categorie Mise a jour avec success', 'success', ["positionClass" => "toast-bottom-left"]);
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
