<?php

namespace Src\Modules\Order;

use Server\Routing\AbstractApi;

class Api extends AbstractApi
{
    /**
     * @var string|null The name of the module. Defaults to "order".
     */
    protected ?string $moduleName = "order";

    /**
     * @var string|null The default authentication class to use. Defaults to null.
     */
    protected ?string $defaultAuthClass = null;

    /**
     * @var string|null The default authentication method to use. Defaults to null.
     */
    protected ?string $defaultAuthMethod = null;

    /**
     * @var bool The default value if ignore auth method.
     */
    protected ?bool $ignoreAuth = false;

    /**
     * Api constructor.
     * Initializes the parent class with the module name, authentication class, and authentication method.
     */
    public function __construct()
    {
        parent::__construct(
            $this->moduleName,
            $this->defaultAuthClass,
            $this->defaultAuthMethod,
            $this->ignoreAuth
        );
    }

    /**
     * Defines the list of API endpoints for the "order" module.
     * Configures the HTTP methods, endpoint paths, controllers, and authentication methods.
     *
     * @return void
     */
    public function defineEndpointList(): void
    {
        $this->addEndpoint(
            static::METHOD_GET,
            null,
            OrderController::class,
            "list"
        );
        $this->addEndpoint(
            static::METHOD_POST,
            null,
            OrderController::class,
            "store"
        );
        $this->addEndpoint(
            static::METHOD_PUT,
            null,
            OrderController::class,
            "update"
        );
        $this->addEndpoint(
            static::METHOD_DELETE,
            null,
            OrderController::class,
            "delete"
        );
    }
}