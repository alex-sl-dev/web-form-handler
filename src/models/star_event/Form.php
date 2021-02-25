<?php


namespace app\models\star_event;



/**
 * Class Form
 * @package app\model\star_event
 */
class Form extends StarEvent
{
    protected array $formData;

    public function handleRequest(array $post)
    {
        $this->validator->updateData($post);
    }

    public function setFormData(array $post)
    {
        $this->formData = $post;
    }
}
