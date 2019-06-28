<?php

abstract class Enum
{
    /**
     * @var int
     */
    protected $id;

    protected static $list;

    abstract public function getDefaultId();

    abstract public function getDefaultValue();

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        if (!isset(static::$list[$this->getId()])) {
            return $this->getDefaultValue();
        }

        return static::$list[$this->getId()];
    }

    public static function getList()
    {
        return static::$list;
    }

    /**
     * @param $id
     * @return static
     */
    public static function create($id)
    {
        if (!isset(static::$list[$id])) {
            $id = (new static())->getDefaultId();
        }

        return (new static())
            ->setId($id);
    }

    /**
     * @param $id
     * @return static
     */
    public static function createByValue($value)
    {
        foreach(static::$list as $itemId => $itemValue) {
            if ($itemValue == $value) {
                return (new static())
                    ->setId($itemId);
            }
        }

        $id = (new static())->getDefaultId();

        return (new static())
            ->setId($id);
    }
}