<?php

namespace src\Integration;

class DataProvider // Так как мы не знаем сколько и каких еще провайдеров будет у нас в системе, то лучше дать классу DataProvider конкретное имя, например HttpDataProvider, если он будет подключаться к HTTP серверу и получать от него данные. Также надо определить интерфейс DataProvider, чтобы явно в нем указать, что именно должно быть доступно для клиентского кода (внешнего мира), и в качестве зависимости использовать этот интерфейс, а не конкретный класс.
{
    private $host;
    private $user;
    private $password;

    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }
    
    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request)
    {
    // returns a response from external service
    }
}

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\Integration\DataProvider;

class DecoratorManager extends DataProvider // Вместо наследования от конкретного класса лучше использовать паттерн Декоратор и наследоваться от абстрактного класса. Это позволит проще добавлять/удалять расширенную логику, которая должна выполняться до или после метода get() для DataProvider.
{
    public $cache; // Свойства $cache и $logger не должны быть публичными, чтобы клиентский код не мог работать с ними
    public $logger; // напрямую. Свойства надо сделать приватными, если нет причин делать их защищенными.

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param CacheItemPoolInterface $cache
     */
    public function __construct($host, $user, $password, CacheItemPoolInterface // получается длинный список параметров, с котором будет работать неудобно. Еще один повод отказаться от наследования, использовать паттерн Декоратор и передавать в конструктор экземпляр DataProvider.
    $cache) {
        parent::__construct($host, $user, $password);
        $this->cache = $cache;
    }

    public function setLogger(LoggerInterface $logger) // Логгер внедряется через сеттер, в то время как кэш внедряется через конструктор. Лучше использовать единообразной подход внедрения зависимостей и внедрять логгер через конструктор, используя паттерн Декоратор.
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(array $input) // В классе DecoratorManager определен публичный метод getResponse() в то время как в классе DataProvider определен метод get(). Это не позволит использовать экземпляр класса DecoratorManager в клиентском коде без его изменения в тех местах, где уже используется DataProvider.
    {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
            $result = parent::get($input);
            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify('+1 day')
                );
            return $result;
        } catch (Exception $e) {
            $this->logger->critical('Error');
        }
        return [];
    }
    public function getCacheKey(array $input) // Метод надо спрятать от внешнего мира, сделать приватным. Чтобы у разработчика клиентского кода не было возможности использовать этот метод напрямую. Это не будет накладывать на нас ограничения в будущем, если мы захотим сделать рефакторинг и изменить сигнатуру этого метода.
    {
        return json_encode($input);
    }
}
