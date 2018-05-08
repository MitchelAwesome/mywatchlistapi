<?php

namespace AppBundle\Form\Enum;

class WatchStatusTypeEnum
{
    const TYPE_WATCHING    = "watching";
    const TYPE_FINISHED = "finished";
    const TYPE_TODO = "todo";

    /** @var array text that will show up in dropdown */
    protected static $typeName = [
        self::TYPE_WATCHING => 'Watching',
        self::TYPE_FINISHED => 'Finished',
        self::TYPE_TODO => 'To Do'
    ];

    /**
     * @param $typeShortName
     * @return string
     */
    public static function getTypeName($typeShortName)
    {
        if (!isset(static::$typeName[$typeShortName])) {
            return "Unknown enum type ($typeShortName)";
        }

        return static::$typeName[$typeShortName];
    }

    /**
     * @return array
     */
    public static function getAvailableTypes()
    {
        return [
            self::TYPE_WATCHING,
            self::TYPE_FINISHED,
            self::TYPE_TODO
        ];
    }
}
