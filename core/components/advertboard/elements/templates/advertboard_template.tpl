<!doctype html>
<html lang="en">

<head>
    <title>{$_modx->resource.pagetitle~' / '~$_modx->config.site_name}</title>
    <base href="{$_modx->config.site_url}" />
    <meta charset="{$_modx->config.modx_charset}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>

<body>
    {include 'advertboard.modals'}
    <section class="mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <h2 class="text-center mb-4">Catalog</h2>
                </div>
            </div>
            <div class="row justify-content-center mb-5">
                <div class="col-12">
                    {*set $filters = '{"user_id": 45}'*}
                    {set $search = $.get.s? :''}
                    
                    {'!pdoPage'|snippet : [
                    'element' => 'AdvertBoard',
                    'action' => 'advert/get',
                    'query' => $search,
                    'parents' => '27',
                    'depth' => 3,
                    'where' => $filters,
                    'limit' => 4,
                    'tplOut' => 'advertboard.adverts',
                    'tpl' => 'advertboard.adverts.row'
                    ]}
                    {'page.nav' | placeholder}
                </div>
            </div>
        </div>
    </section>
    <section class="mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <h2 class="text-center mb-4">Advert create / edit / delete</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6">
                    {'!Login' | snippet : [
                    'tplType' => 'modChunk',
                    'logoutTpl' => 'advertboard.advert.edit',
                    'loginTpl' => 'advertboard.advert.login',
                    ]}
                </div>
            </div>
        </div>
        </div>
    </section>

    <link rel="stylesheet" href="{$_modx->config.assets_url}theme/apps/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{$_modx->config.assets_url}theme/apps/select2/jquery.scrollbar.css">
    <link rel="stylesheet" href="{$_modx->config.assets_url}theme/apps/select2/select2.min.css">
    

    <script src="{$_modx->config.assets_url}theme/apps/jquery/jquery-3.6.0.min.js"></script>
    <script src="{$_modx->config.assets_url}theme/apps/bootstrap-4.5.3-dist/js/popper.min.js"></script>
    <script src="{$_modx->config.assets_url}theme/apps/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
    <script src="{$_modx->config.assets_url}theme/apps/inputmask/jquery.inputmask.min.js"></script>
    <script src="{$_modx->config.assets_url}theme/apps/select2/jquery.scrollbar.min.js"></script>
    <script src="{$_modx->config.assets_url}theme/apps/select2/select2.full.min.js"></script>
    <script src="{$_modx->config.assets_url}components/advertboard/js/web/script.min.js"></script>
    <script src="{$_modx->config.assets_url}components/advertboard/js/web/advertboard.ajax.min.js"></script>

</body>

</html>