  <!-- Core JS -->
  <!-- build:/sneat_backend/assets/vendor/js/core.js -->


  <script src="/sneat_backend/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="/sneat_backend/assets/vendor/libs/popper/popper.js"></script>
  <script src="/sneat_backend/assets/vendor/js/bootstrap.js"></script>
  <script src="/sneat_backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="/sneat_backend/assets/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="/sneat_backend/assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="/sneat_backend/assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="/sneat_backend/assets/js/dashboards-analytics.js"></script>
  <script src="/sneat_backend/assets/js/ui-toasts.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->

  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
  <script>
      $(document).ready(function() {
          // General toast function
          function showToast(type, message, title = 'Notification') {
              const toast = $('#toastMessage'); // Get the toast container

              // Reset previous classes and add the correct type class
              toast.removeClass('bg-success bg-danger').addClass(`bg-${type}`);


              // Set message and title
              $('#toastBody').text(message);

              // Display the toast
              toast.fadeIn().show();

              // Hide the toast after 10 seconds
              setTimeout(function() {
                  toast.fadeOut();
              }, 5000);
          }

          // Show success toast
          function showSuccessToast(message) {
              showToast('success', message, 'Success');
          }

          // Show error toast
          function showErrorToast(message) {
              showToast('danger', message, 'Error');
          }

          // Example usage (from session flash messages)
          @if (Session::has('success'))
              showSuccessToast('{{ Session::get('success') }}');
          @endif

          @if (Session::has('error'))
              showErrorToast('{{ Session::get('error') }}');
          @endif
      });
  </script>




  </body>

  </html>
