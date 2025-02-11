<?php

namespace Src\Modules\Customer;


use DatabaseConnection\DatabaseModel;
class Custumer extends DatabaseModel
{
    protected ?int $id = null;
    private ?string $custumerName = null;
    private ?string $custumerEmail = null;

    public const TABLE_NAME = 'custumer';

    public const COLUMN_ID = "id";
    public const COLUMN_NAME = "custumerName";
    public const COLUMN_EMAIL = "custumerEmail";

    public function __construct(?string $custumerName = null, ?string $custumerEmail = null)
    {
        $this->custumerName = $custumerName;
        $this->custumerEmail = $custumerEmail;
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

    public function getCustumerName(): ?string
    {
        return $this->custumerName;
    }

    public function setCustumerName(?string $custumerName): self
    {
        $this->custumerName = $custumerName;
        return $this;
    }

    public function getCustumerEmail(): ?string
    {
        return $this->custumerEmail;
    }

    public function setCustumerEmail(?string $custumerEmail): self
    {
        $this->custumerEmail = $custumerEmail;
        return $this;
    }
}