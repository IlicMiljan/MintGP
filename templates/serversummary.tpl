    <div class="container">
      <div class="col-md-4">
        <div class="page-info">
          <h3>Server :: {$ServerData.ID}</h3>
          <img src="templates/img/icons/png/Retina-Ready.png">
        </div>
      </div>
      <div class="col-md-8">
        <div class="panel panel-inverse">
          <div class="panel-heading">
            <h3 class="panel-title">Server: {$ServerData.ServerIP}:{$ServerData.ServerPort}</h3>
          </div>
          <div class="panel-body">
            <div class="pull-left">
              {if $ServerData.Status eq '0'}
              <a href="serversummary.php?Action=Start&ID={$ServerData.ID}" class="btn btn-success"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> POKRENI</a>
              {/if}
              {if $ServerData.Status eq '1'}
              <a href="serversummary.php?Action=Restart&ID={$ServerData.ID}" class="btn btn-warning"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> RESTARTUJ</a>
              {/if}
              {if $ServerData.Status eq '1'}
              <a href="serversummary.php?Action=Stop&ID={$ServerData.ID}" class="btn btn-danger"><span class="glyphicon glyphicon-stop" aria-hidden="true"></span> ZAUSTAVI</a>
              {/if}
            </div>
            <div class="pull-right">
              <a href="webftp.php?ID={$ServerData.ID}" class="btn btn-inverse"><span class="glyphicon glyphicon-folder-open" aria-hidden="true" style="padding-right: 5px;"></span> WEB FTP</a>
            </div>
          </div>
        </div>
        <div class="panel panel-inverse">
          <div class="panel-heading">
            <h3 class="panel-title">Server Info</h3>
          </div>
          <div class="panel-body">
            <div class="col-md-6">
              <h6>Generalno</h6>
              <li>Ime servera: <b>{$ServerData.Hostname}</b></li>
              <li>Datum isteka: <b>{$ServerData.Expires}</b></li>
              <li>Igra: <b>{$ServerData.GameName}</b></li>
              {if $ServerData.Type eq '0'}
              <li>Status: <span class="text-warning"><b>Suspendovan</b><span></li>
              {elseif $ServerData.Type eq '1'}
              <li>Status: <span class="text-success"><b>Aktivan</b><span></li>
              {/if}
            </div>
            <div class="col-md-6">
              <h6>FTP Informacije</h6>
              <li>IP Adresa: <b>{$ServerData.ServerIP}</b></li>
              <li>FTP Port: <b>21</b></li>
              <li>FTP Username: <b>{$ServerData.Username}</b></li>
              <li>FTP Password: <b>{if isset($FTP_Password)}{$FTP_Password}{else}<a style="cursor: pointer;" data-toggle="modal" data-target="#ShowPassword">PRIKAŽI</a>{/if}</b></li>
            </div>
            <div class="clearfix"></div><br/>
            <div class="col-md-12">
              <h6>Server Status</h6>
              {if $ServerData.Status eq '1'}
              <li>Hostname: <b>{$ServerQuery.Hostname}</b></li>
              <li>Igrači: <b>{$ServerQuery.Numplayers} / {$ServerQuery.Maxplayers}</b></li>
              <li>Mapa: <b>{$ServerQuery.Mapname}</b></li>
              <li>Mod: <b>{$ServerQuery.GameMode}</b></li>
              {else}
              <div class="alert alert-danger">Server nije pokrenut!</div>
              {/if}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ShowPassword" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-inverse">
            <button type="button" class="close" style="color: #FFF" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Prikaži Lozinku</h4>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
              <label style="margin-bottom: 0px;"><b>Unesite PIN:* <span class="fui-question-circle" data-toggle="tooltip" title="Unesite PIN kako biste otključali FTP lozinku!"></span></b></label>
              <input type="password" id="ShowPasswordInput" class="form-control" required="true" name="PIN">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success" name="ShowPassword"><span class="fui-upload"></span> Prikaži</button>
            </div>
          </form>
        </div>
      </div>
    </div>
