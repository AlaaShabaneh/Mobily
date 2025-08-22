<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إدارة صور الأجهزة</title>
  <style>
    body { font-family: Arial, sans-serif; direction: rtl; margin: 20px; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; }
    input, select, button { padding: 8px; width: 100%; }
    .image-list { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; }
    .image-card { border: 1px solid #ddd; padding: 10px; text-align: center; width: 150px; }
    .image-card img { width: 100%; height: auto; border-radius: 6px; }
    .delete-btn { margin-top: 10px; padding: 5px; background: red; color: white; border: none; cursor: pointer; }
  </style>
</head>
<body>
  <h2>📸 إدارة صور الأجهزة</h2>

  <!-- نموذج رفع صورة -->
  <div class="form-group">
    <label>اختر الجهاز (Device Variant):</label>
    <select id="variantSelect"></select>
  </div>

  <div class="form-group">
    <label>اختر صورة:</label>
    <input type="file" id="imageFile" accept="image/*">
  </div>

  <button onclick="uploadImage()">رفع الصورة</button>

  <!-- عرض الصور -->
  <h3>📂 الصور المرفوعة</h3>
  <div id="imageList" class="image-list"></div>

  <script>
    const API_URL = "http://localhost:8000/api"; // عدل الرابط حسب السيرفر عندك

    // جلب قائمة الأجهزة (variants)
    async function loadVariants() {
      let res = await fetch(`${API_URL}/device_variants`);
      let data = await res.json();
      let select = document.getElementById("variantSelect");
      select.innerHTML = "";
      data.forEach(v => {
        let opt = document.createElement("option");
        opt.value = v.id;
        opt.textContent = "Variant #" + v.id + " - Model: " + v.model_id;
        select.appendChild(opt);
      });
      loadImages(); // تحميل الصور للجهاز الأول بشكل افتراضي
    }

    // رفع صورة
    async function uploadImage() {
      let variantId = document.getElementById("variantSelect").value;
      let fileInput = document.getElementById("imageFile");

      if (!fileInput.files.length) {
        alert("الرجاء اختيار صورة");
        return;
      }

      let formData = new FormData();
      formData.append("variant_id", variantId);
      formData.append("image", fileInput.files[0]);

      let res = await fetch(`${API_URL}/device_images`, {
        method: "POST",
        body: formData
      });

      if (res.ok) {
        alert("تم رفع الصورة بنجاح ✅");
        loadImages();
      } else {
        alert("حصل خطأ أثناء الرفع");
      }
    }

    // جلب الصور الخاصة بجهاز محدد
    async function loadImages() {
      let variantId = document.getElementById("variantSelect").value;
      let res = await fetch(`${API_URL}/device_images?variant_id=${variantId}`);
      let images = await res.json();
      let container = document.getElementById("imageList");
      container.innerHTML = "";
      images.forEach(img => {
        let card = document.createElement("div");
        card.className = "image-card";
        card.innerHTML = `
          <img src="${API_URL}/uploads/${img.image_path}" alt="device image">
          <button class="delete-btn" onclick="deleteImage(${img.id})">حذف</button>
        `;
        container.appendChild(card);
      });
    }

    // حذف صورة
    async function deleteImage(id) {
      if (!confirm("هل أنت متأكد من حذف الصورة؟")) return;
      let res = await fetch(`${API_URL}/device_images/${id}`, { method: "DELETE" });
      if (res.ok) {
        alert("تم الحذف ✅");
        loadImages();
      } else {
        alert("حصل خطأ أثناء الحذف");
      }
    }

    // تحميل البيانات عند فتح الصفحة
    loadVariants();
    document.getElementById("variantSelect").addEventListener("change", loadImages);
  </script>
</body>
</html>
