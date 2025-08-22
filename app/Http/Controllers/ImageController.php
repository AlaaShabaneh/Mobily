<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        //dd($request->model_id);
        $query = Image::query();

        if ($request->has('model_id')) {
            $query->where('model_id', $request->model_id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_id' => 'required|integer|exists:models,id',
            'image' => 'required|image|max:2048',
            'is_main' => 'boolean',
        ]);

        $modelId = $request->model_id;
        $imageFile = $request->file('image');

        // إنشاء مجلد إذا لم يكن موجودًا
        $destinationPath = public_path("storage/images/brands/{$modelId}");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // توليد اسم فريد للصورة
        $fileName = time() . '_' . $imageFile->getClientOriginalName();

        // نقل الملف إلى المجلد الجديد
        $imageFile->move($destinationPath, $fileName);

        // حفظ السجل في قاعدة البيانات
        $image = Image::create([
            'model_id' => $modelId,
            'url' => "/storage/images/brands/{$modelId}/{$fileName}",
            'is_main' => $request->is_main ?? 0,
        ]);

        return response()->json($image, 201);
    }

    public function setMain($id)
    {
        $image = Image::findOrFail($id);

        // إلغاء جميع الصور الرئيسية لنفس الموديل
        Image::where('model_id', $image->model_id)->update(['is_main' => 0]);

        // تعيين هذه الصورة كـ رئيسية
        $image->is_main = 1;
        $image->save();

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
}
