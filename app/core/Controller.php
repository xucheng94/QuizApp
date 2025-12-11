<?php

class Controller {
    /**
     * Render a view with optional data
     * Usage:
     *   $this->view('home', ['pageTitle' => 'Home']);
     */
    protected function view(string $view, array $data = [])
    {
        // Extract variables into local scope (e.g. $pageTitle, $pageCSS, etc.)
        if (!empty($data)) {
            extract($data, EXTR_SKIP);
        }

        $file = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($file)) {
            require $file;
        } else {
            throw new Exception("View '{$view}' not found in /views/");
        }
    }


    /**
     * Load a model class from /app/models/
     * Usage:
     *   $user = $this->model('User');
     */
    protected function model(string $model)
    {
        $file = __DIR__ . '/../models/' . $model . '.php';

        if (file_exists($file)) {
            require_once $file;

            if (class_exists($model)) {
                return new $model();
            }

            throw new Exception("Model class '{$model}' not found inside {$model}.php");
        }

        throw new Exception("Model file '{$model}.php' not found in /models/");
    }


    /**
     * Redirect to another route cleanly
     */
    protected function redirect(string $route, array $params = [])
    {
        header("Location: /quiz_app/?route={$route}&" . http_build_query($params));
        exit;
    }
}

?>