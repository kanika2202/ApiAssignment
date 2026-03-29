<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qrcode;
use Illuminate\Support\Facades\File; // កែសម្រួលត្រង់នេះ

class QrcodeController extends Controller
{
    public function index() {
        $qrcodes = Qrcode::latest()->get();
        return view('layouts.qrcode.index', compact('qrcodes'));
    }

    public function store(Request $request) {
        $request->validate([
            'qr_name' => 'required|string|max:255',
            'qr_image' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        if ($request->hasFile('qr_image')) {
            $image = $request->file('qr_image');
            // ប្តូរឈ្មោះ file ដើម្បីកុំឱ្យជាន់គ្នា
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // បង្កើត folder បើមិនទាន់មាន
            $destinationPath = public_path('img/qrcode');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $image->move($destinationPath, $imageName);

            Qrcode::create([
                'qr_name' => $request->qr_name,
                'qr_image' => $imageName
            ]);

            return back()->with('success', 'QR Code uploaded successfully!');
        }

        return back()->with('error', 'Something went wrong while uploading!');
    }

    public function delete($id) {
        $qr = Qrcode::findOrFail($id);
        $path = public_path('img/qrcode/' . $qr->qr_image);

        // លុបរូបភាពចេញពី Folder
        if (File::exists($path)) { 
            File::delete($path); 
        }

        $qr->delete();
        return back()->with('success', 'QR Code deleted successfully!');
    }
}