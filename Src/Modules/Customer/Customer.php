<?php

namespace Src\Modules\Customer;


use DatabaseConnection\DatabaseModel;
class Customer extends DatabaseModel
{
    protected ?int $id = null;
    private ?string $customerName = null;
    private ?string $customerEmail = null;
    private ?string $externalId = null;

    public const TABLE_NAME = 'customer';

    public const COLUMN_ID = "id";
    public const COLUMN_NAME = "customerName";
    public const COLUMN_EMAIL = "customerEmail";
    public const COLUMN_EXTERNAL_ID = "externalId";

    public function __construct(?string $customerName = null, ?string $customerEmail = null)
    {
        $this->customerName  = $customerName;
        $this->customerEmail = $customerEmail;
        parent::__construct();

    }

    protected static function defineTableName(): string
    {
        static::$table_name = self::TABLE_NAME;
        return static::$table_name;
    }

    protected static function defineColumnList(): array
    {
        static::$columnList = [
            self::COLUMN_ID,
            self::COLUMN_NAME,
            self::COLUMN_EMAIL,
            self::COLUMN_EXTERNAL_ID,
        ];
        return static::$columnList;
    }


    public function store()
    {
        $this->validateStore();
        $this->create();
    }

    private function validateStore()
    {

    }

    public function update()
    {
        $this->validateUpdate();
        parent::update();
    }

    private function validateUpdate()
    {
        $this->validateId();
    }

    public function delete() {
        $this->validateDelete();
        parent::delete();
    }

    private function validateDelete() {
        $this->validateId();
        $this->validateDependencies();
    }

    private function validateId()
    {
        if (empty($this->id)) {
            //Lancar erro
        }
    }

    private function validateDependencies()
    {
        $this->validateOrders();
    }

    private function validateOrders()
    {
        if ($this->haveOrders()) {
            //lancarErro
        }
    }
    private function haveOrders()
    {
        //consultarOrders por id
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(?string $customerName): self
    {
        $this->customerName = $customerName;
        return $this;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(?string $customerEmail): self
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): self
    {
        $this->externalId = $externalId;
        return $this;
    }
}