<?php

namespace Src\Modules\Customer;


use DatabaseConnection\DatabaseModel;
use DatabaseConnection\Join;
use DatabaseConnection\WhereCondition;
use Server\Constants\ApiExceptionTypes;
use Server\Constants\StatusCodes;
use Server\Errors\ApiException;
use Src\Modules\Order\Order;

class Customer extends DatabaseModel
{
    protected ?int $id = null;
    private ?string $customerName = null;
    private ?string $customerEmail = null;
    private ?string $externalId = null;
    private ?string $customerLocation = null;

    public const TABLE_NAME = 'customer';

    public const COLUMN_ID = "id";
    public const COLUMN_NAME = "customerName";
    public const COLUMN_EMAIL = "customerEmail";
    public const COLUMN_EXTERNAL_ID = "externalId";
    public const COLUMN_CUSTOMER_LOCATION = "customerLocation";

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
            self::COLUMN_CUSTOMER_LOCATION,
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
        $this->validateEmail();
        $this->validateExternalId();
    }

    protected function validateEmail() {
        if (!empty($this->customerEmail)) {
            $customerEmail = Customer::findOne(null, [], [new WhereCondition(self::COLUMN_EMAIL, "=", $this->customerEmail)]);
            if (empty($customerEmail)) {
                return;
            }
            if (empty($this->id) || (!empty($this->id) && $this->id != $customerEmail->getId())) {
                throw new ApiException(true, ApiExceptionTypes::ERROR, ["Cliente com o email informado ja existe"], StatusCodes::HTTP_BAD_REQUEST);
            }
        }
    }
    protected function validateExternalId() {
        if (!empty($this->externalId)){
            $customerExternalId = Customer::findOne(null, [], [new WhereCondition(self::COLUMN_EXTERNAL_ID, "=", $this->externalId)]);
            if (empty($customerExternalId)){
                return;
            }
            if (empty($this->id) || (!empty($this->id) && $this->id != $customerExternalId->getId())) {
                throw new ApiException(true, ApiExceptionTypes::ERROR, ["Cliente com esse id externo ja existe"], StatusCodes::HTTP_BAD_REQUEST);
            }
        }
    }

    public function update()
    {
        $this->validateUpdate();
        parent::update();
    }

    private function validateUpdate()
    {
        $this->validateId();
        $this->validateEmail();
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
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Entidade cliente sem id preenchido para seguir com a ação"], StatusCodes::HTTP_BAD_REQUEST);
        }
    }

    private function validateDependencies()
    {
        $this->validateOrders();
    }

    private function validateOrders()
    {
        if ($this->haveOrders()) {
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Não foi possivel deletar o cliente, existem ordens vinculadas a ele"], StatusCodes::HTTP_BAD_REQUEST);
        }
    }
    private function haveOrders()
    {
        $order = Order::findOne(
            null,
            [new Join('inner', Order::TABLE_NAME, self::TABLE_NAME . '.id', '=', Order::TABLE_NAME . '.' . Order::COLUMN_ID_CUSTOMER),],
            [new WhereCondition(Order::COLUMN_ID_CUSTOMER, "=", $this->id)]
        );
        return !empty($order);
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

    public function getCustomerLocation(): ?string
    {
        return $this->customerLocation;
    }

    public function setCustomerLocation(?string $customerLocation): self
    {
        $this->customerLocation = $customerLocation;
        return $this;
    }


}