<?php
    namespace Src\Suport;

    use DatabaseConnection\DatabaseModel;

    trait TraitModelResponse { 
        public static function modelListToArrayResponse(array $modelList = []) {
                $modelsMappeds = [];
                foreach ($modelList as $model) {
                    if ($model instanceof DatabaseModel) {
                        $modelsMappeds[] = $model->toArray();
                    }
                }
    
                return $modelsMappeds;
        }
    }