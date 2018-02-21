<?php

class Databaselight
{
    private $handle = null;
    private static $instances = null;
    private $name;

    /**
     * @return Databaselight
     */
    public static function factory($name = 'default')
    {
        $instance = new self();
        $instance->name = $name;
        return $instance;
    }

    /**
     * @return Databaselight
     */
    public static function singleton($name = 'default')
    {
        if (is_array(self::$instances) == false) {
            self::$instances = array();
        }
        if (isset(self::$instances[$name]) == false) {
            self::$instances[$name] = self::factory($name);
        }
        return self::$instances[$name];
    }

    private function _connect()
    {
        if ($this->handle == null) {
            try {
                $configs = \Fuel\Core\Config::get('db');
                $this->handle = new \PDO(
                    $configs['default']['connection']['dsn'],
                    $configs['default']['connection']['username'],
                    $configs['default']['connection']['password']
                );
            } catch (\PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public function all($sql, $values = array())
    {
        $sth = $this->prepare($sql);
        $this->execute($sth, $values);
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function row($sql, $values = array())
    {
        $sth = $this->prepare($sql);
        $this->execute($sth, $values);
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function one($sql, $values = array())
    {
        $sth = $this->prepare($sql);
        $this->execute($sth, $values);
        $array = $sth->fetch(\PDO::FETCH_NUM);
        return is_array($array) ? $array[0] : false;
    }

    /**
     * @return PDOStatement
     */
    public function prepare($sql)
    {
        $this->_connect();
        $sth = $this->handle->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
        if ($sth == false) {
            throw new \Exception(
                implode(':', $this->handle->errorInfo()) . ' "' . $sql . '"'
            );
        }
        return $sth;
    }

    public function execute($sth, $values = array())
    {
        $sth->closeCursor();

        if (is_array($values) === false) {
            $values = array($values);
        }

        foreach ($values as $key => $value) {
            if (is_string($key) && substr($key, 0, 1) !== ':') {
                unset($values[$key]);
                $values[':' . $key] = $value;
            }
        }

        if ($sth->execute($values) === false) {
            $error = $sth->errorInfo();
            throw new \Exception(
                $error[2] . ':' . $sth->queryString
            );
        }

        return $sth->rowCount();
    }

    public function begin()
    {
        $this->_connect();
        $this->handle->beginTransaction();
    }

    public function commit()
    {
        $this->handle->commit();
    }

    public function rollback()
    {
        $this->handle->rollback();
    }

    public function exec($sql, $values = array())
    {
        $sth = $this->prepare($sql);
        return $this->execute($sth, $values);
    }

    public function close()
    {
        $this->handle = null;
    }

}
