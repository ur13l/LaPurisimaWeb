$("#imagen").on('change',function(){
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imagen-view").attr('src', e.target.result);
            $("#imagen-view").attr('height', 200);
        }
        reader.readAsDataURL(this.files[0]);
    }
});