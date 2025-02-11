<?php

namespace Src\Modules\Product;

use DatabaseConnection\DatabaseModel;

class Product extends DatabaseModel
{

    protected ?int $id = null;
    private ?string $productName = null;
    private ?float $productValue = null;

    public const TABLE_NAME = 'product';

    public const COLUMN_ID = "id";
    public const COLUMN_NAME = "productName";
    public const COLUMN_VALUE = "productValue";

    public function __construct(?string $productName = null, ?float $productValue = null)
    {
        $this->productName = $productName;
        $this->productValue = $productValue;
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
            self::COLUMN_VALUE,
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

    protected function validateBasicValues()
    {
        $this->validateName();
        $this->validateValue();
    }
    private function validateName()
    {
        if (!is_string($this->productName) || empty(trim($this->productName))) {
            //Lancar erro
        }
    }

    private function validateValue()
    {
        if (empty($this->productValue)){
            //Lancar erro
        }

        if ($this->productValue < 0) {
            //lancar erro
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

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): void
    {
        $this->productName = $productName;
    }

    public function getProductValue(): ?float
    {
        return $this->productValue;
    }

    public function setProductValue(?float $productValue): void
    {
        $this->productValue = $productValue;
    }

}