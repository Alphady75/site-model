const img = document.querySelector('.photo');
const file = document.querySelector('.picture');

const img2 = document.querySelector('.photo2');
const file2 = document.querySelector('.picture2');

const img3 = document.querySelector('.photo3');
const file3 = document.querySelector('.picture3');

if (file) {
   file.addEventListener('change', function () {
      const choosefile = this.files[0];
      if (choosefile) {
         const reader = new FileReader();
         reader.addEventListener('load', function () {
            img.setAttribute('src', reader.result);
         })
         reader.readAsDataURL(choosefile);
      }
   })
}

if (file2) {
   file2.addEventListener('change', function () {
      const choosefile2 = this.files[0];
      if (choosefile2) {
         const reader = new FileReader();
         reader.addEventListener('load', function () {
            img2.setAttribute('src', reader.result);
         })
         reader.readAsDataURL(choosefile2);
      }
   })
}

if (file3) {
   file3.addEventListener('change', function () {
      const choosefile3 = this.files[0];
      if (choosefile3) {
         const reader = new FileReader();
         reader.addEventListener('load', function () {
            img3.setAttribute('src', reader.result);
         })
         reader.readAsDataURL(choosefile3);
      }
   })
}