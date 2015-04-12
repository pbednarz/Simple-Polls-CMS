<?php

/*
 * This file is part of Slim HTTP Basic Authentication middleware
 *
 * Copyright (c) 2013-2014 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/slim-basic-auth
 *
 */

namespace Slim\Middleware;

 use \Slim\Middleware\HttpBasicAuthentication\ArrayAuthenticator;
 use \Slim\Middleware\HttpBasicAuthentication\DefaultValidator;

class HttpBasicAuthentication extends \Slim\Middleware
{
    public $options;

    public function __construct($options = null)
    {

        /* Default options. */
        $this->options = array(
            "users" => array(),
            "path" => "/",
            "realm" => "Protected",
            "environment" => "HTTP_AUTHORIZATION"
        );

        /* Pass all options. Extra stuff get ignored anyway. */
        $this->options["authenticator"] = new ArrayAuthenticator($options);
        $this->options["validator"] = new DefaultValidator($options);

        if ($options) {
            $this->options = array_merge($this->options, (array)$options);
        }
    }

    public function call()
    {
        $environment = $this->app->environment;

        if ($this->shouldAuthenticate()) {
            /* Just in case. */
            $user = false;
            $pass = false;

            /* If using PHP in CGI mode. */
            if (isset($_SERVER[$this->options["environment"]])) {
                if (preg_match("/Basic\s+(.*)$/i", $_SERVER[$this->options["environment"]], $matches)) {
                    list($user, $pass) = explode(":", base64_decode($matches[1]));
                }
            } else {
                $user = $environment["PHP_AUTH_USER"];
                $pass = $environment["PHP_AUTH_PW"];
            }

            /* Check if user authenticates. */
            if ($this->options["authenticator"]->authenticate($user, $pass)) {
                $this->next->call();
            } else {
                $this->app->response->status(401);
                $this->app->response->header("WWW-Authenticate", sprintf('Basic realm="%s"', $this->options["realm"]));
                return;
            }
        } else {
            $this->next->call();
        }
    }

    public function shouldAuthenticate()
    {
        $request = $this->app->request;

        /* If path matches what is given on initialization. */
        $path = rtrim($this->options["path"], "/");
        $regex = "@{$path}(/.*)?$@";
        $path_matches = !!preg_match($regex, $request->getPath());

        /* If validator returns true should authenticate. */
        $validator_passes = !!$this->options["validator"]->validate();

        return $path_matches && $validator_passes;
    }
}
