<?php

namespace Core;

	class Router{

	    /**
         * Associatve array of routes (the routing table)
         * @var array
	    */
		public $routes = [];

		/**
         * Parameters from the matched route(url)
         * @var array
		*/
		public $params = [];

		/**
         * Add a route to the routing table
         * @param string $route The route URL
         * @param array $params Parameters(Controllers,action,id,etc.)
		*/
		public function add($route,$params=[]){

            // Convert the route to a regular expression: escape forward slashes
            $route = preg_replace('/\//', '\\/', $route);
            // Convert variables e.g. {controller}
            $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
            // Convert variables with custom regular expressions e.g. {id:\d+}
            $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
            // Add start and end delimiters, and case insensitive flag
            $route = '/^' . $route . '$/i';
            $this->routes[$route] = $params;

		}

		public function getRoutes()
		{
			return $this->routes;
		}

		/**
         * Match the route to the routes in the routing table,setting the $params
         * property if the route is found.
         *
         * @param string $url The route URL
         * @return boolean true if a match found , false otherwise
		*/

		public function  match($url)
		{

			//Match to the fixed URL format /controller/action


			foreach ($this->routes as $route => $params) {


				if (preg_match($route, $url, $matches)) {
            	//Get named capture group values

            		foreach ($matches as $key => $match) {

            				if (is_string($key)) {

            					//print_r($params[$key] = $match . "<br><br>");
                                $params[$key] = $match;
            				}

            	}

                $this->params = $params;
                return true;

            }

			}
            return false;

        }

        /**
         * Dispatch the route, creating the controller object and running the
         * action method
         *
         * @param string $url The route URL
         *
         * @return void
         */

	public function dispatch($url){

        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {

            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller; // App/Controller/Admin/User

            if (class_exists($controller)) {

                $controller_object = new $controller($this->params); // new Items([controller] => Items [action] =>signup);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {

                    $controller_object->$action(); // User->create();

                } else {

                    throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                }
            } else {

                throw new \Exception("Controller class $controller not found");
            }
        } else {

            throw new \Exception('No route matched.', 404);
        }
    }


        /**
         * Get the currently matched parameters
         * @return array
         */

        public function getParams(){

            return $this->params;

        }

        /**
     * Get the namsepsace for the controller class. The namespace defined in the
     * route parametrs is added if present
     *
     *  @return string the Request URL
     */




        public function getNamespace(){
              
            
            $namespace = 'App\Controllers\\';

            if (array_key_exists('namespace', $this->params)) {

                $namespace = 'App\\'.$this->params["namespace"] . '\\' . 'Controllers\\';

            }
            return $namespace;
        }


    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToStudlyCaps($string){

        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase($string){

        return lcfirst($this->convertToStudlyCaps($string));

    }



    protected function removeQueryStringVariables($url){

        if ($url != '') {

            $parts = explode('&', $url, 2);

                if (strpos($parts[0], '=') === false) {

                $url = $parts[0];

            }else{

                $url = '';
            }

        }

        return $url;
    }




}




 ?>