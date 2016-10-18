    <div class="container">
      <div class="col-md-4">
        <div class="page-info">
          <h3>WEB FTP :: 1</h3>
          <img src="templates/img/icons/png/Compas.png"><br/><br/>
          <a href="serversummary.php?ID={$ServerData.ID}" class="btn btn-success"><span class="fui-windows"></span> Pregled Servera</a>
        </div>
      </div>
      <div class="col-md-8">
        <ol class="breadcrumb">
          {foreach from=$Navigation item=Query}
          <li><a href="webftp.php?ID={$ServerData.ID}&Path={$Query.Link}">{if $Query.Name eq '.' || $Query.Name eq ''}<span class="glyphicon glyphicon-home" aria-hidden="true">{else}{$Query.Name}{/if}</a></li>
          {/foreach}
        </ol>
        {if isset($DirList) || isset($FileList)}
        <div class="table-responsive">
          <table class="table table-bordered table-condensed">
            <thead>
              <tr>
                <th>Naziv</th>
                <th>Velicina</th>
                <th>Korisnik</th>
                <th>Grupa</th>
                <th>Dozvole</th>
                <th>Opcije</th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$DirList item=Query}
              <tr>
                <td><span class="glyphicon glyphicon-folder-open" aria-hidden="true" style="margin-right: 6px;"></span> <a href="webftp.php?ID={$ServerData.ID}&Path={$CurrentPath}/{$Query.Name}">{$Query.Name}</a></td>
                <td>{$Query.Size}</td>
                <td>{$Query.Owner}</td>
                <td>{$Query.Group}</td>
                <td style="text-transform: uppercase;">{$Query.Chmod}</td>
                <td><a data-toggle="modal" data-target="#Rename" class="text-warning" style="cursor: pointer;" onclick="Rename('{$Query.Name}');">Preimenuj</a></td>
              </tr>
              {/foreach}
              {foreach from=$FileList item=Query}
              <tr>
                <td><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <a href="webftp.php?ID={$ServerData.ID}&Path={$CurrentPath}/{$Query.Name}">{$Query.Name}</a></td>
                <td>{$Query.Size}</td>
                <td>{$Query.Owner}</td>
                <td>{$Query.Group}</td>
                <td style="text-transform: uppercase;">{$Query.Chmod}</td>
                <td><a data-toggle="modal" data-target="#Rename" class="text-warning" style="cursor: pointer;" onclick="Rename('{$Query.Name}');">Preimenuj</a> | <a href="webftp.php?ID={$ServerData.ID}&Path={$CurrentPath}&Action=Delete&File={$Query.Name}" class="text-danger delete">Obriši</a></td>
              </tr>
              {/foreach}
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-md-5">
            <div class="panel panel-inverse">
              <div class="panel-heading">
                <h3 class="panel-title">Kreiraj Direktorijum</h3>
              </div>
              <div class="panel-body">
                <form action="" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" required="true" name="FolderName" placeholder="Naziv ..." id="search-query-3">
                    <span class="input-group-btn">
                      <button type="submit" name="CreateFolder" class="btn"><span class="fui-plus"></span></button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-5 pull-right">
            <div class="panel panel-inverse">
              <div class="panel-heading">
                <h3 class="panel-title">Otpremi Datoteku (Max. {$MaxUploadSize})</h3>
              </div>
              <div class="panel-body">
                <form action="" method="POST" enctype="multipart/form-data">
                  <div class="input-group">
                    <input type="file" class="form-control" required="true" name="File" id="search-query-3">
                    <span class="input-group-btn">
                      <button type="submit" name="UploadFile" class="btn"><span class="fui-upload"></span></button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        {/if}
        {if isset($FileData)}
        <form action="" method="POST">
          <textarea class="form-control" rows="18" name="FileContent">{$FileData}</textarea>
          <button type="submit" class="btn btn-success pull-right" style="margin-top: 5px;"><span class="fui-upload"></span> Sačuvaj</button>
        </form>
        {/if}
      </div>
      <div id="Rename" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-inverse">
              <button type="button" class="close" style="color: #FFF" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Preimenuj Fajl/Folder</h4>
            </div>
            <form action="" method="POST">
              <div class="modal-body">
                <input type="text" id="OldName" hidden="true" name="OldName">
                <label style="margin-top: 5px; margin-bottom: 0px;"><b>Novi naziv:* <span class="fui-question-circle" data-toggle="tooltip" title="Unesite novo ime fajla/foldera!"></span></b></label>
                <input type="text" id="NewName" class="form-control" required="true" name="NewName">
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="Rename"><span class="fui-check"></span> Izmeni</button>
              </div>
            </form>
          </div>
        </div>
      </div>
