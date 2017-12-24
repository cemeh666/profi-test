<h3>Категории</h3>
<div class="panel panel-default col-md-6">
    <div class="panel-body">
        <form class="form-inline" method="get" action="{{action('API\ApiCategoryController@get')}}" data-form-get-category>
            <div class="form-group">
                <label>Вывод категорий</label>
            </div>
            <button type="submit" class="btn btn-primary pull-right">Показать категории</button>

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
        <form class="form-inline" method="post" action="{{action('API\ApiCategoryController@create')}}" data-form-create-category>
            <div class="form-group">
                <label for="category_name">Название категории</label>
                <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Название категории">
            </div>
            <button type="submit" class="btn btn-primary pull-right">Создать категорию</button>

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
        <form class="form" method="put" action="" data-action="/api/category/" data-form-edit-category>
            <div class="form-group">
                <label>Выберите категорию для изменения</label>
                <select name="categories_list" class="form-control">
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="category_name" class="form-control" placeholder="Новое название категории">
            </div>
            <button type="submit" class="btn btn-primary pull-right">Изменить категорию</button>

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
        <form class="form-inline" method="delete" action="" data-action="/api/category/" data-form-delete-category>
            <div class="form-group">
                <label>Удаление категории</label>
                <select name="categories_list" class="form-control"></select>
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