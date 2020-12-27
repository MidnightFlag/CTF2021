<?php
require_once('Controller.php');

class ApplicationController
{
    private static $instance;
    private $routes;

    private function __construct()
    {
        $this->routes = [
            '/' => ['controller' => null, 'view' => 'MainView'],
            'validPseudo' => ['controller' => 'ValidPseudoController', 'view' => null],
            'home' => ['controller' => null, 'view' => 'HomeView'],
            'addSecret' => ['controller' => null, 'view' => 'AddSecretView'],
            'saveSecret' => ['controller' => 'SaveSecretController', 'view' => null],
            'manageSecrets' => ['controller' => null, 'view' => 'ManageSecretsView'],
            'manageOneSecret' => ['controller' => null, 'view' => 'ManageOneSecretView'],
            'modifySecret' => ['controller' => 'ModifySecretController', 'view' => null]
        ];
    }

    /**
     * Returns the single instance of this class.
     * @return ApplicationController the single instance of this class.
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ApplicationController;
        }
        return self::$instance;
    }

    /**
     * Returns the controller that is responsible for processing the request
     * specified as parameter. The controller can be null if their is no data to
     * process.
     * @param Array $request The HTTP request.
     * @param Controller The controller that is responsible for processing the
     * request specified as parameter.
     * @return The controller associate if exists
     */
    public function getController($request)
    {
        if (array_key_exists($request['page'], $this->routes)) {
            return $this->routes[$request['page']]['controller'];
        }
        return null;
    }

    /**
     * Returns the view that must be return in response of the HTTP request
     * specified as parameter.
     * @param Array $request The HTTP request.
     * @param Object The view that must be return in response of the HTTP request
     * @return The view associate if exists
     * specified as parameter.
     */
    public function getView($request)
    {
        if (array_key_exists($request['page'], $this->routes)) {
            return $this->routes[$request['page']]['view'];
        }
        header('Location:?page=/');
    }
}