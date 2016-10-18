    <script src="templates/js/vendor/jquery.min.js"></script>
    <script src="templates/js/vendor/video.js"></script>
    <script src="templates/js/flat-ui.min.js"></script>
    <script src="templates/js/sweetalert.min.js"></script>
    {literal}<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
      $('select').select2({dropdownCssClass: 'dropdown-inverse'});
    })
    $(document).ready(function() {
      $(".modal").on('shown.bs.modal', function() {
        $('#ShowPasswordInput').focus();
        $('#NewName').focus();
      });
    });
    function Rename(OldName) {
      $('#OldName').val('');
      $('#OldName').val(OldName);
      $('#NewName').val('');
      $('#NewName').val(OldName);
    }
    $('.delete').click(function(e){
      e.preventDefault();
      var link = $(this).attr('href');

      swal({
        title: "Da li ste sigurni?",
        text: "Nećete biti u mogućnosti da povratite obrisani fajl!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Da, obriši!",
        closeOnConfirm: false
      },
      function(){
        window.location.href = link;
      });
    });
    </script>{/literal}
  </body>
</html>
