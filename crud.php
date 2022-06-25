<?php
require_once 'layout/header.php';
?>


<div class="row">
    <div class="col-md-12">
        <form>
            <div class="form-group">
                <label for="pwd">Paramerter:</label>
                <input type="text" class="form-control" id="param1" name="param1">
            </div>
            <button type="submit" class="btn btn-success" name="parameterized">Generate</button>
        </form>
    </div>
</div>
<?php
require_once 'layout/footer.php';
?>