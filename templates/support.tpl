    <div class="container">
      <div class="col-md-4">
        <div class="page-info">
          <h3>Podrška</h3>
          <img src="templates/img/icons/png/Mail.png">
        </div>
      </div>
      <div class="col-md-8">
        <div class="panel panel-inverse">
          <div class="panel-heading">
            <h3 class="panel-title">Opcije</h3>
          </div>
          <div class="panel-body">
            <form action="" method="POST">
              <div class="input-group col-md-4 pull-left">
                <input type="text" class="form-control" placeholder="Pretraga ..." id="search-query-3">
                <span class="input-group-btn">
                  <button type="submit" class="btn"><span class="fui-search"></span></button>
                </span>
              </div>
            </form>
            <div class="pull-right">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#NewTicket"><span class="fui-plus"></span> Otvori Tiket</button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Status</th>
                <th>Datum</th>
                <th>Server</th>
                <th>Naslov Tiketa</th>
              </tr>
            </thead>
            <tbody>
              {foreach item=Query from=$Tickets}
              <tr>
                {if $Query.Status eq '0'}
                <td><span class="text-warning"><b>Neodgovoren</b><span></td>
                {elseif $Query.Status eq '1'}
                <td><span class="text-success"><b>Odgovoren</b><span></td>
                {elseif $Query.Status eq '2'}
                <td><span class="text-danger"><b>Zatvoren</b><span></td>
                {/if}
                <td>{$Query.SubmitDate}</td>
                <td>{$Query.ServerIP}</td>
                <td><a href="viewticket.php?ID={$Query.ID}">{$Query.Title}</a></td>
              </tr>
              {/foreach}
             </tbody>
           </table>
        </div>
      </div>
    </div>
    <div id="NewTicket" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-inverse">
            <button type="button" class="close" style="color: #FFF" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Otvori Tiket</h4>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-8">
                  <label style="margin-bottom: 0px;"><b>Naslov Tiketa:* <span class="fui-question-circle" data-toggle="tooltip" title="Minimalno 10 karaktera! Trudite se da naslov bude što precizniji!"></span></b></label>
                  <input type="text" class="form-control" required="true" minlength="10" name="Title">
                </div>
                <div class="col-md-4">
                  <label style="margin-bottom: 0px;"><b>Server:* <span class="fui-question-circle" data-toggle="tooltip" title="Izaberite server za koji je vezano Vaše pitanje!"></span></b></label>
                  <select class="form-control select select-primary" style="width: 100%;" name="ServerIP">
                    <option value="192.168.1.1">192.168.1.1</option>
                    <option value="192.168.1.2">192.168.1.2</option>
                  </select>
                </div>
              </div>
              <label style="margin-top: 5px; margin-bottom: 0px;"><b>Pitanje:* <span class="fui-question-circle" data-toggle="tooltip" title="Minimalno 50 karaktera! Obrazložite Vaš problem što jasnije!"></span></b></label>
              <textarea class="form-control" required="true" minlength="50" rows="8" name="Content"></textarea>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success"><span class="fui-plus"></span> Pošalji</button>
            </div>
          </form>
        </div>
      </div>
    </div>
