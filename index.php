<?php

class RequestPath{

    private $parts = array();
    
    public function __construct(){
        if(isset($_SERVER['PATH_INFO'])){
            echo 'get path info <br />';
            $path = (substr($_SERVER['PATH_INFO'], -1) == "/") ? 
                substr($_SERVER['PATH_INFO'], 0, -1) : $_SERVER['PATH_INFO'];
        }else{
            echo 'get request uri <br />';
            $path = (substr($_SERVER['REQUEST_URI'], -1) == "/") ? 
                substr($_SERVER['REQUEST_URI'], 0, -1) : $_SERVER['REQUEST_URI'];
        }
        
        $bits = explode("/", substr($path, 1));
        
        $parsed['controller'] = array_shift($bits);
        $parsed[] = $parsed['controller'];
        
        $parsed['action'] = array_shift($bits);
        $parsed[] = $parsed['action'];
        
        $parts_size = sizeof($bits);
        if($parts_size % 2 != 0){
            $parts_size -= 1;
        }
        
        for($i = 0; $i < $parts_size; $i += 2){
            $parsed[$bits[$i]] = $bits[$i+1];
            $parsed[] = $bits[$i+1];
        }
        
        if(sizeof($bits) % 2 != 0){
            $parsed[] = array_pop($bits);
        }
        
        $this->parts = $parsed;
    }
    
    public function __get($key){
        return $this->parts[$key];
    }
    
    public function __set($key, $value){
        $this->parts[$key] = $value;
    }
    
    public function __isset($key){
        return isset($this->parts[$key]);
    }
}

$request = new RequestPath;
echo "Request controller: {$request->controller}<br />";
echo "Request action: {$request->action}<br />";
echo "Request for: {$request->for}<br />";

//test dengan : http://localhost/edit/trackbacks/for/163-My-Example-Page