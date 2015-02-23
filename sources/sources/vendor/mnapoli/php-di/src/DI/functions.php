<?php
/**
 * PHP-DI
 *
 * @link      http://php-di.org/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI;

use DI\Definition\EntryReference;
use DI\Definition\Helper\ArrayDefinitionExtensionHelper;
use DI\Definition\Helper\FactoryDefinitionHelper;
use DI\Definition\Helper\ClassDefinitionHelper;
use DI\Definition\Helper\EnvironmentVariableDefinitionHelper;
use DI\Definition\Helper\ValueDefinitionHelper;
use DI\Definition\Helper\StringDefinitionHelper;

if (! function_exists('DI\value')) {
    /**
     * Helper for defining an object.
     *
     * @param mixed $value
     *
     * @return ValueDefinitionHelper
     */
    function value($value)
    {
        return new ValueDefinitionHelper($value);
    }
}

if (! function_exists('DI\object')) {
    /**
     * Helper for defining an object.
     *
     * @param string|null $className Class name of the object.
     *                               If null, the name of the entry (in the container) will be used as class name.
     *
     * @return ClassDefinitionHelper
     */
    function object($className = null)
    {
        return new ClassDefinitionHelper($className);
    }
}

if (! function_exists('DI\factory')) {
    /**
     * Helper for defining a container entry using a factory function/callable.
     *
     * @param callable $factory The factory is a callable that takes the container as parameter
     *                          and returns the value to register in the container.
     *
     * @return FactoryDefinitionHelper
     */
    function factory($factory)
    {
        return new FactoryDefinitionHelper($factory);
    }
}

if (! function_exists('DI\link')) {
    /**
     * Helper for referencing another container entry in an object definition.
     *
     * @param string $entryName
     *
     * @return EntryReference
     */
    function link($entryName)
    {
        return new EntryReference($entryName);
    }
}

if (! function_exists('DI\env')) {
    /**
     * Helper for referencing environment variables.
     *
     * @param string $variableName The name of the environment variable.
     * @param mixed $defaultValue The default value to be used if the environment variable is not defined.
     *
     * @return EnvironmentVariableDefinitionHelper
     */
    function env($variableName, $defaultValue = null)
    {
        // Only mark as optional if the default value was *explicitly* provided.
        $isOptional = 2 === func_num_args();

        return new EnvironmentVariableDefinitionHelper($variableName, $isOptional, $defaultValue);
    }
}

if (! function_exists('DI\add')) {
    /**
     * Helper for extending another definition.
     *
     * Example:
     *
     *     'log.backends' => DI\add(DI\link('My\Custom\LogBackend'))
     *
     * or:
     *
     *     'log.backends' => DI\add([
     *         DI\link('My\Custom\LogBackend')
     *     ])
     *
     * @param mixed|array $values A value or an array of values to add to the array.
     *
     * @return ArrayDefinitionExtensionHelper
     *
     * @since 5.0
     */
    function add($values)
    {
        if (! is_array($values)) {
            $values = array($values);
        }

        return new ArrayDefinitionExtensionHelper($values);
    }
}

if (! function_exists('DI\string')) {
    /**
     * Helper for concatenating strings.
     *
     * Example:
     *
     *     'log.filename' => DI\string('{app.path}/app.log')
     *
     * @param string $expression A string expression. Use the `{}` placeholders to reference other container entries.
     *
     * @return StringDefinitionHelper
     *
     * @since 5.0
     */
    function string($expression)
    {
        return new StringDefinitionHelper((string) $expression);
    }
}
