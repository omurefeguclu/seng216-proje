<?php
$currentPath = $viewEngine->requestContext->path;
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">
        <li class="breadcrumb-item">
            <a class="link-body-emphasis" href="/">
                <svg class="bi"><use xlink:href="#house-door-fill"></use> </svg>
                <span class="visually-hidden">Home</span>
            </a>
        </li>
        <?php
        if($breadcrumb) {
            foreach($breadcrumb as $breadcrumbItem) {
                $isActive = $breadcrumbItem[1] == $currentPath;

                echo '<li class="breadcrumb-item'. ($isActive ? ' active' : '') . '">
            <a class="link-body-emphasis fw-semibold text-decoration-none" href="'. $breadcrumbItem[1] .'">'
                . $breadcrumbItem[0] .
            '</a>
        </li>';
            }
        }
        ?>
    </ol>
</nav>