
import Cropper from 'cropperjs';
import Swal from 'sweetalert2';
import lightbox from 'lightbox2';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
window.addEventListener('DOMContentLoaded', function () {
    var avatar = document.getElementById('avatar');
    var foto = document.getElementById('foto');
    var image = document.getElementById('image');
    var input = document.getElementById('input');
    var $progress = $('.progress');
    var $progressBar = $('.progress-bar');
    var $alert = $('.alert');
    var $modal = $('#modal');
    var cropper;

    $('[data-toggle="tooltip"]').tooltip();

    input.addEventListener('change', function (e) {
      var files = e.target.files;
      var done = function (url) {     
          
        input.value = '';
        image.src = url;
        $alert.hide();
        $modal.modal('show');
      };
      var reader;
      var file;
      var url;

      if (files && files.length > 0) {
        file = files[0];

        if (URL) {            
          done(URL.createObjectURL(file));
        } else if (FileReader) {
           
          reader = new FileReader();
          reader.onload = function (e) {
            done(reader.result);
          };
          reader.readAsDataURL(file);
        }
      }
    });

    $modal.on('shown.bs.modal', function () {
      cropper = new Cropper(image, {        
        viewMode: 1,
      });
    }).on('hidden.bs.modal', function () {
      cropper.destroy();
      cropper = null;
    });

    document.getElementById('crop').addEventListener('click', function () {
      var initialAvatarURL;
      var canvas;
      
      $modal.modal('hide');

      if (cropper) {
        var width;
        var height;
        var image;
        image = cropper.getImageData();        
        width = image.naturalWidth;
        height = image.naturalHeight;
        if(width > 6000 || height > 6000){
          height = height/3;
          width  = width/3;
        }
        canvas = cropper.getCroppedCanvas({
          width: width,
          height: height,
        });
        initialAvatarURL = avatar.src;
        //avatar.src = canvas.toDataURL();
        $progress.show();
        $alert.removeClass('alert-success alert-warning');
        canvas.toBlob(function (blob) {
          var formData = new FormData();
          formData.append('foto', blob, 'pagina.jpg');
          formData.append('pagina',$('meta[name="pagina"]').attr('content'))
          formData.append('livro',$('meta[name="livro"]').attr('content'))
          console.log(formData);
          $.ajax($('meta[name="url-upload-store"]').attr('content'), {
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            xhr: function () {
              var xhr = new XMLHttpRequest();

              xhr.upload.onprogress = function (e) {
                var percent = '0';
                var percentage = '0%';

                if (e.lengthComputable) {
                  percent = Math.round((e.loaded / e.total) * 100);
                  percentage = percent + '%';
                  $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                }
              };

              return xhr;
            },

            success: function () {
              Swal.fire('Uploaded!', 'Imagens enviada com sucesso','success');
              $alert.show().addClass('alert-success').text('Upload success');
              setTimeout(function(){
                window.location.href=$('meta[name="url-paginas"]').attr('content');
              },1500)
            },

            error: function () {
              avatar.src = initialAvatarURL;
              Swal.fire('Falha!!', '01 erro encontrado.','error');
              $alert.show().addClass('alert-warning').text('Erro ao fazer upload.');
            },

            complete: function () {
              $progress.hide();
            },
          });
        });
      }
    });
  });