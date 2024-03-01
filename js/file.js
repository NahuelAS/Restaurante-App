document.getElementById('file-upload').onchange = function () {
    var fileName = this.value.split('\\').pop();
    // Asumiendo que tienes un elemento para mostrar el nombre del archivo
    document.getElementById('file-name').textContent = fileName;
};

document.getElementById('file-upload').addEventListener('change', function() {
    var fileName = this.files[0].name;
    document.getElementById('file-name').textContent = fileName;
});