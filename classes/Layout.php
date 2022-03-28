<?php

include 'Config.php';

class Layout
{
    protected static $_instance;

    private $pathsCSS = [];
    private $pathsJS = [];

    private const fileSetting = 'Layout';

    private const folderJS = 'js';
    private const folderCSS = 'css';

    private function connectFont($font){
     echo '<link href="https://fonts.googleapis.com/css2?family='.$font.':wght@500&display=swap" rel="stylesheet">';
    }

    protected function __construct() {
        $font = Config::getSetting('FONT', self::fileSetting);
        $this->loadResource();
        $this->connectFont($font);
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function connectCSS()
    {
        foreach ($this->pathsCSS as $path)

            echo '<link rel="stylesheet" href='.$path.' type="text/css"/>';
    }

    public function getJS() : array
    {
        return $this->pathsJS;
    }

    private function loadResource(){
        $this->pathsCSS = $this->getPath(self::folderCSS, 'css');
        $this->pathsJS = $this->getPath(self::folderJS, 'js');
    }

    private function getPath($nameFolder, $extension){
        return glob('./static/' .$nameFolder .'/*.' .$extension);
    }

}