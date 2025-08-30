<?php

namespace App\Traits;

trait UploadTrait
{
    public function uploadImage($image, $path)
    {
        // التحقق من وجود صورة مرفوعة
        if (!$image) {
            return false; // إرجاع false إذا لم يتم رفع صورة
        }

        // إنشاء اسم فريد وآمن للصورة
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        // محاولة حفظ الصورة
        try {
            $image->move(public_path($path), $imageName);
            return $imageName; // إرجاع اسم الصورة عند النجاح
        } catch (\Exception $e) {
            // يمكن تسجيل الخطأ هنا في حالة الفشل
            // Log::error('Failed to upload image: ' . $e->getMessage());
            return false; // إرجاع false عند الفشل
        }
    }
    public function deleteImage($folder, $imageName)
    {
        $imagePath = $folder . '/' . $imageName;
        if (file_exists($imagePath)) {
            unlink($imagePath); 
             return true;
        }
        return false;
    }
}
