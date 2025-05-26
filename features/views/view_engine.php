<?php

class ViewEngine {
    public function __construct(string $moduleViewPath)
    {
        $this->customScripts = '';

        $this->searchViewPaths = [
            $moduleViewPath,
            __DIR__ . '/../../modules/shared/views/'
        ];
    }

    public string $customScripts;
    private $searchViewPaths;
    private string|null $currentLayoutViewName;


    public function startCustomScripts() {
        ob_start();
    }
    public function endCustomScripts()
    {
        $this->customScripts .= ob_get_clean();
    }

    public function setLayout(string $layoutViewName) {
        $this->currentLayoutViewName = $layoutViewName;
    }
    private function consumeLayout(): string | null{
        $layout = $this->currentLayoutViewName;
        $this->currentLayoutViewName = null;

        return $layout;
    }


    private function cycle_paths(array $viewPaths, string $viewName): string|null {
        foreach ($viewPaths as $viewPath) {
            $viewFile = $viewPath . $viewName . '.php';
            if (file_exists($viewFile)) {
                return $viewFile;
            }
        }

        return null;
    }
    private function findView(string $viewName) {
        $viewFile = $this->cycle_paths($this->searchViewPaths, $viewName);
        if (!$viewFile) {
            http_response_code(500);
            throw new Exception("View not found: $viewFile");
        }

        return $viewFile;
    }
    public function renderView(string $viewName, array $model = []) {
        $viewFile = $this->findView($viewName);
        $viewEngine = $this;

        extract($model);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        while($layoutViewName = $this->consumeLayout()) {
            $layoutViewFile = $this->findView($layoutViewName);
            ob_start();
            require $layoutViewFile;
            $content = ob_get_clean();
        }

        return $content;
    }
    public function renderPartial(string $viewName, array $model = []) {
        $viewFile = $this->findView($viewName);
        $viewEngine = $this;

        extract($model);
        ob_start();
        require $viewFile;

        return ob_get_clean();
    }
}