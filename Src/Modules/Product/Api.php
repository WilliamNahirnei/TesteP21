<?php

namespace Src\Modules\Product;

use Server\Routing\AbstractApi;

/**
 * Class Api
 *
 * This class defines the API endpoints for the "product" module.
 * It extends the AbstractApi class and configures endpoints with their respective HTTP methods, controllers, and authentication.
 *
 * @package Src\Modules\Product
 * @author William Nahirnei Lopes
 */
class Api extends AbstractApi
{
    /**
     * @var string|null The name of the module. Defaults to "product".
     */
    protected ?string $moduleName = "product";

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
     * Defines the list of API endpoints for the "product" module.
     * Configures the HTTP methods, endpoint paths, controllers, and authentication methods.
     *
     * @return void
     */
    public function defineEndpointList(): void
    {
        $this->addEndpoint(
            static::METHOD_GET,
            null,
            ProductController::class,
            "list"
        );
        $this->addEndpoint(
            static::METHOD_POST,
            null,
            ProductController::class,
            "store"
        );
        $this->addEndpoint(
            static::METHOD_PUT,
            null,
            ProductController::class,
            "update"
        );
        $this->addEndpoint(
            static::METHOD_DELETE,
            null,
            ProductController::class,
            "delete"
        );
    }
}