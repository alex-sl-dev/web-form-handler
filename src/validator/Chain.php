<?php


namespace app\validator;


use app\models\star_event\DomainCreationException;

/**
 * Class Chain
 * @package app\validator
 */
class Chain
{
    /** @var Validator[] */
    protected array $rules;
    /** @var array */
    protected array $errors;
    /** @var array */
    protected array $data;

    /**
     * Chain constructor.
     * @param array[] $rules
     * @param array $data
     */
    public function __construct(array $rules, array $data)
    {
        $this->errors = [];

        $this->rules = $rules;
        $this->data = $data;

        $this->hasErrors();
    }

    /**
     */
    private function init(): void
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

    /**
     * @param Validator[] $rules
     * @return Chain
     */
    public function updateRules(array $rules): self
    {
        $this->rules = $rules;
        $this->hasErrors();

        return $this;
    }

    public function updateData(array $data): self
    {
        $this->data = $data;
        $this->hasErrors();

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $this->hasErrors();

        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        $this->init();

        if (empty($this->errors)) {
            return false;
        }

        return true;
    }
}
