<?php


namespace app\validator;


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

    /**
     * Chain constructor.
     * @param array[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
        $this->errors = [];
    }

    /**
     * @param array $post
     */
    public function invoke(array $post): void
    {
        foreach ($this->rules as $fieldName => $validators) {

            if (!array_key_exists($fieldName, $post)) {
                $this->errors[$fieldName][] = (new Required())->getErrorMessage();
                continue;
            }

            array_walk($validators, function ($validator) use ($post, $fieldName) {
                /** @var Validator $validator */
                if (is_string($validator)) {
                    $validator = new $validator;
                }
                if (!$validator->valid($post[$fieldName])) {
                    $this->errors[$fieldName][] = $validator->getErrorMessage();
                }
            });
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
