<h3>Товары</h3>
<div class="row">
    <div class="panel panel-default col-md-12">
        <div class="panel-body">
            <form class="form-inline" method="get" action="" data-action="/api/category/{id}/goods" data-form-get-goods>
                <div class="form-group">
                    <label>Выбор категорий</label>
                    <select name="categories_list" class="form-control"></select>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Показать товары</button>

            </form>
        </div>
        <div class="panel-footer collapse">
            <table class="table table-bordered ">
                <thead >
                <tr>
                    <th class="text-center">JSON</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="json-out">JSON</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel panel-default col-md-6">
        <div class="panel-body">
            <form class="form" method="post" action="{{action('API\ApiGoodsController@create')}}" data-form-create-goods>
                <div class="form-group">
                    <label>Выбор категорий</label>
                    <select name="categories[]" id="multiselect_categories" class="form-control"  multiple="multiple"></select>
                </div>
                <div class="form-group">
                    <label>Название товара</label>
                    <input type="text" name="goods_title" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="goods_description">Описание товара</label>
                    <textarea name="goods_description" id="goods_description" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Создать товары</button>

            </form>
        </div>
        <div class="panel-footer collapse">
            <table class="table table-bordered ">
                <thead >
                <tr>
                    <th class="text-center">JSON</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="json-out">JSON</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-default col-md-6">
        <div class="panel-body">
            <form class="form" method="put" action="" data-action="/api/goods/{id}" data-form-edit-goods>
                <div class="form-group">
                    <label>Выберите товар</label>
                    <select name="goods" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label for="multiselect_categories_goods">Выбор категорий</label>
                    <select name="categories[]" id="multiselect_categories_goods" class="form-control"  multiple="multiple"></select>
                </div>
                <div class="form-group">
                    <label for="goods_edit_title">Название товара</label>
                    <input type="text" name="goods_title" id="goods_edit_title" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="goods_edit_description">Описание товара</label>
                    <textarea name="goods_description" id="goods_edit_description" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Изменить товар</button>

            </form>
        </div>
        <div class="panel-footer collapse">
            <table class="table table-bordered ">
                <thead >
                <tr>
                    <th class="text-center">JSON</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="json-out">JSON</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-default col-md-6">
        <div class="panel-body">
            <form class="form-inline" method="delete" action="" data-action="/api/goods/{id}" data-form-delete-goods>
                <div class="form-group">
                    <label for="goods">Удаление товара</label>
                    <select name="goods" id="goods" class="form-control"></select>
                </div>

                <button type="submit" class="btn btn-primary pull-right">Удалить</button>

            </form>
        </div>
        <div class="panel-footer collapse">
            <table class="table table-bordered">
                <thead >
                <tr>
                    <th class="text-center">JSON</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="json-out">JSON</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>