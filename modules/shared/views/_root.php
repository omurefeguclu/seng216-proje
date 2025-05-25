
<!DOCTYPE html>
<html>
<head>
    <title>My App</title>

    <link href="/assets/lib/bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .bi {
            vertical-align: -.125em;
            width: 16px;
            height: 16px;
        }
        .icon-md {
            width: 20px;
            height: 20px;
        }
        .icon-lg {
            width: 24px;
            height: 24px;
        }
        svg {
            fill: currentColor;
            pointer-events: none;
        }
    </style>
</head>
<body>
<div class="d-none">
    <?php include __DIR__ . '/../../../public/assets/lib/bootstrap-icons/bootstrap-icons.svg' ?>
</div>


<?= $content ?>


<script src="/assets/oeg.templating.js"></script>
<script src="/assets/app.js"></script>
<script src="/assets/lib/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js"></script>
<?= $viewEngine->customScripts ?>

</body>
</html>