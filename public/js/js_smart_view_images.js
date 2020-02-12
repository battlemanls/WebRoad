

$(document).ready(function() {
    var full = false;



$(function () {




});


$(function () {
    // Get the modal

    var photo = $('#myImg');

   if(photo.length!=0) {

       var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
       var img = document.getElementById("myImg");
       var modalImg = document.getElementById("img01");
       var captionText = document.getElementById("caption");
       img.onclick = function () {

           modal.style.display = "block";
           //  modalImg.src = this.title
           modalImg.src = $('#url_img').html();
           //   captionText.innerHTML = this.alt;
       }

// Get the <span> element that closes the modal
       var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
       span.onclick = function () {
           modal.style.display = "none";
       }

   }
})



})


