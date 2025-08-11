<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة البراندات والموديلات</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial; direction: rtl; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
        input, button, select { padding: 8px; margin: 5px; }
        .actions button { margin: 0 2px; }
    </style>
</head>
<body>

<h2>إضافة براند جديد</h2>
<input type="text" id="brandName" placeholder="اسم البراند">
<button onclick="addBrand()">إضافة</button>

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

<h2>إضافة موديل جديد</h2>
<select id="modelBrandSelect"></select>
<input type="text" id="modelName" placeholder="اسم الموديل">
<button onclick="addModel()">إضافة</button>

<h2>الموديلات</h2>
<table id="modelsTable">
    <thead>
        <tr>
            <th>الرقم</th>
            <th>البراند</th>
            <th>الاسم</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                    <td class="actions">
                        <button onclick="deleteBrand(${brand.id})">🗑 حذف</button>
                    </td>
                </tr>
            `;
            select.innerHTML += `<option value="${brand.id}">${brand.name}</option>`;
        });
    }

    async function fetchModels() {
        let res = await fetch('/api/models');
        let data = await res.json();
        let table = document.querySelector('#modelsTable tbody');
        table.innerHTML = '';
        data.forEach(model => {
            table.innerHTML += `
                <tr>
                    <td>${model.id}</td>
                    <td>${model.brand?.name || ''}</td>
                    <td contenteditable="true" onblur="updateModel(${model.id}, this.innerText)">${model.name}</td>
                    <td class="actions">
                        <button onclick="deleteModel(${model.id})">🗑 حذف</button>
                    </td>
                </tr>
            `;
        });
    }

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

    async function updateBrand(id, name) {
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

    async function addModel() {
        let name = document.getElementById('modelName').value;
        let brand_id = document.getElementById('modelBrandSelect').value;
        if (!name) return alert('أدخل اسم الموديل');
        await fetch('/api/models', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ name, brand_id })
        });
        document.getElementById('modelName').value = '';
        fetchModels();
    }

    async function updateModel(id, name) {
        await fetch(`/api/models/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ name })
        });
    }

    async function deleteModel(id) {
        if (!confirm('هل أنت متأكد من الحذف؟')) return;
        await fetch(`/models/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        fetchModels();
    }

    fetchBrands();
    fetchModels();
</script>

</body>
</html>
