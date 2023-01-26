<form {$formID? 'id="'~$formID~'"':''} {$multipartForm? 'enctype="multipart/form-data"':''}>
    {*Важно для AjaxForm <button> на новой строке*}
    <button {$buttonClass? 'class="'~$buttonClass~'"':''} type="submit">{$buttonText}</button>
</form>