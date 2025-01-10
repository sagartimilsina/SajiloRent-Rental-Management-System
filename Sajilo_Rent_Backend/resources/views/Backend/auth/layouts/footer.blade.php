<script>
    // JavaScript for toggling password visibility
    const pwShowHide = document.querySelectorAll(".eye-icon");
    pwShowHide.forEach(eyeIcon => {
        eyeIcon.addEventListener("click", () => {
            let pwFields = eyeIcon.parentElement.querySelectorAll(".password");
            pwFields.forEach(password => {
                if (password.type === "password") {
                    password.type = "text"; // Show the password
                    eyeIcon.classList.replace("bx-hide", "bx-show"); // Change icon to show
                } else {
                    password.type = "password"; // Hide the password
                    eyeIcon.classList.replace("bx-show", "bx-hide"); // Change icon to hide
                }
            });
        });
    });
</script>
<script src="/sneat_backend/assets/js/ui-toasts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<script>
    < script >
        $(function() {
            $("#date-range").daterangepicker({
                locale: {
                    format: "YYYY-MM-DD",
                },
                opens: "left",
                minDate: moment().startOf("day"), // Disable past dates
                startDate: moment().startOf("day"),
                endDate: moment().add(1, "days"), // Default end date as tomorrow
            });
        }); <
    />
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
