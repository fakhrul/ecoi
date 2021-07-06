<?php

// HTML Macros


HTML::macro('clever_link', function($route, $text, $param="") {
    if(allowed($route)) {
//if( strtolower(Request::path()) == $route ) {
       if(Route::current()->getName() == $route) {
            $active = "class = 'active'";
        }
        else {
            $active = '';
        }
        if ($param != ""){
            return '<li ' . $active . '>' . link_to(URL::route($route,$param), $text) . '</li>';
        }
        else{
            return '<li ' . $active . '>' . link_to(URL::route($route), $text) . '</li>';
        }   
    }
});

HTML::macro('clever_menu', function($routes, $text) { 

    $permitted = false;
    foreach($routes as $route) {
        if(allowed($route)) {
            $permitted = true;
            break;
        }
    }

    if($permitted) {

       if(in_array(Route::current()->getName(),$routes)) {
            $active = 'class="dropdown active"';
        }
        else {
            $active = 'class="dropdown"';
        }
         
        return '<li ' . $active . '> <a href="#" class="dropdown-toggle" data-toggle="dropdown">'. $text .' <span class="caret"></span></a>';
    }
});

HTML::macro('clever_info', function($label, $info) {  

    return '<li class="list-group-item"><strong>'.$label.'</strong> : '.$info.'</li>';

});

HTML::macro('clever_table', function($label, $value) {

  return '<tr><td style="width:30%"><strong>'.$label.'</strong></td><td style="width:70%">'.$value.'</td></tr>';
});

HTML::macro('clever_form', function($label, $value) {

  return '<div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">'.$label.'</label>
            <div class="col-sm-5">
                <p class="form-control-static">'.$value.'</p>
            </div>
          </div>';
});

HTML::macro('clever_form_lg', function($label, $value) {

  return '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">'.$label.'</label>
            <div class="col-sm-5">
                <p class="form-control-static">'.$value.'</p>
            </div>
          </div>';
});

Form::macro("field", function($options)
{
    $markup = "";
    $type = "text";
    if (!empty($options["type"]))
    {
        $type = $options["type"];
    }
    if (empty($options["name"]))
    {
        return;
    }
    $name = $options["name"];
    $label = "";
    if (!empty($options["label"]))
    {
        $label = $options["label"];
    }
    $value = Input::old($name);
    if (!empty($options["value"]))
    {
        $value = Input::old($name, $options["value"]);
    }
    $placeholder = "";
    if (!empty($options["placeholder"]))
    {
        $placeholder = $options["placeholder"];
    }
    $class = "";
    if (!empty($options["class"]))
    {
        $class = " " . $options["class"];
    }
    $parameters = [
        "class"       => "form-control" . $class,
        "placeholder" => $placeholder
    ];
    $error = "";
    if (!empty($options["form"]))
    {
        $error = $options["form"]->getError($name);
    }
    if ($type !== "hidden")
    {
        $markup .= "<div class='form-group";
        $markup .= ($error ? " has-error" : "");
        $markup .= "'>";
    }
    switch ($type)
    {
        case "text":
        {
            $markup .= Form::label($name, $label, [
                "class" => "control-label"
            ]);
           $markup .= Form::text($name, $value, $parameters);
           break;
        }
        case "password":
        {
            $markup .= Form::label($name, $label, [
                "class" => "control-label"
            ]);
            $markup .= Form::password($name, $parameters);
            break;
        }
        case "checkbox":
        {
            $markup .= "<div class='checkbox'>";
            $markup .= "<label>";
            $markup .= Form::checkbox($name, 1, (boolean) $value);
            $markup .= " " . $label;
            $markup .= "</label>";
            $markup .= "</div>";
            break;
        }
        case "hidden":
        {
            $markup .= Form::hidden($name, $value);
            break;
        }
    }
    if ($error)
    {
        $markup .= "<span class='help-block'>";
        $markup .= $error;
        $markup .= "</span>";
    }
    if ($type !== "hidden")
    {
        $markup .= "</div>";
    }
    return $markup;
});

HTML::macro('show_branch', function($label) {
    if ( strlen($label)>20)
        return substr($label, 0, 20)."...";
    else
        return $label;
});