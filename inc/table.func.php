<?php
function p_textfield ($type, $name, $value, $placeholder = '', $required = 0, $style= '', $else = ''){
    if ($required !== 0 ){
        $required = 'required';
    }
    if ($style !== '') {
        $style = 'style="' .$style. '""';
    }


    echo '<input type="' .$type. '" ' .$style. ' name="' .$name. '" value="' .$value. '" ' .$required. ' />';
}