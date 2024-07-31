<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Models\banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = banners::All();
        return view('admin.banners.banner', compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $imagePath = $request->file('banner');
        $imageName = $imagePath->getClientOriginalName();
        $imagePath->move('images/banner', $imageName);

        $banner = new banners();
        $banner->image_path = $imageName;
        $banner->save();

        return redirect()->back()->with('success', 'Banner đã được cập nhật thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(banners $banners)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(banners $banners)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = banners::find($id);
        if($banner)
        {
            if ($request->hasFile('banner')) {
                $imagePath = $request->file('banner');
                $imageName = $imagePath->getClientOriginalName();
                $imagePath->move('images/banner', $imageName);
                $banner->image_path = $imageName;
            }
            $banner->save();
            return redirect()->back()->with('success', 'Banner đã được cập nhật thành công!');
        }
        else
        {
            return redirect()->back()->with('error', 'Banner không tồn tại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = banners::find($id);
        if($banner)
        {
            $banner->delete();
            return redirect()->back()->with('success', 'Banner đã được xóa thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Banner không tồn tại!');
        }
    }
}
