<div class="mb-5">
    <p>id: {$_modx->user.id} Name: {$_modx->user.fullname}</p>
    <a class="btn btn-primary" href="{1 | url :[]:['service' => 'logout']}" title="Logout">Logout</a>
</div>
{set $formID = 'advertCreateForm'}
{set $buttonTextCE = 'Create'}
{if $.get.a}
{set $where = '{"user_id": 45}'}
{set $advert = '!AdvertBoard'|snippet : [
'action' => 'advert/get'
'where' => $where,
'hash' => $.get.a,
'formID' => $formID,
'tplOut' => '@INLINE {$wrapper}',
'tpl' => 'advertboard.advert.edit.form'
]}
{/if}
{if $advert}
{set $buttonTextCE = 'Edit'}
{$advert}
{else}
{include 'advertboard.advert.edit.form' formID = $formID}
{/if}
<div class="form-group d-flex justify-content-around">
    {'!AjaxForm'|snippet : [
    'snippet' => 'AdvertBoard',
    'action' => 'advert/create',
    'hash' => $.get.a,
    'buttonText' => $buttonTextCE,
    'buttonClass' => 'btn btn-primary',
    'formID' => $formID,
    'multipartForm' => 1,
    'imagesDirPath' => $_modx->config.assets_path~'adverts',
    'imageMaxSize' => 1048576,
    'imageExt' => 'jpg, png, jpeg',
    'successMsg' => 'Объявление успешно сохранено!',
    'successModalID' => 'successModalAdvert',
    'errorMsg' => 'Что то пошло не так, попробуйте еще раз!',
    'errorModalID' => 'errorModalAdvert',
    'form' => 'advertboard.advert.actions.form',
    ]}
    {if $advert}
    {'!AjaxForm'|snippet : [
    'snippet' => 'AdvertBoard',
    'action' => 'advert/delete',
    'hash' => $.get.a,
    'formID' => 'advertDeleteForm',
    'buttonText' => 'Delete',
    'buttonClass' => 'btn btn-outline-primary',
    'successMsg' => 'Объявление успешно сохранено!',
    'successModalID' => 'successModalAdvert',
    'errorMsg' => 'Что то пошло не так, попробуйте еще раз!',
    'errorModalID' => 'errorModalAdvert',
    'form' => 'advertboard.advert.actions.form',
    ]}
    {/if}
</div>