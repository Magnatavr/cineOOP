<?php

namespace App\Kernel\Router;



use App\Kernel\Auth\AuthInterface;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Http\RedirectInterface;

use App\Kernel\Http\RequestInterface;

use App\Kernel\Middleware\AbstractMiddleware;
use App\Kernel\Session\SessionInterface;

use App\Kernel\Storage\StorageInterface;
use App\Kernel\View\ViewInterface;



class Router implements RouterInterface
{

    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function __construct(
        private ViewInterface $view,
        private RequestInterface $request,
        private RedirectInterface $redirect,
        private SessionInterface $session,
        private DatabaseInterface $database,
        private AuthInterface $auth,
        private StorageInterface $storage
    ) {
        $this->initRoutes();
    }

    public function dispatch(string $uri, string $method)
    {

        $routeKey = $this->getValidRoute($uri);
        $routeObj = $this->findRoute($routeKey, $method);

        if (!$routeObj) {
            $this->notFound();
            return;
        }

        if ($routeObj->hasMiddlewares()) {
            foreach ($routeObj->getMiddlewares() as $middleware) {
                /** @var \App\Kernel\Middleware\AbstractMiddleware $middleware */
                $middleware = new $middleware($this->request, $this->auth, $this->redirect);
                $middleware->handle();
            }
        }

        $action = $routeObj->getAction();
        if (is_array($routeObj->getAction())) {
            [$controller, $action] = $routeObj->getAction();
            $controller = new $controller();


            call_user_func([$controller, 'setView'], $this->view);
            call_user_func([$controller, 'setRequest'], $this->request);
            call_user_func([$controller, 'setRedirect'], $this->redirect);
            call_user_func([$controller, 'setSession'], $this->session);
            call_user_func([$controller, 'setDatabase'], $this->database);
            call_user_func([$controller, 'setAuth'], $this->auth);
            call_user_func([$controller, 'setStorage'], $this->storage);



            call_user_func([$controller, $action]);
        } else {
            if (is_callable($action)) {
                $action();
            } else {
                throw new \Exception("Route action is not callable");
            }
        }



    }
    private function findRoute(string $route, string $method): Route|false
    {
        if (!isset($this->routes[$method][$route])) {
            return false;
        }
        return $this->routes[$method][$route];
    }

    private function initRoutes()
    {

        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }

    }

    public function getValidRoute($uri)
    {

        // Убираем /video-version/public/ и опционально index.php/
        $uri = preg_replace('#^/[^/]+/public/(index\.php/)?#', '', $uri);
        // "admin/movies/add.php"
        $uri = parse_url($uri, PHP_URL_PATH);
        //убираем гет параметры 


        // Разбиваем на сегменты
        /**
         *  array:3 [▼
         * 0 => "admin"
         * 1 => "movies"
         * 2 => "add.php"
         * ]
         */
        $segments = explode('/', trim($uri, '/'));

        if (empty($segments[0]) || $segments[0] === 'index.php') {
            return 'home';
        }

        return implode('/', $segments);

    }
    private function getRoutes(): array
    {
        return require BASE_PATH . "/config/routes.php";
    }
    private function notFound(): void
    {
        echo '404';
    }

}