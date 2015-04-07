<?php namespace Owl;

abstract class AbstractTestCase extends \TestCase
{
    /**
     * Privateメソッドをアクセス可能な状態で取得する
     *
     * @param mixed $class 対象のクラス名、又は、対象クラスのインスタンス
     * @param string $name メソッド名
     */
    private static function getPrivateMethod($class, $name)
    {
        $method = new \ReflectionMethod($class, $name);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * Privateメソッド実行する
     *
     * @param object $object メソッドを実行するオブジェクト
     * @param string $name メソッド名
     * @param array $args 引数
     */
    public static function invokeMethod($object, $name, array $args)
    {
        $method = static::getPrivateMethod($object, $name);
        return $method->invokeArgs($object, $args);
    }

    /**
     * Privateプロパティをアクセス可能な状態で取得する
     *
     * @param mixed $class 対象のクラス名、又は、対象クラスのインスタンス
     * @param string $name メソッド名
     */
    private static function getPrivateProperty($class, $name)
    {
        $prop = new \ReflectionProperty($class, $name);
        $prop->setAccessible(true);
        return $prop;
    }

    /**
     * Privateプロパティを取得する
     *
     * @param object $object 対象オブジェクト
     * @param string $name プロパティ名
     * @return mixed プロパティの値
     */
    public static function getPropertyValue($object, $name)
    {
        $prop = self::getPrivateProperty($object, $name);
        return $prop->getValue($object);
    }

    /**
     * オブジェクトのPrivateプロパティに値を代入する
     *
     * @param object $object      対象のオブジェクト
     * @param array  $propToValue 対象のプロパティと代入値をマッピングした連想配列
     *                            - array($propName => $value)
     */
    public function setInaccessibleProp($object, array $propToValue)
    {
        foreach ($propToValue as $propName => $value) {
            $prop = $this->getPrivateProperty($object, $propName);
            $prop->setValue($object, $value);
        }
    }
}
