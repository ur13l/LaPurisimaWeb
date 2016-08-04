<!DOCTYPE html>
<html>
  <head>
    <title>Photo</title>
  </head>
  <body>
    <form class="" action="{{ URL::to('usuario/uploadPhoto')}}" method="post" enctype="multipart/form-data">
      <input type="text" name="id" value="2">
      <input type="file" name="imagen_usuario" id="file">
      <input type="submit" name="upload" value="upload">
    </form>
  </body>
</html>
