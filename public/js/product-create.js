document.addEventListener("DOMContentLoaded", function(){
    const codeLock = document.getElementById('code_lock');
    const codeInput = document.getElementById('product_code');
    codeLock.addEventListener('change', function() {
        if(this.checked) {
            codeInput.readOnly = true;
            codeInput.value = codeInput.dataset.default || codeInput.value;
        } else {
            codeInput.readOnly = false;
            codeInput.select();
        }
    });
});
