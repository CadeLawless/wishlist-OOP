<?php

namespace Helpers;

class FormValidation
{
    private array $formFields = [];
    private string $errorList = "";

    public function __construct(
        private string $errorMessageTitle = "The form couldn not be submitted due to the following errors:"
    ){}

    public function add(FormField $field): void
    {
        $this->formFields[] = $field;
    }

    public function printFormFields(): void
    {
        if(count($this->formFields) > 0){
            foreach($this->formFields as $field) $field->printFormField();
        }
    }

    public function validateFormFields(): void
    {
        if(count($this->formFields) > 0){
            foreach($this->formFields as $field) $field->validate();
        }
    }

    public function setErrorMessageTitle(string $title): void
    {
        $this->errorMessageTitle = $title;
    }

    public function findErrors(): bool
    {
        if(count($this->formFields) > 0){
            foreach($this->formFields as $field){
                if($field->errors) return true;
            }
        }
        return false;
    }

    private function updateErrorList(): void
    {
        if(count($this->formFields) > 0){
            foreach($this->formFields as $field){
                if(count($field->errorList) > 0){
                    foreach($field->errorList as $errorMessage){
                        $this->errorList .= "<li>$errorMessage</li>";
                    }
                }
            }
        }
    }

    public function printErrorMessage(): void
    {
        $this->updateErrorList();
        if($this->findErrors()){
            echo "
            <div class='submit-error'>
                <strong>$this->errorMessageTitle</strong>
                <ul>
                    $this->errorList
                </ul>
                <p>Please fix the error above and resubmit.</p>
            </div>";
        }
    }
}

?>