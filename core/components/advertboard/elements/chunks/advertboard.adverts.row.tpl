<li class="col-3 mb-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <a class="btn btn-link" href="{27 | url :[]:['a' => $hash]}" >{$title}</a>
            </h5>
        </div>
        <div class="card-body">
            <p>id: {$id}</p>
            <p>hash: {$hash}</p>
            <p>parent: {$parent}</p>
            <p>created: {$created}</p>
            <p>updated: {$updated}</p>
            <p>status: {$status}</p>
            <p>content: {$content}</p>
            <p>price: {$price}</p>
            <p>old_price: {$old_price}</p>
            <p>images: </p>
            {foreach $images|fromJSON as $image}
                <img class="w-100" src="{$image[url]}" alt="">
            {/foreach}
            <p>top: {$top}</p>
        </div>
        <div class="card-footer">
            <p>usr_id: {$usr_id}</p>
            <p>fullname: {$fullname}</p>
            <p>email: {$email}</p>
            <p>mobilephone: {$mobilephone}</p>
            <p>avatar: <img class="w-100" src="{$avatar}" alt=""></p>
            <p>city: {$city}</p>
        </div>
</li>