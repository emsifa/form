<?php namespace AdamWathan\Form\Elements;

class Select extends FormControl
{
    private $options;
    private $selected = array();

    public function __construct($name, $options = array())
    {
        $this->setName($name);
        $this->setOptions($options);
    }

    public function select($option)
    {
        $this->selected = (array) $option;
        return $this;
    }

    protected function setOptions($options)
    {
        $this->options = $options;
    }

    public function options($options)
    {
        $this->setOptions($options);
        return $this;
    }

    public function multiple()
    {
        $this->setAttribute('multiple', 'multiple');
        return $this;
    }

    public function render()
    {
        $result = '<select';
        $result .= $this->renderAttributes();
        $result .= '>';
        $result .= $this->renderOptions();
        $result .= '</select>';

        return $result;
    }

    protected function renderOptions()
    {
        $result = '';

        foreach ($this->options as $value => $label) {
            if (is_array($label)) {
                $result .= $this->renderOptGroup($value, $label);
                continue;
            }
            $result .= $this->renderOption($value, $label);
        }

        return $result;
    }

    protected function renderOptGroup($label, $options)
    {
        $result = "<optgroup label=\"{$label}\">";
        foreach ($options as $value => $label) {
            $result .= $this->renderOption($value, $label);
        }
        $result .= "</optgroup>";
        return $result;
    }

    protected function renderOption($value, $label)
    {
        $option = '<option ';
        $option .= 'value="' . $value . '"';
        $option .= $this->isSelected($value) ? ' selected' : '';
        $option .= '>';
        $option .= $label;
        $option .= '</option>';
        return $option;
    }

    protected function isSelected($value)
    {
        return in_array($value, $this->selected);
    }

    public function addOption($value, $label)
    {
        $this->options[$value] = $label;
        return $this;
    }

    public function defaultValue($value)
    {
        if ( ! empty($this->selected)) {
            return $this;
        }

        $this->select($value);
        return $this;
    }
}
