<?php

function camelCaseToNormal(String $text)
{
    return implode(' ', preg_split('/(?=[A-Z])/', ucfirst($text)));
}
