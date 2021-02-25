<?php


namespace app\validator;


/**
 * Class ValidatorChain
 * @package app\validator
 */
class ValidatorChain
{
    protected array $rules;
    protected array $errors;
    protected array $data;

    public function __construct(array $rules, array $data)
    {
        $this->errors = [];
        $this->rules = $rules;
        $this->data = $data;
        $this->initRules();
    }

    private function initRules(): void
    {
        foreach ($this->rules as $fieldName => $validators) {

            if (!array_key_exists($fieldName, $this->data)) {
                $this->errors[$fieldName][] = (new Required())->getErrorMessage();
                continue;
            }

            array_walk($validators, function ($validator) use ($fieldName) {
                /** @var Validator $validator */
                if (is_string($validator)) {
                    $validator = new $validator;
                }
                if (!$validator->valid($this->data[$fieldName])) {
                    $this->errors[$fieldName][] = $validator->getErrorMessage();
                }
            });
        }
    }

    public function updateData(array $data): ValidatorChain
    {
        $this->data = $data;
        $this->initRules();

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        if (empty($this->errors)) {
            return false;
        }

        return true;
    }

}
