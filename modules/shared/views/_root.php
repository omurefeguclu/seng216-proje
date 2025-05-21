
<!DOCTYPE html>
<html>
<head>
    <title>My App</title>

    <link href="/assets/lib/bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .bi {
            vertical-align: -.125em;
        }
        svg {
            fill: currentColor;
        }
    </style>
</head>
<body>
<div class="d-none">
    <?php include __DIR__ . '/../../../public/assets/lib/bootstrap-icons/bootstrap-icons.svg' ?>
</div>


<main class="d-flex flex-nowrap min-vh-100">
    <?php echo $content ?>
</main>


<script src="/assets/lib/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>