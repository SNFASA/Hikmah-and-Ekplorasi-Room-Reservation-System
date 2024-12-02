<?php

namespace App\UML;

use ReflectionClass;
use ReflectionProperty;

class CustomUMLGenerator
{
    /**
     * Extract class properties.
     *
     * @param string $className
     * @return array
     */
    public static function getClassProperties(string $className): array
    {
        $reflection = new ReflectionClass($className);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
        $propertyList = [];

        foreach ($properties as $property) {
            $visibility = $property->isProtected() ? '#' : ($property->isPrivate() ? '-' : '+');
            $propertyList[] = "{$visibility}{$property->getName()}";
        }

        return $propertyList;
    }
}
