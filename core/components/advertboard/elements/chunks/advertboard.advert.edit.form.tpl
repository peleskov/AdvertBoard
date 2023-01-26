<div class="form-group" {$title}>
    <label>Category:</label>
    <select name="parent" class="w-100 custom-select2" {$formID? 'form="' ~$formID~'"':''}>
        {if !$parent}
        <option value="27" selected>{27|resource:'pagetitle'}</option>
        {/if}
        {'!pdoResources'|snippet:[
        'parents' => 27,
        'parentID' => $parent,
        'depth' => 10,
        'limit' => 0,
        'tpl' => 'advertboard.abvert.parent.option'
        ]}
    </select>
</div>
<div class="form-group">
    <label>Title:</label>
    <input class="form-control" type="text" name="title" {$formID? 'form="' ~$formID~'"':''} {$title? ' value="'
        ~$title~'"':''}>
</div>
<div class="form-group">
    <label>Content:</label>
    <textarea class="form-control" name="content" cols="30" rows="5" {$formID? 'form="'
        ~$formID~'"':''}>{$content? :''}</textarea>
</div>
<div class="form-group row">
    <div class="col-6">
        <label>Price:</label>
        <input class="form-control" type="number" name="price" {$formID? 'form="' ~$formID~'"':''} {$price? ' value="'
            ~$price~'"':''}>
    </div>
    <div class="col-6">
        <label>Old Price:</label>
        <input class="form-control" type="number" name="old_price" {$formID? 'form="' ~$formID~'"':''}
            {$old_price? ' value="' ~$old_price~'"':''}>
    </div>
</div>
<div class="form-group">
    <label>Photo:</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="inputFile" aria-describedby="inputFile" name="images[]"
            multiple {$formID? 'form="' ~$formID~'"':''} accept="image/*">
        <label class="custom-file-label" for="inputFile">Choose file</label>
    </div>
</div>