    <div class="container">
      <div class="col-md-4">
        <div class="page-info">
          <h3>Obaveštenja</h3>
          <img src="templates/img/icons/png/Clipboard.png">
        </div>
      </div>
      <div class="col-md-8">
        {foreach item=Query from=$News}
        <div class="panel panel-inverse">
          <div class="panel-heading">
            <h3 class="panel-title">{$Query.Title} <small class="pull-right date">{$Query.PostDate}</small></h3>
          </div>
          <div class="panel-body">
            {$Query.Content}
          </div>
        </div>
        {/foreach}
      </div>
    </div>
