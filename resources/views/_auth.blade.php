<h3>Авторизация</h3>

<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-inline" method="post" action="{{action('Auth\LoginController@login')}}" data-form-auth>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="test-user@test.test" value="test-user@test.test">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" value="test-user@test.test">
            </div>
            <button type="submit" class="btn btn-primary">Авторизация</button>
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

<h3>Выход</h3>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-inline" method="post" action="{{action('Auth\LoginController@api_logout')}}" data-form-logout>
            <button type="submit" class="btn btn-primary">Выйти</button>
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
