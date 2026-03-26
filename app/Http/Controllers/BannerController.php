<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
     public function create()
    {
        return view('banner');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'nullable|string|max:255',
            'Link' => 'nullable|string|max:255',
            'SortOrder' => 'nullable|integer',
            'IsActive' => 'nullable|boolean',
            'BannerImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('BannerImage')) {
            $file = $request->file('BannerImage');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('img/banner'), $fileName);
        }

        Banner::create([
            'Title' => $request->Title,
            'Link' => $request->Link,
            'SortOrder' => $request->SortOrder ?? 0,
            'IsActive' => $request->IsActive ?? 1,
            'BannerImage' => $fileName,
        ]);

        return redirect()->route('banner.list')->with('success','Banner created successfully.');
    }

    public function list()
    {
        $Banners = Banner::orderBy('SortOrder','asc')->orderBy('id','desc')->get();
        return view('banner_list', compact('Banners'));
    }

    public function showEdit($id)
    {
        $Banner = Banner::findOrFail($id);
        return view('bannerEdit', compact('Banner'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'Title' => 'nullable|string|max:255',
            'Link' => 'nullable|string|max:255',
            'SortOrder' => 'nullable|integer',
            'IsActive' => 'nullable|boolean',
            'BannerImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $Banner = Banner::findOrFail($request->id);

        $fileName = $Banner->BannerImage;
        if ($request->hasFile('BannerImage')) {
            $file = $request->file('BannerImage');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('img/banner'), $fileName);

            // delete old file (optional)
            if (!empty($Banner->BannerImage)) {
                $oldPath = public_path('img/banner/'.$Banner->BannerImage);
                if (file_exists($oldPath)) @unlink($oldPath);
            }
        }

        $Banner->update([
            'Title' => $request->Title,
            'Link' => $request->Link,
            'SortOrder' => $request->SortOrder ?? 0,
            'IsActive' => $request->IsActive ?? 1,
            'BannerImage' => $fileName,
        ]);

        return redirect()->route('banner.list')->with('success','Banner updated successfully.');
    }

    public function delete($id)
    {
        $Banner = Banner::findOrFail($id);

        if (!empty($Banner->BannerImage)) {
            $oldPath = public_path('img/banner/'.$Banner->BannerImage);
            if (file_exists($oldPath)) @unlink($oldPath);
        }

        $Banner->delete();
        return redirect()->route('banner.list')->with('success','Banner deleted successfully.');
    }
}
