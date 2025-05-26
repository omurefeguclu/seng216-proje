<?php

function setLayout(string $layoutViewName) {
    global $viewEngine;

    $viewEngine->setLayout($layoutViewName);
}

function renderPartial(string $partialViewName, array $model = []) {
    global $viewEngine;

    return $viewEngine->renderPartial($partialViewName, $model);
}
