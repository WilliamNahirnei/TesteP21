<?php

namespace Src\Modules\Order;

use DatabaseConnection\DatabaseModel;
use Server\Constants\ApiExceptionTypes;
use Server\Constants\StatusCodes;
use Server\Errors\ApiException;
use Src\Modules\Customer\Customer;

class Order extends DatabaseModel
{

    protected ?int $id = null;
    private ?string $orderObservations = null;
    private ?float $orderTotalValue = null;
    private ?string $orderDate = null;
    private ?int $orderIdCustomer = null;
    private ?string $orderLocation = null;

    private string $orderStatus;

    private ?Customer  $customer = null;

    public const TABLE_NAME = 'purchaseOrder';

    public const COLUMN_ID = "id";
    public const COLUMN_OBSERVATIONS = "orderObservations";
    public const COLUMN_TOTAL_VALUE = "orderTotalValue";
    public const COLUMN_DATE = "orderDate";
    public const COLUMN_ID_CUSTOMER = "orderIdCustomer";
    public const COLUMN_ORDER_LOCATION = "orderLocation";
    public const COLUMN_ORDER_STATUS = "orderStatus";

    public const RELATIONAL_MODEL_CUSTOMER = "customer";

    public function __construct(
        ?string $orderObservations = null,
        ?float $value = 0,
        ?string $dateTime = null
    ) {
        $this->orderObservations = $orderObservations;
        $this->orderTotalValue = $value;
        $this->orderDate = $dateTime;
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
            self::COLUMN_OBSERVATIONS,
            self::COLUMN_TOTAL_VALUE,
            self::COLUMN_DATE,
            self::COLUMN_ID_CUSTOMER,
            self::COLUMN_ORDER_LOCATION,
            self::COLUMN_ORDER_STATUS,
        ];
        return static::$columnList;
    }
    protected static function defineRelationalModelsName(): array
    {
        static::$modelList = [
            self::RELATIONAL_MODEL_CUSTOMER,
        ];
        return static::$modelList;
    }

    public function store()
    {
        $this->validateStore();
        if (empty($this->getOrderDate())) {
            $this->setOrderDate((new \DateTime())->format('Y-m-d H:i:s'));
        }
        $this->create();
    }

    private function validateStore()
    {
        $this->validateBasicValues();
    }

    public function update()
    {
        $this->validateUpdate();
        parent::update();
    }

    private function validateUpdate()
    {
        $this->validateId();
        $this->validateBasicValues();
    }

    public function delete() {
        $this->validateDelete();
        parent::delete();
        $this->deleteDependencies();
    }

    private function validateDelete() {
        $this->validateId();
    }

    private function validateId()
    {
        if (empty($this->id)) {
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Entidade pedido sem id preenchido para seguir com a ação"], StatusCodes::HTTP_BAD_REQUEST);
        }
    }

    protected function validateBasicValues()
    {
        $this->validateValue();
    }

    private function validateValue()
    {
        if (!empty($this->orderTotalValue) && $this->orderTotalValue < 0) {
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Valor total do pedido não pode sermenor que zero"], StatusCodes::HTTP_BAD_REQUEST);
        }
    }

    private function deleteDependencies()
    {
    }


    public function searchCustomer(bool $force = false): self
    {
        if (is_null($this->customer) || $force) {
            $customer = Customer::findById($this->getOrderIdCustomer());
            if ($customer instanceof Customer) {
                $this->setCustomer($customer);
            }
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getOrderObservations(): ?string
    {
        return $this->orderObservations;
    }

    public function setOrderObservations(?string $orderObservations): void
    {
        $this->orderObservations = $orderObservations;
    }

    public function getOrderTotalValue(): ?float
    {
        return $this->orderTotalValue;
    }

    public function setOrderTotalValue(?float $orderTotalValue): void
    {
        $this->orderTotalValue = $orderTotalValue;
    }

    public function getOrderDate(): ?string
    {
        return $this->orderDate;
    }

    public function setOrderDate(?string $orderDateTime): void
    {
        $this->orderDate = $orderDateTime;
    }

    public function getOrderIdCustomer(): ?int
    {
        return $this->orderIdCustomer;
    }

    public function setOrderIdCustomer(?int $idCustomer): void
    {
        $this->orderIdCustomer = $idCustomer;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): void
    {
        if ($customer instanceof Customer) {
            $this->setOrderIdCustomer($customer->getId());
        }
        $this->customer = $customer;
    }

    public function getOrderLocation(): ?string
    {
        return $this->orderLocation;
    }

    public function setOrderLocation(?string $orderLocation): self
    {
        $this->orderLocation = $orderLocation;
        return $this;
    }

    public function getOrderStatus(): string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): self
    {
        $this->orderStatus = $orderStatus;
        return $this;
    }



}