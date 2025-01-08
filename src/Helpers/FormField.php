<?php

namespace Helpers;

class FormField
{
    public bool $errors = false;
    public array $errorList = [];
    public function __construct(
        FormValidation $formValidation,
        protected string $name,
        protected string $type,
        protected bool $required,
        protected string $label,
        protected string $value = "",
        protected array $options = [],
        protected string $pattern = "",
        protected string $patternMessage = "",
        protected array $radioValues = [],
        protected string $radioDirection = "row",
        protected string $size = "large"
    ){
        $formValidation->add($this);
    }

    public function printFormField(): void
    {
        echo "
        <div class='$this->size-input'>";
            if(!in_array($this->type, ["checkbox", "radio"])){
                echo "
                <label for='$this->name'>$this->label:";
                if($this->required) echo " <span class='required-field'>*</span>";
                echo "</label><br />";
            }
            switch($this->type){
                case "text":
                case "password":
                case "date":
                case "number":
                case "time":
                case "url":
                case "email":
                case "search":
                    echo "<input type='$this->type' id='$this->name' name='$this->name' value='" . htmlspecialchars($this->value) . "'";
                    if($this->type == "date") echo " max='9999-12-31'";
                    if($this->pattern != "") echo " pattern='$this->pattern'";
                    if($this->required) echo " required";
                    echo " />";
                    break;
                case "select":
                    echo "<select id='$this->name' name='$this->name'";
                    if($this->required) echo " required";
                    echo ">
                        <option disabled value=''";
                        if($this->value == "") echo " selected";
                        echo ">Select an option</option>";
                        if(count($this->options) > 0){
                            foreach($this->options as $option){
                                $optionValue = $option["value"];
                                $optionDisplay = $option["display"];
                                echo "<option value='" . htmlspecialchars($optionValue) . "'";
                                if($this->value == $optionValue) echo " selected";
                                echo ">" . htmlspecialchars($optionDisplay) . "</option>";
                            }
                        }
                    echo "</select>";
                    break;
                case "checkbox":
                    echo "
                    <div class='flex-checkbox'>
                        <input type='checkbox' value='Yes' id='$this->name' name='$this->name'";
                        if($this->value == "Yes") echo " checked";
                        if($this->required) echo " required";
                        echo " />
                        <span class='checkbox-label-container'>
                            <label class='normal-text' for='$this->name'>$this->label</label>
                        </span>
                    </div>";
                    break;
                case "radio":
                    if(count($this->radioValues) > 0){
                        echo "<div class='flex-radio-group $this->radioDirection'>";
                        $counter = 1;
                        foreach($this->radioValues as $val){
                            $id = $this->name . "_$counter";
                            echo "
                            <div class='radio-input'>
                                <input type='radio' id='$id' name='$this->name' value='" . htmlspecialchars($val) . "'";
                                if($this->required) echo " required";
                                echo " />
                                <label for='$id' class='normal-text'>" . htmlspecialchars($val) . "</label>
                            </div>";
                            $counter++;
                        }
                        echo "</div>";
                    }
                    break;
            }
        echo "</div>";
    }

    public function setErrors(bool $value=true, string $message=''): void
    {
        $this->errors = $value;
        $this->errorList[] = $message;
    }

    public function validate(): void
    {
        if($this->type == "checkbox"){
            $this->value = isset($_POST[$this->name]) ? "Yes" : "No";
        }else{
            if(isset($_POST[$this->name]) && trim($_POST[$this->name]) != ""){
                $this->value = htmlspecialchars_decode(trim($_POST[$this->name]));

                if($this->pattern != ""){
                    if(!preg_match($this->pattern, $this->value)){
                        $this->setErrors(message: $this->patternMessage);
                    }
                }

                switch($this->type){
                    case "select":
                    case "radio":
                        $selectOptionCheck = ($this->type == "select" && array_search($this->value, array_column($this->options, "value")) === FALSE);
                        $radioOptionCheck = ($this->type == "radio" && !in_array($this->value, $this->radioValues));
                        if($selectOptionCheck || $radioOptionCheck){
                            $this->setErrors(message: "Please select a valid option for $this->label");
                        }
                        break;
                    case "url":
                        $path = parse_url($this->value, PHP_URL_PATH);
                        $encoded_path = array_map('urlencode', explode('/', $path));
                        $url = str_replace($path, implode('/', $encoded_path), $this->value);
                
                        if(!filter_var($url, FILTER_VALIDATE_URL)){
                            $this->setErrors(message: "Please enter a valid URL for $this->label");
                        }
                        break;
                    case "email":
                        if(!filter_var($this->value, FILTER_VALIDATE_EMAIL)){
                            $this->setErrors(message: "Please enter a valid email address for $this->label");
                        }
                        break;
                }
        
            }else{
                if($this->required){
                    $errorMessage = "$this->label is a required field. ";
                    $errorMessage .= match($this->type){
                        "select", "radio" => "Please select an option.",
                        "checkbox" => "Please check the checkbox.",
                        default => "Please fill it out.",
                    };
                    $this->setErrors(message: $errorMessage);
                }
                $this->value = "";
            }  
        }              
    }
}

?>