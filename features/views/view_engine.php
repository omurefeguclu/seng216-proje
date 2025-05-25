<?php

class ViewEngine {
    public function __construct()
    {
        $this->customScripts = '';
    }

    public string $customScripts;

    public function startCustomScripts() {
        ob_start();
    }

    public function endCustomScripts()
    {
        $this->customScripts .= ob_get_clean();
    }

}