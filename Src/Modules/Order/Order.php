<?php

namespace Src\Modules\Order;

use DatabaseConnection\DatabaseModel;
use Src\Modules\Customer\Custumer;

class Order extends DatabaseModel
{

    protected ?int $id = null;
    private ?string $orderObservations = null;
    private ?float $orderTotalValue = null;
    private ?\DateTime $orderDateTime = null;
    private ?int $orderIdCustomer = null;

    private ?Custumer  $custumer = null;

    public const TABLE_NAME = 'purchaseOrder';

    public const COLUMN_ID = "id";
    public const COLUMN_OBSERVATIONS = "orderObservations";
    public const COLUMN_TOTAL_VALUE = "orderTotalValue";
    public const COLUMN_DATE = "orderDate";
    public const COLUMN_ID_CUSTOMER = "orderIdCustomer";

    public function __construct(
        ?string $orderObservations = null
    ) {
        $this->orderObservations = $orderObservations;
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
            //Lancar erro
        }
    }

    protected function validateBasicValues()
    {
        $this->validateValue();
    }

    private function validateValue()
    {
        if (!empty($this->orderTotalValue) && $this->orderTotalValue < 0) {
            //lancar erro
        }
    }

    private function deleteDependencies()
    {
    }


    public function searchCustomer(bool $force = false): self
    {
        if (is_null($this->custumer) || $force) {
            $customer = Custumer::findById($this->getOrderIdCustomer());
            $this->setCustumer($customer);
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

    public function getOrderDateTime(): ?\DateTime
    {
        return $this->orderDateTime;
    }

    public function setOrderDateTime(?\DateTime $orderDateTime): void
    {
        $this->orderDateTime = $orderDateTime;
    }

    public function getOrderIdCustomer(): ?int
    {
        return $this->orderIdCustomer;
    }

    public function setOrderIdCustomer(?int $idCustomer): void
    {
        $this->orderIdCustomer = $idCustomer;
    }

    public function getCustumer(): ?Custumer
    {
        return $this->custumer;
    }

    public function setCustumer(?Custumer $custumer): void
    {
        if ($custumer instanceof Custumer) {
            $this->setOrderIdCustomer($custumer->getId());
        }
        $this->custumer = $custumer;
    }


}