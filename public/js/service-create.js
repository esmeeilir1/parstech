document.addEventListener('DOMContentLoaded', function () {
    // تولید خودکار کد خدمات
    const codeInput = document.getElementById('service_code');
    const customSwitch = document.getElementById('custom_code_switch');
    let baseCode = 'ser' + (10000 + Math.floor(Math.random() * 9000));
    codeInput.value = baseCode;
    codeInput.readOnly = true;

    customSwitch.addEventListener('change', function() {
        if(customSwitch.checked) {
            codeInput.readOnly = false;
            codeInput.value = '';
            codeInput.focus();
        } else {
            codeInput.readOnly = true;
            codeInput.value = baseCode;
        }
    });

    // پیش‌نمایش تصویر خدمات
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image_preview');
    if(imageInput){
        imageInput.addEventListener('change', function() {
            if (imageInput.files && imageInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.style.display = "block";
                    imagePreview.src = e.target.result;
                }
                reader.readAsDataURL(imageInput.files[0]);
            }
        });
    }

    // افزودن واحد جدید
    let selectedUnitIndex = null;
    document.getElementById('add-unit-btn').addEventListener('click', function() {
        document.getElementById('addUnitModalLabel').innerText = 'افزودن واحد جدید';
        document.getElementById('new-unit-input').value = '';
        document.getElementById('edit-unit-index').value = '';
        $('#addUnitModal').modal('show');
    });


    // ثبت واحد (افزودن یا ویرایش)
    document.getElementById('add-unit-form').addEventListener('submit', function(e) {
        e.preventDefault();
        let newUnit = document.getElementById('new-unit-input').value.trim();
        let editIndex = document.getElementById('edit-unit-index').value;
        let unitList = document.getElementById('unit-list');
        let select = document.getElementById('unit');

        if (editIndex === '') {
            // افزودن
            let exists = false;
            for(let i=0; i<select.options.length; i++) {
                if(select.options[i].value === newUnit) exists = true;
            }
            if(!exists && newUnit.length > 0) {
                // افزودن به سلکت
                let opt = document.createElement('option');
                opt.value = newUnit;
                opt.text = newUnit;
                select.appendChild(opt);

                // افزودن به لیست
                let li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center p-1';
                li.innerHTML = `<span class="unit-name">${newUnit}</span>
                <span>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-unit-btn">حذف</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary edit-unit-btn">ویرایش</button>
                </span>`;
                unitList.appendChild(li);
            }
        } else {
            // ویرایش
            let lis = unitList.getElementsByTagName('li');
            if(lis[editIndex]) {
                lis[editIndex].querySelector('.unit-name').innerText = newUnit;
                select.options[editIndex].value = newUnit;
                select.options[editIndex].text = newUnit;
            }
        }
        $('#addUnitModal').modal('hide');
    });
    // حذف و ویرایش واحد
    document.getElementById('unit-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('delete-unit-btn')) {
            let li = e.target.closest('li');
            let name = li.querySelector('.unit-name').innerText;
            if(confirm('حذف واحد "' + name + '"؟')) {
                let select = document.getElementById('unit');
                for(let i=0; i<select.options.length; i++) {
                    if(select.options[i].value === name) {
                        select.remove(i);
                        break;
                    }
                }
                li.remove();
            }
        }
                if(e.target.classList.contains('edit-unit-btn')) {
            let li = e.target.closest('li');
            let name = li.querySelector('.unit-name').innerText;
            let unitList = document.getElementById('unit-list');
            let lis = Array.from(unitList.getElementsByTagName('li'));
            let index = lis.indexOf(li);
            document.getElementById('addUnitModalLabel').innerText = 'ویرایش واحد';
            document.getElementById('new-unit-input').value = name;
            document.getElementById('edit-unit-index').value = index;
            $('#addUnitModal').modal('show');
        }
    });

    // تغییر رنگ سربرگ بر اساس گروه خدمات
    const categorySelect = document.getElementById('service_category_id');
    const cardHeader = document.getElementById('service-header');
    if(categorySelect && cardHeader){
        categorySelect.addEventListener('change', function(){
            let selected = categorySelect.options[categorySelect.selectedIndex];
            let color = selected.getAttribute('data-color');
            if(color){
                cardHeader.style.background = `linear-gradient(90deg, var(--main) 0%, ${color} 100%)`;
            }else{
                cardHeader.style.background = '';
            }
        });
    }
});
