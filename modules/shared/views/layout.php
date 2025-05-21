
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
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi pe-none me-2" width="40" height="32" aria-hidden="true"><use xlink:href="#bootstrap"></use></svg> <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                    <svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true"><use xlink:href="#speedometer2"></use></svg>
                    Home
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true"><use xlink:href="#speedometer2"></use></svg>
                    Dashboard
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="javascript:void(0);" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/assets/images/avatar.png" alt="" width="32" height="32" class="rounded-circle">
                <strong class="ps-2 pe-2">omurefeguclu</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>

    <div class="d-flex flex-column flex-fill">
        <?= $content ?>

    </div>
</main>


<script src="/assets/lib/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
