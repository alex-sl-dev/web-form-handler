<?php


namespace app\validator;


/**
 * Class ValidatorChain
 * @package app\validator
 */
class ValidatorChain
{

    /** @var ValidatorInterface[]  */
    protected array $rules;

    /** @var array */
    protected array $errors;

    /**
     * ValidatorChain constructor.
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
                $this->errors[$fieldName][] = (new RequiredValidator())->getErrorMessage();
                continue;
            }
            array_walk($validators, function ($validator) use ($post, $fieldName) {
                /** @var ValidatorInterface $validator */
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
