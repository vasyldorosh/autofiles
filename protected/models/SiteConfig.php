<?php
/**
 * Author: Yuriy Sorokolat aka Sw00p (Aiken Studio)
 * Date: 07.06.2010
 * Time: 13:33:05
 */

class SiteConfig {
    /* Имя файла-хранилища */
    const FILE_NAME = 's.conf';

    protected $_data = null;
    protected static $_instance = null;

    private function __construct() {}
    private function __clone() {}

    /**
     * @static
     * @return SiteConfig
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new SiteConfig();
        }
        return self::$_instance;
    }

    /**
     * Получить массив всех данных конфига
     * @return array
     */
    public function getData() {
        $this->_init();
        return $this->_data;
    }

    /**
     * Вернуть значение параметра конфига по его имени
     * 
     * @param string $name
     * @param bool $defaultValue
     * @return mixed
     */
    public function getValue($name, $defaultValue = true) {
        $this->_init();
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
        return $defaultValue;
    }

    public function setValue($name, $value) {
        $this->_data[$name] = $value;
    }

    private function _init() {
        if (is_null($this->_data)) {
            if ($this->_loadFromFile()) {
                return true;
            }
            
        }
        //throw new CException('Ошибка при загрузке конфига приложения');
    }

    private function _loadFromFile() {
        $filePath = $this->_getFilePath();
        if (file_exists($filePath) && $content = file_get_contents($filePath)) {
            $unserializedContent = unserialize($content);
            if ($unserializedContent) {
            	
                $this->_data = $unserializedContent;
                return true;
            }
        }
        return false;
    }

    private function _getFilePath() {
        $path = YiiBase::getPathOfAlias('application.config');
        $filePath = $path .DIRECTORY_SEPARATOR. self::FILE_NAME;
        return $filePath;
    }

    private function _saveToFile() {
        $filePath = $this->_getFilePath();
        return file_put_contents($filePath, serialize($this->_data));
    }

    public function save() {
        $this->_saveToFile();
    }
}
