<?php

/**
 * View class for rendering templates
 * 
 * This class provides a simple template engine for rendering HTML views
 * with data passing and layout support.
 */
class View
{
    private string $viewsPath;
    private array $data = [];

    public function __construct(string $viewsPath = null)
    {
        $this->viewsPath = $viewsPath ?? dirname(__DIR__) . '/views';
    }

    /**
     * Set data to be passed to the view
     * 
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function with(string $key, $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Set multiple data at once
     * 
     * @param array $data
     * @return self
     */
    public function withData(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Render a view template
     * 
     * @param string $template Template name (without .php extension)
     * @param array $data Additional data to pass to template
     * @return string Rendered HTML
     */
    public function render(string $template, array $data = []): string
    {
        $templatePath = $this->viewsPath . '/' . $template . '.php';
        
        if (!file_exists($templatePath)) {
            throw new Exception("Template not found: {$template}");
        }

        // Merge additional data with existing data
        $viewData = array_merge($this->data, $data);
        
        // Extract data to variables for use in template
        extract($viewData, EXTR_SKIP);
        
        // Start output buffering
        ob_start();
        
        // Include the template
        include $templatePath;
        
        // Get the buffered content
        $content = ob_get_clean();
        
        return $content;
    }

    /**
     * Render a view with layout
     * 
     * @param string $template Template name
     * @param string $layout Layout name (default: 'main')
     * @param array $data Additional data
     * @return string Rendered HTML
     */
    public function renderWithLayout(string $template, string $layout = 'main', array $data = []): string
    {
        // Render the main content
        $content = $this->render($template, $data);
        
        // Add content to data for layout
        $layoutData = array_merge($data, ['content' => $content]);
        
        // Render the layout
        return $this->render("layouts/{$layout}", $layoutData);
    }

    /**
     * Escape HTML output to prevent XSS
     * 
     * @param string $string
     * @return string
     */
    public function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Get a URL for the application
     * 
     * @param string $path
     * @return string
     */
    public function url(string $path = ''): string
    {
        $baseUrl = rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'], '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }

    /**
     * Get a URL for static assets
     * 
     * @param string $assetPath Path to asset relative to public/assets/
     * @return string
     */
    public function asset(string $assetPath): string
    {
        return $this->url('assets/' . ltrim($assetPath, '/'));
    }

    /**
     * Check if a view exists
     * 
     * @param string $template
     * @return bool
     */
    public function exists(string $template): bool
    {
        return file_exists($this->viewsPath . '/' . $template . '.php');
    }
}
