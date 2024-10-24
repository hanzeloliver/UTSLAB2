<?php
$error_code = $_SERVER['REDIRECT_STATUS'] ?? 404;
$error_messages = [
    403 => 'Forbidden',
    404 => 'Page Not Found',
    500 => 'Internal Server Error'
];
$error_message = $error_messages[$error_code] ?? 'Unknown Error';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?php echo $error_code; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 class="display-1"><?php echo $error_code; ?></h1>
                <h2 class="mb-4"><?php echo htmlspecialchars($error_message); ?></h2>
                <p class="mb-4">Sorry, something went wrong. Please try again or return to the homepage.</p>
                <a href="/" class="btn btn-primary">Go Home</a>
            </div>
        </div>
    </div>
</body>
</html>