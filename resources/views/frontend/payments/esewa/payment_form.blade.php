<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to eSewa...</title>
</head>

<body>
    <!-- Form to eSewa Payment Gateway -->
    <form
        action="{{ $isTesting ? 'https://rc-epay.esewa.com.np/api/epay/main/v2/form' : 'https://www.esewa.com.np/api/epay/main/v2/form' }}"
        method="POST" id="esewaForm">
        @foreach ($formData as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <!-- Automatically submit the form after the page loads -->
        <script type="text/javascript">
            document.getElementById('esewaForm').submit();
        </script>
    </form>
</body>

</html>
