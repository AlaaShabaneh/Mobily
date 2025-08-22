<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>إدارة البراندات والموديلات والـ Variants</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial;
            direction: rtl;
            padding: 20px;
        }

        h2 {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        input,
        button,
        select {
            padding: 8px;
            margin: 5px;
        }

        .actions button {
            margin: 0 2px;
        }

        hr {
            margin: 30px 0;
        }
    </style>
</head>

<body>

    <!-- ────── Brands ────── -->
    <h2>إضافة براند جديد</h2>
    <input type="text" id="brandName" placeholder="اسم البراند">
    <button id="addBrandBtn">إضافة</button>

    <h2>البراندات</h2>
    <table id="brandsTable">
        <thead>
            <tr>
                <th>الرقم</th>
                <th>الاسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <hr>

    <!-- ────── Models ────── -->
    <h2>إضافة موديل جديد</h2>
    <select id="modelBrandSelect"></select>
    <select id="modelTypeSelect"></select>
    <input type="text" id="modelName" placeholder="اسم الموديل">
    <button id="addModelBtn">إضافة</button>

    <h2>الموديلات</h2>
    <table id="modelsTable">
        <thead>
            <tr>
                <th>الرقم</th>
                <th>البراند</th>
                <th>النوع</th>
                <th>الاسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <hr>

    <!-- ────── Device Variants ────── -->
    <h2>إضافة Device Variant جديد</h2>
    <select id="variantModelSelect"></select>
    <input type="text" id="variantTitle" placeholder="اسم الـ Variant">
    <button id="addVariantBtn">إضافة</button>

    <h2>الـ Device Variants</h2>
    <table id="variantsTable">
        <thead>
            <tr>
                <th>الرقم</th>
                <th>الموديل</th>
                <th>الاسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <h2>مواصفات الجهاز</h2>
    <select id="selectVariantForSpecs"></select>
    <button id="loadSpecsBtn">تحميل المواصفات</button>

    <table id="variantSpecsTable">
        <thead>
            <tr>
                <th>المواصفة</th>
                <th>القيمة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Modal -->
    <div id="specsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:#fff; padding:20px; border-radius:10px; width:400px;">
            <h3>إضافة مواصفات</h3>
            <form id="specsForm"></form>
            <button id="saveSpecsBtn">حفظ</button>
            <button id="closeModalBtn">إغلاق</button>
        </div>
    </div>

    <div class="images-section">
        <h3>إدارة الصور</h3>

        <!-- إضافة صورة جديدة -->
        <form id="addImageForm" enctype="multipart/form-data">
            <input type="hidden" id="currentModelId" value="1"> <!-- الموديل الحالي -->
            <input type="file" name="image" accept="image/*" required>
            <label>
                صورة رئيسية؟
                <input type="checkbox" name="is_main" value="1">
            </label>
            <button type="submit">إضافة</button>
        </form>


        <hr>

        <!-- عرض الصور -->
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>المعاينة</th>
                    <th>الرابط</th>
                    <th>رئيسية؟</th>
                    <th>تحكم</th>
                </tr>
            </thead>
            <tbody id="imagesTableBody"></tbody>
        </table>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');



            // ─── Fetch Functions ──────────────────────────────
            async function fetchBrands() {
                let res = await fetch('/api/brands');
                let data = await res.json();
                let table = document.querySelector('#brandsTable tbody');
                let select = document.querySelector('#modelBrandSelect');
                table.innerHTML = '';
                select.innerHTML = '';
                data.forEach(brand => {
                    table.innerHTML += `
                <tr>
                    <td>${brand.id}</td>
                    <td contenteditable="true" onblur="updateBrand(${brand.id}, this.innerText)">${brand.name}</td>
                    <td class="actions"><button data-id="${brand.id}" class="delete-brand-btn">🗑</button></td>
                </tr>
            `;
                    select.innerHTML += `<option value="${brand.id}">${brand.name}</option>`;
                });
            }

            async function fetchTypes() {
                let res = await fetch('/api/types');
                let data = await res.json();
                let select = document.querySelector('#modelTypeSelect');
                select.innerHTML = '';
                data.forEach(type => {
                    select.innerHTML += `<option value="${type.id}">${type.name}</option>`;
                });
            }

            async function fetchModels() {
                let res = await fetch('/api/models');
                let data = await res.json();
                let table = document.querySelector('#modelsTable tbody');
                let select = document.querySelector('#variantModelSelect');
                table.innerHTML = '';
                select.innerHTML = '';
                data.forEach(model => {
                    table.innerHTML += `
                <tr>
                    <td>${model.id}</td>
                    <td>${model.brand?.name || ''}</td>
                    <td>${model.type?.name || ''}</td>
                    <td contenteditable="true" onblur="updateModel(${model.id}, this.innerText)">${model.name}</td>
                    <td class="actions"><button data-id="${model.id}" class="delete-model-btn">🗑</button></td>
                </tr>
            `;
                    select.innerHTML += `<option value="${model.id}">${model.name}</option>`;
                });
            }

            async function fetchVariants() {
                let res = await fetch('/api/device-variants');
                let data = await res.json();
                let table = document.querySelector('#variantsTable tbody');
                table.innerHTML = '';
                data.forEach(variant => {
                    table.innerHTML += `
                <tr>
                    <td>${variant.id}</td>
                    <td>${variant.model?.name || ''}</td>
                    <td contenteditable="true" onblur="updateVariant(${variant.id}, this.innerText)">${variant.title || ''}</td>
                    <td class="actions"><button data-id="${variant.id}" class="delete-variant-btn">🗑</button></td>
                </tr>
            `;
                });
            }

            // ─── Brand Actions ─────────────────────────────────
            async function addBrand() {
                let name = document.getElementById('brandName').value;
                if (!name) return alert('أدخل اسم البراند');
                await fetch('/api/brands', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ name })
                });
                document.getElementById('brandName').value = '';
                fetchBrands();
            }

            window.updateBrand = async function (id, name) {
                await fetch(`/api/brands/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ name })
                });
            }

            async function deleteBrand(id) {
                if (!confirm('هل أنت متأكد من الحذف؟')) return;
                await fetch(`/api/brands/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                fetchBrands();
            }

            // ─── Model Actions ─────────────────────────────────
            async function addModel() {
                let name = document.getElementById('modelName').value;
                let brand_id = document.getElementById('modelBrandSelect').value;
                let type_id = document.getElementById('modelTypeSelect').value;
                if (!name || !brand_id || !type_id) return alert('أدخل جميع البيانات');
                await fetch('/api/models', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ name, brand_id, type_id })
                });
                document.getElementById('modelName').value = '';
                fetchModels();
            }

            window.updateModel = async function (id, name) {
                await fetch(`/api/models/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ name })
                });
            }

            async function deleteModel(id) {
                if (!confirm('هل أنت متأكد من الحذف؟')) return;
                await fetch(`/api/models/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                fetchModels();
            }

            // ─── Variant Actions ───────────────────────────────
            async function addVariant() {
                let model_id = document.getElementById('variantModelSelect').value;
                let title = document.getElementById('variantTitle').value;
                if (!model_id || !title) return alert('اختر الموديل وأدخل اسم الـ Variant');
                await fetch('/api/device-variants', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ model_id, title })
                });
                document.getElementById('variantTitle').value = '';
                fetchVariants();
            }

            window.updateVariant = async function (id, title) {
                await fetch(`/api/device-variants/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ title })
                });
            }

            async function deleteVariant(id) {
                if (!confirm('هل أنت متأكد من الحذف؟')) return;
                await fetch(`/api/device-variants/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                fetchVariants();
            }

            // ─── Specs Actions ───────────────────────────────
            async function loadVariantsForSpecs() {
                let res = await fetch('/api/device-variants');
                let variants = await res.json();
                let select = document.getElementById('selectVariantForSpecs');
                select.innerHTML = '';
                variants.forEach(v => {
                    select.innerHTML += `<option value="${v.id}">${v.title}</option>`;
                });
            }

            async function loadVariantSpecifications() {
                let variantId = document.getElementById('selectVariantForSpecs').value;
                let res = await fetch(`/api/device-variant-specifications?variant_id=${variantId}`);
                let specs = await res.json();
                let table = document.querySelector('#variantSpecsTable tbody');
                table.innerHTML = '';

                if (specs.length > 0) {
                    specs.forEach(s => {
                        table.innerHTML += `
                            <tr>
                                <td>${s.specification.name}</td>
                                <td contenteditable="true" 
                                    onblur="updateSpec(${s.id}, this.innerText)">
                                    ${s.value}
                                </td>
                                <td class="actions">
                                    <button data-id="${s.id}" class="delete-spec-btn">🗑</button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    openSpecsModal(variantId);
                }
            }

            window.updateSpec = async function (id, value) {
                await fetch(`/api/device-variant-specifications/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ value })
                });
            }

            async function deleteSpec(id) {
                if (!confirm('هل أنت متأكد من حذف هذه المواصفة؟')) return;
                await fetch(`/api/device-variant-specifications/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                loadVariantSpecifications();
            }

            async function openSpecsModal(variantId) {
                let res = await fetch('/api/specifications'); // المواصفات المتاحة
                let allSpecs = await res.json();
                let form = document.getElementById('specsForm');
                form.innerHTML = '';
                allSpecs.forEach(spec => {
                    form.innerHTML += `
                        <label>${spec.name}</label>
                        <input type="text" name="spec_${spec.id}" placeholder="أدخل القيمة">
                    `;
                });

                document.getElementById('saveSpecsBtn').onclick = async function () {
                    let inputs = form.querySelectorAll('input');
                    for (let input of inputs) {
                        let specId = input.name.split('_')[1];
                        let value = input.value;
                        if (value) {
                            await fetch('/api/device-variant-specifications', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                                body: JSON.stringify({ variant_id: variantId, specification_id: specId, value })
                            });
                        }
                    }
                    closeModal();
                    loadVariantSpecifications();
                };

                document.getElementById('specsModal').style.display = 'flex';
            }

            function closeModal() {
                document.getElementById('specsModal').style.display = 'none';
            }

            // ─── Event Listeners ───────────────────────────────
            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('loadSpecsBtn').addEventListener('click', loadVariantSpecifications);
            document.getElementById('addBrandBtn').addEventListener('click', addBrand);
            document.getElementById('addModelBtn').addEventListener('click', addModel);
            document.getElementById('addVariantBtn').addEventListener('click', addVariant);

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('delete-brand-btn')) deleteBrand(e.target.dataset.id);
                if (e.target.classList.contains('delete-model-btn')) deleteModel(e.target.dataset.id);
                if (e.target.classList.contains('delete-variant-btn')) deleteVariant(e.target.dataset.id);
                if (e.target.classList.contains('delete-spec-btn')) deleteSpec(e.target.dataset.id);
            });

            //-----

            // جلب الصور
            function fetchImages() {
                const modelId = document.getElementById("variantModelSelect").value;
                fetch(`/api/images?model_id=${modelId}`)
    .then(res => res.json())
    .then(data => {
        let rows = "";
        data.forEach(img => {
            // استخراج اسم الملف فقط
            let fileName = img.url.split('/').pop();

            rows += `
                <tr>
                    <td>${img.id}</td>
                    <td><img src="${img.url}" width="80"></td>
                    <td>${fileName}</td>
                    <td>${img.is_main == 1 ? "✔" : ""}</td>
                    <td>
                        <button onclick="setMain(${img.id})">تعيين رئيسية</button>
                        <button onclick="deleteImage(${img.id})">حذف</button>
                    </td>
                </tr>
            `;
        });
        document.getElementById("imagesTableBody").innerHTML = rows;
    });

            }

            // إضافة صورة
            document.getElementById("addImageForm").addEventListener("submit", function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                const modelId = document.getElementById("variantModelSelect").value;
                formData.append("model_id", modelId);

                fetch("/api/images", {
                    method: "POST",
                    body: formData
                })
                    .then(res => res.json())
                    .then(() => {
                        fetchImages(modelId);
                        this.reset();
                    });
            });

            // تعيين صورة رئيسية
            // تعيين صورة رئيسية
window.setMain = function(id) {
    fetch(`/api/images/${id}/set-main`, { method: "PUT" })
        .then(() => fetchImages());
}

// حذف صورة
window.deleteImage = function(id) {
    if (confirm("هل أنت متأكد من الحذف؟")) {
        fetch(`/api/images/${id}`, { method: "DELETE" })
            .then(() => fetchImages());
    }
}


            // أول تحميل
            // ─── Init ─────────────────────────────────────────
            fetchBrands();
            fetchTypes();
            fetchModels();
            fetchVariants();
            loadVariantsForSpecs();
            fetchImages();

        });
    </script>

</body>

</html>