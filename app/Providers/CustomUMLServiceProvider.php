<?php

namespace App\Providers;

use Andyabih\LaravelToUML\LaravelToUMLServiceProvider;
use App\UML\CustomUMLGenerator;
use Illuminate\Support\ServiceProvider;

class CustomUMLServiceProvider extends LaravelToUMLServiceProvider
{
    /**
     * Generate UML diagram including properties.
     *
     * @return string
     */
    public function generateUML(): string
    {
        $uml = '';

        // Get all classes and generate UML for them
        foreach ($this->getClassNames() as $className) {
            $uml .= $this->renderClass($className);
        }

        return $uml;
    }
    /**
     * Render class with properties.
     *
     * @param string $className
     * @return string
     */
    protected function renderClass(string $className): string
    {
        // Get properties for the class using CustomUMLGenerator
        $properties = CustomUMLGenerator::getClassProperties($className);
        $methods = CustomUMLGenerator::getClassMethods($className);

        // Convert properties and methods to string format for UML
        $propertiesStr = implode(';', $properties);
        $methodsStr = implode(';', $methods);

        return "[{$className}|{$propertiesStr}|{$methodsStr}]\n";
    }
}
